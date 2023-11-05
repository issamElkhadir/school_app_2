<template>
  <ResourceIndex :title="$t('')"
                 :modes="modes">
    <template #default="props">
      <RouterView v-bind="props" />
    </template>

    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Academic Years"
                         :to="{ name: 'admin.academic-years.table' }" />

        <PlfBreadcrumbEl label="Index" />
      </PlfBreadcrumb>
    </template>

    <template #actions>
      <PlfButton label="New"
                 :to="{ name: 'admin.academic-years.create' }"
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
    to: { name: 'admin.academic-years.table' }
  },
];
</script>