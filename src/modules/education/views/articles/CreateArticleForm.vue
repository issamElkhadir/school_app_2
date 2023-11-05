<template>
  <ResourceCreate resource="education/articles"
                  :title="$t('articles.title')"
                  @saved="onSaved"
                  v-model:record="record">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl :label="$t('articles.title')"
                         :to="{ name: 'admin.articles.table' }"/>

        <PlfBreadcrumbEl label="New"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.articles.table' }"/>

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary"/>
    </template>

    <template #form="props">
      <h3 class="card-title">{{ $t('articles.create') }}</h3>

      <ArticleForm v-model="props.record"
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
import ArticleForm from "@education/views/articles/ArticleForm.vue";

const router = useRouter();

const onSaved = ({id}) => {
  router.push({name: 'admin.articles.update', params: {id}});
}

const record = ref({
  name: '',
  category  : {},
  unit  : {},
  currency  : {},
  rtl_name: '',
  product_type: '',
  invoicing_policy: true,
  sale_price: 0,
  vat: 0,
  default_code: '',
  barcode: '',


});
</script>
