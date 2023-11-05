<template>
  <ResourceCreate resource="education/packs"
                  @saved="onSaved"
                  v-model:record="record">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl :label="$t('packs.title')"
                         :to="{ name: 'admin.packs.table' }"/>

        <PlfBreadcrumbEl label="New"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.packs.table' }"/>

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary"/>
    </template>

    <template #form="props">
      <h3 class="card-title">{{ $t('packs.create') }}</h3>

      <PackForm v-model="props.record"
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
import {ref} from 'vue';
import PackForm from "@education/views/packs/PackForm.vue";

const router = useRouter();

const onSaved = ({id}) => {
  router.push({name: 'admin.packs.update', params: {id}});
}

const record = ref({
  name: '',
  level: {},
  unit: {},
  rtl_name: '',
  short_name: '',
  invoicing_policy: true,
  sale_price: 0,
  vat: 0,
  description: '',
  barcode: '',


});
</script>
