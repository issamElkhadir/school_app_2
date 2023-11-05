<template>
  <ResourceUpdate resource="translations"
                  :id="+id"
                  :title="$t('translations.title')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl :label="$t('translations.title')"
                         :to="{ name: 'admin.translations.table' }"/>

        <PlfBreadcrumbEl :label="original.name ?? 'Edit'"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit"/>

        <PlfButton label="New"
                   :to="{ name: 'admin.translations.create' }"
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

    <template #form="{ record, validation, original, disabled }">
      <h3 class="card-title">Update Translation {{ original.name }}</h3>

      <TranslationForm :model-value="record"
                       @update:model-value="record = $event"
                       :disabled="disabled"
                       :validation="validation"/>
    </template>
  </ResourceUpdate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import ResourceUpdate from '@/components/ResourceUpdate.vue';
import TranslationForm from './TranslationForm.vue';

defineProps({
  id: {
    type: [Number, String],
    required: true
  }
});
</script>