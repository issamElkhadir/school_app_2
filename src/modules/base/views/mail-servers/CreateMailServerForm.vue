<template>
  <ResourceCreate :title="$t('mail-servers.title')"
                  resource="mail-servers"
                  @saved="onSaved">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl :label="$t('mail-servers.title')"
                         :to="{ name: 'admin.mail-servers.table' }" />

        <PlfBreadcrumbEl label="New" />
      </PlfBreadcrumb>
    </template>

    <template #form="props">
      <MailServerForm v-model:record="props.record"
                      :validation="props.validation" />
    </template>
  </ResourceCreate>
</template>

<script setup>
import ResourceCreate from '@/components/ResourceCreate.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import MailServerForm from './MailServerForm.vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const onSaved = ({ id }) => {
  router.push({
    name: 'admin.mail-servers.update',
    params: { id }
  });
}
</script>