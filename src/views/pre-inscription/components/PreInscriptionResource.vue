<template>
  <div class="page-wrapper lvh-100">
    <div class="flex-fill page-body">
      <div class="container-fluid d-flex mb-2 flex-column h-100">
        <div class="row row-cards h-100">
          <div class="col-12 h-100">
            <PlfLoading v-if="loading1" />
            <form v-if="!loading1" class="card h-100 overflow-hidden">
              <div class="card-body h-100">
                <slot  name="form"
                      :data="data"
                      :user-record="userRecord"
                      :show-form="showForm"
                      :change-mode="changeMode"
                      :error1="error1"
                      :error2="error2"
                      :save="save"
                      :update="update"
                      :updating="updating"
                      :checking-email="checkingEmail"
                      :checking-email-password="checkingEmailPassword"
                      :saving="saving"
                      :check-email-existence="checkEmailExistence"
                      :check-email-password="checkEmailPasswordFunc"
                      :updating-mode="updatingMode"
                      :submit-modal="submitModal"
                      :show-submit-modal="showSubmitModal">
                </slot>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useToast } from '@/components/shared/toast/useToast';
import PlfLoading from '@/components/shared/loading/PlfLoading.vue';
import { useRouter } from 'vue-router';
import { useApiGetPreInscriptionBySlug } from '../network/useApiGetPreInscriptionBySlug';
import { useApiPreInscriptionAuth} from '../network/useApiPreInscriptionAuth';
import { useVModel } from '@vueuse/core';
import { useApiStore } from '@/composables/network/resources/useApiStore';

const emit = defineEmits(['saved']);

const props = defineProps({
  currentPath: {
    type: String,
    required: true
  },
  userRecord : {
    type : Object
  }
});

const router = useRouter();
const showForm = ref(false);
const changeMode  = () => {
    showForm.value = !showForm.value
};
const submitModal = ref(false);
const showSubmitModal = () => {
  submitModal.value = !submitModal.value
};

const updatingMode = ref(false);
// data means the data received from the server
const data = ref({});
// user_record means the data collected from the form : answers , email , first name ...
const userRecord = useVModel(props, "userRecord", emit, {
  defaultValue: {},
  passive: true ,
  deep : true
});

const toast = useToast();

const {
  load : load1 ,
  loading : loading1 ,
  error : error1
} = useApiGetPreInscriptionBySlug(props.currentPath);


const {
  check : checkEmail,
  checking : checkingEmail,
  error : error2 
} = useApiPreInscriptionAuth('pre-inscription/check-email');

const {
  check : checkEmailPassword ,
  checking : checkingEmailPassword,
  error : error3
} = useApiPreInscriptionAuth('pre-inscription/check-email-password');

const {
  store,
  storing : saving,
  error : error4,
} = useApiStore('pre-inscription/save-form');
const {
  store : updateFunc,
  storing : updating,
  error : error5,
} = useApiStore('pre-inscription/update-form');

// Load pre inscription data
onMounted(() => {
  load1({
    onSuccess: (response) => {
      data.value = response.data;
      userRecord.value.form_id = data.value.form.id;
    }
  });
});

// check email existence
const checkEmailExistence = () => {
  showForm.value=false;
  checkEmail({email : userRecord.value.email,
    form_id : data.value.form.id},{
    onSuccess: () => {
      showForm.value=true;
    },
    onError : () => {
      toast.add({
        severity: 'error',
        summary: 'Error',
        detail: error2.value ?? 'Something Went Wrong',
        position: 'bottom-right'
      });
    }
  })
}
// check email password
const checkEmailPasswordFunc = () => {
  checkEmailPassword({email : userRecord.value.email,
    form_id : data.value.form.id,
    password : userRecord.value.password},{
    onSuccess: (response) => {
      showForm.value=true;
      updatingMode.value=true;
      userRecord.value.answers = response.data.answers ?? []
      userRecord.value.participator_id = response.data.participator_id ;
    },
    onError : () => {
      updatingMode.value=false;
      toast.add({
        severity: 'error',
        summary: 'Error',
        detail: error3.value ?? 'Something Went Wrong',
        position: 'bottom-right'
      });
    }
  })
}
// save 
const save = () => {
  store(userRecord.value, {
    onSuccess: () => {
      submitModal.value = false;
      
      toast.add({
        severity: 'success',
        summary: 'Success',
        detail: data.value.form.preferences.confirmation_message,
        position: 'bottom-right'
      });
      setTimeout(() => {
        router.push({name: 'login'});
      }, 1000);
    },

    onError: () => {
      submitModal.value = false;
      toast.add({
        severity: 'error',
        summary: 'Error',
        detail: error4.value ?? 'Resource could not be created',
        position: 'bottom-right'
      });
    },
  });
};

const update = () => {
  updateFunc(userRecord.value, {
    onSuccess: () => {
      toast.add({
        severity: 'success',
        summary: 'Success',
        detail: data.value.form.preferences.confirmation_message,
        position: 'bottom-right'
      });
      setTimeout(() => {
        router.push({name: 'login'});
      }, 1000);
    },

    onError: () => {
      toast.add({
        severity: 'error',
        summary: 'Error',
        detail: error5.value ?? 'Resource could not be created',
        position: 'bottom-right'
      });
    },
  });
};
</script>