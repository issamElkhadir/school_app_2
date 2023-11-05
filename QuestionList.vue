<template>
  <div class="d-flex gap-2">
    <div class="flex-fill overflow-auto">
      <div class="d-flex gap-3">
        <div ref="questionListWrapper"
             class="w-100 overflow-auto d-flex flex-fill flex-column gap-3">

          <template v-for="(section, index) in sectionsMutation"
                    :key="`section-${index}`">
            <SectionBreakQuestion :index="index"
                                  :sections-count="sectionsMutation.length"
                                  :validation="validation"
                                  :disabled="disabled"
                                  :active="activeSectionIndex === index"
                                  @click="handleSectionClick(index)"
                                  @move="handleMove($event, index)"
                                  @duplicate="handleDuplicate(index)"
                                  @remove-section="handleRemoveSection(index)"
                                  @merge-with-previous-section="handleMergeWithPreviousSection(index)"
                                  v-model="sectionsMutation[index]" />

            <SingleQuestion v-for="(question, index) in questionsBySection[section.slug]"
                            :key="`question-${section.slug}-${question.index}`"
                            :index="question.index"
                            :validation="validation"
                            :disabled="disabled"
                            :is-last="index === questionsBySection[section.slug].length - 1"
                            :is-first="index === 0"
                            @remove-question="handleRemoveQuestion"
                            @copy-question="handleCopyQuestion"
                            @click="onQuestionClick(question.index)"
                            @move-question-down="handleMoveQuestionDown(question.index)"
                            @move-question-up="handleMoveQuestionUp(question.index)"
                            @move-question-first="handleMoveQuestionFirst(question.index)"
                            @move-question-last="handleMoveQuestionLast(question.index)"
                            :active="activeQuestionIndex === question.index"
                            v-model="questionsMutation[question.index]" />
          </template>

        </div>
      </div>
    </div>

    <div style="top: .5em"
         class="position-sticky d-flex flex-column gap-2 align-self-start start-0 end-0">
      <PlfButton class="btn-outline-primary"
                 :title="$t('Add Question')"
                 @click="addQuestion"
                 :disabled="disabled"
                 icon="mdi.IconPlus" />

      <PlfButton class="btn-outline-primary"
                 :title="$t('Add Section')"
                 @click="addSection"
                 :disabled="disabled"
                 icon="mdi.IconViewAgendaOutline" />
    </div>
  </div>
</template>

<script setup>
import { cloneDeep } from 'lodash';
import { useModel } from '../../composables/ui/useModel.js';
import PlfButton from '../shared/button/PlfButton.vue';
import SingleQuestion from './SingleQuestion.vue';
import { computed } from 'vue';
import SectionBreakQuestion from './SectionBreakQuestion.vue';

const emit = defineEmits([
  'update:questions',
  'update:active-question-index',
  'update:active-section-index',
]);

const props = defineProps({
  questions: {
    type: Array,
    required: true,
  },

  sections: {
    type: Array,
    required: true,
  },

  validation: {
    type: Object,
  },

  disabled: {
    type: Boolean,
    default: false,
  },

  activeQuestionIndex: {
    type: Number,
  },

  activeSectionIndex: {
    type: Number,
  },
});

const questionsMutation = useModel(props, 'questions', emit);
const sectionsMutation = useModel(props, 'sections', emit);

const questionsBySection = computed(() => {
  const questions = questionsMutation.value;

  return questions.reduce((acc, question, index) => {
    const section = question.section || 'default';

    if (!acc[section]) {
      acc[section] = [];
    }

    acc[section].push({
      ...question,
      index,
    });

    return acc;
  }, {});
});

const addQuestion = () => {
  let activeQuestion, activeSection;

  if (props.activeQuestionIndex) {
    activeQuestion = questionsMutation.value[props.activeQuestionIndex];
  }

  if (props.activeSectionIndex) {
    activeSection = sectionsMutation.value[props.activeSectionIndex];
  }

  let section = activeQuestion?.section || activeSection?.slug;

  if (!section) {
    section = sectionsMutation.value[0]?.slug || 'default';
  }

  questionsMutation.value.push({
    type: 'short-answer',
    title: '',
    required: false,
    section: section,
  });
};

const addSection = () => {
  const section = sectionsMutation.value.length + 1;

  sectionsMutation.value.push({
    title: '',
    slug: `section-${section}`,
  });
};

const handleRemoveQuestion = (_, index) => {
  questionsMutation.value = questionsMutation.value.filter((_, i) => i !== index);
};

const handleCopyQuestion = (_, index) => {
  const copy = cloneDeep(questionsMutation.value[index]);

  delete copy.id;

  questionsMutation.value.splice(index, 0, copy);
};

const handleSectionClick = (index) => {
  emit('update:active-section-index', index);

  emit('update:active-question-index', null);
};

const onQuestionClick = (index) => {
  emit('update:active-question-index', index);

  emit('update:active-section-index', null);
};

const handleRemoveSection = (index) => {
  const section = sectionsMutation.value[index];

  questionsMutation.value = questionsMutation.value.filter((question) => {
    return question.section !== section.slug;
  });

  sectionsMutation.value = sectionsMutation.value.filter((_, i) => i !== index);
};

const handleMergeWithPreviousSection = (index) => {
  const section = sectionsMutation.value[index];
  const previousSection = sectionsMutation.value[index - 1];

  questionsMutation.value = questionsMutation.value.map((question) => {
    if (question.section === section.slug) {
      question.section = previousSection.slug;
    }

    return question;
  });

  sectionsMutation.value = sectionsMutation.value.filter((_, i) => i !== index);
};

const handleMove = (direction, index) => {
  // Move section
  if (direction === 'up' || direction === 'down') {
    const newIndex = direction === 'up' ? index - 1 : index + 1;

    const section = sectionsMutation.value[index];
    const otherSection = sectionsMutation.value[newIndex];

    sectionsMutation.value[index] = otherSection;
    sectionsMutation.value[newIndex] = section;

    return;
  }
}

const handleDuplicate = (index) => {
  const section = sectionsMutation.value[index];

  sectionsMutation.value.splice(index, 0, {
    ...section,
    slug: `${section.slug}-copy`,
  });

  questionsMutation.value = questionsMutation.value.map((question) => {
    if (question.section === section.slug) {
      return {
        ...cloneDeep(question),
        section: `${section.slug}-copy`,
      };
    }

    return question;
  });
}

const handleMoveQuestionDown = (index) => {
  const newIndex = index + 1;
  const question = questionsMutation.value[index];
  const otherQuestion = questionsMutation.value[newIndex];

  questionsMutation.value[index] = otherQuestion;
  questionsMutation.value[newIndex] = question;

  emit('update:active-question-index', newIndex);
};

const handleMoveQuestionUp = (index) => {
  const newIndex = index - 1;
  const question = questionsMutation.value[index];
  const otherQuestion = questionsMutation.value[newIndex];

  questionsMutation.value[index] = otherQuestion;
  questionsMutation.value[newIndex] = question;

  emit('update:active-question-index', newIndex);
};

const handleMoveQuestionFirst = (index) => {
  const question = questionsMutation.value[index];

  questionsMutation.value.splice(index, 1);
  questionsMutation.value.unshift(question);

  emit('update:active-question-index', 0);
};

const handleMoveQuestionLast = (index) => {
  const question = questionsMutation.value[index];

  questionsMutation.value.splice(index, 1);
  questionsMutation.value.push(question);

  emit('update:active-question-index', questionsMutation.value.length - 1);
};
</script>
