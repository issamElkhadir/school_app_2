<template>
  <PreInscriptionResource :currentPath="currentPath">
    <template
      #form="{
        data,
        error1,
        userRecord,
        changeMode,
        showForm,
        save,
        update,
        updating,
        saving,
        checkEmailExistence,
        checkEmailPassword,
        checkingEmailPassword,
        checkingEmail,
        updatingMode,
        submitModal,
        showSubmitModal
      }"
    >
      <div v-if="error1" class="error-section">
        <div class="error-icon">
          <i class="fa fa-exclamation-triangle"></i>
        </div>
        <div class="error-message">
          <h2>{{ $t('Oops! Something Went Wrong') }}</h2>
          <p>{{ error1 }}</p>
        </div>
      </div>
      <div v-else>
        <SubmitModal
          :save="save"
          :saving="saving"
          :user-record="userRecord"
          :visible="submitModal"
          :selected-count="1"
        />
        <PreInscriptionInfo
          v-if="!showForm"
          :check-email-existence="checkEmailExistence"
          :checking-email="checkingEmail"
          :check-email-password="checkEmailPassword"
          :checking-email-password="checkingEmailPassword"
          :user-record="userRecord"
          :data="data"
          :change-mode="changeMode"
        />
        <FormBuilder
          v-if="showForm"
          :record="data.form"
          :is-for-pre-inscription="true"
          :change-mode="changeMode"
          v-model:answers="userRecord.answers"
          :initialize-answers="userRecord.answers ? false : true"
          :show-submit-modal="showSubmitModal"
          :updating-mode="updatingMode"
          :update="update"
          :updating="updating"
        />
      </div>
    </template>
  </PreInscriptionResource>
</template>

<script setup>
import { useRouter } from 'vue-router';
import PreInscriptionResource from './components/PreInscriptionResource.vue';
import PreInscriptionInfo from './components/PreInscriptionInfo.vue';
import FormBuilder from '@/modules/education/views/forms/form-builder/FormBuilder.vue';
import SubmitModal from './components/SubmitModal.vue';

const router = useRouter();
const currentPath = router.currentRoute.value.path ?? null;
</script>

<style scoped>
.error-section {
  border: 2px solid #e3342f;
  background-color: #f56565;
  color: #fff;
  padding: 20px;
  border-radius: 5px;
  display: flex;
  align-items: center;
}

.error-icon {
  margin-right: 20px;
}

.error-message {
  flex-grow: 1;
}
</style>
