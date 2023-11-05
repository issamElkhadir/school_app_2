<template>
  <ResourceTable :title="t('students.title')"
                 :columns="columns"
                 module="education"
                 model="student"
                 url="/education/students" 
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('students.fields.id'), filterable: true, sortable: true, required: true },
  { name: 'first_name', field: 'first_name', label: t('students.fields.first_name'), filterable: true, sortable: true },
  { name: 'last_name', field: 'last_name', label: t('students.fields.last_name'), filterable: true, sortable: true },
  { name: 'image', field: 'image', label: t('students.fields.image'), filterable: false, sortable: true, hidden: true },
  { name: 'rtl_first_name', field: 'rtl_first_name', label: t('students.fields.rtl_first_name'), filterable: true, sortable: true },
  { name: 'rtl_last_name', field: 'rtl_last_name', label: t('students.fields.rtl_last_name'), filterable: true, sortable: true },
  { name: 'cin', field: 'cin', label: t('students.fields.cin'), filterable: true, sortable: true },
  { name: 'cne', field: 'cne', label: t('students.fields.cne'), filterable: true, sortable: true },
  { name: 'birthday', field: 'birthday', label: t('students.fields.birthday'), filterable: true, sortable: true },
  { name: 'gender', field: 'gender', label: t('students.fields.gender'), filterable: true, sortable: true, dataType: '' },
  { name: 'nationality', field: 'nationality', label: t('students.fields.nationality'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'countries' },
  { name: 'native_language', field: 'nativeLanguage', label: t('students.fields.native_language'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'languages' },
  { name: 'second_language', field: 'secondLanguage', label: t('students.fields.second_language'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'languages' },


  // contact fields
  { name: 'contact_address', field: 'contact_address', label: t('students.fields.contact_address'), filterable: true, sortable: true, hidden: true },
  { name: 'contact_rtl_address', field: 'contact_rtl_address', label: t('students.fields.contact_rtl_address'), filterable: true, sortable: true, hidden: true },
  { name: 'contact_name', field: 'contact_name', label: t('students.fields.contact_name'), filterable: true, sortable: true, hidden: true },
  { name: 'contact_email', field: 'contact_email', label: t('students.fields.contact_email'), filterable: true, sortable: true, hidden: true },
  { name: 'contact_whatsapp', field: 'contact_whatsapp', label: t('students.fields.contact_whatsapp'), filterable: true, sortable: true, hidden: true },
  { name: 'contact_website', field: 'contact_website', label: t('students.fields.contact_website'), filterable: true, sortable: true, hidden: true },
  { name: 'contact_phone_1', field: 'contact_phone_1', label: t('students.fields.contact_phone_1'), filterable: true, sortable: true, hidden: true },
  { name: 'contact_phone_2', field: 'contact_phone_2', label: t('students.fields.contact_phone_2'), filterable: true, sortable: true, hidden: true },
  { name: 'contact_mobile_1', field: 'contact_mobile_1', label: t('students.fields.contact_mobile_1'), filterable: true, sortable: true, hidden: true },
  { name: 'contact_mobile_2', field: 'contact_mobile_2', label: t('students.fields.contact_mobile_2'), filterable: true, sortable: true, hidden: true },
  { name: 'contact_fax_1', field: 'contact_fax_1', label: t('students.fields.contact_fax_1'), filterable: true, sortable: true, hidden: true },
  { name: 'contact_fax_2', field: 'contact_fax_2', label: t('students.fields.contact_fax_2'), filterable: true, sortable: true, hidden: true },
  { name: 'country', field: 'country', label: t('students.fields.country'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'countries', hidden: true },
  { name: 'city', field: 'city', label: t('students.fields.city'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'cities', hidden: true },
  { name: 'contact_street', field: 'contact_street', label: t('students.fields.contact_street'), filterable: true, sortable: true, hidden: true },
  { name: 'contact_zip', field: 'contact_zip', label: t('students.fields.contact_zip'), filterable: true, sortable: true, hidden: true },

  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.students.update', params: { id: row.id } };
}
</script>

<style scoped></style>