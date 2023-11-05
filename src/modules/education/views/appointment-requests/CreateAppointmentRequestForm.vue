<template>
    <ResourceCreate resource="education/appointment-requests"
                    @saved="onSaved"
                    v-model:record="record">
      <template #subtitle>
        <PlfBreadcrumb>
          <PlfBreadcrumbEl label="Education"
                           class="text-danger"
                           icon="tblr.IconPackage"/>
  
          <PlfBreadcrumbEl :label="$t('appointment-requests.title')"
                           :to="{ name: 'admin.appointment-requests.table' }"/>
  
          <PlfBreadcrumbEl label="New"/>
        </PlfBreadcrumb>
      </template>
  
      <template #actions="{ save, storing }">
        <PlfButton label="Cancel"
                   :to="{ name: 'admin.appointment-requests.table' }"/>
  
        <PlfButton label="Save"
                   @click="save"
                   :loading="storing"
                   icon="mdi.IconContentSave"
                   color="primary"/>
      </template>
  
      <template #form="props">
        <h3 class="card-title">{{ $t('appointment-requests.create') }}</h3>
  
        <AppointmentRequestForm v-model="props.record"
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
  import AppointmentRequestForm from "@education/views/appointment-requests/AppointmentRequestForm.vue";
  
  const router = useRouter();
  
  const onSaved = ({id}) => {
    router.push({name: 'admin.appointment-requests.update', params: {id}});
  }

  </script>
  