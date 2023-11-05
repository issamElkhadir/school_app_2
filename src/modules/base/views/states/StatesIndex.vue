<template>
  <ResourceIndex url="states"
                 :title="$t('states.title')"
                 :modes="modes">

    <template #default="props">
      <RouterView v-bind="props" />
    </template>

    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="States"
                         :to="{ name: 'admin.states.table' }" />

        <PlfBreadcrumbEl label="Index" />
      </PlfBreadcrumb>
    </template>

    <template #actions>
      <PlfButton label="New"
                 :to="{ name: 'admin.states.create' }"
                 icon="mdi.IconPlus"
                 color="primary" />
    </template>
  </ResourceIndex>
</template>

<script setup>
import ResourceIndex from '@/components/ResourceIndex.vue';
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const modes = [
  {
    title: t('views.modes.table'),
    to: { name: 'admin.states.table' }
  }
]
</script>