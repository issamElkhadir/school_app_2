<template>
  <div class="d-flex gap-2">
    <div class="flex-fill overflow-auto">
      <div class="d-flex gap-3">
        <div
          ref="questionListWrapper"
          class="w-100 overflow-auto d-flex flex-fill flex-column gap-3"
        >
          <template
            v-for="(section, sectionIndex) in sectionsMutation"
            :key="`section-${sectionIndex}`"
          >
            <SectionBreakQuestion
              :index="sectionIndex"
              :sections-count="sectionsMutation.length"
              :validation="validation"
              :disabled="disabled"
              :active="activeSectionIndex === sectionIndex && activeQuestionIndex === null"
              @click="handleSectionClick(sectionIndex)"
              @move="handleMove($event, sectionIndex)"
              @duplicate="handleDuplicate(sectionIndex)"
              @remove-section="handleRemoveSection(sectionIndex)"
              @merge-with-previous-section="handleMergeWithPreviousSection(sectionIndex)"
              v-model="sectionsMutation[sectionIndex]"
            />

            <SingleQuestion
              v-for="(question, questionIndex) in section.questions"
              :key="`question-${sectionIndex}-${questionIndex}`"
              :question-index="questionIndex"
              :section-index="sectionIndex"
              :validation="validation"
              :disabled="disabled"
              :is-last="questionIndex === section.questions.length - 1"
              :is-first="questionIndex === 0"
              :preferences="preferences"
              @remove-question="handleRemoveQuestion(sectionIndex, questionIndex)"
              @copy-question="handleCopyQuestion(sectionIndex, questionIndex)"
              @click="onQuestionClick(sectionIndex, questionIndex)"
              @move-question-down="handleMoveQuestionDown(sectionIndex, questionIndex)"
              @move-question-up="handleMoveQuestionUp(sectionIndex, questionIndex)"
              @move-question-first="handleMoveQuestionFirst(sectionIndex, questionIndex)"
              @move-question-last="handleMoveQuestionLast(sectionIndex, questionIndex)"
              :active="activeQuestionIndex === questionIndex"
              v-model="section.questions[questionIndex]"
            />
          </template>
        </div>
      </div>
    </div>

    <div
      style="top: 0.5em"
      class="position-sticky d-flex flex-column gap-2 align-self-start start-0 end-0"
    >
    <!-- <PlfButton
        class="btn-outline-primary"
        :title="$t('Customize Theme')"
        icon="mdi.IconPalette"
      /> -->
      <PlfButton
        class="btn-outline-primary"
        :title="$t('Preview')"
        @click="changeMode('preview')"
        :disabled="props.sections.length === 0"
        icon="mdi.IconEye"
      />
      
      <PlfButton
        class="btn-outline-primary"
        :title="$t('Add Question')"
        @click="addQuestion"
        :disabled="props.sections.length === 0 ?? disabled"
        icon="mdi.IconPlus"
      />

      <PlfButton
        class="btn-outline-primary"
        :title="$t('Add Section')"
        @click="addSection"
        :disabled="disabled"
        icon="mdi.IconViewAgendaOutline"
      />

      <PlfButton
        class="btn-outline-primary"
        :title="$t('Undo')"
        @click="undoFunc"
        :disabled="!props.canUndo ?? disabled"
        icon="mdi.IconUndo"
      />
      <PlfButton
        class="btn-outline-primary"
        :title="$t('Redo')"
        @click="redoFunc"
        :disabled="!props.canRedo ?? disabled"
        icon="mdi.IconRedo"
      />
    </div>
  </div>
</template>

<script setup>
import { cloneDeep } from 'lodash';
import { useVModel } from '@vueuse/core';
import SingleQuestion from './SingleQuestion.vue';
import SectionBreakQuestion from './SectionBreakQuestion.vue';
import PlfButton from '@/components/shared/button/PlfButton.vue';

const emit = defineEmits([
  'update:questions',
  'update:sections',
  'update:mode',
  'update:active-question-index',
  'update:active-section-index'
]);

const props = defineProps({
  sections: {
    type: Array,
    required: true
  },

  validation: {
    type: Object
  },

  disabled: {
    type: Boolean,
    default: false
  },

  activeQuestionIndex: {
    type: Number
  },

  activeSectionIndex: {
    type: Number
  },
  undo: {
    type: Function
  },
  redo: {
    type: Function
  },
  canUndo: {
    type: Boolean
  },
  canRedo: {
    type: Boolean
  } ,
  preferences : {
    type : Object
  }  ,
  changeMode : {
    type : Function
  }
});

const undoFunc = () => {
  props.undo();
};
const redoFunc = () => {
  props.redo();
};
const sectionsMutation = useVModel(props, 'sections', emit);

const addQuestion = () => {
  let activeSection;

  if (props.activeSectionIndex) {
    activeSection = sectionsMutation.value[props.activeSectionIndex];
  } else {
    activeSection = sectionsMutation.value[0];
  }
  activeSection.questions.push({
    type: 'short-answer',
    title: '',
    is_required: props.preferences.questions_required_by_default === true ? true : false,
    order: sectionsMutation.value[props.activeSectionIndex].questions
      ? sectionsMutation.value[props.activeSectionIndex].questions.length + 1
      : 1 ,
    points : props.preferences.make_form_as_quiz ? props.preferences.default_question_point_value : null
  });
};

const addSection = () => {
  sectionsMutation.value.push({
    title: '',
    questions: [],
    order: sectionsMutation.value.length + 1
  });
  if(sectionsMutation.value.length <= 1 ){
    emit('update:active-section-index', sectionsMutation.value.length-1);
  }
};

const handleRemoveQuestion = (sectionIndex, questionIndex) => {
  sectionsMutation.value = sectionsMutation.value.filter((section, i) => {
    if (i !== sectionIndex) return true;
    return (section.questions = section.questions.filter((question, j) => {
      return questionIndex !== j;
    }));
  });
  if (sectionsMutation.value[sectionIndex].questions.length === 0) {
    sectionsMutation.value = sectionsMutation.value.filter((section, i) => {
      return i !== sectionIndex;
    });
  }
  sectionsMutation.value[sectionIndex].questions.map(
    (question, index) => (question.order = index + 1)
  );
  sectionsMutation.value.map((section, index) => (section.order = index + 1));
};

const handleCopyQuestion = (sectionIndex, questionIndex) => {
  const question = sectionsMutation.value[sectionIndex].questions[questionIndex];

  const copy = cloneDeep(question);

  delete copy.id;

  sectionsMutation.value[sectionIndex].questions.splice(questionIndex, 0, copy);
  sectionsMutation.value[sectionIndex].questions.map(
    (question, index) => (question.order = index + 1)
  );
};

const handleSectionClick = (index) => {
  emit('update:active-section-index', index);

  emit('update:active-question-index', null);
};

const onQuestionClick = (sectionIndex, questionIndex) => {
  emit('update:active-question-index', questionIndex);

  emit('update:active-section-index', sectionIndex);
};

const handleRemoveSection = (index) => {
  sectionsMutation.value = sectionsMutation.value
    .filter((_, i) => i !== index)
    .map((section, index) => {
      section.order = index + 1;
      return section;
    });
};

const handleMergeWithPreviousSection = (index) => {
  const section = sectionsMutation.value[index];
  const previousSection = sectionsMutation.value[index - 1];

  previousSection.questions = previousSection.questions.concat(section.questions);

  sectionsMutation.value = sectionsMutation.value
    .filter((_, i) => i !== index)
    .map((section, index) => {
      section.order = index + 1;
      return section;
    });
};

const handleMove = (direction, index) => {
  // Move section
  if (direction === 'up' || direction === 'down') {
    const newIndex = direction === 'up' ? index - 1 : index + 1;

    const section = sectionsMutation.value[index];
    const otherSection = sectionsMutation.value[newIndex];

    sectionsMutation.value[index] = otherSection;
    sectionsMutation.value[newIndex] = section;
    sectionsMutation.value.map((section, index) => (section.order = index + 1));
    return;
  }
};

const handleDuplicate = (index) => {
  const section = sectionsMutation.value[index];

  sectionsMutation.value.splice(index, 0, cloneDeep(section))
  sectionsMutation.value.map((section, index) => {
    section.order = index + 1;
    return section;
  });
};

const handleMoveQuestionDown = (sectionIndex, questionIndex) => {
  const newIndex = questionIndex + 1;
  const section = sectionsMutation.value[sectionIndex];

  const question = section.questions[questionIndex];
  const otherQuestion = section.questions[newIndex];

  section.questions[newIndex] = question;
  section.questions[questionIndex] = otherQuestion;

  section.questions.map((question, index) => (question.order = index + 1));

  emit('update:active-question-index', newIndex);
};

const handleMoveQuestionUp = (sectionIndex, questionIndex) => {
  const newIndex = questionIndex - 1;
  const section = sectionsMutation.value[sectionIndex];

  const question = section.questions[questionIndex];
  const otherQuestion = section.questions[newIndex];

  section.questions[newIndex] = question;
  section.questions[questionIndex] = otherQuestion;
  section.questions.map((question, index) => (question.order = index + 1));

  emit('update:active-question-index', newIndex);
};

const handleMoveQuestionFirst = (sectionIndex, questionIndex) => {
  const section = sectionsMutation.value[sectionIndex];

  const question = section.questions[questionIndex];

  section.questions.splice(questionIndex, 1);
  section.questions.unshift(question);
  section.questions.map((question, index) => (question.order = index + 1));

  emit('update:active-question-index', 0);
};

const handleMoveQuestionLast = (sectionIndex, questionIndex) => {
  const section = sectionsMutation.value[sectionIndex];

  const question = section.questions[questionIndex];

  section.questions.splice(questionIndex, 1);
  section.questions.push(question);
  section.questions.map((question, index) => (question.order = index + 1));

  emit('update:active-question-index', section.questions.length - 1);
};
</script>
