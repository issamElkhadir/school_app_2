<template>
  <label class="form-check form-switch p-0 mb-0 d-flex gap-2"
         :for="id"
         :class="{'form-check-inline': inline, 'flex-row-reverse': leftLabel}">
    <input
        :id="id"
        class="form-check-input ms-0"
        :tabindex="tabIndex"
        v-bind="{
        disabled,
        checked
      }"
        :class="{'rounded-0': square}"
        :name="name"
        type="checkbox"
        @change="onChange"
    >
    <slot name="label" :label="label">
      <span class="form-check-label">{{ label }}</span>
    </slot>
  </label>
</template>

<script setup>
import {computed} from "vue";

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  label: {
    type: String,
    default: '',
  },

  leftLabel: {
    type: Boolean,
    default: false,
  },

  id: String,

  modelValue: {
    default: () => null
  },

  disabled: {
    type: Boolean,
    default: false
  },

  tabIndex: {
    type: [Number, String],
    default: 0
  },

  trueValue: {
    type: [Boolean, String, Number],
    default: () => true
  },

  falseValue: {
    type: [Boolean, String, Number],
    default: () => false
  },

  name: {
    type: String,
    default: null
  },

  value: {
    default: null
  },

  square: {
    type: Boolean,
    default: () => false
  },

  inline: {
    type: Boolean,
    default: () => false
  }
});

const checked = computed(() => {
  if (Array.isArray(props.modelValue)) {
    return props.modelValue.includes(props.value);
  } else {
    return props.modelValue === props.trueValue;
  }
});

const onChange = (event) => {
  let newValue;
  if (Array.isArray(props.modelValue)) {
    if (event.target.checked) {
      newValue = [...props.modelValue];
      newValue.push(props.value);
    } else {
      newValue = [...props.modelValue];
      newValue.splice(newValue.indexOf(props.value), 1);
    }
  } else {
    newValue = event.target.checked ? props.trueValue : props.falseValue;
  }

  emit('update:modelValue', newValue);
};
</script>
