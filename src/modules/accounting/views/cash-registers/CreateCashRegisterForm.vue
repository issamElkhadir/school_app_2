<template>
  <ResourceCreate resource="accounting/cash-registers"
                  :title="$t('')"
                  @saved="onSaved">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Cash Registers"
                         :to="{ name: 'admin.accounting.cash-registers.table' }" />

        <PlfBreadcrumbEl label="New" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.accounting.cash-registers.table' }" />

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary" />
    </template>

    <template #form="props">
      <h3 class="card-title">New Cash Register</h3>

      <CashRegisterForm v-model:record="props.record"
                        :validation="props.validation" />
    </template>
  </ResourceCreate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import { useRouter } from 'vue-router';
import ResourceCreate from '@/components/ResourceCreate.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import CashRegisterForm from './CashRegisterForm.vue';

const router = useRouter();

const onSaved = ({ id }) => {
  router.push({ name: 'admin.accounting.cash-registers.update', params: { id } });
}
</script>