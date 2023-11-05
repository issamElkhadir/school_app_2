<template>
    <ResourceCreate resource="education/pre-inscriptions"
                    @saved="onSaved"
                    v-model:record="record">
      <template #subtitle>
        <PlfBreadcrumb>
          <PlfBreadcrumbEl label="Education"
                           class="text-danger"
                           icon="tblr.IconPackage"/>
  
          <PlfBreadcrumbEl :label="$t('pre-inscriptions.title')"
                           :to="{ name: 'admin.pre-inscriptions.table' }"/>
  
          <PlfBreadcrumbEl label="New"/>
        </PlfBreadcrumb>
      </template>
  
      <template #actions="{ save, storing }">
        <PlfButton label="Cancel"
                   :to="{ name: 'admin.pre-inscriptions.table' }"/>
  
        <PlfButton label="Save"
                   @click="save"
                   :loading="storing"
                   icon="mdi.IconContentSave"
                   color="primary"/>
      </template>
  
      <template #form="props">
        <h3 class="card-title">{{ $t('pre-inscriptions.create') }}</h3>
  
        <PreInscriptionForm v-model="props.record"
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
  import PreInscriptionForm from "@education/views/pre-inscriptions/PreInscriptionForm.vue";
  
  const router = useRouter();
  
  const onSaved = ({id}) => {
    router.push({name: 'admin.pre-inscriptions.update', params: {id}});
  }
  </script>
  