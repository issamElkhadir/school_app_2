<template>
  <div class="d-flex flex-column gap-3">
    <div>
      {{ question.title }}
    </div>

    <small v-if="question.description">
      {{ question.description }}
    </small>

    <div class="d-flex justify-content-center gap-3">
      <PlfRadio v-for="i in options"
                :key="`linear-scale-${i}`"
                v-model="value"
                color="teal"
                :value="i"
                :label="i" />
    </div>

    <PlfExpandTransitionV2 duration="100ms">
      <div v-if="value"
           class="text-end">
        <PlfButton class="btn-ghost-teal ms-auto"
                   @click="value = null"
                   label="Clear selection" />
      </div>
    </PlfExpandTransitionV2>
  </div>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfRadio from '@/components/shared/radio/PlfRadio.vue';
import PlfExpandTransitionV2 from '@/components/shared/transition/PlfExpandTransitionV2.vue';
import { useVModel } from '@vueuse/core';
import { computed } from 'vue';

const emit = defineEmits([
  'update:modelValue',
]);

const props = defineProps({
  question: {
    type: Object,
    required: true
  },

  modelValue: {
    type: String
  },
  answerValue : {
    type : String
  }
});

const value = useVModel(props, 'modelValue', emit);

const options = computed(() => {
  const from = props.question.options.from.value;
  const to = props.question.options.to.value;

  return Array.from({ length: to - from + 1 }, (_, i) => from + i);
})
</script>

<!-- <style scoped>
.fade-enter-from,
.fade-leave-to {
  height: 0;
  opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
  transition: height, opacity 0.3s ease-in-out;
}

/* .fade-enter-to,
.fade-leave-from {
  height: auto;
} */

</style> -->