<template>
  <PlfTooltip :offset="offset"
              :show-arrow="!hideArrow"
              :position-fixed="positionFixed"
              :teleported="teleported"
              enterable
              :z-index="zIndex"
              :placement="placement"
              :square="square"
              trigger="click">
    <template #content>
      <div :class="[dropdownMenuClasses, { 'rounded-0': square }]">
        <slot name="menu"></slot>
      </div>
    </template>

    <template #default>
      <component class="cursor-pointer"
                 :is="tag"
                 :tabindex="tabindex"
                 :class="toggleClasses">
        <slot :label="label">
          {{ label }}
        </slot>
      </component>
    </template>
  </PlfTooltip>
</template>

<script setup>
import PlfTooltip from '../tooltip/PlfTooltip.vue';

defineProps({
  label: {
    type: String,
  },

  toggleClasses: {
    type: [String, Object, Array],
  },

  dropdownClasses: {
    type: [String, Object, Array],
  },

  dropdownMenuClasses: {
    type: [String, Object, Array],
  },

  autoClose: Boolean,

  tag: {
    type: String,
    default: 'a',
  },

  tabindex: {
    type: [Number, String],
    default: -1,
  },

  square: Boolean,

  positionFixed: Boolean,

  teleported: {
    type: Boolean,
    default: false,
  },

  placement: {
    type: String,
    default: 'bottom-end',
  },

  hideArrow: Boolean,

  offset: {
    type: [Number, String],
    default: 10,
  },

  zIndex: {
    type: [Number, String],
    default: 1000,
  },
});
</script>

<style scoped>

</style>
