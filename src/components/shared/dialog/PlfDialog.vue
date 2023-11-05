<template>
  <!-- Dialog component -->
  <Teleport to="body">
    <div ref="modalRef">
      <Transition name="modal">
        <div v-if="visible">
          <div class="modal overflow-hidden"
               style="display: block"
               @keyup.esc="onEscClicked"
               :class="{ 'modal-blur': !seamless }"
               autofocus
               ref="modalRef"
               tabindex="0">
            <div v-outside-click="onBackdropDismiss"
                 tabindex="0"
                 class="modal-dialog modal-dialog-scrollable"
                 :style="dialogStyles"
                 style="outline: none"
                 :class="dialogClasses"
                 role="dialog">
              <div class="modal-content"
                   :style="modalContentStyles"
                   :class="{ 'rounded-0': square }">
                <slot></slot>
              </div>
            </div>
          </div>

          <div v-if="!hideBackdrop"
               class="modal-backdrop fade show"></div>
        </div>
      </Transition>
    </div>

  </Teleport>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import vOutsideClick from '../../../directives/outside-click.js';
import { mergeClasses, toUnit } from "@/composables/utils";

const props = defineProps({
  persistent: {
    type: Boolean,
    default: false,
  },

  seamless: {
    type: Boolean,
    default: false,
  },

  hideBackdrop: {
    type: Boolean,
    default: false,
  },

  maximized: {
    type: Boolean,
    default: false,
  },

  animation: {
    type: Boolean,
    default: true,
  },

  fullWidth: {
    type: Boolean,
    default: false,
  },

  fullHeight: {
    type: Boolean,
    default: false,
  },

  position: {
    type: String,
    default: 'center',

    validator: (value) => {
      return ['center', 'top', 'bottom', 'left', 'right'].includes(value);
    },
  },

  modelValue: {
    type: Boolean,
    default: null,
  },

  square: {
    type: Boolean,
    default: false,
  },

  width: {
    type: [String, Number],
    default: 'modal-md'
  },

  noEscDismiss: {
    type: Boolean,
    default: () => true,
  },

  noBackdropDismiss: {
    type: Boolean,
    default: () => true,
  },

  modalDialogClasses: {
    type: [String, Array, Object],
    default: () => '',
  },

  modalContentStyles: {
    type: [String, Array, Object],
    default: () => '',
  },
});

const emit = defineEmits(['update:modelValue']);

const modalRef = ref();

const visible = ref();

watch(() => props.modelValue, (val) => {
  visible.value = val;

  if (modalRef.value) {
    modalRef.value.focus();
  }
}, { immediate: true });

const show = () => {
  visible.value = true;
  emit('update:modelValue', visible.value);
}

const hide = () => {
  visible.value = false;
  emit('update:modelValue', visible.value);
}

const toggle = () => {
  visible.value = !visible.value;
  emit('update:modelValue', visible.value);
}

defineExpose({
  show,
  hide,
  toggle,

  visible,
});

const onBackdropDismiss = () => {
  if (!props.persistent || !props.noBackdropDismiss) {
    hide();
  }
}

const onEscClicked = () => {
  if (!props.persistent || !props.noEscDismiss) {
    hide();
  }
}

const dialogClasses = computed(() => {
  return mergeClasses({
    'animated': props.animation,
    'modal-full-width': props.fullWidth,
    'modal-full-height': props.fullHeight,
    'modal-fullscreen': props.maximized,
    [`modal-dialog-${props.position}`]: true,
    [props.width]: typeof props.width === 'string' && props.width.startsWith('modal')
  }, props.modalDialogClasses);
});

const dialogStyles = computed(() => {
  const styles = {};

  if (typeof props.width === 'number') {
    styles.width = toUnit(props.width);
  } else if (!isNaN(parseInt(props.width))) {
    styles.width = toUnit(props.width);
  }

  return styles
});
</script>

<style scoped>
.modal {
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}

.modal-dialog {
  min-height: 100%;
  margin: 0;
}

.modal-dialog-top {
  display: flex;
  align-items: start;
  margin: 0 auto;
}

.modal-dialog-bottom {
  display: flex;
  align-items: end;
  margin: 0 auto;
}

.modal-dialog-right {
  margin-left: auto;
  display: flex;
  align-items: center;
}

.modal-dialog-left {
  margin-left: 0;
  display: flex;
  align-items: center;
}

.modal-dialog-center {
  display: flex;
  align-items: center;
  margin: auto;
}

.modal-fullscreen {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}

.modal-full-height .modal-content {
  height: 100%;
}

/**************************************/
.modal-enter-active,
.modal-leave-active {
  animation: all 500ms ease-in-out;
}

.modal-enter-active .modal-dialog,
.modal-leave-active .modal-dialog {
  transition: all 300ms ease;
}

/* Left */
.modal-enter-from .modal-dialog-left.animated,
.modal-leave-to .modal-dialog-left.animated {
  transform: translateX(-100%);
}

/* Right */
.modal-enter-from .modal-dialog-right.animated,
.modal-leave-to .modal-dialog-right.animated {
  transform: translateX(100%);
}

/* Top */
.modal-enter-from .modal-dialog-top.animated,
.modal-leave-to .modal-dialog-top.animated {
  transform: translateY(-100%);
}

/* Bottom */
.modal-enter-from .modal-dialog-bottom.animated,
.modal-leave-to .modal-dialog-bottom.animated {
  transform: translateY(100%);
}

.modal-enter-from .modal-dialog-center.animated,
.modal-leave-to .modal-dialog-center.animated {
  transform: scale(0);
  opacity: 0;
}

/* Center */
/*.modal-enter-from .modal-dialog-center.animated,*/
/*.modal-leave-to .modal-dialog-center.animated {*/
/*  transform: scale(0);*/
/*}*/
</style>
