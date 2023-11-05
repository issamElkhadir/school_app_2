<template>
  <PlfList nav>
    <PlfListItem :to="{ name: 'admin.users.table' }"
                 prepend-icon="tblr.IconUsers">
      {{ $t('users.title') }}
    </PlfListItem>

    <PlfListGroup>
      <template #toggler="props">
        <PlfListItem v-bind="props">
          Resources
        </PlfListItem>
      </template>

      <template #default>
        <PlfListItem :to="{ name: 'admin.countries.table' }"
                     :title="$t('countries.title')" />

        <PlfListItem :to="{ name: 'admin.states.table' }"
                     :title="$t('states.title')" />

        <PlfListItem :to="{ name: 'admin.cities.table' }"
                     :title="$t('cities.title')" />

        <PlfListItem :to="{ name: 'admin.currencies.table' }"
                     :title="$t('currencies.title')" />
      </template>

    </PlfListGroup>

    <PlfListItem :to="{ name: 'admin.measure-unit-categories.table' }"
                 :title="$t('measure-unit-categories.title')" />

    <PlfListItem :to="{ name: 'admin.measure-units.table' }"
                 :title="$t('measure-units.title')" />

    <PlfListItem :to="{ name: 'admin.sequences.table' }"
                 :title="$t('sequences.title')" />

    <PlfListItem :to="{ name: 'admin.mail-servers.table' }"
                 :title="$t('mail-servers.title')" />

    <PlfListItem :to="{ name: 'admin.schools.table' }"
                 :title="$t('schools.title')" />
  </PlfList>
</template>

<script setup>
import PlfListGroup from '@/components/shared/list/PlfListGroup.vue';
import PlfList from '@/components/shared/list/PlfList.vue';
import PlfListItem from '@/components/shared/list/PlfListItem.vue';

</script>