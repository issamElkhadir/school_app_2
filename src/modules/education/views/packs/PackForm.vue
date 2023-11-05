<template>
  <div class="row row-cards">

    <div class="col-md-6">
      <TextField :label="$t('packs.fields.name')"
                 v-model="record.name"
                 :invalid="'name' in validation"
                 :errors="validation.name"
                 :disabled="disabled"
                 required
      />
    </div>

    <div class="col-md-6">
      <TextField :label="$t('packs.fields.rtl_name')"
                 v-model="record.rtl_name"
                 :invalid="'rtl_name' in validation"
                 :errors="validation.rtl_name"
                 :disabled="disabled"
      />
    </div>

    <div class="col-md-6">
      <TextField :label="$t('packs.fields.short_name')"
                 v-model="record.short_name"
                 :invalid="'short_name' in validation"
                 :errors="validation.short_name"
                 :disabled="disabled"
      />
    </div>


    <div class="col-md-6">
      <StateField :label="$t('packs.fields.invoicing_policy')"
                  v-model="record.invoicing_policy"
                  :states="invoicingPolicies"
                  :invalid="'invoicing_policy' in validation"
                  :errors="validation.invoicing_policy"
                  :disabled="disabled"
                  required
      />
    </div>

    <div class="col-md-6">
      <BelongsToField :label="$t('packs.fields.level')"
                      v-model="record.level"
                      resource="education/levels"
                      :invalid="'level.id' in validation"
                      :errors="validation['level.id']"
                      :disabled="disabled"
                      required
      />
    </div>

    <div class="col-md-6">
      <BelongsToField :label="$t('packs.fields.unit')"
                      v-model="record.unit"
                      resource="measure-units"
                      :invalid="'unit.id' in validation"
                      :errors="validation['unit.id']"
                      :disabled="disabled"
                      required
      />
    </div>

    <div class="col-md-6">
      <NumberField :label="$t('packs.fields.sale_price')"
                   v-model="record.sale_price"
                   :invalid="'sale_price' in validation"
                   :errors="validation.sale_price"
                   :disabled="disabled"
      />
    </div>

    <div class="col-md-6">
      <NumberField :label="$t('packs.fields.vat')"
                   v-model="record.vat"
                   :invalid="'vat' in validation"
                   :errors="validation.vat"
                   :disabled="disabled"
      />
    </div>

    <div class="col-md-6">
      <BooleanField :label="$t('packs.fields.status')"
                    v-model="record.status"
                    :invalid="'status' in validation"
                    :errors="validation.status"
                    :disabled="disabled"
      />
    </div>

    <div class="col-md-6">
      <TextField :label="$t('packs.fields.description')"
                 v-model="record.description"
                 type="textarea"
                 :invalid="'description' in validation"
                 :errors="validation.description"
                 :disabled="disabled"
      />
    </div>

    <div class="col-12">
      <HasManyField v-model="record.articles"
                    :columns="cols"
                    :label="$t('packs.fields.articles')"
                    :disabled="disabled"
                    :validation="validation"
                    attribute="articles">

        <template #body-cell-article="{ row, invalid, errors }">
          <BelongsToField resource="education/articles"
                          required
                          :disabled="disabled"
                          v-model="row.article"
                          :errors="errors"
                          :invalid="invalid"/>
        </template>

        <template #body-cell-currency="{ row, invalid, errors }">
          <BelongsToField resource="currencies"
                          required
                          :disabled="disabled"
                          v-model="row.currency"
                          :errors="errors"
                          :invalid="invalid"/>
        </template>

        <template #body-cell-sale_price="{ row, invalid, errors }">
          <TextField v-model="row.sale_price"
                     type="number"
                     :disabled="disabled"
                     :invalid="invalid"
                     :errors="errors"/>
        </template>

        <template #body-cell-vat="{ row, invalid, errors }">
          <TextField v-model="row.vat"
                     type="number"
                     :disabled="disabled"
                     :invalid="invalid"
                     :errors="errors"/>
        </template>

        <template #body-cell-discount="{ row, invalid, errors }">
          <TextField v-model="row.discount"
                     type="number"
                     :disabled="disabled"
                     :invalid="invalid"
                     :errors="errors"/>
        </template>

      </HasManyField>
    </div>

  </div>
</template>

<script setup>
import BelongsToField from '@/fields/forms/BelongsToField.vue';
import {useVModel} from '@vueuse/core';
import TextField from "@/fields/forms/TextField.vue";
import StateField from "@/fields/forms/StateField.vue";
import NumberField from "@/fields/forms/NumberField.vue";
import BooleanField from "@/fields/forms/BooleanField.vue";
import HasManyField from "@/fields/forms/HasManyField.vue";

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {
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

const record = useVModel(props, 'modelValue', emit);

const cols = [
  {name: 'article', field: 'article', label: 'Article'},
  {name: 'currency', field: 'currency', label: 'Currency'},
  {name: 'sale_price', field: 'sale_price', label: 'Sale Price'},
  {name: 'discount', field: 'discount', label: 'Discount'},
  {name: 'vat', field: 'vat', label: 'VAT'},
];

const invoicingPolicies = [
  {value: 1, label: 'Yearly'},
  {value: 2, label: 'Monthly'},
];

</script>