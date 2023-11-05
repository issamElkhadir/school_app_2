<template>
  <ResourceCreate :title="$t('currencies.title')"
                  resource="currencies"
                  @saved="onSaved">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl :label="$t('currencies.title')"
                         :to="{ name: 'admin.currencies.table' }" />

        <PlfBreadcrumbEl label="New" />
      </PlfBreadcrumb>
    </template>

    <template #form="props">
      <CurrencyForm v-model:record="props.record"
                    :validation="props.validation" />
    </template>
  </ResourceCreate>
</template>

<script setup>
import { useRouter } from 'vue-router';
import ResourceCreate from '@/components/ResourceCreate.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import CurrencyForm from './CurrencyForm.vue';

const router = useRouter();

const onSaved = ({ id }) => {
  router.push({
    name: 'admin.currencies.update',
    params: { id }
  });
}
</script>