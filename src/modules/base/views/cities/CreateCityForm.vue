<template>
  <ResourceCreate resource="cities"
                  :title="$t('cities.title')"
                  @saved="onSaved">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Base"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Cities"
                         :to="{ name: 'admin.cities.table' }" />

        <PlfBreadcrumbEl label="New" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.cities.table' }" />

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary" />
    </template>

    <template #form="{ record, validation }">
      <h3 class="card-title">New City</h3>

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
          <BelongsToField label="State"
                          resource="states"
                          required
                          inline
                          :disabled="disabled"
                          v-model="record.state"
                          :errors="validation['state.id']"
                          :invalid="'state.id' in validation" />
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
          <PlfInput label="State Code"
                    required
                    inline
                    :disabled="disabled"
                    v-model="record.state_code"
                    :errors="validation.state_code"
                    :invalid="'state_code' in validation" />
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
  </ResourceCreate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import PlfSelect from '@/components/shared/select/PlfSelect.vue';
import { useRouter } from 'vue-router';
import ResourceCreate from '@/components/ResourceCreate.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import BelongsToField from '@/fields/forms/BelongsToField.vue';

const router = useRouter();

const status = [
  { value: true, label: 'Active', color: 'bg-success' },
  { value: false, label: 'Inactive', color: 'bg-secondary' }
];

const onSaved = ({ id }) => {
  router.push({ name: 'admin.cities.update', params: { id } });
}
</script>