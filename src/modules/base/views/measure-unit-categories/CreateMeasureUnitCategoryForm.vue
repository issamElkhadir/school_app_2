<template>
  <ResourceCreate resource="measure-unit-categories"
                  :title="$t('measure-unit-categories.title')"
                  @saved="onSaved"
                  v-model:record="record">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="MOU Categories"
                         :to="{ name: 'admin.measure-unit-categories.table' }" />

        <PlfBreadcrumbEl label="New" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.measure-unit-categories.table' }" />

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary" />
    </template>

    <template #form="props">
      <h3 class="card-title">New UOM Category</h3>

      <MeasureUnitCategoryForm v-model:record="props.record"
                               :validation="props.validation" />
    </template>
  </ResourceCreate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import ResourceCreate from '@/components/ResourceCreate.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import MeasureUnitCategoryForm from './MeasureUnitCategoryForm.vue';

const router = useRouter();

const onSaved = ({ id }) => {
  router.push({ name: 'admin.measure-unit-categories.update', params: { id } });
}

const record = ref({
  name: '',
  units: []
});
</script>