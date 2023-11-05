import {
  computed,
  ref,
  readonly,
  watch,
  onMounted,
  onActivated,
  reactive,
  onBeforeUnmount,
  getCurrentInstance,
  provide,
  inject,
  onDeactivated
} from 'vue'
import { convertToUnit } from '../../../composables/utils'

const uid = ref(0);

const ROOT_ZINDEX = 1000;

const IN_BROWSER = typeof window !== 'undefined'

function useResizeObserver(callback) {
  const resizeRef = ref()
  const contentRect = ref()

  if (IN_BROWSER) {
    const observer = new ResizeObserver((entries) => {
      callback?.(entries, observer)

      if (!entries.length) return

      contentRect.value = entries[0].contentRect
    })

    onBeforeUnmount(() => {
      observer.disconnect()
    })

    watch(
      resizeRef,
      (newValue, oldValue) => {
        if (oldValue) {
          observer.unobserve(oldValue)
          contentRect.value = undefined
        }

        if (newValue) observer.observe(newValue)
      },
      {
        flush: 'post'
      }
    )
  }

  return {
    resizeRef,
    contentRect: readonly(contentRect)
  }
}

export const PLFLayoutKey = Symbol.for('plf:layout')
export const PLFLayoutItemKey = Symbol.for('plf:layout-item')

export function findChildrenWithProvide(key, vnode) {
  if (!vnode || typeof vnode !== 'object') return []
  if (Array.isArray(vnode)) {
    return vnode.map((child) => findChildrenWithProvide(key, child)).flat(1)
  } else if (Array.isArray(vnode.children)) {
    return vnode.children.map((child) => findChildrenWithProvide(key, child)).flat(1)
  } else if (vnode.component) {
    if (Object.getOwnPropertySymbols(vnode.component.provides).includes(key)) {
      return [vnode.component]
    } else if (vnode.component.subTree) {
      return findChildrenWithProvide(key, vnode.component.subTree).flat(1)
    }
  }
  return []
}

const getUid = () => {
  return uid.value++
}

export function useLayoutItem({
  id,
  order,
  position,
  layoutSize,
  elementSize,
  active,
  disableTransitions,
  absolute
}) {
  const layout = inject(PLFLayoutKey)

  if (!layout) throw new Error('[PLF] Could not find injected layout')

  id = id ?? `layout-item-${getUid()}`

  const vm = getCurrentInstance()

  provide(PLFLayoutItemKey, { id })

  const isKeptAlive = ref(false)
  onDeactivated(() => (isKeptAlive.value = true))
  onActivated(() => (isKeptAlive.value = false))

  const {
    layoutItemStyles,

    layoutItemScrimStyles
  } = layout.register(vm, {
    order,
    position,
    layoutSize,
    elementSize,
    disableTransitions,
    absolute,
    active: computed(() => (isKeptAlive.value ? false : active.value)),
    id
  })

  onBeforeUnmount(() => layout.unregister(id))

  return {
    layoutItemStyles,
    layoutRect: layout.layoutRect,
    layoutItemScrimStyles
  }
}

export function useMainLayout() {
  const layout = inject(PLFLayoutKey)

  if (!layout) throw new Error('[PLF] Could not find injected layout')

  return {
    getLayoutItem: layout.getLayoutItem,
    mainRect: layout.mainRect,
    mainStyles: layout.mainStyles
  }
}

const generateLayers = (layout, positions, layoutSizes, activeItems) => {
  let previousLayer = { top: 0, left: 0, right: 0, bottom: 0 }

  const layers = [{ id: '', layer: { ...previousLayer } }]
  for (const id of layout) {
    const position = positions.get(id)
    const amount = layoutSizes.get(id)
    const active = activeItems.get(id)
    if (!position || !amount || !active) continue

    const layer = {
      ...previousLayer,
      [position.value]:
        parseInt(previousLayer[position.value], 10) +
        (active.value ? parseInt(amount.value, 10) : 0)
    }

    layers.push({
      id,
      layer
    })

    previousLayer = layer
  }

  return layers
}

export function createLayout(props) {
  // Store each item registered item id
  const registered = ref([])

  // Store the position / layout size / order / active item / disable transition
  // of each registered item using id as key and the value.
  const positions = reactive(new Map())
  const layoutSizes = reactive(new Map())
  const priorities = reactive(new Map())
  const activeItems = reactive(new Map())
  const disabledTransitions = reactive(new Map())

  const { resizeRef, contentRect: layoutRect } = useResizeObserver()

  const computedOverlaps = computed(() => {
    const map = new Map()
    const overlaps = props.overlaps ?? []

    for (const overlap of overlaps.filter((item) => item.includes(':'))) {
      const [top, bottom] = overlap.split(':')
      if (!registered.value.includes(top) || !registered.value.includes(bottom)) continue
      const topPosition = positions.get(top)
      const bottomPosition = positions.get(bottom)
      const topAmount = layoutSizes.get(top)
      const bottomAmount = layoutSizes.get(bottom)
      if (!topPosition || !bottomPosition || !topAmount || !bottomAmount) continue
      map.set(bottom, {
        position: topPosition.value,
        amount: parseInt(topAmount.value, 10)
      })
      map.set(top, {
        position: bottomPosition.value,
        amount: -parseInt(bottomAmount.value, 10)
      })
    }

    return map
  })

  const parentLayout = inject(PLFLayoutKey, null)

  const rootZIndex = computed(() =>
    parentLayout ? parentLayout.rootZIndex.value - 100 : ROOT_ZINDEX
  )

  const layers = computed(() => {
    const uniquePriorities = [...new Set([...priorities.values()].map((p) => p.value))].sort(
      (a, b) => a - b
    )

    const layout = []

    for (const p of uniquePriorities) {
      const items = registered.value.filter((id) => priorities.get(id)?.value === p)
      layout.push(...items)
    }

    return generateLayers(layout, positions, layoutSizes, activeItems)
  })

  const transitionsEnabled = computed(() => {
    return !Array.from(disabledTransitions.values()).some((ref) => ref.value)
  })

  // The remaining space for the main content.
  const mainRect = computed(() => {
    return layers.value[layers.value.length - 1].layer
  })

  // The style of the main content
  const mainStyles = computed(() => {
    return {
      '--plf-layout-left': convertToUnit(mainRect.value.left),
      '--plf-layout-right': convertToUnit(mainRect.value.right),
      '--plf-layout-top': convertToUnit(mainRect.value.top),
      '--plf-layout-bottom': convertToUnit(mainRect.value.bottom),
      ...(transitionsEnabled.value ? undefined : { transition: 'none' })
    }
  })

  // The list of items injected.
  const items = computed(() => {
    return layers.value.slice(1).map(({ id }, index) => {
      const { layer } = layers.value[index]
      const size = layoutSizes.get(id)
      const position = positions.get(id)

      return {
        id,
        ...layer,
        size: Number(size?.value),
        position: position?.value
      }
    })
  })

  // Get a layout item by its id
  const getLayoutItem = (id) => {
    return items.value.find((item) => item.id === id)
  }

  // Get the root Layout component.
  const rootVm = getCurrentInstance()

  const isMounted = ref(false)
  onMounted(() => {
    isMounted.value = true
  })

  provide(PLFLayoutKey, {
    register(
      vm,
      { id, order, position, layoutSize, elementSize, active, disableTransitions, absolute }
    ) {
      priorities.set(id, order)
      positions.set(id, position)
      layoutSizes.set(id, layoutSize)
      activeItems.set(id, active)
      disableTransitions && disabledTransitions.set(id, disableTransitions)

      const instances = findChildrenWithProvide(PLFLayoutItemKey, rootVm?.vnode)
      const instanceIndex = instances.indexOf(vm)

      if (instanceIndex > -1) registered.value.splice(instanceIndex, 0, id)
      else registered.value.push(id)

      const index = computed(() => items.value.findIndex((i) => i.id === id))
      const zIndex = computed(() => rootZIndex.value + layers.value.length * 2 - index.value * 2)

      const layoutItemStyles = computed(() => {
        const isHorizontal = position.value === 'left' || position.value === 'right'
        const isOppositeHorizontal = position.value === 'right'
        const isOppositeVertical = position.value === 'bottom'

        const styles = {
          [position.value]: 0,
          zIndex: zIndex.value,
          transform: `translate${isHorizontal ? 'X' : 'Y'}(${
            (active.value ? 0 : -110) * (isOppositeHorizontal || isOppositeVertical ? -1 : 1)
          }%)`,
          position: absolute.value || rootZIndex.value !== ROOT_ZINDEX ? 'absolute' : 'fixed',
          ...(transitionsEnabled.value ? undefined : { transition: 'none' })
        }

        if (!isMounted.value) return styles

        const item = items.value[index.value]

        if (!item) throw new Error(`[PLF] Could not find layout item "${id}"`)

        const overlap = computedOverlaps.value.get(id)

        if (overlap) {
          item[overlap.position] += overlap.amount
        }

        return {
          ...styles,
          height: isHorizontal
            ? `calc(100% - ${item.top}px - ${item.bottom}px)`
            : elementSize.value
            ? `${elementSize.value}px`
            : undefined,
          left: isOppositeHorizontal ? undefined : `${item.left}px`,
          right: isOppositeHorizontal ? `${item.right}px` : undefined,
          top: position.value !== 'bottom' ? `${item.top}px` : undefined,
          bottom: position.value !== 'top' ? `${item.bottom}px` : undefined,
          width: !isHorizontal
            ? `calc(100% - ${item.left}px - ${item.right}px)`
            : elementSize.value
            ? `${elementSize.value}px`
            : undefined
        }
      })

      const layoutItemScrimStyles = computed(() => ({
        zIndex: zIndex.value - 1
      }))

      return { layoutItemStyles, zIndex, layoutItemScrimStyles }
    },

    unregister(id) {
      priorities.delete(id)
      positions.delete(id)
      layoutSizes.delete(id)
      activeItems.delete(id)
      disabledTransitions.delete(id)
      registered.value = registered.value.filter((v) => v !== id)
    },

    mainRect,
    mainStyles,
    getLayoutItem,
    items,
    layoutRect,
    rootZIndex
  })

  const layoutClasses = computed(() => [
    'plf-layout',
    { 'plf-layout-full-height': props.fullHeight }
  ])

  const layoutStyles = computed(() => ({
    zIndex: rootZIndex.value,
    position: parentLayout ? 'relative' : undefined,
    overflow: parentLayout ? 'hidden' : undefined
  }))

  return {
    layoutClasses,
    layoutStyles,
    getLayoutItem,
    items,
    layoutRect,
    layoutRef: resizeRef
  }
}
