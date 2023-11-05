<template>
  <ResourceCreate resource="education/medical-forms"
                  @saved="onSaved"
                  v-model:record="record">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl :label="$t('medical-forms.title')"
                         :to="{ name: 'admin.medical-forms.table' }"/>

        <PlfBreadcrumbEl label="New"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.medical-forms.table' }"/>

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary"/>
    </template>

    <template #form="props">
      <h3 class="card-title">{{ $t('medical-forms.create') }}</h3>

      <MedicalFormForm v-model="props.record"
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
import MedicalFormForm from "@education/views/medical-forms/MedicalFormForm.vue";

const router = useRouter();

const onSaved = ({id}) => {
  router.push({name: 'admin.medical-forms.update', params: {id}});
}

</script>
