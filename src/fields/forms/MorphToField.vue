<template>
  <div :class="{ 'flex-column': !inline }"
       class="d-flex flex-column gap-3">
    <SelectField v-if="!hideMorphType"
                 class="flex-fill"
                 :hide-label="hideLabel"
                 :disabled="disabled"
                 :inline="inline"
                 :label="label"
                 option-value="value"
                 :square="square"
                 @update:model-value="onTypeChanged"
                 :invalid="`${attribute}.${morphType}` in validation"
                 :z-index="3"
                 :errors="validation[`${attribute}.${morphType}`]"
                 :model-value="internalValue[morphType]"
                 :options="types" />

    <BelongsToField class="flex-fill"
                    :resource="resource"
                    :hide-label="hideLabel"
                    :errors="validation[`${attribute}.${morphId}`]"
                    :square="square"
                    :disabled="disabled"
                    :label="morphLabel ?? '*'"
                    :inline="inline"
                    :option-label="selectedItem?.optionLabel"
                    :option-value="selectedItem?.optionValue"
                    @update:model-value="onValueChanged"
                    :model-value="computedValue"
    />
  </div>

</template>

<script setup>
import { ref, watch, computed } from 'vue';
import SelectField from './SelectField.vue';
import BelongsToField from './BelongsToField.vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  resource: {
    type: String,
    required: true
  },

  types: {
    type: Array,
    default: () => [],
  },

  square: Boolean,

  label: String,

  inline: Boolean,

  modelValue: Object,

  attribute: {
    type: String,
  },

  disabled: Boolean,

  hideMorphType: Boolean,

  validation: {
    default: {}
  },

  hideLabel: Boolean,

  domains: {
    type: Array,
    default: () => []
  },

  action: {
    type: String,
    required: false
  },
});

const internalValue = ref({});

const computedValue = computed(() => {
  const title = selectedItem.value?.optionLabel;
  const value = selectedItem.value?.optionValue;

  return {
    [title]: internalValue.value[`${props.attribute}_title`],
    [value]: internalValue.value[`${props.attribute}_id`],
  };
});

const morphType = computed(() => `${props.attribute}_type`);
const morphId = computed(() => `${props.attribute}_id`);
const morphTitle = computed(() => `${props.attribute}_title`);

const selectedItem = computed(() => {
  const value = internalValue.value[morphType.value];

  if (value) {
    return props.types.find(item => item.value === value);
  }

  return null;
});

const morphLabel = computed(() => selectedItem.value?.label);
watch(() => props.modelValue, val => {
  if (val) {
    internalValue.value = val;
  } else {
    internalValue.value = {};
  }
}, { immediate: true, deep: true });

const emitValue = () => {
  console.log({internalValue})
  emit('update:modelValue', internalValue.value);
}

const onTypeChanged = ({ value }) => {
  console.log({value}, {internalValue});
  internalValue.value[morphType.value] = value;
  emitValue();
}

const onValueChanged = (val) => {

  console.log('selected Item: ',selectedItem.value.optionValue)
  if (val) {
    internalValue.value[morphId.value] = val[selectedItem.value.optionValue];
    internalValue.value[morphTitle.value] = val[selectedItem.value.optionLabel];
  } else {
    internalValue.value[morphId.value] = null;
    internalValue.value[morphTitle.value] = null;
  }

  emitValue();
}
</script>
