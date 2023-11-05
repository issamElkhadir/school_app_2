<template>
  <ResourceIndex :title="$t('cities.title')"
                 :modes="modes">
    <template #default="props">
      <RouterView v-bind="props" />
    </template>

    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Cities"
                         :to="{ name: 'admin.cities.table' }" />

        <PlfBreadcrumbEl label="Index" />
      </PlfBreadcrumb>
    </template>

    <template #actions>
      <PlfButton label="New"
                 :to="{ name: 'admin.cities.create' }"
                 icon="mdi.IconPlus"
                 color="primary" />
    </template>
  </ResourceIndex>
</template>

<script setup>
import ResourceIndex from "@/components/ResourceIndex.vue";

import { useI18n } from 'vue-i18n';
import PlfBreadcrumb from "@/components/shared/breadcrumb/PlfBreadcrumb.vue";
import PlfBreadcrumbEl from "@/components/shared/breadcrumb/PlfBreadcrumbEl.vue";
import PlfButton from "@/components/shared/button/PlfButton.vue";

const { t } = useI18n();

const modes = [
  {
    title: t('views.modes.table'),
    to: { name: 'admin.cities.table' }
  },
];
</script>