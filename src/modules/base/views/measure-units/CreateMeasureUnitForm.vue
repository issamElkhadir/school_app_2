<template>
  <ResourceCreate resource="measure-units"
                  :title="$t('measure-units.title')"
                  @saved="onSaved">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl :label="$t('measure-units.title')"
                         :to="{ name: 'admin.measure-units.table' }" />

        <PlfBreadcrumbEl label="New" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.measure-units.table' }" />

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary" />
    </template>

    <template #form="props">
      <h3 class="card-title">{{ $t('measure-units.create') }}</h3>

      <MeasureUnitForm v-model="props.record"
                       :validation="props.validation" />
    </template>
  </ResourceCreate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import { useRouter } from 'vue-router';
import ResourceCreate from '@/components/ResourceCreate.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import MeasureUnitForm from './MeasureUnitForm.vue';

const router = useRouter();

const onSaved = ({ id }) => {
  router.push({ name: 'admin.measure-units.update', params: { id } });
}
</script>