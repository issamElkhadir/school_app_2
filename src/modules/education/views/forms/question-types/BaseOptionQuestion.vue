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
            <PlfIcon v-if="!preferences.make_form_as_quiz" name="mdi.IconRadioButtonUnchecked"
               class="text-muted"/>
          <input v-if="preferences.make_form_as_quiz && (questionType === 'multiplechoicequestion' || questionType === 'checkboxquestion') " 
            :type="questionType === 'multiplechoicequestion' ? 'radio' : 'checkbox'" 
            rounded
            name="option"
            :value="options[index].is_correct"
            @click="handleOptionClick(index)"
            class="form-check-input" />
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
import { computed, watch  } from 'vue';
import { useVModel } from '@vueuse/core';
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';

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
  } ,
  preferences : {
    type : Object ,
    required : true
  } ,
  questionType : {
    type : String ,
    required : true
  }
});

const value = useVModel(props, 'modelValue', emit);

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
    value: `option-${options.value.length + 1}` ,
    is_correct : (props.questionType === 'multiplechoicequestion' || props.questionType === 'checkboxquestion') ? false : null 
  });
};

const handleOptionClick = (index) => {
  if(props.questionType === "multiplechoicequestion") {
    options.value.map((option) => option.is_correct = false );
    options.value[index].is_correct = true ;
  }else if(props.questionType === "checkboxquestion") {
    options.value[index].is_correct = options.value[index].is_correct ? false : true ;
  }
}


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