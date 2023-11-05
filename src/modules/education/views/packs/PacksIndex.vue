<template>
  <ResourceIndex url="/education/packs"
                 :modes="modes">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl :label="$t('packs.title')"
                         :to="{ name: 'admin.packs.table' }" />

        <PlfBreadcrumbEl label="Index" />
      </PlfBreadcrumb>
    </template>

    <template #actions>
      <PlfButton label="New"
                 :to="{ name: 'admin.packs.create' }"
                 icon="mdi.IconPlus"
                 color="primary" />
    </template>

    <template #default="props">
      <RouterView v-bind="props" />
    </template>
  </ResourceIndex>
</template>

<script setup>
import ResourceIndex from "@/components/ResourceIndex.vue";
import PlfBreadcrumb from "@/components/shared/breadcrumb/PlfBreadcrumb.vue";
import PlfBreadcrumbEl from "@/components/shared/breadcrumb/PlfBreadcrumbEl.vue";
import PlfButton from "@/components/shared/button/PlfButton.vue";

import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const modes = [
  {
    title: t('views.modes.table'),
    to: { name: 'admin.packs.table' },
    icon: 'mdi.IconTable',
  }
];
</script>