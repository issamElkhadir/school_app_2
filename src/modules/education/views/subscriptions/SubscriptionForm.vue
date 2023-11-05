<template>
  <div class="row row-cards">

    <PlfTabView @tab-change="onTabChange">
      <PlfTabPanel :header="$t('Subscription')">
        <SubscriptionTab v-model:record="record"
                         :validation="validation"
                         :disabled="props.disabled"/>
      </PlfTabPanel>

      <PlfTabPanel :disabled="!record.id"
                   :header="$t('Payment Bill')">
        <SubscriptionPaymentBillTab v-model:payment-bill="record.paymentBill"
                                    :subscription="record"
                                    :disabled="props.disabled"/>
      </PlfTabPanel>

      <PlfTabPanel :disabled="!record.id"
                   :header="$t('Payment Schedule')">
        <SubscriptionScheduleTab v-model:schedule="schedule"
                                 :subscription="record"
                                 :disabled="props.disabled"
                                 :payment-bill="record.paymentBill"/>
      </PlfTabPanel>


      <!--          <PlfTabPanel :disabled="!subscription.id"
                             :header="$t('Payments')">
                  <div class="position-relative">
                    <PaymentsTab v-model:schedule="schedule"
                                 :fields="paymentFields"
                                 :payments="payments"
                                 :subscription="subscription"
                                 @refresh="loadPayments(true)"
                                 :payment-bill="paymentBill" />
                  </div>
                </PlfTabPanel>-->
    </PlfTabView>

  </div>

</template>

<script setup>
import {useVModel} from '@vueuse/core';
import {ref} from 'vue';
import PlfTabPanel from "@/components/shared/tabview/PlfTabPanel.vue";
import PlfTabView from "@/components/shared/tabview/PlfTabView.vue";
import SubscriptionTab from "@education/views/subscriptions/SubscriptionTab.vue";
import SubscriptionPaymentBillTab from "@education/views/subscriptions/SubscriptionPaymentBillTab.vue";
import SubscriptionScheduleTab from "@education/views/subscriptions/SubscriptionScheduleTab.vue";
import {api} from '@/boot/axios.js';

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

const paymentScheduleLoaded = ref(false);
const loadingPaymentSchedule = ref(false);

const schedule = ref({
  lines: {
    YEARLY: [],
    MONTHLY: [],
  }
});

const payments = ref([]);
const paymentsLoaded = ref(false);

const loadPaymentSchedules = () => {
  if (paymentScheduleLoaded.value) return;
  loadingPaymentSchedule.value = true;
  api(`/education/subscriptions/${record.value.id}/payment-schedules`).then(response => {
    console.log({response});
    if (response.data.record) {
      schedule.value = response.data.record;
    }
    paymentScheduleLoaded.value = true;
  }).catch(error => {
    console.log({error: error});
  }).finally(() => {
    loadingPaymentSchedule.value = false;
  });

}

const loadPayments = (force = false) => {
  /*if (paymentsLoaded.value && force === false) return;

  rpc.execute({
    method: 'platform.payment.search',

    params: {
      fields: ['amount', 'customer', 'memo', 'payable', 'payment_date', 'payment_method'],
      filters: {
        pagination: false,
        domains: [
          {
            field: 'payable.subscription.id',
            operation: '=',
            value: subscription.value.id
          }
        ]
      }
    }
  }).then(response => {
    payments.value = response.data.records.map(record => record.data);
    paymentsLoaded.value = true;
  }).catch(error => {
    console.log({ error: error.response.data.data });
  });*/
}

const onTabChange = ({index}) => {
  if (index === 2) {
    loadPaymentSchedules();
  }else if (index === 3) {
    loadPayments();
  }
}

</script>