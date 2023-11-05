<template>
  <ResourceIndex title="Countries"
                 :modes="modes">
    <template #default="props">
      <RouterView v-bind="props" />
    </template>

    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Countries"
                         :to="{ name: 'admin.countries.table' }" />

        <PlfBreadcrumbEl label="Index" />
      </PlfBreadcrumb>
    </template>

    <template #actions>
      <PlfButton label="New"
                 :to="{ name: 'admin.countries.create' }"
                 icon="mdi.IconPlus"
                 color="primary" />
    </template>
  </ResourceIndex>
</template>

<script setup>
import ResourceIndex from "@/components/ResourceIndex.vue";
import PlfBreadcrumb from "@/components/shared/breadcrumb/PlfBreadcrumb.vue";
import PlfBreadcrumbEl from "@/components/shared/breadcrumb/PlfBreadcrumbEl.vue";
import PlfButton from "@/components/shared/button/PlfButton.vue";

const modes = [
  {
    title: 'Table',
    to: { name: 'admin.countries.table' }
  }
];
</script>

<style scoped></style>