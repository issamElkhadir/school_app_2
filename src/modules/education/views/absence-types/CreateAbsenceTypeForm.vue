<template>
    <ResourceCreate resource="education/absence-types"
                    @saved="onSaved"
                    v-model:record="record">
      <template #subtitle>
        <PlfBreadcrumb>
          <PlfBreadcrumbEl label="Education"
                           class="text-danger"
                           icon="tblr.IconPackage"/>
  
          <PlfBreadcrumbEl :label="$t('absence-types.title')"
                           :to="{ name: 'admin.absence-types.table' }"/>
  
          <PlfBreadcrumbEl label="New"/>
        </PlfBreadcrumb>
      </template>
  
      <template #actions="{ save, storing }">
        <PlfButton label="Cancel"
                   :to="{ name: 'admin.absence-types.table' }"/>
  
        <PlfButton label="Save"
                   @click="save"
                   :loading="storing"
                   icon="mdi.IconContentSave"
                   color="primary"/>
      </template>
  
      <template #form="props">
        <h3 class="card-title">{{ $t('absence-types.create') }}</h3>
  
        <AbsenceTypeForm v-model="props.record"
                  :validation="props.validation"/>
      </template>
    </ResourceCreate>
  </template>
  
  <script setup>
  import PlfButton from '@/components/shared/button/PlfButton.vue';
  import {useRouter} from 'vue-router';
  import ResourceCreate from '@/components/ResourceCreate.vue';
  import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
  import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
  import AbsenceTypeForm from "@education/views/absence-types/AbsenceTypeForm.vue";
  
  const router = useRouter();
  
  const onSaved = ({id}) => {
    router.push({name: 'admin.absence-types.update', params: {id}});
  }
  </script>
  