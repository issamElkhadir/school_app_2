<template>
  <div class="plf-toast-message"
       :class="[`plf-toast-message-${toast.severity ?? 'info'}`]"
       :key="`toast-${toast.id}`">

    <div class="d-flex gap-2 plf-toast-message-content"
         :class="[toast.summary ? 'align-items-start' : 'align-items-center']">

      <slot name="icon"
            :toast="toast">
        <div class="plf-toast-message-icon">
          <component class="icon"
                     :is="icon" />
        </div>
      </slot>

      <slot name="text"
            :toast="toast">
        <div style="min-width: 0"
             class="plf-toast-message-text w-full">

          <slot class="summary"
                :toast="toast">
            <div class="fw-bold plf-toast-message-summary text-truncate">
              {{ toast.summary }}
            </div>
          </slot>

          <slot name="detail"
                :toast="toast">
            <div class="plf-toast-detail">
              {{ toast.detail }}
            </div>
          </slot>
        </div>
      </slot>

      <div class="plf-toast-icon-close">
        <PlfIcon name="tblr.IconX"
                 class="icon"
                 v-if="toast.closable !== false"
                 @click="onCloseClick" />
      </div>
    </div>

    <!-- Progress bar -->
    <div class="plf-toast-message-progress"
         v-if="toast.progress"
         :class="`plf-toast-message-progress-${toast.severity ?? 'info'}`"
         :style="{ width: `${remainingTime}%` }"></div>

  </div>
</template>

<script setup>
import { computed, ref } from "vue";
import { ToastSeverity } from './useToast.js';
import PlfIcon from "../icon/PlfIcon.vue";

const emit = defineEmits(['close']);

const props = defineProps({
  toast: {
    type: Object,
  }
});

const close = () => {
  emit('close', props.toast);
};

const icon = computed(() => {
  switch (props.toast.severity) {
    case ToastSeverity.ERROR:
      return 'CircleXIcon';
    case ToastSeverity.WARN:
      return 'AlertCircleIcon';
    case ToastSeverity.SUCCESS:
      return 'CircleCheckIcon';
    default:
      return 'InfoCircleIcon';
  }
});

const remainingTime = ref(100);

const created = Date.now();

const updateRemainingTime = () => {
  const life = props.toast.life ?? 5000;

  // Calculate remaining time in %
  const remaining = (life - (Date.now() - created)) / life * 100;

  remainingTime.value = Math.max(0, Math.min(100, remaining));
};

const timer = setInterval(() => {
  // Update remaining time and close timer if toast is closed
  if (remainingTime.value === 0) {
    clearInterval(timer);
  } else {
    updateRemainingTime();
  }
}, 1000);

const onCloseClick = () => {
  clearInterval(timer);
  close();
};
</script>

<style>
/* define colors */
:root {
  --plf-toast-message-info-color: var(--tblr-indigo);
  --plf-toast-message-error-color: var(--tblr-danger);
  --plf-toast-message-warn-color: var(--tblr-warning);
  --plf-toast-message-success-color: var(--tblr-teal);
}
</style>

<style scoped>
.plf-toast .plf-toast-message .plf-toast-message-content {
  padding: 1rem;
  border-width: 0 0 0 4px;
  width: 25rem;
}

@media (max-width: 768px) {
  .plf-toast .plf-toast-message .plf-toast-message-content {
    width: 100%;
    justify-content: center;
  }
}

.plf-toast .plf-toast-message {
  margin: 0 0 1rem 0;
  box-shadow: 0 2px 12px 0 rgb(0 0 0 / 10%);
  border-radius: 6px;
}

.plf-toast .plf-toast-message .plf-toast-icon-close {
  border-radius: 50%;
  padding: 3px;
  background: transparent;
  transition: background-color 0.2s, color 0.2s, box-shadow 0.2s;
}

.plf-toast .plf-toast-icon-close {
  cursor: pointer;
}

.plf-toast .plf-toast-message .plf-toast-icon-close:hover {
  background: rgba(255, 255, 255, 0.3);
}

/* ERROR */
.plf-toast .plf-toast-message.plf-toast-message-error .plf-toast-icon-close {
  color: var(--plf-toast-message-error-color);
}

.plf-toast .plf-toast-message.plf-toast-message-error {
  background: #ffe7e6;
  border: solid var(--plf-toast-message-error-color);
  border-width: 0 0 0 6px;
  /* border: 0; */
  /* border-inline-start-width: 6px; */
  color: var(--plf-toast-message-error-color);
}

/* INFO */
.plf-toast .plf-toast-message.plf-toast-message-info .plf-toast-icon-close {
  color: var(--plf-toast-message-info-color);
}

.plf-toast .plf-toast-message.plf-toast-message-info {
  background: #e9e9ff;
  border-style: solid;
  border-color: var(--plf-toast-message-info-color);
  border-width: 0 0 0 6px;
  /* border: 0; */
  /* border-inline-start-width: 6px; */
  color: var(--plf-toast-message-info-color);
}

/* WARN */
.plf-toast .plf-toast-message.plf-toast-message-warn .plf-toast-icon-close {
  color: var(--plf-toast-message-warn-color);
}

.plf-toast .plf-toast-message.plf-toast-message-warn {
  background: #fff2e2;
  border: solid var(--plf-toast-message-warn-color);
  border-width: 0 0 0 6px;
  /* border: 0; */
  /* border-inline-start-width: 6px; */
  color: var(--plf-toast-message-warn-color);
}


/* SUCCESS */
.plf-toast .plf-toast-message.plf-toast-message-success .plf-toast-icon-close {
  color: var(--plf-toast-message-success-color);
}

.plf-toast .plf-toast-message.plf-toast-message-success {
  background: #e4f8f0;
  border-style: solid;
  border-color: var(--plf-toast-message-success-color);
  border-width: 0 0 0 6px;
  /* border: 0; */
  /* border-inline-start-width: 6px; */
  color: var(--plf-toast-message-success-color);
}

.plf-toast-message-progress {
  height: 3px;
  background: var(--plf-toast-message-info-color);
  /*border-bottom-left-radius: 6px;*/
  /*border-bottom-right-radius: 6px;*/
  transition: width 1s linear;
}

.plf-toast-message-progress.plf-toast-message-progress-error {
  background: var(--plf-toast-message-error-color);
}

.plf-toast-message-progress.plf-toast-message-progress-warn {
  background: var(--plf-toast-message-warn-color);
}

.plf-toast-message-progress.plf-toast-message-progress-success {
  background: var(--plf-toast-message-success-color);
}
</style>
