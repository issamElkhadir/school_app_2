import { defineAsyncComponent } from "vue";

export default {
  string: defineAsyncComponent(() => import('../fields/filters/StringField.vue')),
  number: defineAsyncComponent(() => import('../fields/filters/NumberField.vue')),
  boolean: defineAsyncComponent(() => import('../fields/filters/BooleanField.vue')),
  enum: defineAsyncComponent(() => import('../fields/filters/EnumField.vue')),
  date: defineAsyncComponent(() => import('../fields/filters/DateField.vue')),
  dateTime: defineAsyncComponent(() => import('../fields/filters/DateTimeField.vue')),
  time: defineAsyncComponent(() => import('../fields/filters/TimeField.vue')),
  'belongs-to': defineAsyncComponent(() => import('../fields/filters/BelongsToField.vue')),
}