<template>
  <div v-if="visible"
       @click="onCheck"
       class="d-inline-flex gap-1 badge rounded-outline border-0"
       :class="chipClasses">

    <slot name="icon"
          :icon="icon">
      <PlfIcon v-if="icon && !selected"
               :name="icon" />

      <PlfIcon name="tblr.IconCheck"
               v-else-if="selected" />
    </slot>

    <slot name="label"
          :label="label"
          class="overflow-hidden">
      <span class="text-truncate">
        {{ label }}
      </span>
    </slot>

    <div v-if="removable"
         @click="removeChip">
      <slot name="remove"
            :remove="removeIcon">
        <PlfIcon :name="removeIcon" />
      </slot>
    </div>

  </div>
</template>

<script setup>

import { computed, ref } from "vue";
import PlfIcon from "../icon/PlfIcon.vue";

const emit = defineEmits(['remove', 'update:modelValue', 'check']);

const props = defineProps({
  label: {
    type: String,
    default: () => '',
  },
  icon: {
    type: String,
    default: () => '',
  },
  color: {
    type: String,
    default: () => 'primary',
  },
  rounded: {
    type: Boolean,
    default: () => false,
  },
  square: {
    type: Boolean,
    default: () => false,
  },
  outlined: {
    type: Boolean,
    default: () => false,
  },
  classes: {
    type: [Array, String, Object],
    default: () => '',
  },
  removable: {
    type: Boolean,
    default: () => false,
  },
  removeIcon: {
    type: String,
    default: () => 'tblr.IconCircleX',
  },

  modelValue: {
    type: Boolean,
    default: () => true,
  },
  selected: {
    type: Boolean,
    default: () => false,
  },
  clickable: {
    type: Boolean,
    default: () => false,
  },
});

const chipClasses = computed(() => {
  return [
    { 'badge-pill': props.rounded },
    [props.outlined ? `text-${props.color}` : `bg-${props.color}`],
    [props.classes],
    { 'rounded-0': props.square }
  ];
  // [outlined ? `text-${color}` : `bg-${color}`, {'rounded-pill': rounded} , classes]
});

const visible = ref(props.modelValue);

const removeChip = () => {
  emit('update:modelValue', false);
  emit('remove');
  visible.value = false;
};

const selected = ref(props.selected);

const onCheck = () => {
  if (!props.clickable) return;

  selected.value = !selected.value;
  emit('check', props.label, selected.value);
};


</script>

<style scoped></style>
