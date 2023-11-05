<script>
import { h, watch, ref, toRef, computed, onBeforeMount, withDirectives } from 'vue';
import vOutsideClick from '../../../directives/outside-click';
import { useLayoutItem } from '../layout/layout';
import { useTouch } from './useTouch';
import { toUnit } from '../../../composables/utils';
import { useBreakpoints, breakpointsBootstrapV5 } from '@vueuse/core';

export default {
  name: 'PlfNavigationDrawer',

  emits: ["update:modelValue"],

  props: {
    border: {
      type: Boolean,
      default: false,
    },

    color: {
      type: String,
    },

    expandOnHover: {
      type: Boolean,
      default: false,
    },

    location: {
      type: String,
      default: 'start',
      validator: (val) =>
        ['left', 'right', 'bottom', 'top', 'start', 'end'].includes(val),
    },

    modelValue: {
      type: Boolean,
      default: true,
    },

    overlay: Boolean,

    width: {
      type: [Number, String],
      default: 300
    },

    height: {
      type: [Number, String],
      default: '100%'
    },

    maxHeight: {
      type: [Number, String],
      default: '100%'
    },

    minHeight: {
      type: [Number, String],
      default: 0
    },

    miniWidth: {
      type: [Number, String],
      default: 60
    },

    tag: {
      type: String,
      default: "nav",
    },

    mini: {
      type: Boolean,
      default: false,
    },

    name: {
      type: String,
    },

    order: {
      type: Number,
      default: 0,
    },

    permanent: {
      type: Boolean,
      default: false,
    },

    breakpoint: {
      type: Number,
      default: 1023
    },

    touchless: Boolean,

    absolute: Boolean,

    rtl: {
      type: Boolean,
      default: false,
    },
  },

  setup(props, { slots, emit }) {

    const breakpoints = useBreakpoints(breakpointsBootstrapV5);
    
    const mobile = breakpoints.smallerOrEqual('md');

    const isOverlay = computed(() => !props.permanent && (mobile.value || props.overlay));

    const isActive = ref(!mobile.value);

    const isHovering = ref(false);

    const width = computed(() => {
      if ((props.mini && props.expandOnHover && isHovering.value)) {
        return parseInt(props.width);
      }

      return parseInt(props.mini ? props.miniWidth : props.width);
    });

    const location = computed(() => {
      if (['start', 'end'].includes(props.location)) {
        if (props.rtl) {
          return props.location === 'end' ? 'left' : 'right';
        }

        return props.location === 'end' ? 'right' : 'left';
      }

      return props.location;
    });

    const layoutSize = computed(() => {
      const size = isOverlay.value ? 0
        : props.mini && props.expandOnHover ? parseInt(props.miniWidth, 10)
          : width.value;

      return isDragging.value ? size * dragProgress.value : size;
    });

    const { isDragging, dragProgress, dragStyles } = useTouch({
      isActive: isActive,
      isTemporary: isOverlay,
      position: location,
      width: width,
      touchless: toRef(props, 'touchless')
    });

    const { layoutItemStyles } = useLayoutItem({
      absolute: computed(() => props.absolute),
      order: computed(() => parseInt(props.order, 10)),
      active: computed(() => isActive.value || isDragging.value),
      elementSize: width,
      position: location,
      id: props.name,
      layoutSize,
      disableTransitions: computed(() => isDragging.value),
    });

    watch(() => props.permanent, val => {
      if (val) isActive.value = true;
    });

    onBeforeMount(() => {
      if (props.modelValue != null || isOverlay.value) return;
      isActive.value = props.permanent || !mobile.value;
    });

    watch(() => props.modelValue, (val) => {
      if (val === isActive.value) return;

      isActive.value = val;
    }, { immediate: true });

    watch(isActive, (val) => {
      if (val === props.modelValue) return;

      emit('update:modelValue', val);
    }, { immediate: true });

    return () => {
      return withDirectives(h(props.tag,
        {
          class: {
            'plf-navigation-drawer': true,
            [`bg-${props.color}`]: !!props.color,
          },

          onMouseenter: () => isHovering.value = true,

          onMouseleave: () => isHovering.value = false,

          onClick() {
            emit("update:modelValue", true);
          },

          style: {
            ...layoutItemStyles.value,
            ...dragStyles.value,
            height: toUnit(props.mini ? props.miniHeight : props.height),
            maxHeight: toUnit(props.maxHeight),
            minHeight: toUnit(props.minHeight),
          },
        },

        [
          h('div', { class: 'plf-navigation-prepend' }, slots.prepend && h(slots.prepend)),
          h('div', { class: 'plf-navigation-content', }, slots.default && h(slots.default)),
          h('div', { class: 'plf-navigation-append' }, slots.append && h(slots.append)),
        ]
      ), [
        [vOutsideClick, {
          handler: () => {
            isActive.value = false;
            emit('update:modelValue', false);
          },

          isActive: isOverlay.value,

          events: ['click'],
        }]
      ]);
    };
  },
};
</script>

<style scoped>
.plf-navigation-drawer {
  transition: all .2s cubic-bezier(0.4, 0, 0.2, 1);
  display: flex;
  flex-direction: column;
  background-color: var(--tblr-white);
}

body[data-bs-theme='dark'] .plf-navigation-drawer {
  background-color: var(--tblr-dark);
}

.plf-navigation-content {
  flex: 1 1 auto;
  /* height: 100%; */
  /* max-width: 100%; */
  overflow-x: hidden;
  overflow-y: auto;
}
</style>
