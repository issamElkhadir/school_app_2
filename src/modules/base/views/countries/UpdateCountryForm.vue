<template>
  <ResourceUpdate resource="countries"
                  :id="id"
                  :title="$t('countries.title')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Countries"
                         :to="{ name: 'admin.countries.table' }" />

        <PlfBreadcrumbEl :label="original.name || 'Edit'" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit" />

        <PlfButton label="New"
                   :to="{ name: 'admin.countries.create' }"
                   icon="mdi.IconPlus"
                   color="primary" />
      </template>

      <template v-else>
        <PlfButton label="Cancel"
                   @click="toggleEdit" />

        <PlfButton label="Save"
                   @click="save"
                   :loading="saving"
                   icon="mdi.IconContentSave"
                   color="primary" />
      </template>
    </template>

    <template #form="{ record, original, validation, disabled }">
      <h3 class="card-title">Update Country {{ original.name }}</h3>

      <div class="row row-cards">
        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.name')"
                    inline
                    :disabled="disabled"
                    v-model="record.name"
                    :invalid="'name' in validation"
                    :errors="validation.name"
                    required />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.native')"
                    v-model="record.native"
                    inline
                    :disabled="disabled"
                    :invalid="'native' in validation"
                    :errors="validation.native" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.iso3')"
                    inline
                    :disabled="disabled"
                    v-model="record.iso3"
                    :invalid="'iso3' in validation"
                    :errors="validation.iso3" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.numeric_code')"
                    inline
                    :disabled="disabled"
                    v-model="record.numeric_code"
                    :invalid="'numeric_code' in validation"
                    :errors="validation.numeric_code" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.iso2')"
                    inline
                    :disabled="disabled"
                    v-model="record.iso2"
                    :invalid="'iso2' in validation"
                    :errors="validation.iso2" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.phone_code')"
                    inline
                    :disabled="disabled"
                    v-model="record.phone_code"
                    :invalid="'phone_code' in validation"
                    :errors="validation.phone_code" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.capital')"
                    inline
                    :disabled="disabled"
                    v-model="record.capital"
                    :invalid="'capital' in validation"
                    :errors="validation.capital" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.currency')"
                    inline
                    :disabled="disabled"
                    v-model="record.currency"
                    :invalid="'currency' in validation"
                    :errors="validation.currency" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.currency_name')"
                    inline
                    :disabled="disabled"
                    v-model="record.currency_name"
                    :invalid="'currency_name' in validation"
                    :errors="validation.currency_name" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.currency_symbol')"
                    inline
                    :disabled="disabled"
                    v-model="record.currency_symbol"
                    :invalid="'currency_symbol' in validation"
                    :errors="validation.currency_symbol" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.tld')"
                    inline
                    :disabled="disabled"
                    v-model="record.tld"
                    :invalid="'tld' in validation"
                    :errors="validation.tld" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.region')"
                    inline
                    :disabled="disabled"
                    v-model="record.region"
                    :invalid="'region' in validation"
                    :errors="validation.region" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.subregion')"
                    inline
                    :disabled="disabled"
                    v-model="record.subregion"
                    :invalid="'subregion' in validation"
                    :errors="validation.subregion" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.latitude')"
                    type="number"
                    inline
                    :disabled="disabled"
                    v-model="record.latitude"
                    :invalid="'latitude' in validation"
                    :errors="validation.latitude" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.longitude')"
                    type="number"
                    inline
                    :disabled="disabled"
                    v-model="record.longitude"
                    :invalid="'longitude' in validation"
                    :errors="validation.longitude" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.emoji')"
                    inline
                    :disabled="disabled"
                    v-model="record.emoji"
                    :invalid="'emoji' in validation"
                    :errors="validation.emoji" />
        </div>

        <div class="col-md-6">
          <PlfInput :label="$t('countries.fields.emoji_u')"
                    inline
                    :disabled="disabled"
                    v-model="record.emojiU"
                    :invalid="'emojiU' in validation"
                    :errors="validation.emojiU" />
        </div>
      </div>
    </template>
  </ResourceUpdate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import ResourceUpdate from '@/components/ResourceUpdate.vue';

defineProps({
  id: {
    type: Number,
    required: true
  }
});
</script>