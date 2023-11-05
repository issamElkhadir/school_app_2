<template>
  <label class="form-check m-0 d-flex align-items-center gap-2 p-0"
         :class="{ 'form-check-inline': inline, checked, disabled }"
         @click="onValueChanged">

    <span v-if="leftLabel"
          class="form-check-label">
      <slot name="label">{{ label }}</slot>
    </span>

    <input :tabindex="tabindex"
           type="radio"
           class="form-check-input p-0 m-0 d-none"
           :value="value"
           :name="name"
           v-bind="{ disabled, checked }" />

    <span v-if="checkedIcon && checked"
          class="form-check-icon">
      <PlfIcon :name="checkedIcon" />
    </span>

    <span v-else-if="uncheckedIcon && !checked"
          class="form-check-icon">
      <PlfIcon :name="uncheckedIcon" />
    </span>

    <span v-else
          class="form-check-icon">
      <PlfIcon :name="checked ? 'mdi.IconRadioboxMarked' : 'mdi.IconCheckboxBlankCircleOutline'" />
    </span>

    <span v-if="!leftLabel"
          class="form-check-label">
      <slot name="label">{{ label }}</slot>
    </span>
  </label>
</template>

<script setup>
import { computed } from 'vue';
import PlfIcon from '../icon/PlfIcon.vue';
import {useVModel} from "@vueuse/core";

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  name: {
    type: String,
  },

  tabindex: {
    type: Number,
  },

  label: {
    type: String,
  },

  leftLabel: {
    type: Boolean,
  },

  modelValue: {
    type: [Number, String, Boolean],
  },

  value: {
    type: [Number, String, Boolean],
  },

  disabled: {
    type: Boolean,
  },

  inline: {
    type: Boolean,
  },

  checkedIcon: {
    type: String,
  },

  uncheckedIcon: {
    type: String
  },

  color: {
    type: String,
    default: 'primary'
  },

  dark: {
    type: Boolean,
  }
});

const internalValue = useVModel(props, 'modelValue', emit, { passive: true, defaultValue: false });

const checked = computed(() => internalValue.value === props.value);

const onValueChanged = ($evt) => {
  if (props.disabled) return;

  emit('update:modelValue', props.value, $evt);
}

const computedColor = computed(() => {
  return `var(--tblr-${props.color})`;
});
</script>

<style scoped>
.form-check:not(.disabled) {
  cursor: pointer !important;
}

.form-check.checked .form-check-icon {
  color: v-bind('computedColor');
}

.form-check.disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>