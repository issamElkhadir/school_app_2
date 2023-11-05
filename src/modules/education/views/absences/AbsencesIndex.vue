<template>
    <ResourceIndex url="/education/absences"
                   :modes="modes">
      <template #subtitle>
        <PlfBreadcrumb>
          <PlfBreadcrumbEl label="Education"
                           class="text-danger"
                           icon="tblr.IconPackage" />
  
          <PlfBreadcrumbEl :label="$t('absences.title')"
                           :to="{ name: 'admin.absences.table' }" />
  
          <PlfBreadcrumbEl label="Index" />
        </PlfBreadcrumb>
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
  
  import { useI18n } from 'vue-i18n';
  
  const { t } = useI18n();
  
  const modes = [
    {
      title: t('views.modes.table'),
      to: { name: 'admin.absences.table' },
      icon: 'mdi.IconTable',
    }
  ];
  </script>