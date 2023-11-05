<template>
  <div class="row row-cards">

    <div class="col-md-6">
      <TextField :label="$t('articles.fields.name')"
                 v-model="record.name"
                 required
                 :invalid="'name' in validation"
                 :errors="validation.name"
                 :disabled="disabled"/>
    </div>

    <div class="col-md-6">
      <TextField :label="$t('articles.fields.rtl_name')"
                 v-model="record.rtl_name"
                 :invalid="'rtl_name' in validation"
                 :errors="validation.rtl_name"
                 :disabled="disabled"
      />
    </div>

    <div class="col-md-6">
      <StateField :label="$t('articles.fields.product_type')"
                  v-model="record.product_type"
                  :states="productTypes"
                  :invalid="'product_type' in validation"
                  :errors="validation.product_type"
                  :disabled="disabled"
      />
    </div>

    <div class="col-md-6">
      <StateField :label="$t('articles.fields.invoicing_policy')"
                  v-model="record.invoicing_policy"
                  :states="invoicingPolicies"
                  :invalid="'invoicing_policy' in validation"
                  :errors="validation.invoicing_policy"
                  :disabled="disabled"
                  required
      />
    </div>

    <div class="col-md-6">
      <BelongsToField :label="$t('articles.fields.category')"
                      v-model="record.category"
                      resource="education/categories"
                      :invalid="'category.id' in validation"
                      :errors="validation['category.id']"
                      :disabled="disabled"
                      required
      />
    </div>

    <div class="col-md-6">
      <BelongsToField :label="$t('articles.fields.unit')"
                      v-model="record.unit"
                      resource="measure-units"
                      :invalid="'unit.id' in validation"
                      :errors="validation['unit.id']"
                      :disabled="disabled"
                      required
      />
    </div>

    <div class="col-md-6">
      <BelongsToField :label="$t('articles.fields.currency')"
                      v-model="record.currency"
                      resource="currencies"
                      :invalid="'currency.id' in validation"
                      :errors="validation['currency.id']"
                      :disabled="disabled"
                      required
      />
    </div>

    <div class="col-md-6">
      <NumberField :label="$t('articles.fields.sale_price')"
                   v-model="record.sale_price"
                   :invalid="'sale_price' in validation"
                   :errors="validation.sale_price"
                   :disabled="disabled"
      />
    </div>

    <div class="col-md-6">
      <NumberField :label="$t('articles.fields.vat')"
                   v-model="record.vat"
                   :invalid="'vat' in validation"
                   :errors="validation.vat"
                   :disabled="disabled"
      />
    </div>

    <div class="col-md-6">
      <TextField :label="$t('articles.fields.default_code')"
                 v-model="record.default_code"
                 :invalid="'default_code' in validation"
                 :errors="validation.default_code"
                 :disabled="disabled"
      />
    </div>

    <div class="col-md-6">
      <TextField :label="$t('articles.fields.barcode')"
                 v-model="record.barcode"
                 :invalid="'barcode' in validation"
                 :errors="validation.barcode"
                 :disabled="disabled"
      />
    </div>

  </div>
</template>

<script setup>
import BelongsToField from '@/fields/forms/BelongsToField.vue';
import {useVModel} from '@vueuse/core';
import TextField from "@/fields/forms/TextField.vue";
import StateField from "@/fields/forms/StateField.vue";
import NumberField from "@/fields/forms/NumberField.vue";

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

const productTypes = [
  {value: 'service', label: 'Service'},
  {value: 'consumable', label: 'Consumable'},
  {value: 'product', label: 'Product'},
];

const invoicingPolicies = [
  {value: 1, label: 'Yearly'},
  {value: 2, label: 'Monthly'},
];

</script>