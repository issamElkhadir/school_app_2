<template>
  <div class="row row-cards">
    <div class="col-md-6">
      <TextField label="Name"
                 inline
                 :disabled="disabled"
                 v-model="recordMutation.name"
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
                      v-model="recordMutation.country"
                      :errors="validation['country.id']"
                      :invalid="'country.id' in validation" />
    </div>

    <div class="col-md-6">
      <TextField label="Country Code"
                 required
                 inline
                 :disabled="disabled"
                 v-model="recordMutation.country_code"
                 :errors="validation.country_code"
                 :invalid="'country_code' in validation" />
    </div>

    <div class="col-md-6">
      <TextField label="Fips Code"
                 inline
                 :disabled="disabled"
                 v-model="recordMutation.fips_code"
                 :errors="validation.fips_code"
                 :invalid="'fips_code' in validation" />
    </div>

    <div class="col-md-6">
      <TextField label="ISO 2"
                 inline
                 :disabled="disabled"
                 v-model="recordMutation.iso2"
                 :errors="validation.iso2"
                 :invalid="'iso2' in validation" />
    </div>

    <div class="col-md-6">
      <TextField label="Type"
                 inline
                 :disabled="disabled"
                 v-model="recordMutation.type"
                 :errors="validation.type"
                 :invalid="'type' in validation" />
    </div>

    <div class="col-md-6">
      <TextField label="Latitude"
                 required
                 inline
                 type="number"
                 :disabled="disabled"
                 v-model="recordMutation.latitude"
                 :errors="validation.latitude"
                 :invalid="'latitude' in validation" />
    </div>

    <div class="col-md-6">
      <TextField label="Longitude"
                 required
                 type="number"
                 :disabled="disabled"
                 inline
                 v-model="recordMutation.longitude"
                 :errors="validation.longitude"
                 :invalid="'longitude' in validation" />
    </div>

    <div class="col-md-6">
      <BooleanField :true-label="$t('general.status.active')"
                    :false-label="$t('general.status.inactive')"
                    label="Flag"
                    required
                    inline
                    v-model="recordMutation.flag"
                    :errors="validation.flag"
                    :disabled="disabled"
                    :invalid="'flag' in validation" />
    </div>
  </div>
</template>

<script setup>
import BelongsToField from '@/fields/forms/BelongsToField.vue';
import BooleanField from '@/fields/forms/BooleanField.vue';
import TextField from '@/fields/forms/TextField.vue';
import { useVModel } from '@vueuse/core';

const emit = defineEmits(['update:record']);

const props = defineProps({
  record: {
    type: Object,
    required: true
  },

  validation: {
    type: Object,
    required: true
  },

  disabled: {
    type: Boolean,
    default: false
  }
});

const recordMutation = useVModel(props, 'record', emit);
</script>