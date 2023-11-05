<template>
  <div class="w-full h-full d-flex justify-content-center align-items-center">
    <div style="width: 85%" class="shadow-sm rounded-top-4">
      <div class="w-full bg-primary py-2 rounded-top-4"></div>
      <div class="w-full d-flex flex-column space-x-2">
        <div class="w-full p-3 pb-1 border-bottom border-secondary">
          <h1>{{ data.title }}</h1>
        </div>
        <div class="w-full p-3 pb-1 border-bottom border-secondary">
          <h3>{{ data.description ?? '' }}</h3>
        </div>
        <div class="w-full p-3">
          <div class="flex flex-col space-y-2">
            <div class="flex items-center space-x-2">
              <span class="text-sm font-bold">{{ $t('Starts in') }}:</span>
              <span class="text-lg">{{ data.start_date_time }}</span>
            </div>
            <div class="flex items-center space-x-2">
              <span class="text-sm font-bold">{{ $t('Ends in') }}:</span>
              <span class="text-lg">{{ data.end_date_time }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full px-4 row row-cards">
        <div class="col-md-12">
          <TextField
            :label="$t('Email')"
            v-model="userRecordMutation.email"
            placeholder="exemple@gmail.com"
            required
          />
        </div>
        <div v-if="!updateForm" class="col-md-6">
          <TextField :label="$t('First name')" v-model="userRecordMutation.first_name" required />
        </div>
        <div v-if="!updateForm" class="col-md-6">
          <TextField :label="$t('Last name')" v-model="userRecordMutation.last_name" required />
        </div>
        <div v-if="updateForm" class="col-md-6">
          <PlfInput
            :type="passwordInputType"
            square
            required
            class="m-0"
            v-model="userRecordMutation.password"
            :label="$t('Password')"
          >
            <template #append>
              <PlfIcon
                name="tblr.IconEye"
                @click="togglePasswordVisibility"
                v-if="passwordInputType === 'password'"
                class="icon cursor-pointer"
              />
              <PlfIcon
                name="tblr.IconEyeOff"
                @click="togglePasswordVisibility"
                v-else
                class="icon cursor-pointer"
              />
            </template>

            <template #label="{ label }">
              <label class="form-label px-0">
                {{ label }}
              </label>
            </template>
          </PlfInput>
        </div>
        <div class="col-md-12">
          <span class="text-muted">
            {{
              updateForm
                ? "You haven't signed in to this form before ?"
                : 'Already signed in to this form ?'
            }}
          </span>
          <span
            @click.prevent="() => (updateForm = !updateForm)"
            class="text-primary cursor-pointer"
          >
            {{ updateForm ? 'Click here to sign in' : 'Click here to update it' }}
          </span>
        </div>
      </div>
      <div class="w-full d-flex justify-content-center align-items-center mb-4 mt-4">
        <PlfButton
          v-if="!updateForm"
          class="btn-outline-primary"
          label="Next"
          icon="mdi.IconArrowRight"
          @click="handleCheckEmail"
          :loading="checkingEmail"
        />
        <PlfButton
          v-if="updateForm"
          class="btn-outline-primary"
          label="Next"
          icon="mdi.IconArrowRight"
          @click="handleCheckEmailPassword"
          :loading="checkingEmailPassword"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import { useToast } from '@/components/shared/toast/useToast';
import TextField from '@/fields/forms/TextField.vue';
import { useVModel } from '@vueuse/core';
import { ref } from 'vue';
const toast = useToast();
const updateForm = ref(false);
const emit = defineEmits(['update:userRecord']);
const props = defineProps({
  data: {
    type: Function,
    required: true
  },
  userRecord: {
    type: Object,
    required: true
  },
  checkEmailExistence: {
    type: Function,
    required: true
  },
  checkEmailPassword: {
    type: Function,
    required: true
  },
  checkingEmail: {
    type: Boolean,
    required: true
  },
  checkingEmailPassword: {
    type: Boolean,
    required: true
  }
});
const userRecordMutation = useVModel(props, 'userRecord', emit, {
  passive: true,
  deep: true
});

const handleCheckEmail = () => {
  const { email, first_name, last_name } = userRecordMutation.value;

  if (!email || !first_name || !last_name) {
    return toast.add({
      severity: 'error',
      summary: 'Error',
      detail: 'Please fill all the required fields',
      position: 'bottom-right'
    });
  }

  if (!isValidEmail(email)) {
    return toast.add({
      severity: 'error',
      summary: 'Error',
      detail: 'Invalid email address. Please enter a valid email.',
      position: 'bottom-right'
    });
  }
  props.checkEmailExistence();
};
const handleCheckEmailPassword = () => {
  const { email, password } = userRecordMutation.value;

  if (!email || !password) {
    return toast.add({
      severity: 'error',
      summary: 'Error',
      detail: 'Please fill all the required fields',
      position: 'bottom-right'
    });
  }
  props.checkEmailPassword();
};
const isValidEmail = (email) => {
  const emailRegex = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
  return emailRegex.test(email);
};
const passwordInputType = ref('password');
const togglePasswordVisibility = () => {
  if (passwordInputType.value === 'password') {
    passwordInputType.value = 'text';
  } else {
    passwordInputType.value = 'password';
  }
};
</script>
