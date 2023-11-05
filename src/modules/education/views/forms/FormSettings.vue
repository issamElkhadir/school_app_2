<template>
  <div class="position-relative w-100 d-flex justify-content-center align-items-center mt-5">
    <div style="width: 80%" class="shadow-sm p-5 rounded">
      <p class="w-full border-bottom border-1 pb-2 fw-semibold fs-2">{{ $t('Settings') }}</p>
      <div
        class="w-full d-flex justify-content-center align-items-center flex-column space-x-4 mt-5"
      >
        <div style="width: 95%" class="d-flex flex-column  pb-2 mb-2">
          <!-- mark this a quiz section -->
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="d-flex flex-column">
              <p style="font-size: 17px" class="fw-semibold">{{ $t('Make this form as quiz') }}</p>
              <p class="fs-3">
                {{ $t('Assign point values, set answers, and automatically provide feedback') }}
              </p>
            </div>
            <PlfSwitch 
            :disabled="disabled"
              right-label
              class="ps-0 mb-1"
              v-model="preferencesMutation.make_form_as_quiz"
            />
          </div>
          <div
            v-if="preferencesMutation.make_form_as_quiz"
            style="width: 80%"
            class="d-flex justify-content-start align-items-start flex-column ms-5 mt-2 mb-2"
          >
            <div class="d-flex flex-column mt-2 space-x-2">
              <p class="text-secondary fs-3 fw-semibold">{{ $t('RELEASE GRADES') }}</p>
              <div class="d-flex flex-row align-items-center ms-2 space-x-2">
                <input
                  type="radio"
                  name="RELEASE GRADES"
                  :disabled="disabled"
                  value="immediately_after_each_submission"
                  v-model="preferencesMutation.release_grades"
                  rounded
                  class="form-check-input"
                />
                <div class="fs-3">{{ $t('Immediately after each submission') }}</div>
              </div>
              <div class="d-flex flex-row align-items-center ms-2 space-x-2">
                <input
                  type="radio"
                  :disabled="disabled"
                  name="RELEASE GRADES"
                  value="later_after_manual_review"
                  v-model="preferencesMutation.release_grades"
                  rounded
                  class="form-check-input"
                />
                <div class="fs-3">{{ $t('Later, after manual review') }}</div>
              </div>
            </div>
            <div class="w-full d-flex flex-column mt-4 space-x-2">
              <p class="text-secondary fs-3 fw-semibold">{{ $t('RESPONDENT SETTINGS') }}</p>
              <div class="w-full d-flex flex-row justify-content-between align-items-center">
                <div class="d-flex flex-column">
                  <p class="fs-3 fw-semibold">{{ $t('Missed questions') }}</p>
                  <p class="fs-3">
                    {{ $t('Respondents can see which questions were answered incorrectly') }}
                  </p>
                </div>
                <PlfSwitch 
                :disabled="disabled"
                  right-label
                  v-model="preferencesMutation.missed_questions"
                  class="ps-0 mb-1"
                />
              </div>
            </div>
            <div class="w-full d-flex flex-column mt-2">
              <div class="w-full d-flex flex-row justify-content-between align-items-center">
                <div class="d-flex flex-column">
                  <p class="fs-3 fw-semibold">{{ $t('Correct answers') }}</p>
                  <p class="fs-3">
                    {{ $t('Respondents can see correct answers after grades are released') }}
                  </p>
                </div>
                <PlfSwitch 
                :disabled="disabled"
                  right-label
                  class="ps-0 mb-1"
                  v-model="preferencesMutation.correct_answers"
                />
              </div>
            </div>
            <div class="w-full d-flex flex-column mt-2">
              <div class="w-full d-flex flex-row justify-content-between align-items-center">
                <div class="d-flex flex-column">
                  <p class="fs-3 fw-semibold">{{ $t('Point values') }}</p>
                  <p class="fs-3">
                    {{
                      $t('Respondents can see total points and points received for each question')
                    }}
                  </p>
                </div>
                <PlfSwitch 
                :disabled="disabled"
                  right-label
                  class="ps-0 mb-1"
                  v-model="preferencesMutation.point_values"
                />
              </div>
            </div>
            <div class="w-full d-flex flex-column mt-3 space-x-2">
              <p class="text-secondary fs-3 fw-semibold">{{ $t('GLOBAL QUIZ DEFAULTS') }}</p>
              <div class="w-full d-flex flex-row justify-content-between align-items-center">
                <div class="d-flex flex-column">
                  <p class="fs-3 fw-semibold">{{ $t('Default question point value') }}</p>
                  <p class="fs-3">{{ $t('Point values for every new question') }}</p>
                </div>
                <div class="w-25 d-flex flex-row align-items-center space-x-2">
                  <NumberField
                  :disabled="disabled"
                    :value="preferencesMutation.default_question_point_value"
                    v-model="preferencesMutation.default_question_point_value"
                    class="w-25"
                  />
                  <div>{{ $t('Points') }}</div>
                </div>
              </div>
            </div>
          </div>
          <!-- responses section -->
          <div class="d-flex justify-content-between align-items-center pt-3 border-top">
            <div class="d-flex flex-column">
              <p style="font-size: 17px" class="fw-semibold">{{ $t('Responses') }}</p>
              <p class="fs-3">{{ $t('Manage how responses are collected and protected') }}</p>
            </div>
            <PlfIcon
              class="icon icon-md cursor-pointer"
              name="mdi.IconMenuDown"
              @click="toggleResponsesSection"
            />
          </div>
          <div
            v-if="showResponsesSection"
            style="width: 80%"
            class="d-flex justify-content-start align-items-start flex-column ms-5 mt-2 mb-2"
          >
            <div class="w-full d-flex flex-column mt-4">
              <div
                class="w-full d-flex flex-row justify-content-between align-items-center space-x-8"
              >
                <div class="d-flex flex-column">
                  <p class="fs-3 fw-semibold">{{ $t('Allow response editing') }}</p>
                  <p class="fs-3">
                    {{ $t('Responses can be changed after being submitted') }}
                  </p>
                </div>
                <PlfSwitch 
                :disabled="disabled"
                  right-label
                  v-model="preferencesMutation.allow_response_editing"
                  class="ps-0 mb-1"
                />
              </div>
            </div>
            <div class="w-full d-flex flex-column mt-2">
              <p class="text-secondary fs-3 fw-semibold">{{ $t('REQUIRES SIGN IN') }}</p>
              <div
                class="w-full d-flex flex-row justify-content-between align-items-center space-x-8"
              >
                <p class="fs-3 fw-semibold">{{ $t('Limit to 1 response') }}</p>
                <PlfSwitch 
                :disabled="disabled"
                  right-label
                  class="ps-0 mb-1"
                  v-model="preferencesMutation.limit_to_1_response"
                />
              </div>
            </div>
          </div>
          <!-- presentation section -->
          <div class="d-flex justify-content-between align-items-center pt-3 border-top">
            <div class="d-flex flex-column">
              <p style="font-size: 17px" class="fw-semibold">{{ $t('Presentation') }}</p>
              <p class="fs-3">{{ $t('Manage how the form and responses are presented') }}</p>
            </div>
            <PlfIcon
              class="icon icon-md cursor-pointer"
              name="mdi.IconMenuDown"
              @click="togglePresentationSection"
            />
          </div>
          <div
            v-if="showPresentationSection"
            style="width: 80%"
            class="d-flex justify-content-start align-items-start flex-column ms-5 mt-2 mb-2"
          >
            <div class="w-full d-flex flex-column mt-2 space-x-2">
              <p class="text-secondary fs-3 fw-semibold">{{ $t('FORM PRESENTATION') }}</p>
              <div class="w-full d-flex flex-row justify-content-between align-items-center ms-2">
                <div class="fs-3 fw-semibold">{{ $t('Show progress bar (Only when the form is a quiz)') }}</div>
                <PlfSwitch 
                :disabled="disabled || !preferencesMutation.make_form_as_quiz"
                  right-label
                  class="ps-0"
                  v-model="preferencesMutation.show_progress_bar"
                />
              </div>
              <div
                class="w-full d-flex flex-row justify-content-between align-items-center ms-2 mt-1"
              >
                <div class="fs-3 fw-semibold">{{ $t('Shuffle question order') }}</div>
                <PlfSwitch 
                :disabled="disabled"
                  right-label
                  class="ps-0"
                  v-model="preferencesMutation.shuffle_question_order"
                />
              </div>
            </div>
            <div class="w-full d-flex flex-column mt-5">
              <p class="text-secondary fs-3 fw-semibold">{{ $t('AFTER SUBMISSION') }}</p>
              <div class="w-full d-flex flex-row justify-content-between align-items-center">
                <div v-if="!showConfirmationMessageEdit" class="d-flex flex-column">
                  <div class="fs-3 fw-semibold">{{ $t('Confirmation message') }}</div>
                  <div class="fs-3 mt-1">{{ preferencesMutation.confirmation_message }}</div>
                </div>
                <div style="width: 50%">
                  <PlfInput
                    v-model="preferencesMutation.confirmation_message"
                    v-if="showConfirmationMessageEdit"
                    label="Confirmation message"
                    floating
                  />
                </div>
                <PlfButton
                  v-if="!showConfirmationMessageEdit"
                  @click="toggleConfirmationMessageEdit"
                  label="Edit"
                  :disabled="disabled"
                  class="bg-primary text-white"
                />
                <PlfButton
                  v-if="showConfirmationMessageEdit"
                  @click="saveConfirmationMessage"
                  label="Save"
                  class="bg-white text-primary"
                />
              </div>
            </div>
            <div class="w-full d-flex flex-column mt-2">
              <div class="w-full d-flex flex-row justify-content-between align-items-center">
                <p class="fs-3 fw-semibold">{{ $t('View results summary') }}</p>
                <PlfSwitch 
                :disabled="disabled"
                  right-label
                  class="ps-0 mb-1"
                  v-model="preferencesMutation.view_results_summary"
                />
              </div>
            </div>
            <div class="w-full d-flex flex-column mt-4">
              <p class="text-secondary fs-3 fw-semibold">{{ $t('RESTRICTIONS') }}}:</p>
              <div class="w-full d-flex flex-row justify-content-between align-items-center">
                <p class="fs-3 fw-semibold">{{ $t('Disable autosave for all respondents') }}</p>
                <PlfSwitch 
                :disabled="disabled"
                  right-label
                  class="ps-0 mb-1"
                  v-model="preferencesMutation.disable_autosave_for_all_respondents"
                />
              </div>
            </div>
          </div>
          <div class="w-full d-flex flex-column mt-3 border-top pt-5">
            <div class="w-full d-flex flex-row justify-content-between align-items-center">
                <p class="fs-3 fw-semibold">{{ $t('Make questions required by default') }}</p>
                <PlfSwitch 
                :disabled="disabled"
                   right-label class="ps-0 mb-1" v-model="preferencesMutation.questions_required_by_default" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfSwitch from '@/components/shared/switch/PlfSwitch.vue';
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import NumberField from '@/fields/filters/NumberField.vue';
import { useVModel } from '@vueuse/core';
import { ref } from 'vue';

const showResponsesSection = ref(false);
const showPresentationSection = ref(false);
const showConfirmationMessageEdit = ref(false);
const toggleResponsesSection = () => {
  showResponsesSection.value = !showResponsesSection.value;
};
const togglePresentationSection = () => {
  showPresentationSection.value = !showPresentationSection.value;
};
const toggleConfirmationMessageEdit = () => {
  showConfirmationMessageEdit.value = !showConfirmationMessageEdit.value;
};
const saveConfirmationMessage = () => {
  showConfirmationMessageEdit.value = false;
};
const emit = defineEmits(['update:preferences']);
const props = defineProps({
  preferences: {
    type: Object,
    required: true
  } ,
  disabled : {
    type : Boolean
  }
});

const preferencesMutation = useVModel(props, 'preferences', emit, {
  passive: true,
  deep: true
});
</script>
