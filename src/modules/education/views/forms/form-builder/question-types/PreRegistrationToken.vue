<template>
  <div class="min-dvh-100 container">
    <div class="row min-dvh-100 justify-content-center">
      <!-- Loading -->
      <PlfLoading v-if="loading" />

      <!-- Not Found -->
      <div class="min-dvh-100 col-6 mx-auto d-flex flex-column align-items-center justify-content-center"
           v-else-if="notFound">
        <NotFound description="The pre-registration you're looking for doesn't exists." />
      </div>

      <!-- Expired -->
      <div v-else-if="expired">
        <NotFound description="The pre-registration you're looking for has expired."
                  title="Pre-Registration Expired"
                  code="" />
      </div>

      <!-- Closed -->
      <div v-else-if="closed">
        <NotFound description="The pre-registration you're looking for has closed."
                  title="Pre-Registration Closed"
                  code="" />
      </div>

      <div v-else
           class="col-12 col-sm-10 col-md-8 p-2">
        <div class="rounded-3 mb-3 overflow-hidden border bg-white">
          <div style="border-block-start-width: 5px !important;"
               class="border-top-wide border-teal"></div>

          <div class="m-3">
            <h1 class="mb-4 display-6 fw-semibold">{{ $t('Pre-Registration Form') }}</h1>
            <h2>{{ sections[activeSection]?.title }}</h2>
            <p>{{ sections[activeSection]?.description }}</p>
            <span class="small text-danger">{{ $t('Required fields are marked with an asterisk (*).') }}</span>
          </div>

        </div>

        <div class="d-flex flex-column gap-3">
          <div v-for="(question, index) in activeSectionQuestions"
               :key="`question-${index}`"
               class="bg-white overflow-hidden d-flex align-items-stretch rounded-3 border">
            <!-- <div style="border-inline-start-width: 3px !important;"
                 class="border-start-wide border-teal"></div> -->

            <div class="p-3 flex-fill">
              <component :is="questionTypes[question.type]?.component"
                         :question="question"
                         :validation="validation[`answers.${question.id}.answer`]"
                         v-model="answers[question.id].answer" />
            </div>

          </div>

          <div class="d-flex justify-content-between">
            <PlfButton @click="clearForm"
                       class="btn-ghost-teal"
                       label="Clear Form" />

            <div class='d-inline-flex gap-2'>
              <PlfButton v-if="hasNext"
                         @click="next"
                         class="btn-outline-teal"
                         label="Next" />

              <PlfButton v-if="hasPrevious"
                         @click="previous"
                         class="btn-outline-teal"
                         label="Back" />

              <PlfButton v-if="!hasNext"
                         @click="submit"
                         :loading="submitting"
                         class="btn-teal"
                         label="Submit" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onBeforeMount, provide, ref } from 'vue';
import { useRpc, RPCErrorCode } from '../../composables/network/rpc';
import questionTypes from './question-types.js';
import PlfButton from '../shared/button/PlfButton.vue';
import axios from 'axios';
import { useToast } from '../../composables/ui/useToast';
import PlfLoading from '../shared/loading/PlfLoading.vue';
import NotFound from './NotFound.vue';

const props = defineProps({
  email: {
    type: String,
    required: true
  },

  slug: {
    type: String,
    required: true
  },

  token: {
    type: String,
    required: true
  }
});

const rpc = useRpc();

const notFound = ref(false);
const loading = ref(false);
const expired = ref(false);
const closed = ref(false);
const questions = ref([]);
const sections = ref([]);
const preRegistration = ref({});

const toast = useToast();

const activeSection = ref(0);

const questionsBySection = computed(() => {
  return sections.value.reduce((accumulator, section) => {
    accumulator[section.slug] = questions.value.filter(question => question.section === section.slug);

    return accumulator;
  }, {});
});

const activeSectionQuestions = computed(() => {
  const slug = sections.value[activeSection.value]?.slug;

  if (!slug) {
    return [];
  }

  return questionsBySection.value[slug];
});

const hasNext = computed(() => {
  return activeSection.value < sections.value.length - 1;
});

const hasPrevious = computed(() => {
  return activeSection.value > 0;
});

const answers = ref({});

const validation = ref({});

const loadQuestions = () => {
  loading.value = true;

  rpc.execute({
    method: 'platform.pre-registration.check-token',
    params: {
      email: props.email,
      token: props.token,
      slug: props.slug
    }
  }).then(response => {
    preRegistration.value = response.data.pre_registration;
    questions.value = response.data.questions;
    sections.value = response.data.sections;

    const savedResponses = (response.data.answers ?? []).reduce((accumulator, answer) => {
      accumulator[answer.question_id] = answer;

      return accumulator;
    }, {});

    answers.value = questions.value.reduce((accumulator, question) => {
      if (!accumulator[question.id]) {
        accumulator[question.id] = {
          question_id: question.id,
          answer: ''
        };
      }

      return accumulator;
    }, savedResponses);

  }).catch(error => {
    if (error.response.status === RPCErrorCode.RECORD_NOT_FOUND) {
      notFound.value = true;
    } else if (error.response.data?.result?.data?.expired) {
      expired.value = true;
    } else if (error.response.data?.result?.data?.closed) {
      closed.value = true;
    } else {
      console.error(error);
    }
  }).finally(() => {
    loading.value = false;
  });
};

onBeforeMount(() => {
  loadQuestions();
});

const formFiles = ref([]);

const addUploadFileFn = (submitFn) => {
  formFiles.value.push(submitFn);
}

provide('addUploadFileFn', addUploadFileFn);

const submitFiles = async () => {
  return await axios.all(formFiles.value.map(submitFn => submitFn()));
}

const submitting = ref(false);

const submitForm = async () => {
  return await rpc.execute({
    method: 'platform.pre-registration.save-pre-register',
    params: {
      email: props.email,
      token: props.token,
      slug: props.slug,
      answers: answers.value
    }
  }).then(() => {
    toast.add({
      summary: 'Success',
      detail: 'Your pre-registration has been submitted.',
      severity: 'success',
      position: 'bottom-right'
    });
  }).catch(error => {
    validation.value = error.response.data.result.data;

    toast.add({
      summary: 'Error',
      detail: 'There was an error submitting your pre-registration.',
      severity: 'error',
      position: 'bottom-right'
    });
  });
};

const submit = async () => {

  // submitting.value = true;

  // submitFiles()
  //   .then(async () => {
  //     return await submitForm();
  //   }).catch(error => {
  //     console.log('An error occurred submitting the form', error);
  //   }).finally(() => {
  //     submitting.value = false;
  //   });

  // return;

  try {
    // Submit all files before submitting the form
    submitting.value = true;

    await submitFiles();

    await submitForm();
  } catch (error) {
    toast.add({
      summary: 'Error',
      detail: 'There was an error submitting your pre-registration. Please try again.',
      severity: 'error',
      position: 'bottom-right'
    });
  } finally {
    submitting.value = false;
  }
};

const clearForm = () => {
  answers.value = questions.value.reduce((accumulator, question) => {
    accumulator[question.id] = {
      question_id: question.id,
      answer: ''
    };

    return accumulator;
  }, {});
};

const next = () => {
  activeSection.value++;
};

const previous = () => {
  activeSection.value--;
};
</script>