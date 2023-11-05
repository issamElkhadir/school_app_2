<template>
  <h2 class="mb-0">Payment methods</h2>
  <p class="text-muted">Manage your payment methods.</p>

  <PlfDivider class="my-2" />

  <div class="row">
    <div class="col-md-4">
      <h4 class="text-muted">Card details</h4>
    </div>

    <div class="col-md-8">
      <div class="row">
        <div class="col-md-8 mb-3">
          <PlfInput label="Name on card"
                    model-value="Olivia Rhye" />
        </div>

        <div class="col-md-4 mb-3">
          <PlfInput label="Expiry"
                    model-value="06 / 2024" />
        </div>

        <div class="col-md-8 mb-3">
          <PlfInput label="Card number"
                    model-value="1234 1234 1234 1234">
            <template #prepend>
              <span class="payment payment-provider-mastercard payment-xs"></span>
            </template>
          </PlfInput>
        </div>
        <div class="col-md-4 mb-3">
          <PlfInput label="CVV"
                    type="password"
                    model-value="123" />
        </div>
      </div>
    </div>
  </div>

  <PlfDivider class="my-2" />

  <div class="row">
    <div class="col-md-4">
      <h4 class="text-muted mb-0">Email address</h4>
      <p class="text-muted">Invoices will be sent to this email address.</p>
    </div>

    <div class="col-md-8">
      <div class="mb-2">
        <PlfInput model-value="billing@untiteledui.com">
          <template #prepend>
            <PlfIcon name="mdi.IconEnvelopeOutline" />
          </template>
        </PlfInput>
      </div>

      <PlfButton class="btn-action w-auto px-2"
                 label="Add another"
                 icon="mdi.IconPlus" />
    </div>
  </div>

  <PlfDivider class="my-2" />

  <div class="row">
    <div class="col-md-4 mb-2">
      <h4 class="text-muted mb-0">Street address</h4>
    </div>

    <div class="col-md-8 mb-2">
      <PlfInput model-value="100 Smith Street" />
    </div>
  </div>

  <PlfDivider class="my-2" />

  <div class="row">
    <div class="col-md-4 mb-2">
      <h4 class="text-muted mb-0">City</h4>
    </div>

    <div class="col-md-8 mb-2">
      <PlfInput model-value="Collingwood" />
    </div>
  </div>

  <PlfDivider class="my-2" />

  <div class="row">
    <div class="col-md-4 mb-2">
      <h4 class="text-muted mb-0">State / Province</h4>
    </div>

    <div class="col-md-8 mb-2">
      <div class="row">
        <div class="col">
          <PlfInput model-value="VIC" />
        </div>
        <div class="col">
          <PlfInput model-value="3066" />
        </div>
      </div>
    </div>
  </div>

  <PlfDivider class="my-2" />

  <div class="row">
    <div class="col-md-4 mb-2">
      <h4 class="text-muted mb-0">Country</h4>
    </div>

    <div class="col-md-8 mb-2">
      <PlfInput model-value="Australia" />
    </div>
  </div>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfDivider from '@/components/shared/divider/PlfDivider.vue';
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import '@tabler/core/dist/css/tabler-payments.min.css';

defineProps({
  modelValue: {
    type: Object,
    required: true
  },

  validation: {
    type: Object,
    required: true
  }
});

</script>