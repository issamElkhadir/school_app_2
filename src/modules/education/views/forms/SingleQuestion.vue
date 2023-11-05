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
                  :disabled="disabled"
                  :invalid="`sections.${sectionIndex}.questions.${questionIndex}.title` in validation"
                  :errors="validation[`sections.${sectionIndex}.questions.${questionIndex}.title`]"
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
                   :options="extraOptions" 
                   :preferences="preferences"/>

        <PlfDivider class="my-3" />

        <div :class="preferences.make_form_as_quiz ?'d-flex align-items-center justify-content-between' : 'd-flex align-items-center justify-content-end'">
          <NumberField :disabled="disabled"  v-if="preferences.make_form_as_quiz" :label="$t('points')" v-model="value.points" :value="value.points || preferences.default_question_point_value" />
          <div class="d-flex align-items-center justify-content-between w-25">
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

          <PlfSwitch
                     right-label class="w-100"
                     v-model="value.is_required"
                     :disabled="disabled"
                     :label="$t('required')" />

          <PlfDropdown :disabled="disabled" hide-arrow
                       popper-classes="shadow">
            <template #menu>
              <PlfList  v-model:selected="extraOptions"
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
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useVModel } from '@vueuse/core';
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';
import PlfList from '@/components/shared/list/PlfList.vue';
import types from './question-types.js';
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import PlfTooltip from '@/components/shared/tooltip/PlfTooltip.vue';
import PlfDivider from '@/components/shared/divider/PlfDivider.vue';
import PlfDropdown from '@/components/shared/dropdown/PlfDropdown.vue';
import PlfListItem from '@/components/shared/list/PlfListItem.vue';
import PlfSwitch from '@/components/shared/switch/PlfSwitch.vue';
import NumberField from '@/fields/forms/NumberField.vue';

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

  questionIndex: {
    type: Number,
    required: true,
  },
  sectionIndex: {
    type: Number,
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
  preferences : {
    type : Object
  }
});

const questionsType = types.filter(q => q.type === 'question');

const value = useVModel(props, 'modelValue', emit);

const extraOptions = ref([]);

const selectedType = computed(() => {
  return types.find(type => type.value === value.value.type);
});

const selectedTypeComponent = computed(() => {
  return selectedType.value?.component;
});

const removeQuestion = () => {
  emit('remove-question', value.value, props.questionIndex);
};

const copyQuestion = () => {
  emit('copy-question', value.value, props.questionIndex);
};

const moveQuestionUp = () => {
  emit('move-question-up', props.questionIndex);
};

const moveQuestionDown = () => {
  emit('move-question-down', props.questionIndex);
};

const moveQuestionFirst = () => {
  emit('move-question-first', props.questionIndex);
};

const moveQuestionLast = () => {
  emit('move-question-last', props.questionIndex);
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