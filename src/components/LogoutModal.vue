<template>
  <!-- Logout Dialog -->
  <PlfDialog :model-value="visible"
             seamless
             persistent
             square
             modal-dialog-classes="modal-sm modal-dialog-centered">
    <div class="modal-content rounded-0">
      <div class="modal-status bg-danger rounded-0"></div>

      <div class="modal-body text-center py-4 rounded-0">
        <PlfIcon name="tblr.IconAlertTriangle"
                 class="mb-2 text-danger icon-lg" />
        <h3 class="fw-bold">{{ $t('Are you sure?') }}</h3>
        <div class="text-muted">{{ $t('Are you sure you want to logout?') }}</div>
      </div>
    </div>

    <div class="modal-footer">
      <div class="w-100">
        <div class="row">
          <div class="col">
            <PlfButton @click="emit('update:visible', false)"
                       :disabled="logoutInProgress"
                       class="w-100"
                       square>
              {{ $t('Cancel') }}
            </PlfButton>
          </div>
          <div class="col">
            <PlfButton @click="processLogout"
                       :loading="logoutInProgress"
                       :icon="processed ? 'tblr.IconCheck' : null"
                       class="btn-danger w-100"
                       square>
              {{ $t('Logout') }}
            </PlfButton>
          </div>
        </div>
      </div>
    </div>
  </PlfDialog>
</template>

<script setup>
import { useRouter } from 'vue-router';
import PlfButton from './shared/button/PlfButton.vue';
import PlfDialog from './shared/dialog/PlfDialog.vue';
import PlfIcon from './shared/icon/PlfIcon.vue';
import { ref } from 'vue';
import { useAuthStore } from '@base/stores/auth';

const emit = defineEmits(['update:visible']);

defineProps({
  visible: {
    type: Boolean,
    required: false
  },
});

const auth = useAuthStore();

const router = useRouter();

const logoutInProgress = ref(false);

const processed = ref(false);

const processLogout = async () => {
  logoutInProgress.value = true;

  try {
    await auth.logout();

    processed.value = true;
    
    setTimeout(() => {
      emit('update:visible', false);
      router.push({ name: 'login' });
    }, 300);
  } finally {
    logoutInProgress.value = false;
  }
}
</script>