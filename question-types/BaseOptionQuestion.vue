<template>
  <div class="mt-1">
    <component :is="tagName"
               :class="listClass"
               class="d-flex flex-column mb-3 gap-3">
      <li v-for="(option, index) in options"
          :key="`option-${index}`">
        <PlfInput input-classes="fs-4 border-bottom border-hover-primary"
                  v-model="options[index].label"
                  square
                  :disabled="disabled"
                  borderless>
          <template #prefix>
            <slot name="option-icon"></slot>
          </template>

          <template #append>
            <PlfIcon name="mdi.IconAlert"
                     v-if="option.invalid"
                     class="text-warning" />
          </template>

          <template #suffix>
            <PlfButton icon="mdi.IconClose"
                       :disabled="disabled"
                       @click="removeOption(index)"
                       class="btn-action rounded-circle" />
          </template>
        </PlfInput>

      </li>
    </component>
    <div class="d-flex align-items-center justify-content-end">
      <PlfButton class="btn-action"
                 icon="mdi.IconPlus"
                 :disabled="disabled"
                 @click="addOption" />
    </div>
  </div>
</template>

<script setup>
import { computed, watch } from 'vue';
import PlfInput from '../../shared/forms/PlfInput.vue';
import PlfButton from '../../shared/button/PlfButton.vue';
import PlfIcon from '../../shared/icon/PlfIcon.vue';
import { useModel } from '../../../composables/ui/useModel.js';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {
    type: Object,
    default: () => ({})
  },

  tagName: {
    type: String,
    default: 'ul'
  },

  listClass: {
    type: String,
  },

  disabled: {
    type: Boolean,
    default: false
  }
});

const value = useModel(props, 'modelValue', emit);

const options = computed({
  get() {
    return value.value.options || [];
  },

  set(newVal) {
    value.value = {
      ...value.value,
      options: newVal
    };
  }
});

const addOption = () => {
  options.value = options.value.concat({
    label: `Option ${options.value.length + 1}`,
    value: `option-${options.value.length + 1}`
  });
};

const removeOption = (index) => {
  options.value = options.value.filter((_, i) => i !== index);
};

watch(options, (newVal) => {
  // Mark the duplicated option labels as invalid (Except the first one)
  const duplicatedOptions = newVal
    .filter((option, index) => index !== 0 && newVal
      .filter((o) => o.label === option.label)
      .length > 1);

  duplicatedOptions.forEach((option) => {
    option.invalid = true;
  });

  // Remove the invalid flag from the rest of the options
  newVal
    .filter((option) => !duplicatedOptions.includes(option))
    .forEach((option) => {
      option.invalid = false;
    });
}, { deep: true });
</script>