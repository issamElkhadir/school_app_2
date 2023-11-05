<template>
  <ResourceCreate resource="countries"
                  :title="$t('countries.title')"
                  @saved="onSaved">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Countries"
                         :to="{ name: 'admin.countries.table' }" />

        <PlfBreadcrumbEl label="New" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.countries.table' }" />

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary" />
    </template>

    <template #form="{ record, validation }">
      <h3 class="card-title">New Country</h3>

      <div class="row row-cards">
        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.name')"
                    inline
                    v-model="record.name"
                    :invalid="'name' in validation"
                    :errors="validation.name"
                    required />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.native')"
                    v-model="record.native"
                    inline
                    :invalid="'native' in validation"
                    :errors="validation.native" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.iso3')"
                    inline
                    v-model="record.iso3"
                    :invalid="'iso3' in validation"
                    :errors="validation.iso3" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.numeric_code')"
                    inline
                    v-model="record.numeric_code"
                    :invalid="'numeric_code' in validation"
                    :errors="validation.numeric_code" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.iso2')"
                    inline
                    v-model="record.iso2"
                    :invalid="'iso2' in validation"
                    :errors="validation.iso2" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.phone_code')"
                    inline
                    v-model="record.phone_code"
                    :invalid="'phone_code' in validation"
                    :errors="validation.phone_code" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.capital')"
                    inline
                    v-model="record.capital"
                    :invalid="'capital' in validation"
                    :errors="validation.capital" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.currency')"
                    inline
                    v-model="record.currency"
                    :invalid="'currency' in validation"
                    :errors="validation.currency" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.currency_name')"
                    inline
                    v-model="record.currency_name"
                    :invalid="'currency_name' in validation"
                    :errors="validation.currency_name" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.currency_symbol')"
                    inline
                    v-model="record.currency_symbol"
                    :invalid="'currency_symbol' in validation"
                    :errors="validation.currency_symbol" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.tld')"
                    inline
                    v-model="record.tld"
                    :invalid="'tld' in validation"
                    :errors="validation.tld" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.region')"
                    inline
                    v-model="record.region"
                    :invalid="'region' in validation"
                    :errors="validation.region" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.subregion')"
                    inline
                    v-model="record.subregion"
                    :invalid="'subregion' in validation"
                    :errors="validation.subregion" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.latitude')"
                    type="number"
                    inline
                    v-model="record.latitude"
                    :invalid="'latitude' in validation"
                    :errors="validation.latitude" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.longitude')"
                    type="number"
                    inline
                    v-model="record.longitude"
                    :invalid="'longitude' in validation"
                    :errors="validation.longitude" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.emoji')"
                    inline
                    v-model="record.emoji"
                    :invalid="'emoji' in validation"
                    :errors="validation.emoji" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.emoji_u')"
                    inline
                    v-model="record.emojiU"
                    :invalid="'emojiU' in validation"
                    :errors="validation.emojiU" />
        </div>
      </div>
    </template>
  </ResourceCreate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import { useRouter } from 'vue-router';
import ResourceCreate from '@/components/ResourceCreate.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';

const router = useRouter();

const onSaved = ({ id }) => {
  router.push({ name: 'admin.countries.update', params: { id } });
}
</script>