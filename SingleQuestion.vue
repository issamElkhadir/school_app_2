<template>
  <div class="d-flex border overflow-hidden shadow-sm rounded">
    <div class="flex-fill border border-2"
         :class="{ 'border-primary': active, 'border-transparent': !active }">
    </div>

    <div class="flex-fill d-flex flex-column px-3 py-2 gap-3 w-100">
      <div class="align-self-center">

        <!-- Move Down -->
        <PlfButton icon="mdi.IconChevronUp"
                   class="btn-action"
                   @click.stop="moveQuestionUp"
                   :disabled="disabled || isFirst" />

        <!-- Move First -->
        <PlfButton icon="mdi.IconChevronDoubleUp"
                   class="btn-action"
                   @click.stop="moveQuestionFirst"
                   :disabled="disabled || isFirst" />

        <!-- Move Up -->
        <PlfButton icon="mdi.IconChevronDown"
                   class="btn-action"
                   @click.stop="moveQuestionDown"
                   :disabled="disabled || isLast" />

        <!-- Move Last -->
        <PlfButton icon="mdi.IconChevronDoubleDown"
                   class="btn-action"
                   @click.stop="moveQuestionLast"
                   :disabled="disabled || isLast" />

      </div>
      <div class="flex-fill">
        <PlfInput floating
                  autofocus
                  v-model="value.title"
                  :errors="validation[`questions.${index}.title`]"
                  :disabled="disabled"
                  :invalid="`questions.${index}.title` in validation"
                  :label="$t('Question')">
          <template #append>
            <PlfTooltip z-index="1000"
                        trigger="click"
                        :show-arrow="false"
                        placement="right"
                        :disabled="disabled"
                        position-fixed>
              <PlfButton class="btn-action"
                         :disabled="disabled">
                <PlfIcon name="mdi.IconDotsVertical"
                         class="icon-md" />
              </PlfButton>

              <template #content>
                <PlfList :items="questionsType"
                         mandatory
                         v-model:selected="value.type"
                         select-strategy="single" />
              </template>
            </PlfTooltip>
          </template>
        </PlfInput>

        <component class="mt-3 mb-4"
                   v-model="value"
                   :disabled="disabled"
                   :is="selectedTypeComponent"
                   :options="extraOptions" />

        <PlfDivider class="my-3" />

        <div class="d-flex align-items-center justify-content-end">
          <PlfButton class="btn-action"
                     @click="copyQuestion"
                     :disabled="disabled"
                     icon="mdi.IconContentCopy" />

          <PlfButton class="btn-action"
                     @click="removeQuestion"
                     :disabled="disabled"
                     icon="mdi.IconTrashCanOutline" />

          <PlfDivider vertical
                      class="mx-3" />

          <PlfSwitch label="Required"
                     v-model="value.is_required"
                     :disabled="disabled"
                     left-label />

          <PlfDropdown hide-arrow
                       popper-classes="shadow">
            <template #menu>
              <PlfList v-model:selected="extraOptions"
                       select-strategy="multiple">
                <PlfListItem v-if="selectedType.describeable"
                             value="description"
                             title="Description" />

                <PlfListItem v-if="selectedType.validatable"
                             value="validation"
                             title="Response Validation" />
              </PlfList>
            </template>

            <template #default>

              <PlfButton icon="mdi.IconDotsVertical"
                         class="ms-2 btn-action"
                         :disabled="disabled" />
            </template>
          </PlfDropdown>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import PlfIcon from '../shared/icon/PlfIcon.vue';
import PlfTooltip from '../shared/tooltip/PlfTooltip.vue';
import PlfList from '../shared/list/PlfList.vue';
import PlfDivider from '../shared/divider/PlfDivider.vue';
import PlfSwitch from '../shared/forms/PlfSwitch.vue';
import PlfButton from '../shared/button/PlfButton.vue';
import PlfInput from '../shared/forms/PlfInput.vue';
import { useModel } from '../../composables/ui/useModel.js';

import types from './question-types.js';
import PlfDropdown from '../shared/dropdown/PlfDropdown.vue';
import PlfListItem from '../shared/list/PlfListItem.vue';

const emit = defineEmits([
  'update:modelValue',
  'remove-question',
  'copy-question',
  'move-question-up',
  'move-question-down',
  'move-question-first',
  'move-question-last',
]);

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },

  index: {
    type: Number,
    required: true,
  },

  isFirst: {
    type: Boolean,
    default: false,
  },

  isLast: {
    type: Boolean,
    default: false,
  },

  validation: {
    type: Object,
  },

  disabled: {
    type: Boolean,
    default: false,
  },

  active: {
    type: Boolean,
    default: false,
  },
});

const questionsType = types.filter(q => q.type === 'question');

const value = useModel(props, 'modelValue', emit);

const extraOptions = ref([]);

const selectedType = computed(() => {
  return types.find(type => type.value === value.value.type);
});

const selectedTypeComponent = computed(() => {
  return selectedType.value?.component;
});

const removeQuestion = () => {
  emit('remove-question', value.value, props.index);
};

const copyQuestion = () => {
  emit('copy-question', value.value, props.index);
};

const moveQuestionUp = () => {
  emit('move-question-up', props.index);
};

const moveQuestionDown = () => {
  emit('move-question-down', props.index);
};

const moveQuestionFirst = () => {
  emit('move-question-first', props.index);
};

const moveQuestionLast = () => {
  emit('move-question-last', props.index);
};
</script>

<style scoped>
.border-start-primary {
  border-inline-start-color: var(--tblr-primary) !important;
}

.border-transparent {
  border-color: transparent !important;
}
</style>