<template>
  <ResourceTable :title="t('schools.title')"
                 :columns="columns"
                 module="base"
                 model="school"
                 url="/schools"
                 :edit-link="editLink" />
</template>

<script setup>
import ResourceTable from "@/components/ResourceTable.vue";
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const columns = [
  { name: 'id', field: 'id', label: t('schools.fields.id'), filterable: true, sortable: true, required: true, exportable: true },
  { name: 'name', field: 'name', label: t('schools.fields.name'), filterable: true, sortable: true, exportable: true },
  { name: 'rtl_name', field: 'rtl_name', label: t('schools.fields.rtl_name'), filterable: true, sortable: true, exportable: true },
  { name: 'active', field: 'active', label: t('schools.fields.active'), filterable: true, sortable: true, dataType: 'boolean', exportable: true },
  // contact fields
  { name: 'contact_address', field: 'contact_address', label: t('schools.fields.contact_address'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'contact_rtl_address', field: 'contact_rtl_address', label: t('schools.fields.contact_rtl_address'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'contact_name', field: 'contact_name', label: t('schools.fields.contact_name'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'contact_email', field: 'contact_email', label: t('schools.fields.contact_email'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'contact_whatsapp', field: 'contact_whatsapp', label: t('schools.fields.contact_whatsapp'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'contact_website', field: 'contact_website', label: t('schools.fields.contact_website'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'contact_phone_1', field: 'contact_phone_1', label: t('schools.fields.contact_phone_1'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'contact_phone_2', field: 'contact_phone_2', label: t('schools.fields.contact_phone_2'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'contact_mobile_1', field: 'contact_mobile_1', label: t('schools.fields.contact_mobile_1'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'contact_mobile_2', field: 'contact_mobile_2', label: t('schools.fields.contact_mobile_2'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'contact_fax_1', field: 'contact_fax_1', label: t('schools.fields.contact_fax_1'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'contact_fax_2', field: 'contact_fax_2', label: t('schools.fields.contact_fax_2'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'country', field: 'country', label: t('schools.fields.country'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'countries', hidden: true, exportable: true },
  { name: 'city', field: 'city', label: t('schools.fields.city'), filterable: true, sortable: true, dataType: 'belongs-to', resource: 'cities', hidden: true, exportable: true },
  { name: 'contact_street', field: 'contact_street', label: t('schools.fields.contact_street'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'contact_zip', field: 'contact_zip', label: t('schools.fields.contact_zip'), filterable: true, sortable: true, hidden: true, exportable: true },


  { name: 'authorization_date', field: 'authorization_date', label: t('schools.fields.authorization_date'), filterable: true, sortable: true, exportable: true },
  { name: 'authorization_number', field: 'authorization_number', label: t('schools.fields.authorization_number'), filterable: true, sortable: true, exportable: true },
  { name: 'authorization_information', field: 'authorization_information', label: t('schools.fields.authorization_information'), filterable: true, sortable: true, hidden: true, exportable: true },
  { name: 'cnss', field: 'cnss', label: t('schools.fields.cnss'), filterable: true, sortable: true, exportable: true },
  { name: 'rc', field: 'rc', label: t('schools.fields.rc'), filterable: true, sortable: true, exportable: true },
  { name: 'ice', field: 'ice', label: t('schools.fields.ice'), filterable: true, sortable: true, exportable: true },
  { name: 'establishment_type', field: 'establishment_type', label: t('schools.fields.establishment_type'), filterable: true, sortable: true, exportable: true },
  { name: 'responsible_name', field: 'responsible_name', label: t('schools.fields.responsible_name'), filterable: true, sortable: true, exportable: true },
  { name: 'responsible_phone_number', field: 'responsible_phone_number', label: t('schools.fields.responsible_phone_number'), filterable: true, sortable: true, exportable: true },

  { name: 'actions', required: true }
];

const editLink = (row) => {
  return { name: 'admin.schools.update', params: { id: row.id } };
}
</script>

<style scoped></style>