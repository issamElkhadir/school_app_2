<template>
  <ResourceCreate resource="education/subscriptions"
                  :title="$t('')"
                  @saved="onSaved"
                  v-model:record="record">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl  :label="$t('subscriptions.title')"
                         :to="{ name: 'admin.subscriptions.table' }"/>

        <PlfBreadcrumbEl label="New"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.subscriptions.table' }"/>

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary"/>
    </template>

    <template #form="props">

      <h3 class="card-title">{{ $t('subscriptions.create') }}</h3>

      <SubscriptionForm v-model="props.record"
                        @save="props.save"
                        :validation="props.validation"/>

    </template>
  </ResourceCreate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import {useRouter} from 'vue-router';
import ResourceCreate from '@/components/ResourceCreate.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import {ref} from "vue";
import SubscriptionForm from "@education/views/subscriptions/SubscriptionForm.vue";

const router = useRouter();

const onSaved = ({id}) => {
  router.push({name: 'admin.subscriptions.update', params: {id}});
}

const record = ref({
  subscription_date: new Date(),
  student: null,
  class: null,
  sequence: null,
  principal: true,
  paymentBill: {
    sequence: null,
    untaxed_amount: 0,
    tax_amount: 0,
    total_amount: 0,
    paid_amount: 0,
    unpaid_amount: 0,
    currency: {},
    lines: [],
  },
});


</script>