<template>
  <ResourceCreate resource="education/staff"
                  :title="$t('')"
                  @saved="onSaved">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Staff"
                         :to="{ name: 'admin.staff.table' }" />

        <PlfBreadcrumbEl label="New" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.staff.table' }" />

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary" />
    </template>

    <template  #form="props">
      <h3 class="card-title">{{ $t('staff.create') }}</h3>

      <StaffForm v-model="props.record"
                :validation="props.validation"/>
    </template>
  </ResourceCreate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import { useRouter } from 'vue-router';
import ResourceCreate from '@/components/ResourceCreate.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import StaffForm from "@education/views/staff/StaffForm.vue";

const router = useRouter();

const onSaved = ({ id }) => {
  router.push({ name: 'admin.staff.update', params: { id } });
}

</script>