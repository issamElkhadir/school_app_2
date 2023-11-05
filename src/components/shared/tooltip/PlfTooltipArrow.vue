<template>
  <div :style="arrowStyle"
       class="arrow">
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  placement: {
    type: String,
    default: 'top'
  },

  data: {
    type: Object,
    default: () => ({})
  },

  show: {
    type: Boolean,
    default: true
  }
});

const ARROW_HEIGHT = 8;

const arrowStyle = computed(() => {
  const side = props.placement.split("-")[0];

  const staticSide = {
    top: "bottom",
    right: "left",
    bottom: "top",
    left: "right"
  }[side];

  const color = 'var(--plf-popover-arrow-border-color) !important';
  const radiusSize = 'var(--plf-popover-arrow-border-radius) !important';

  const borderStyle = {
    top: {
      borderBottomRightRadius: radiusSize,
      borderBottomColor: color,
      borderRightColor: color
    },
    right: {
      borderBottomLeftRadius: radiusSize,
      borderBottomColor: color,
      borderLeftColor: color
    },
    bottom: {
      borderTopLeftRadius: radiusSize,
      borderTopColor: color,
      borderLeftColor: color
    },
    left: {
      borderTopRightRadius: radiusSize,
      borderTopColor: color,
      borderRightColor: color
    }
  }[side];

  if (props.data?.arrow) {
    const { x, y, centerOffset } = props.data.arrow;

    if (centerOffset !== 0) {
      return {
        display: "none"
      };
    }

    return {
      display: props.show ? 'block': 'none',
      left: x != null ? `${x}px` : "",
      top: y != null ? `${y}px` : "",

      right: "",
      bottom: "",
      ...borderStyle,
      transform: "rotate(45deg)",
      [staticSide]: `${-ARROW_HEIGHT / 2}px`,
    };
  }

  return {};
});
</script>

<style scoped>
.arrow {
  position: absolute;
  width: 8px;
  height: 8px;
  background: white;
  z-index: -1;
  pointer-events: none;
  border: var(--plf-popover-arrow-border-width) solid transparent !important;
}

[data-bs-theme='dark'] .arrow {
  background: var(--tblr-dark) !important;
}

.arrow {
  z-index: -1;
}

[data-bs-theme='dark'] .plf-popper,
[data-bs-theme='dark'] .arrow::before {
  background-color: var(--tblr-dark);
}
</style>