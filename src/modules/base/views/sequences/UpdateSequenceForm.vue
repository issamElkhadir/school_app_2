<template>
  <ResourceUpdate resource="sequences"
                  :id="+id"
                  :title="$t('sequences.title')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl :label="$t('sequences.title')"
                         :to="{ name: 'admin.sequences.table' }" />

        <PlfBreadcrumbEl :label="original.name ?? 'Edit'" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit" />

        <PlfButton label="New"
                   :to="{ name: 'admin.sequences.create' }"
                   icon="mdi.IconPlus"
                   color="primary" />
      </template>

      <template v-else>
        <PlfButton label="Cancel"
                   @click="toggleEdit" />

        <PlfButton label="Save"
                   @click="save"
                   :loading="saving"
                   icon="mdi.IconContentSave"
                   color="primary" />
      </template>
    </template>

    <template #form="props">
      <h3 class="card-title">Update Sequence {{ props.original.name }}</h3>

      <SequenceForm v-model:record="props.record"
                    :disabled="props.disabled"
                    :validation="props.validation" />
    </template>
  </ResourceUpdate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import ResourceUpdate from '@/components/ResourceUpdate.vue';
import SequenceForm from './SequenceForm.vue';

defineProps({
  id: {
    type: [Number, String],
    required: true
  }
});
</script>