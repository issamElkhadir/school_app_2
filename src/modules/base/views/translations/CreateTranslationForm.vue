<template>
  <ResourceCreate resource="translations"
                  :title="$t('translations.title')"
                  @saved="onSaved"
                  v-model:record="record">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl :label="$t('translations.title')"
                         :to="{ name: 'admin.translations.table' }"/>

        <PlfBreadcrumbEl label="New"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.translations.table' }"/>

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary"/>
    </template>

    <template #form="props">
      <h3 class="card-title">{{ $t('translations.create') }}</h3>

      <TranslationForm v-model="props.record"
                       :validation="props.validation"/>
    </template>
  </ResourceCreate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import {useRouter} from 'vue-router';
import ResourceCreate from '@/components/ResourceCreate.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import {ref} from 'vue';
import TranslationForm from "@base/views/translations/TranslationForm.vue";

const router = useRouter();

const onSaved = ({id}) => {
  router.push({name: 'admin.translations.update', params: {id}});
}

const record = ref({
  key: '',
  value: '',
  model: '',
  module: '',
  school: {},

});
</script>
