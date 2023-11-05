<template>
  <PlfDialog
    :model-value="visible"
    @update:modelValue="onCancelClicked"
    :square="square"
    persistent
    modal-dialog-classes="modal-lg"
  >
    <template #default>
      <div class="modal-status rounded-0 bg-primary"></div>

      <div class="modal-body py-4">
        <TextField
          v-model="userRecordMutation.email"
          :value="userRecordMutation.email"
          :label="$t('Email')"
          :disabled="true"
        />
        <div class="password-section mt-2">
          <p class="mb-2">{{ $t('Your Password') }}:</p>
          <div class="w-full d-flex align-items-center gap-2">
            <input
              type="text"
              class="form-control bg-light w-75 custom-disabled-input"
              id="passwordInput"
              readonly
              :value="password"
            />

            <PlfButton
              class="btn-outline-primary"
              icon="mdi.IconRefresh"
              @click="generatePassword"
            />
            <PlfButton
              class="btn-outline-primary"
              icon="mdi.IconContentCopy"
              @click="copyPassword"
              data-clipboard-target="#passwordInput"
            />
          </div>
          <p class="text-muted mt-2">
            {{ $t('Make sure to copy your password to access this form later') }}.
          </p>
        </div>
      </div>

      <div class="modal-footer">
        <div class="w-100">
          <div class="row">
            <div class="col">
              <PlfButton class="btn w-100" :square="square" @click="onCancelClicked">{{
                $t('Cancel')
              }}</PlfButton>
            </div>
            <div class="col">
              <PlfButton
                class="btn btn-primary w-100"
                :square="square"
                :loading="saving"
                @click="save"
                >{{ $t('Submit') }}</PlfButton
              >
            </div>
          </div>
        </div>
      </div>
    </template>
  </PlfDialog>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfDialog from '@/components/shared/dialog/PlfDialog.vue';
import TextField from '@/fields/forms/TextField.vue';
import { ref, watch, watchEffect } from 'vue';
import ClipboardJS from 'clipboard';
import { useVModel } from '@vueuse/core';

const emit = defineEmits(['delete', 'cancel', 'update:visible']);

const props = defineProps({
  visible: Boolean,
  save: {
    type: Function
  },
  square: {
    type: Boolean,
    default: () => false
  },
  userRecord: {
    type: Object
  },
  saving: {
    type: Boolean
  }
});

const userRecordMutation = useVModel(props, 'userRecord', emit, {
  passive: true,
  deep: true
});
const visible = useVModel(props, 'visible', emit);

const onCancelClicked = () => {
  emit('cancel');
  visible.value = false;
};

const generatedPassword = () => {
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  let password = '';

  for (let i = 0; i < 7; i++) {
    const randomIndex = Math.floor(Math.random() * characters.length);
    password += characters.charAt(randomIndex);
  }

  return password;
};

const copyPassword = () => {
  const clipboard = new ClipboardJS('.btn[data-clipboard-target]');
  clipboard.on('success', (e) => {
    e.clearSelection();
  });
};
let password = ref(userRecordMutation.value.password ?? generatedPassword());
watch(password, (newValue) => {
  userRecordMutation.value.password = newValue;
});
watchEffect(() => {
  if (props.visible) {
    userRecordMutation.value.password = password.value ?? '';
  }
});
const generatePassword = () => {
  password.value = generatedPassword();
};

</script>

<style scoped>
.custom-disabled-input {
  background-color: #f5f5f5;
  color: #777;
  border: 1px solid #ccc;
  cursor: not-allowed;
}
</style>
