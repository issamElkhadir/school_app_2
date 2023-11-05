<template>
  <div class="d-flex m-3 gap-3 flex-column">
    <div class="row">
      <div class="col">
        <PlfButton @click="generateSchedule"
                   :loading="generatingSchedule"
                   :disabled="disabled"
                   class="btn-primary">

          <PlfIcon name="tblr.IconSettingsAutomation" class="icon"/>
          {{ $t('Generate Schedule') }}
        </PlfButton>
      </div>

      <div class="col">
        <div class="d-flex justify-content-end gap-3">
          <div class="d-flex gap-1 align-items-end flex-column">
            <div>{{ $t('Annual Total') }}:</div>
            <div>{{ $t('Monthly Total') }}:</div>
            <div>{{ $t('All Total') }}:</div>
            <div>{{ $t('Planned Total') }}:</div>
          </div>

          <div class="d-flex gap-1 align-items-end flex-column">
            <strong>{{ paymentScheduled['annual_total'] }} MAD</strong>
            <strong>{{ paymentScheduled['monthly_total'] }} MAD</strong>
            <strong>{{ paymentScheduled['all_total'] }} MAD</strong>
            <strong>{{ paymentScheduled['planned_total'] }} MAD</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex flex-column gap-3">
      <div v-for="(type, key) in paymentTypes"
           :key="`payment-type-${key}`">
        <PlfTable :title="type.title"
                  :columns="columns"
                  height="auto"
                  :hoverable="false"
                  :rows="paymentScheduled.lines[key] ?? []">

          <template #body-cell-amount_to_pay="{ row, rowIndex, column }">
            <PlfTooltip :disabled="!(`paymentScheduled.lines.${key}.${rowIndex}.${column.field}` in validation)"
                        :z-index="1000"
                        fit-content-width
                        placement="top">
              <template #content>
                <div class="px-2">
                  <div v-for="error in validation[`paymentScheduled.lines.${key}.${rowIndex}.${column.field}`]"
                       :key="`validation-${rowIndex}-${error}`"
                       class="d-block">
                    {{ error }}
                  </div>
                </div>
              </template>
              <template #default>
                <TextField type="number"
                           v-model="row[column.field]"
                           :disabled="disabled"
                           :invalid="`paymentScheduled.lines.${key}.${rowIndex}.${column.field}` in validation"
                           hide-label/>
              </template>
            </PlfTooltip>
          </template>

          <template #body-cell-amount_paid="{ row, rowIndex, column }">
            <PlfTooltip :disabled="!(`paymentScheduled.lines.${key}.${rowIndex}.${column.field}` in validation)"
                        :z-index="1000"
                        fit-content-width
                        placement="top">
              <template #content>
                <div class="px-2">
                  <div v-for="error in validation[`paymentScheduled.lines.${key}.${rowIndex}.${column.field}`]"
                       :key="`validation-${rowIndex}-${error}`"
                       class="d-block">
                    {{ error }}
                  </div>
                </div>
              </template>
              <template #default>
                <TextField type="number"
                           :disabled="disabled"
                           v-model="row[column.field]"
                           :invalid="`paymentScheduled.lines.${key}.${rowIndex}.${column.field}` in validation"
                           hide-label/>
              </template>
            </PlfTooltip>
          </template>

          <template #body-cell-payment_date="{ row, rowIndex, column }">
            <PlfTooltip :disabled="!(`paymentScheduled.lines.${key}.${rowIndex}.${column.field}` in validation)"
                        :z-index="1000"
                        fit-content-width
                        placement="top">
              <template #content>
                <div class="px-2">
                  <div v-for="error in validation[`paymentScheduled.lines.${key}.${rowIndex}.${column.field}`]"
                       :key="`validation-${rowIndex}-${error}`"
                       class="d-block">
                    {{ error }}
                  </div>
                </div>
              </template>
              <template #default>
                <PlfDatePicker v-model="row[column.field]"
                               hide-label
                               :disabled="disabled"
                               :popover="{ positionFixed: true }"
                               :invalid="`paymentScheduled.lines.${key}.${rowIndex}.${column.field}` in validation"
                               square/>
              </template>
            </PlfTooltip>
          </template>

          <template #body-cell-actions="{ row, rowIndex }">
            <PlfIcon name="tblr.IconTrash"
                     @click="onRemoveScheduleLine(key, row, rowIndex)"
                     class="text-danger cursor-pointer"/>
          </template>

          <template #bottom-left>
            <PlfButton label="Add New"
                       :disabled="disabled"
                       @click="addRow(key)"
                       class="btn-sm"/>
          </template>
        </PlfTable>
      </div>
    </div>

    <div class="d-flex gap-3 justify-content-end">
<!--      <PlfButton label="Cancel" :disabled="disabled"/>-->

      <PlfButton @click="onSaveClicked"
                 :disabled="disabled"
                 :loading="submitting"
                 class="btn-primary"
                 label="Save"/>
    </div>
  </div>
</template>

<script setup>
import PlfButton from "@/components/shared/button/PlfButton.vue";
import {ref, watch} from "vue";
import PlfTable from "@/components/shared/table/PlfTable.vue";
import PlfDatePicker from "@/components/shared/date-picker/PlfDatePicker.vue";
import {useToast} from "@/components/shared/toast/useToast";
import PlfIcon from "@/components/shared/icon/PlfIcon.vue";
import PlfTooltip from "@/components/shared/tooltip/PlfTooltip.vue";
import TextField from "@/fields/forms/TextField.vue";
import {api} from '@/boot/axios.js';

const emit = defineEmits(['update:schedule']);

const props = defineProps({
  paymentBill: {
    type: Object
  },

  subscription: {
    type: Object
  },

  disabled: {
    type: Boolean,
    default: false
  },

  schedule: {
    type: Object
  }
});

const paymentTypes = {
  YEARLY: {
    title: 'Yearly',
  },

  MONTHLY: {
    title: 'Monthly'
  }
};

const paymentScheduled = ref({
  lines: {
    YEARLY: [],
    MONTHLY: []
  }
});

const columns = [
  {
    field: 'amount_to_pay',
    name: 'amount_to_pay',
    label: 'Amount to pay',
    style: {
      width: '40%'
    }

  },

  {
    field: 'amount_paid',
    name: 'amount_paid',
    label: 'Amount paid',
    style: {
      width: '30%'
    }
  },

  {
    field: 'payment_date',
    name: 'payment_date',
    label: 'Payment date',
    style: {
      width: '30%'
    }
  },

  {
    field: 'actions',
    name: 'actions',
    style: {
      width: '20%'
    }
  }
];

const generatingSchedule = ref(false);
const validation = ref({});

watch(() => props.schedule, val => {
  paymentScheduled.value = val;
}, {deep: true, immediate: true});

const submitting = ref(false);
const toast = useToast();

const onRemoveScheduleLine = (paymentType, row, rowIndex) => {
  if (props.disabled) return;
  paymentScheduled.value.lines[paymentType].splice(rowIndex, 1);
}

const addRow = (paymentType) => {
  if (!(paymentType in paymentScheduled.value.lines)) {
    paymentScheduled.value.lines[paymentType] = [];
  }

  paymentScheduled.value.lines[paymentType].push({
    amount_to_pay: 0,
    amount_paid: 0,
    payment_date: null,
  });
}

const generateSchedule = () => {
  generatingSchedule.value = true;
  api.post(`education/subscriptions/${props.subscription.id}/payment-schedules/generate`,)
      .then(response => {
        paymentScheduled.value = response.data.record;
        toast.add({
          summary: 'Success',
          detail: 'Payment Schedule generated successfully',
          severity: 'success',
          position: 'bottom-right'
        });
      }).catch(error => {
    validation.value = error.response.data.errors;
    toast.add({
      summary: 'Error',
      detail: error.response.data.message,
      severity: 'error',
      position: 'bottom-right'
    });
  }).finally(() => {
    generatingSchedule.value = false;
  });

}

const onSaveClicked = () => {
  submitting.value = true;
  validation.value = {};

  api.post(`education/subscriptions/${props.subscription.id}/payment-schedules`, paymentScheduled.value)
      .then(response => {
        paymentScheduled.value = response.data.record;

        emit('update:schedule', paymentScheduled.value);
        toast.add({
          summary: 'Success',
          detail: 'Payment Schedule saved successfully',
          severity: 'success',
          position: 'bottom-right'
        });

      }).catch(error => {
    validation.value = error.response.data.errors;
    toast.add({
      summary: 'Error',
      detail: error.message,
      severity: 'error',
      position: 'bottom-right'
    });
  }).finally(() => {
    submitting.value = false;
  });


}
</script>

<style scoped>

</style>
