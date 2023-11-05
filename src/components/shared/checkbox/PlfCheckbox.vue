<template>
  <label class="form-check mb-0"
         :for="id">
    <input :id="id"
           class="form-check-input mx-0 me-2"
           :tabindex="tabIndex"
           :value="modelIsArray ? value : trueValue"
           v-bind="{
             indeterminate: modelValue === indeterminateValue && !binary,
             disabled,
             checked: !modelIsArray ? isTrue : !isFalse,
           }"
           :class="{
             'rounded-0': square,
             'rounded-circle': rounded,
             [`bg-${color}`]: !disabled && isTrue,
           }"
           :name="name"
           type="checkbox"
           @change="onChange">
    <slot name="label">
      <span class="form-check-label">{{ label }}</span>
    </slot>
  </label>
</template>

<script setup>
import { computed, toRaw } from "vue";

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  label: {
    type: String,
    default: '',
  },

  id: String,

  modelValue: {
    default: () => null
  },

  disabled: {
    type: Boolean,
    default: false
  },

  // The value to be used when the switch is indeterminate.
  indeterminateValue: {
    type: [Boolean, String, Number],
    default: () => null
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
    type: [String, Boolean, Number, Array, Object],
    default: null
  },

  binary: {
    type: Boolean,
    default: true
  },

  square: {
    type: Boolean,
    default: () => false
  },

  rounded: {
    type: Boolean,
    default: () => false
  },
  toggleOrder: {
    type: String,
    default: () => 'tf',

    validator(value) {
      return ['tf', 'ft'].includes(value);
    }
  },
  color: {
    type: String,
    default: () => 'primary'
  }
});

const onChange = (e) => {
  if (props.disabled) return;

  emit('update:modelValue', getNextValue(), e);
};

const modelIsArray = computed(() =>
  props.value !== void 0 && Array.isArray(props.modelValue)
);

const index = computed(() => {
  const val = toRaw(props.value)
  return modelIsArray.value === true
    ? props.modelValue.findIndex(opt => toRaw(opt) === val)
    : -1
})

const isTrue = computed(() => (
  modelIsArray.value === true
    ? index.value > -1
    : toRaw(props.modelValue) === toRaw(props.trueValue)
));

const isFalse = computed(() => (
  modelIsArray.value === true
    ? index.value === -1
    : toRaw(props.modelValue) === toRaw(props.falseValue)
));

// const isIndeterminate = computed(() =>
//     isTrue.value === false && isFalse.value === false
// );

function getNextValue() {
  if (modelIsArray.value === true) {
    if (isTrue.value === true) {
      const val = props.modelValue.slice()
      val.splice(index.value, 1)
      return val;
    }

    console.log({ value: props.value });
    return props.modelValue.concat([props.value])
  }

  if (isTrue.value === true) {
    if (props.toggleOrder !== 'ft' || props.binary) {
      return props.falseValue;
    }
  } else if (isFalse.value === true) {
    if (props.toggleOrder === 'ft' || props.binary) {
      return props.trueValue
    }
  } else {
    return props.toggleOrder !== 'ft' ? props.trueValue : props.falseValue
  }

  return props.indeterminateValue
}

const computedColor = computed(() => {
  const name = props.color;

  return {
    name: `var(--tblr-${name})`,
    rgb: `var(--tblr-${name}-rgb)`,
  }
});
</script>

<style scoped>
.form-check-input:focus {
  border-color: rgba(v-bind('computedColor.rgb'), .5) !important;
  box-shadow: 0 0 0 .25rem rgba(v-bind('computedColor.rgb'), .25) !important;
}
</style>
