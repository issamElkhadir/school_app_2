<template>
  <ResourceCreate resource="education/forms" @saved="onSaved" v-model:record="record">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education" class="text-danger" icon="tblr.IconPackage" />

        <PlfBreadcrumbEl :label="$t('forms.title')" :to="{ name: 'admin.forms.table' }" />

        <PlfBreadcrumbEl label="New" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel" :to="{ name: 'admin.forms.table' }" />
      <PlfButton
        label="Save"
        @click="save"
        :loading="storing"
        icon="mdi.IconContentSave"
        color="primary"
      />
    </template>

    <template #form="props">
      <div v-if="mode !== 'preview'">
        <div class="w-full justify-content-center align-items-center space-x-3">
          <ModeLink
            text="Questions"
            mode="questions"
            :active="mode === 'questions'"
            @click="changeMode('questions')"
          />
          <ModeLink
            text="Responses"
            mode="responses"
            :active="mode === 'responses'"
            @click="changeMode('responses')"
          />
          <ModeLink
            text="Settings"
            mode="settings"
            :active="mode === 'settings'"
            @click="changeMode('settings')"
          />
        </div>
        <component
          :is="selectedComponent"
          :undo="undo"
          :redo="redo"
          :canUndo="canUndo"
          :canRedo="canRedo"
          v-model:record="record"
          :disabled="props.disabled"
          :validation="props.validation"
          v-model:preferences="record.preferences"
          :change-mode="changeMode"
        />
      </div>
      <!-- preview -->
      <FormBuilder
        v-if="mode === 'preview'"
        :record="record"
        :change-mode="changeMode"
        :is-for-preview="true"
      />
    </template>
  </ResourceCreate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import { useRouter } from 'vue-router';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import ModeLink from './form-components/ModeLink.vue';
import { useVModel, useRefHistory } from '@vueuse/core';
import ResourceCreate from '@/components/ResourceCreate.vue';
import { computed, ref  , watch} from 'vue';
import FormForm from './FormForm.vue';
import FormSettings from './FormSettings.vue';
import FormResponses from './FormResponses.vue';
import FormBuilder from './form-builder/FormBuilder.vue';

const emit = defineEmits(['update:form']);

const props = defineProps({
  form: {
    type: Object,
    required: true,
    default: () => ({})
  }
});
const record = useVModel(props, 'update:form', emit, {
  passive: true,
  deep: true,
  defaultValue: {
    sections: [],
    preferences: {
      make_form_as_quiz: false,
      release_grades: 'immediately_after_each_submission',
      missed_questions: false,
      correct_answers: false,
      point_values: false,
      default_question_point_value: 1,
      questions_required_by_default: false,
      allow_response_editing: false,
      limit_to_1_response: false,
      show_progress_bar: false,
      shuffle_question_order: false,
      confirmation_message: 'Your responses has been recorded',
      view_results_summary: false,
      disable_autosave_for_all_respondents: false
    }
  }
});
const mode = ref('questions');
const router = useRouter();
const changeMode = (e) => {
  mode.value = e;
};
const selectedComponent = computed(() => {
  if (mode.value === 'questions') {
    return FormForm;
  } else if (mode.value === 'settings') {
    return FormSettings;
  } else {
    return FormResponses;
  }
});
const { undo, redo, canUndo, canRedo } = useRefHistory(record, { deep: true });

watch(
  record.value.preferences,
  async () => {
    if (record.value.sections.length > 0) {
      record.value.sections.map((section) => {
        if (section.questions) {
          section.questions.map((question) => {
            question.is_required = record.value.preferences.questions_required_by_default ? true : false;
            if (record.value.preferences.make_form_as_quiz) {
              question.points = record.value.preferences.default_question_point_value;
            } else if (!record.value.preferences.make_form_as_quiz) {
              if (question.points) {
                delete question.points;
              }
            }
          });
        }
      });
    }
  },
  { deep: true }
);
const onSaved = ({ id }) => {
  router.push({ name: 'admin.forms.update', params: { id } });
};
</script>
<style scoped>
.form-info-section {
  width: 95%;
}
.settings {
  font-weight: bold;
  font-size: 18px;
}
.text {
  font-weight: bold;
}
</style>
