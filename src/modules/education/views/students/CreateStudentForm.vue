<template>
  <ResourceCreate resource="education/students"
                  :title="$t('')"
                  @saved="onSaved"
                  v-model:record="record">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl  :label="$t('students.title')"
                         :to="{ name: 'admin.students.table' }"/>

        <PlfBreadcrumbEl label="New"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.students.table' }"/>

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary"/>
    </template>

    <template #form="props">

      <h3 class="card-title">{{ $t('students.create') }}</h3>

      <StudentForm v-model="props.record"
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
import StudentForm from "@education/views/students/StudentForm.vue";
import {ref} from "vue";

const router = useRouter();

const onSaved = ({id}) => {
  router.push({name: 'admin.students.update', params: {id}});
}

const record = ref({
  first_name: '',
  last_name: '',
  image: '',
  rtl_first_name: '',
  rtl_last_name: '',
  gender: '',
  nationality: {},
  birthCity: {},
  cin: '',
  cne: '',
  birthday: '',
  nativeLanguage: {},
  secondLanguage: {},
  quotation: '',
  insurance_name: '',
  insurance_number: '',
  old_school: '',
  old_academy: '',
  old_delegation: '',
  notes: '',
  how_he_knew_the_school: '',
  has_scholarship: '',
  scholarship_holder: '',

  contact_address: '',
  contact_rtl_address: '',
  contact_name: '',
  contact_email: '',
  contact_whatsapp: '',
  contact_website: '',
  contact_phone_1: '',
  contact_phone_2: '',
  contact_mobile_1: '',
  contact_mobile_2: '',
  contact_fax_1: '',
  contact_fax_2: '',
  contact_street: '',
  contact_zip: '',
  city: {},
  country: {},


});

</script>