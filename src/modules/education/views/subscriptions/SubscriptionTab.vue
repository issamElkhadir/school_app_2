<template>
  <div class="d-flex m-3 flex-column">
    <div class="row">
      <div class="col-12 col-md-6 col-lg-6 space-y-2 mb-3">

        <BelongsToField :label="$t('subscriptions.fields.student')"
                        v-model="internalValue.student"
                        option-label="first_name"
                        resource="education/students"
                        :invalid="'student.id' in validation"
                        :errors="internalValidation['student.id']"
                        :disabled="disabled"
                        required
        />

        <BelongsToField :label="$t('subscriptions.fields.class')"
                        v-model="internalValue.class"
                        resource="education/classes"
                        :invalid="'class.id' in validation"
                        :errors="internalValidation['class.id']"
                        :disabled="disabled"
                        required
        />

        <DateField label="Subscription Date"
                   :disabled="disabled"
                   v-model="internalValue.subscription_date"
                   :errors="internalValidation.subscription_date"
        />

      </div>

      <div class="col-12 col-md-6 col-lg-6 space-y-2 mb-3">
        <TextField label="Sequence"
                   :disabled="disabled"
                   :errors="internalValidation.sequence"
                   v-model="internalValue.sequence"/>

        <BooleanField label="Principal"
                      :disabled="disabled"
                      v-model="internalValue.principal"
                      :errors="internalValidation.principal"
                      square/>
      </div>

    </div>

    <div class="d-flex gap-3 justify-content-end">

      <PlfButton @click="onSaveClicked"
                 :disabled="disabled"
                 :loading="submitting"
                 class="btn-primary"
                 label="Save"/>
    </div>
  </div>
</template>

<script setup>
import {computed, ref, watch} from 'vue';
import TextField from "@/fields/forms/TextField.vue";
import PlfButton from "@/components/shared/button/PlfButton.vue";
import DateField from "@/fields/forms/DateField.vue";
import BelongsToField from "@/fields/forms/BelongsToField.vue";
import BooleanField from "@/fields/forms/BooleanField.vue";
import {useApiStore} from "@/composables/network/resources/useApiStore";
import {useRouter} from "vue-router";
import {useToast} from "@/components/shared/toast/useToast";
import {useApiSave} from "@/composables/network/resources/useApiSave";


const props = defineProps({
  record: {
    type: Object,
  },

  disabled: {
    type: Boolean,
    default: false,
  },

  validation: {
    type: Object,
  },
});

const router = useRouter();

const internalValue = ref({});
const submitting = ref(false);

const toast = useToast();


const {
  store,
  validation: createValidation,
  storing,
  // error,
} = useApiStore('education/subscriptions');

const {
  save,
  validation: updateValidation,
  error,
  saving,

} = useApiSave('education/subscriptions');

const internalValidation = computed(() => {
  if ('id' in internalValue.value) {
    return updateValidation.value;
  }
  return createValidation.value;
});

const onSaveClicked = async () => {
  submitting.value = true;
  if ('id' in internalValue.value) {
    await updateSubscription(internalValue.value.id);
  } else {
    await storeSubscription();
  }
  submitting.value = false;
}

const storeSubscription = async () => {
  await store(internalValue.value, {
    onSuccess: (response) => {
      internalValue.value = response.data;
      router.push({
        // name: 'education.subscriptions.update',
        // params: {id: response.data.id},
        path: `${response.data.id}/update`
      })
    },
    onError: (error) => {
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
const updateSubscription = async (id) => {
  await save({
    id,
    payload: internalValue.value,
    onSuccess: (response) => {
      internalValue.value = response.data;
    },
    onError: (error) => {
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


watch(() => props.record, (newValue) => {
  internalValue.value = newValue;
}, {deep: true, immediate: true});


</script>

<style scoped>

</style>
