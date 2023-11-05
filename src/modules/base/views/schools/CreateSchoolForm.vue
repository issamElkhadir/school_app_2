<template>
  <ResourceCreate resource="schools"
                  :title="$t('')"
                  @saved="onSaved">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Schools"
                         :to="{ name: 'admin.schools.table' }" />

        <PlfBreadcrumbEl label="New" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.schools.table' }" />

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary" />
    </template>

    <template #form="props">
      <h3 class="card-title">New School</h3>

      <SchoolForm v-model:record="props.record"
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
import SchoolForm from './SchoolForm.vue';

const router = useRouter();

const onSaved = ({ id }) => {
  router.push({ name: 'admin.schools.update', params: { id } });
}
</script>