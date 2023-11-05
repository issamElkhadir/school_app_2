import { defineAsyncComponent } from "vue";

export default {
  string: defineAsyncComponent(() => import('../fields/index/StringField.js')),
  'belongs-to': defineAsyncComponent(() => import('../fields/index/BelongsToField.js')),
  // number: defineAsyncComponent(() => import('../fields/index/NumberField.vue')),
  boolean: defineAsyncComponent(() => import('../fields/index/BooleanField.js')),
  // enum: defineAsyncComponent(() => import('../fields/index/EnumField.vue')),
  // date: defineAsyncComponent(() => import('../fields/index/DateField.vue')),
  // dateTime: defineAsyncComponent(() => import('../fields/index/DateTimeField.vue')),
  // time: defineAsyncComponent(() => import('../fields/index/TimeField.vue')),
}