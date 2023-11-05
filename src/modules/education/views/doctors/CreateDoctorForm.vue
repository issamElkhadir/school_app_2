<template>
    <ResourceCreate resource="education/doctors"
                    @saved="onSaved"
                    v-model:record="record">
      <template #subtitle>
        <PlfBreadcrumb>
          <PlfBreadcrumbEl label="Education"
                           class="text-danger"
                           icon="tblr.IconPackage"/>
  
          <PlfBreadcrumbEl :label="$t('doctors.title')"
                           :to="{ name: 'admin.doctors.table' }"/>
  
          <PlfBreadcrumbEl label="New"/>
        </PlfBreadcrumb>
      </template>
  
      <template #actions="{ save, storing }">
        <PlfButton label="Cancel"
                   :to="{ name: 'admin.doctors.table' }"/>
  
        <PlfButton label="Save"
                   @click="save"
                   :loading="storing"
                   icon="mdi.IconContentSave"
                   color="primary"/>
      </template>
  
      <template #form="props">
        <h3 class="card-title">{{ $t('doctors.create') }}</h3>
  
        <DoctorForm v-model="props.record"
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
  import DoctorForm from "@education/views/doctors/DoctorForm.vue";
import { ref } from 'vue';
  
  const router = useRouter();
  
  const onSaved = ({id}) => {
    router.push({name: 'admin.doctors.update', params: {id}});
  }
  const record = ref({
    'email':"example@exemple.com",
    'phone' :'+'
    });
  </script>
  