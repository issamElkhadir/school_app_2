<template>
  <Teleport to="body">

    <div class="plf-toasts">
      <div class="position-fixed p-3"
        style="pointer-events: none; z-index: 1000" v-for="(items, position) in toasts"
        :class="position"
        :key="`toast-${position}`">

        <div class="position-relative" style="pointer-events: all">

          <TransitionGroup tag="div" class="plf-toast d-flex flex-column" name="plf-toast-message">
            <PlfToastMessage v-for="item in items" :key="`toast-${position}-${item.id}`" :toast="item"
              @close="remove(item)" />
          </TransitionGroup>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import PlfToastMessage from "./PlfToastMessage.vue";
import { useToast } from "./useToast.js";

const { toasts, remove } = useToast();
</script>

<style>
.top-left {
  top: 0;
  left: 0
}

.top-right {
  top: 0;
  right: 0
}

.top-center {
  top: 0;
  left: 50%;
  transform: translateX(-50%);
}

.center {
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.bottom-left {
  bottom: 0;
  left: 0
}

.bottom-right {
  bottom: 0;
  right: 0
}

.bottom-center {
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
}

/* Animations */
.plf-toast-message-enter-from {
  opacity: 0;
  -webkit-transform: translateY(50%);
  -ms-transform: translateY(50%);
  transform: translateY(50%);
}

.plf-toast-message-leave-from {
  max-height: 1000px;
}

.plf-toast .plf-toast-message.plf-toast-message-leave-to {
  max-height: 0;
  opacity: 0;
  margin-bottom: 0;
  overflow: hidden;
}

.plf-toast-message-enter-active {
  -webkit-transition: transform .3s, opacity .3s;
  transition: transform .3s, opacity .3s;
}

.plf-toast-message-leave-active {
  -webkit-transition: max-height .45s cubic-bezier(0, 1, 0, 1), opacity .3s, margin-bottom .3s;
  transition: max-height .45s cubic-bezier(0, 1, 0, 1), opacity .3s, margin-bottom .3s;
}

@media (max-width: 768px) {

  /* Center all toasts horizontally */
  .bottom-center,
  .bottom-right,
  .bottom-left {
    left: 0;
    right: 0;
    transform: translateX(0);
  }

  .top-center,
  .top-right,
  .top-left {
    left: 0;
    right: 0;
    transform: translateX(0);
  }

  .center {
    top: 50%;
    left: 0;
    right: 0;
    transform: translate(0, -50%);
  }
}
</style>
