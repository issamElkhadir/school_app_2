<template>
    <FormResourceUpdate resource="education/forms"
                    :id="+id" >
  
      <template #subtitle="{ original }">
        <PlfBreadcrumb>
          <PlfBreadcrumbEl label="Education"
                           class="text-danger"
                           icon="tblr.IconPackage"/>
  
          <PlfBreadcrumbEl :label="$t('forms.title')"
                           :to="{ name: 'admin.forms.table' }"/>
  
          <PlfBreadcrumbEl :label="original.name ?? 'Edit'"/>
        </PlfBreadcrumb>
      </template>
  
      <template #actions="{ disabled, saving, save, toggleEdit }">
        <IconContainer class="d-none d-md-block" icon="mdi.IconEye" icon-size-px="27px" color="#5f6368"
                :tooltip-text="$t('Preview')" />
        <template v-if="disabled">
          <PlfButton label="Edit"
                     @click="toggleEdit"/>
  
          <PlfButton label="New"
                     :to="{ name: 'admin.forms.create' }"
                     icon="mdi.IconPlus"
                     color="primary"/>
        </template>
  
        <template v-else>
          <PlfButton label="Cancel"
                     @click="toggleEdit"/>
  
          <PlfButton label="Save"
                     @click="save"
                     :loading="saving"
                     icon="mdi.IconContentSave"
                     color="primary"/>
        </template>
      </template>
  
      <template #form="{ record, validation, original, disabled  , undo , canUndo , redo , canRedo}">
      <div v-if="mode !== 'preview'">
        <h3 class="card-title">Update Category {{ original.name }}</h3>
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
          :record="record"
          :disabled="disabled"
          :validation="validation"
          :preferences="record.preferences"
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
    </FormResourceUpdate>
  </template>
  
  <script setup>
  import PlfButton from '@/components/shared/button/PlfButton.vue';
  import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
  import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
  import IconContainer from './form-components/IconContainer.vue';
  import ModeLink from './form-components/ModeLink.vue';
  import { computed, ref } from 'vue';
  import FormResourceUpdate from './form-components/FormResourceUpdate.vue';
  import FormForm from './FormForm.vue';
  import FormSettings from './FormSettings.vue';
  import FormResponses from './FormResponses.vue';
  import FormBuilder from './form-builder/FormBuilder.vue';
  

const mode = ref("questions");

const changeMode = (e) => {
    mode.value = e;
}
const selectedComponent = computed(() => {
  if (mode.value === 'questions') {
    return FormForm;
  } else if (mode.value === 'settings') {
    return FormSettings;
  } else {
    return FormResponses;
  }
});
  </script>