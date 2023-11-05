import { defineAsyncComponent } from 'vue';

export default [
  {
    name: 'Short Answer',
    value: 'short-answer',
    component: defineAsyncComponent(() => import('./question-types/ShortAnswerQuestion.vue')),
    props: {
      prependIcon: 'mdi.IconTextShort'
    },

    describeable: true,
    type: 'question',
  },

  {
    name: 'Paragraph',
    value: 'paragraph',
    component: defineAsyncComponent(() => import('./question-types/ParagraphQuestion.vue')),
    props: {
      prependIcon: 'mdi.IconTextLong'
    },

    describeable: true,
    type: 'question',
  },

  {
    type: 'divider',
    props: {
      class: 'my-1'
    }
  },

  {
    name: 'Multiple Choice',
    value: 'multiple-choice',
    component: defineAsyncComponent(() => import('./question-types/MultipleChoiceQuestion.vue')),
    props: {
      prependIcon: 'mdi.IconRadioButtonChecked'
    },

    describeable: true,
    type: 'question',
  },

  {
    name: 'Checkboxes',
    value: 'checkboxes',
    component: defineAsyncComponent(() => import('./question-types/CheckboxQuestion.vue')),
    props: {
      prependIcon: 'mdi.IconCheckboxOutline'
    },

    describeable: true,
    type: 'question',
  },

  {
    name: 'Dropdown',
    value: 'dropdown',
    component: defineAsyncComponent(() => import('./question-types/DropdownQuestion.vue')),
    props: {
      prependIcon: 'mdi.IconFormDropdown'
    },

    describeable: true,
    type: 'question',
  },

  {
    type: 'divider',
    props: {
      class: 'my-1'
    }
  },

  {
    name: 'File Upload',
    value: 'file-upload',
    component: defineAsyncComponent(() => import('./question-types/FileUploadQuestion.vue')),
    props: {
      prependIcon: 'mdi.IconCloudUploadOutline'
    },

    describeable: true,
    type: 'question',
  },

  {
    type: 'divider',
    props: {
      class: 'my-1'
    }
  },

  {
    name: 'Linear Scale',
    value: 'linear-scale',
    component: defineAsyncComponent(() => import('./question-types/LinearScaleQuestion.vue')),
    props: {
      prependIcon: 'mdi.IconRuler'
    },

    describeable: true,
    type: 'question',
  },

  {
    name: 'Multiple Choice Grid',
    value: 'multiple-choice-grid',
    component: defineAsyncComponent(() => import('./question-types/MultipleChoiceGridQuestion.vue')),
    props: {
      prependIcon: 'mdi.IconDotsGrid'
    },

    describeable: true,
    type: 'question',
  },

  {
    name: 'Checkbox Grid',
    value: 'checkbox-grid',
    component: defineAsyncComponent(() => import('./question-types/CheckboxGridQuestion.vue')),
    props: {
      prependIcon: 'mdi.IconCheckboxMultipleBlankOutline'
    },

    describeable: true,
    type: 'question',
  },

  {
    type: 'divider',
    props: {
      class: 'my-1'
    }
  },

  {
    name: 'Date',
    value: 'date',
    component: defineAsyncComponent(() => import('./question-types/DateQuestion.vue')),
    props: {
      prependIcon: 'mdi.IconCalendar'
    },

    describeable: true,
    type: 'question',
  },

  {
    name: 'Time',
    value: 'time',
    component: defineAsyncComponent(() => import('./question-types/TimeQuestion.vue')),
    props: {
      prependIcon: 'mdi.IconClockTimeFourOutline'
    },

    describeable: true,
    type: 'question',
  }
];