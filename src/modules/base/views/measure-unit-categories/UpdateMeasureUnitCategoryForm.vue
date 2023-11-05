<template>
  <ResourceUpdate resource="measure-unit-categories"
                  :id="+id"
                  :title="$t('measure-unit-categories.title')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Measure Unit Categories"
                         :to="{ name: 'admin.measure-unit-categories.table' }" />

        <PlfBreadcrumbEl :label="original.name ?? 'Edit'" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit" />

        <PlfButton label="New"
                   :to="{ name: 'admin.measure-unit-categories.create' }"
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
      <h3 class="card-title">Update Measure Unit Categories {{ props.original.name }}</h3>

      <MeasureUnitCategoryForm :disabled="props.disabled"
                               :validation="props.validation"
                               v-model:record="props.record" />
    </template>
  </ResourceUpdate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import ResourceUpdate from '@/components/ResourceUpdate.vue';
import MeasureUnitCategoryForm from './MeasureUnitCategoryForm.vue';

defineProps({
  id: {
    type: [Number, String],
    required: true
  }
});
</script>