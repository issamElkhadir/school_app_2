<template>
  <div class="d-flex gap-3 m-3 flex-column">

    <div class="row">
      <div class="col-md-6">
        <TextField label="Sequence"
                   :disabled="disabled"
                   :errors="internalValidation.sequence"
                   v-model="internalValue.sequence"/>
      </div>

      <div class="col-md-6">
        <BelongsToField resource="currencies"
                        required
                        label="Currency"
                        :disabled="disabled"
                        v-model="internalValue.currency"
                        :errors="internalValidation.currency"
                        :invalid="'currency' in internalValidation"/>
      </div>
    </div>

    <div class="col-12">

      <HasManyField v-model="internalValue.lines"
                    :columns="billColumns"
                    :label="$t('payment-bill.fields.payment-bill-lines')"
                    :disabled="disabled"
                    :validation="internalValidation"
                    attribute="paymentBillLines">

        <template #top-right>
          <PlfButton class="btn-sm ms-2 btn-action w-auto px-2"
                     icon="mdi.IconPlus"
                     :disabled="disabled"
                     @click="onAddArticleClicked"
                     :label="$t('Add Article')"/>

          <PlfButton class="btn-sm ms-2 btn-action w-auto px-2"
                     @click="onAddPackClicked"
                     :disabled="disabled"
                     icon="mdi.IconPlus"
                     :label="$t('Add Pack')"/>
        </template>

        <template #body-cell-name="{ row, invalid, errors }">
          <TextField v-model="row.name"
                     :disabled="disabled"
                     :invalid="invalid"
                     :errors="errors"/>
        </template>

        <template #body-cell-item="{ row, invalid, errors }">
          <MorphToField :validation="invalid"
                        attribute="item"
                        hide-morph-type
                        hide-label
                        :types="lineTypes"
                        :disabled="disabled"
                        :resource="row.resource"
                        :errors="errors"
                        v-model="row.item"/>
        </template>

        <template #body-cell-price_unit="{ row, invalid, errors }">
          <TextField v-model="row.price_unit"
                     type="number"
                     :invalid="invalid"
                     :disabled="disabled"
                     :errors="errors"/>
        </template>

        <template #body-cell-quantity="{ row, invalid, errors }">
          <TextField v-model="row.quantity"
                     type="number"
                     :invalid="invalid"
                     :disabled="disabled"
                     :errors="errors"/>
        </template>

        <template #body-cell-vat="{ row, invalid, errors }">
          <TextField v-model="row.vat"
                     type="number"
                     :invalid="invalid"
                     :disabled="disabled"
                     :errors="errors"/>
        </template>

        <template #body-cell-subtotal="{ row, invalid, errors }">
          <TextField :model-value="row.subtotal"
                     :invalid="invalid"
                     type="number"
                     disabled
                     :errors="errors"/>
        </template>

        <template #body-cell-unit="{ row, invalid, errors }">

          <BelongsToField resource="measure-units"
                          required
                          :disabled="disabled"
                          v-model="row.unit"
                          :errors="errors"
                          :invalid="invalid"/>

        </template>

      </HasManyField>
    </div>

    <div class="d-flex justify-content-end">
      <table class="table w-auto card-table">
        <tr>
          <td class="fw-bold text-end pe-3">{{ $t('Untaxed Amount') }}:</td>
          <td class="text-end p-0">{{ internalValue.untaxed_amount }} MAD</td>
        </tr>
        <tr>
          <td class="fw-bold text-end pe-3">{{ $t('Tax Amount') }}:</td>
          <td class="text-end p-0">{{ internalValue.tax_amount }} MAD</td>
        </tr>
        <tr>
          <td class="fw-bold text-end pe-3">{{ $t('Total Amount') }}:</td>
          <td class="text-end p-0">{{ internalValue.total_amount }} MAD</td>
        </tr>
      </table>
    </div>

    <div class="d-flex gap-3 justify-content-end">
      <PlfButton @click="onSaveClicked" :disabled="disabled" :loading="submitting" class="btn-primary" label="Save"/>
    </div>
  </div>
</template>

<script setup>
import {computed, ref, watch} from 'vue';
import TextField from "@/fields/forms/TextField.vue";
import PlfButton from "@/components/shared/button/PlfButton.vue";
import BelongsToField from "@/fields/forms/BelongsToField.vue";
import HasManyField from "@/fields/forms/HasManyField.vue";
import {useToast} from "@/components/shared/toast/useToast";
import {useApiStore} from "@/composables/network/resources/useApiStore";
import {useApiSave} from "@/composables/network/resources/useApiSave";
import MorphToField from "@/fields/forms/MorphToField.vue";

const emit = defineEmits(['update:paymentBill']);

const props = defineProps({
  paymentBill: {
    type: Object,
  },
  subscription: {
    type: Object,
  },
  disabled: {
    type: Boolean,
    default: false,
  },

});

const internalValue = ref({
  sequence: null,
  untaxed_amount: 0,
  tax_amount: 0,
  total_amount: 0,
  paid_amount: 0,
  unpaid_amount: 0,
  currency: {},
  subscription: {},
  lines: []
});

watch(() => props.paymentBill, (newValue) => {
  if (!newValue) return;

  internalValue.value = newValue;
}, {deep: true, immediate: true});

watch(() => props.subscription, (newValue) => {
  if (!newValue) return;

  internalValue.value.subscription = (({ id }) => ({ id }))(newValue);;
}, {deep: true, immediate: true});

const internalValidation = computed(() => {
  if ('id' in internalValue.value) {
    return updateValidation.value;
  }
  return createValidation.value;
});

const {
  store,
  validation: createValidation,
  storing,
  // error,
} = useApiStore('education/payment-bills');

const {
  save,
  validation: updateValidation,
  error,
  saving,

} = useApiSave('education/payment-bills');

const submitting = ref(false);
const toast = useToast();

const billColumns = [
  {
    field: "item",
    name: "item",
    label: "Item",
  },

  {
    field: "price_unit",
    name: "price_unit",
    label: "Price Unit",
  },

  {
    field: "quantity",
    name: "quantity",
    label: "Quantity",
  },

  {
    field: "vat",
    name: "vat",
    label: "VAT",
  },

  {
    field: "subtotal",
    name: "subtotal",
    label: "Subtotal",
  },

  {
    field: "unit",
    name: "unit",
    label: "Unit",
  },

  {
    field: "actions",
    name: "actions",
  }
];


const addItem = (type = 'article') => {
  const line = ref({
    unit: {},
    price_unit: null,
    quantity: null,
    vat: null,
    subtotal: null,
    resource: `education/${type}s`,
    item: {
      item_type: `education.${type}`
    }
  });

  internalValue.value.lines.push(line.value);
}

const onAddArticleClicked = () => {
  addItem();
}

const onAddPackClicked = () => {
  addItem('pack');
}

const onSaveClicked = async () => {
  if ('id' in internalValue.value) {
    await updateSubscriptionPaymentBill(internalValue.value.id);
  } else {
    await storeSubscriptionPaymentBill();
  }
}

const storeSubscriptionPaymentBill = async () => {
  await store(internalValue.value, {
    onSuccess: ({data}) => {
      emit('update:paymentBill', data);
    },
    onError: (error) => {
      console.log(error)
      toast.add({
        severity: 'error',
        summary: 'Error',
        detail: error.message,
        position: 'bottom-right'
      });
      createValidation.value = error.errors
    }
  });
}
const updateSubscriptionPaymentBill = async (id) => {
  console.log({id})
  await save({
    id,
    payload: internalValue.value,
    onSuccess: ({data}) => {
      console.log({data})
      emit('update:paymentBill', data);
      // router.push({name: 'education.subscriptions.update', params: {id}})
    },
    onError: (error) => {
      console.log({error})
      toast.add({
        severity: 'error',
        summary: 'Error',
        detail: error.message,
        position: 'bottom-right'
      });
      updateValidation.value = error.errors
    }
  });
}


const lineTypes = [
  {
    label: 'Pack',
    optionLabel: 'name',
    optionValue: 'id',
    value: 'education.pack',
  },
  {
    label: 'Article',
    optionLabel: 'name',
    optionValue: 'id',
    value: 'education.article',
  }
]

</script>

<style scoped>

</style>
