<template>
  <div class="plf-popper-container"
       v-outside-click="onOutsideClick">
    <div ref="internalReference"
         class="plf-tooltip"
         @click="onClick"
         @blur="onBlur"
         @focus="onFocus"
         :tabindex="tabindex"
         @contextmenu="onContextMenu"
         @mouseenter="onMouseEnter"
         @mouseleave="onMouseLeave">
      <slot></slot>
    </div>

    <Teleport to="body"
              :disabled="!teleported">
      <div ref="floating"
           v-show="opened"
           :style="{
             zIndex,
             ...popperStyle,
             position: strategy,
             top: `${y ?? 0}px`,
             left: `${x ?? 0}px`,
           }"
           class="text-nowrap"
           :class="internalPopperClasses"
           @mouseenter="onMouseEnter"
           @mouseleave="onMouseLeave">
        <slot name="content">{{ content }}</slot>

        <PlfTooltipArrow :data="middlewareData"
                         :placement="finalPlacement"
                         :show="showArrow"
                         ref="floatingArrow" />
      </div>
    </Teleport>
  </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue';
import { useFloating, arrow, size, offset as floatingOffset, shift, autoUpdate, flip } from '@floating-ui/vue';
import vOutsideClick from '../../../directives/outside-click.js';
import PlfTooltipArrow from './PlfTooltipArrow.vue';
import { mergeClasses } from '../../../composables/utils';
import { useVModel } from '@vueuse/core';

const emit = defineEmits(['update:visible']);

const props = defineProps({
  appendTo: {
    type: String,
    default: () => 'body',
  },

  trigger: {
    type: String,
    default: () => 'hover',
    validator: (value) => ['hover', 'click', 'focus', 'contextmenu'].includes(value)
  },

  placement: {
    type: String,
    default: () => 'bottom',
    validator: (value) => [
      'top',
      'top-start',
      'top-end',
      'bottom',
      'bottom-start',
      'bottom-end',
      'left',
      'left-start',
      'left-end',
      'right',
      'right-start',
      'right-end'
    ].includes(value)
  },

  visible: {
    type: Boolean,
    default: () => false,
  },

  disabled: {
    type: Boolean,
    default: () => false,
  },

  offset: {
    type: [Number, Array],
    default: () => 10,
  },

  fallbackPlacements: {
    type: Array
  },

  showAfter: {
    type: Number,
    default: () => 0,
  },

  showArrow: {
    type: Boolean,
    default: true,
  },

  hideAfter: {
    type: Number,
    default: () => 200,
  },

  enterable: {
    type: Boolean,
    default: () => false,
  },

  teleported: {
    type: Boolean,
    default: () => true,
  },

  tabindex: {
    type: [Number, String],
    default: () => 0,
  },

  content: {
    type: String,
  },

  rawContent: {
    type: Boolean,
  },

  manual: {
    type: Boolean,
    default: () => false
  },

  zIndex: {
    type: Number
  },

  virtualRef: {
    type: Object,
    default: () => null,
  },

  square: {
    type: Boolean,
  },

  fitContentWidth: {
    type: Boolean,
    default: false,
  },

  positionFixed: {
    type: Boolean,
  },

  popperStyle: {
    type: Object,
    default: () => ({}),
  },

  popperClasses: {
    type: [String, Array, Object],
    default: () => '',
  },
});

const reference = ref(null);
const internalReference = ref(null);
const appliedReference = computed(() => reference.value ?? internalReference.value);

const floating = ref(null);

const floatingArrow = ref(null);

const opened = useVModel(props, 'visible', emit, { passive: true });

const ARROW_HEIGHT = computed(() => props.showArrow ? 8 : 0);

const internalPlacement = useVModel(props, 'placement', emit, { passive: true });

const getFallbackPlacements = () => {
  return [
    'top',
    'top-start',
    'top-end',
    'bottom',
    'bottom-start',
    'bottom-end',
    'left',
    'left-start',
    'left-end',
    'right',
    'right-start',
    'right-end'
  ];
}

const allowedPlacements = computed(() => {
  const placements = [internalPlacement.value];

  if (props.fallbackPlacements) {
    placements.push(...props.fallbackPlacements);
  } else {
    placements.push(...getFallbackPlacements());
  }

  return [...new Set(placements)];
});

const previousPlacement = ref(internalPlacement.value);

const internalStrategy = computed(() => {
  if (props.positionFixed) {
    return 'fixed';
  }

  return 'absolute';
});

const { x, y, update, strategy, middlewareData, placement: finalPlacement } = useFloating(appliedReference, floating, {
  placement: previousPlacement,
  strategy: internalStrategy,
  whileElementsMounted: autoUpdate,
  open: opened,

  middleware: [
    floatingOffset(ARROW_HEIGHT.value + props.offset),
    // autoPlacement({
    //   // allowedPlacements: allowedPlacements.value,
    //   autoAlignment: true,
    //   // crossAxis: false,
    //   padding: 0
    // }),
    size({
      apply({ rects }) {
        if (floating.value && props.fitContentWidth) {
          Object.assign(floating.value.style, {
            width: `${rects.reference.width}px`,
          });
        }
      }
    }),
    flip({
      mainAxis: true,
      fallbackPlacements: allowedPlacements.value,
      crossAxis: true,
      fallbackStrategy: 'bestFit',
      padding: ARROW_HEIGHT.value + props.offset,
    }),

    shift({
      padding: ARROW_HEIGHT.value + props.offset,
      mainAxis: true,
      crossAxis: false
    }),

    arrow({
      element: floatingArrow,
      padding: 10,
    })
  ]
});

// const dimension = computed(() => {
//   const side = finalPlacement.value.split('-')[0];

//   if (['top', 'bottom'].includes(side)) {
//     return 'height';
//   }

//   return 'width';
// });

const internalPopperClasses = computed(() => {
  return mergeClasses([
    {
      'plf-popper': true,
      'rounded-0': props.square,
    },

    props.popperClasses,
  ]);
});

const show = () => {
  if (props.disabled) return;

  // Show after a delay
  setTimeout(() => {
    opened.value = true;
  }, props.showAfter);
}

const hide = (forceClose = false) => {
  if (forceClose) {
    opened.value = false;
    return;
  }
  // Hide after a delay
  setTimeout(() => {
    opened.value = false;
  }, props.hideAfter);
}

const onClick = () => {
  if (props.trigger !== 'click' || props.manual) return;

  if (opened.value) {
    hide();
  } else {
    show();
  }
}

const onFocus = () => {
  if (props.trigger !== 'focus' || props.manual) return;

  show();
}

const onMouseEnter = () => {
  if (props.trigger !== 'hover' || props.manual) return;

  show();
}

const onMouseLeave = () => {
  if (props.trigger !== 'hover' || props.manual) return;

  hide();
}

const onBlur = () => {
  if (props.trigger !== 'focus' || props.manual) return;

  hide();
}

const onContextMenu = (e) => {
  if (props.trigger !== 'contextmenu' || props.manual) return;

  e.preventDefault();

  if (opened.value) {
    hide();
  } else {
    show();
  }
}

// Toggle visibility on outside click
const onOutsideClick = (evt) => {
  if (props.manual || !['click', 'contextmenu'].includes(props.trigger)) return;

  if (!appliedReference.value.contains(evt.target) && !floating.value.contains(evt.target)) {
    hide();
  }
}

watch(finalPlacement, (value) => {
  previousPlacement.value = value;
});

watch(() => props.placement, value => {
  previousPlacement.value = value;

  update();
});

const events = {
  click: onClick,
  focus: onFocus,
  mouseenter: onMouseEnter,
  mouseleave: onMouseLeave,
  blur: onBlur,
  contextmenu: onContextMenu
};

const addEventListeners = () => {
  Object.entries(events).forEach(([event, handler]) => {
    if (props.trigger === event) {
      appliedReference.value.addEventListener(event, handler);
    }
  });
}

const removeEventListeners = () => {
  Object.entries(events).forEach(([event, handler]) => {
    if (props.trigger === event) {
      appliedReference.value.removeEventListener(event, handler);
    }
  });
}

watch(() => props.virtualRef, value => {
  if (value) {
    // Remove event listeners from previous reference
    if (reference.value) {
      removeEventListeners();
    }

    reference.value = value;

    // Add event listeners to new reference
    addEventListeners();

    update();
  }
}, { deep: true, immediate: true });

defineExpose({
  reference: appliedReference,
  floating,
});
</script>

<style>
:root {
  --plf-popover-arrow-border-width: 1px;
  --plf-popover-arrow-border-radius: 2px;
  --plf-popover-arrow-border-color: rgba(var(--tblr-secondary-rgb), .2);
}
</style>

<style scoped>
.plf-popper {
  box-sizing: border-box;
  background: white;
  /*color: white !important;*/
  /*font-weight: bold !important;*/
  padding: 4px 0;
  border-radius: 4px;
  border: var(--plf-popover-arrow-border-width) solid var(--plf-popover-arrow-border-color);
  z-index: 2000;
}

[data-bs-theme='dark'] .plf-popper {
  background: var(--tblr-dark);
  color: white !important;
}

.plf-tooltip {
  outline: none;
}
</style>
