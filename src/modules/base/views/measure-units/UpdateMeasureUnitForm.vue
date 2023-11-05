<template>
  <ResourceUpdate resource="measure-units"
                  :id="+id"
                  :title="$t('measure-units.title')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl :label="$t('measure-units.title')"
                         :to="{ name: 'admin.measure-units.table' }" />

        <PlfBreadcrumbEl :label="original.name ?? 'Edit'" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit" />

        <PlfButton label="New"
                   :to="{ name: 'admin.measure-units.create' }"
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

      <MeasureUnitForm v-model="props.record"
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
import MeasureUnitForm from './MeasureUnitForm.vue';

defineProps({
  id: {
    type: [Number, String],
    required: true
  }
});
</script>