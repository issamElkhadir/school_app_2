<template>
  <Transition name="loading-spinner">
    <div
      v-if="showing"
      style="opacity: 100%;"
      :style="{zIndex}"
      :class="[color]"
      class="position-absolute loading flex-column d-flex align-items-center justify-content-center start-0 end-0 top-0 bottom-0"
    >
      <div class="loading-spinner-icon text-center">
        <div :class="{'loading-spinner': !!$slots.default}">
          <slot>
            <svg
              class="plf-inner-spinner"
              viewBox="0 0 50 50"
            >
              <circle
                class="path"
                cx="25"
                cy="25"
                r="20"
                fill="none"
                stroke-width="5"
              />
            </svg>
          </slot>
        </div>
      </div>
      <div
        v-if="!!$slots.default"
        :class="labelClass"
        :style="labelStyle"
      >
        {{ label }}
      </div>
    </div>
  </Transition>
</template>

<script setup>
const props = defineProps({
  label: {
    type: String,
    default: '',
  },

  labelClass: {
    type: String,
    default: '',
  },

  labelStyle: {
    type: [String, Array, Object],
    default: '',
  },

  showing: {
    type: Boolean,
    default: false,
  },

  color: {
    type: String,
    default: () => 'text-secondary',
  },

  speed: {
    type: String,
    default: () => '1000ms',
  },

  zIndex: {
    type: Number,
    default: () => 0,
  }
});
</script>

<style scoped>
.loading {
  -webkit-backdrop-filter: blur(3px);
  backdrop-filter: blur(3px);
}

.loading .loading-spinner > :not(.plf-inner-spinner) {
  animation: loading 2s linear infinite;
}

/*Loading Animation*/
@keyframes loading {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}


.plf-inner-spinner {
  animation: rotate 1s linear infinite;
  width: 50px;
  height: 50px;
}

.plf-inner-spinner .path {
  stroke: var(--tblr-secondary);
  stroke-linecap: round;
  animation: dash 1s ease-in-out infinite;
}

@keyframes rotate {
  100% {
    transform: rotate(360deg);
  }
}

@keyframes dash {
  0% {
    stroke-dasharray: 1, 150;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 90, 150;
    stroke-dashoffset: -35;
  }
  100% {
    stroke-dasharray: 90, 150;
    stroke-dashoffset: -124;
  }
}


.loading-spinner-enter-active {
  animation: loading-spinner v-bind('props.speed') ease-in;
}

@keyframes loading-spinner {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}

.loading-spinner-leave-active {
  animation: loading-spinner v-bind('props.speed') ease-out reverse;
}
</style>