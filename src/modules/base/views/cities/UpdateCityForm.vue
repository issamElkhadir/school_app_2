<template>
  <ResourceUpdate resource="cities"
                  :id="id"
                  :title="$t('cities.title')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Cities"
                         :to="{ name: 'admin.cities.table' }" />

        <PlfBreadcrumbEl :label="original.name || 'Edit'" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit" />

        <PlfButton label="New"
                   :to="{ name: 'admin.cities.create' }"
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
      <h3 class="card-title">Update City {{ original.name }}</h3>

      <div class="row row-cards">
        <div class="col-md-6">
          <PlfInput label="Name"
                    inline
                    :disabled="disabled"
                    v-model="record.name"
                    :errors="validation.name"
                    :invalid="'name' in validation"
                    required />
        </div>

        <div class="col-md-6">
          <BelongsToField label="Country"
                          resource="countries"
                          required
                          inline
                          :disabled="disabled"
                          v-model="record.country"
                          :errors="validation['country.id']"
                          :invalid="'country.id' in validation" />
        </div>

        <div class="col-md-6">
          <PlfInput label="Country Code"
                    required
                    inline
                    :disabled="disabled"
                    v-model="record.country_code"
                    :errors="validation.country_code"
                    :invalid="'country_code' in validation" />
        </div>

        <div class="col-md-6">
          <PlfInput label="Fips Code"
                    inline
                    :disabled="disabled"
                    v-model="record.fips_code"
                    :errors="validation.fips_code"
                    :invalid="'fips_code' in validation" />
        </div>

        <div class="col-md-6">
          <PlfInput label="ISO 2"
                    inline
                    :disabled="disabled"
                    v-model="record.iso2"
                    :errors="validation.iso2"
                    :invalid="'iso2' in validation" />
        </div>

        <div class="col-md-6">
          <PlfInput label="Type"
                    inline
                    :disabled="disabled"
                    v-model="record.type"
                    :errors="validation.type"
                    :invalid="'type' in validation" />
        </div>

        <div class="col-md-6">
          <PlfInput label="Latitude"
                    required
                    inline
                    type="number"
                    :disabled="disabled"
                    v-model="record.latitude"
                    :errors="validation.latitude"
                    :invalid="'latitude' in validation" />
        </div>

        <div class="col-md-6">
          <PlfInput label="Longitude"
                    required
                    type="number"
                    :disabled="disabled"
                    inline
                    v-model="record.longitude"
                    :errors="validation.longitude"
                    :invalid="'longitude' in validation" />
        </div>

        <div class="col-md-6">
          <PlfSelect label="Flag"
                     required
                     :disabled="disabled"
                     inline
                     v-model="record.flag"
                     :options="status"
                     emit-value
                     close-on-select
                     :errors="validation.flag"
                     :invalid="'flag' in validation">
            <template #option="{ option, onSelect }">
              <div class="p-2"
                   @click="onSelect(option)">
                <span class="badge"
                      :class="option.color"></span>
                {{ option.label }}
              </div>
            </template>

            <template #select-header="{ option }">
              <div v-if="option"
                   class="flex-fill cursor-pointer d-flex align-items-center">
                <span class="me-1 badge"
                      :class="option.color"></span>
                {{ option.label }}
              </div>
            </template>
          </PlfSelect>
        </div>
      </div>
    </template>
  </ResourceUpdate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import ResourceUpdate from '@/components/ResourceUpdate.vue';
import BelongsToField from '@/fields/forms/BelongsToField.vue';

defineProps({
  id: {
    type: [Number, String],
    required: true
  }
});

const status = [
  { value: true, label: 'Active', color: 'bg-success' },
  { value: false, label: 'Inactive', color: 'bg-secondary' }
];
</script>