<template>
  <QuestionList v-model:questions="questionsMutation"
                v-model:sections="sectionsMutation"
                v-model:active-question-index="activeQuestionIndex"
                v-model:active-section-index="activeSectionIndex"
                :disabled="disabled"
                :validation="validation" />
</template>

<script setup>
import { ref } from 'vue';
import { useModel } from '../../composables/ui/useModel';
import QuestionList from './QuestionList.vue';

const emit = defineEmits(['update:questions']);

const props = defineProps({
  questions: {
    type: Array,
    default: () => []
  },

  sections: {
    type: Array,
  },

  validation: {
    type: Object,
  },

  disabled: {
    type: Boolean,
    default: false,
  },
});

const questionsMutation = useModel(props, 'questions', emit, { defaultValue: [], deep: true, passive: true });
const sectionsMutation = useModel(props, 'sections', emit, {
  deep: true,
  passive: true,
  defaultValue: [
    {
      type: 'section-break',
      title: '',
      description: null,
      slug: 'default',
    }
  ],
});

const activeQuestionIndex = ref(null);
const activeSectionIndex = ref(null);
</script>