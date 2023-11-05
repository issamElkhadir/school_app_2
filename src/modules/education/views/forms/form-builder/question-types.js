import { defineAsyncComponent } from "vue";

export default {
  'short-answer': {
    component: defineAsyncComponent(() => import('./question-types/ShortAnswerQuestion.vue')),
  },

  'paragraph': {
    component: defineAsyncComponent(() => import('./question-types/ParagraphQuestion.vue')),
  },

  'multiple-choice': {
    component: defineAsyncComponent(() => import('./question-types/MultipleChoiceQuestion.vue')),
  },

  'checkboxes': {
    component: defineAsyncComponent(() => import('./question-types/CheckboxQuestion.vue')),
  },

  'dropdown': {
    component: defineAsyncComponent(() => import('./question-types/DropdownQuestion.vue')),
  },

  'linear-scale': {
    component: defineAsyncComponent(() => import('./question-types/LinearScaleQuestion.vue')),
  },

  'multiple-choice-grid': {
    component: defineAsyncComponent(() => import('./question-types/MultipleChoiceGridQuestion.vue')),
  },

  'checkbox-grid': {
    component: defineAsyncComponent(() => import('./question-types/CheckboxGridQuestion.vue')),
  },

  'date': {
    component: defineAsyncComponent(() => import('./question-types/DateQuestion.vue')),
  },

  'time': {
    component: defineAsyncComponent(() => import('./question-types/TimeQuestion.vue')),
  },

  'file-upload': {
    component: defineAsyncComponent(() => import('./question-types/FileUploadQuestion.vue')),
  },
}