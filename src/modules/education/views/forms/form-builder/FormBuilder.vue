<template>
    <div class="position-relative w-full">
        <div v-if="record.preferences.show_progress_bar && record.preferences.make_form_as_quiz"  style="position: sticky; top: 60%; transform: translateY(-50%)"
            class="d-flex justify-content-end align-content-end">
            <div class="progress" style="width: 25%;height: 15px; transform: rotate(270deg) ; margin-right:-130px ;">
                <div class="progress-bar " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" :style="{ width: progressBarWidth }"></div>
            </div>
        </div>
        <div class="w-full d-flex flex-column space-x-4 p-1">

            <FormBuilderHeader 
                :change-mode="changeMode" 
                :is-for-pre-inscription="isForPreInscription" 
                :is-for-preview="isForPreview" 
                :record="record"
            />
            <template v-for="(section, sectionIndex) in record.sections" :key="sectionIndex">
                <div class="w-full justify-content-center align-items-center" v-if="sectionIndex === currentSectionIndex">
                    <div class="w-full d-flex justify-content-center align-items-center">
                      <div class="d-flex flex-column space-x-4" style="width: 85%;">
                        <FormBuilderSection :section="section" />
                        <div class="d-flex flex-column space-x-4" v-if="section.questions.length > 0" >
                            <FormBuilderQuestions v-for="(question, questionIndex) in section.questions" 
                            :sectionId="section.id"
                            :key="questionIndex"
                            :question="question" 
                            v-model:answers="answers" 
                            :record="record"
                            :disabled="disabled"
                            :validation="validation"
                            />
                        </div> 
                      </div>                     
                    </div>
                  </div>
            </template>

            <div style="padding-left: 6.5rem;" class="d-flex justify-content-start space-x-5 align-items-center mt-5">
                <PlfButton
                    class="btn-outline-primary"
                    label="Previous"
                    icon="mdi.IconArrowBack"
                    @click="previousSection"
                    v-if="currentSectionIndex != 0"
                />
                <PlfButton
                    class="btn-primary text-white"
                    label="Submit"
                    icon="mdi.IconSendVariant"
                    @click="submit"
                    v-if="currentSectionIndex == record.sections.length -1 && !updatingMode"
                />
                <PlfButton
                    class="btn-primary text-white"
                    label="Update"
                    icon="mdi.IconReload"
                    @click="update"
                    :loading="updating"
                    v-if="currentSectionIndex == record.sections.length -1 && updatingMode"
                />
                <PlfButton
                    class="btn-outline-primary"
                    label="Next"
                    icon="mdi.IconArrowRight"
                    @click="nextSection"
                    v-if="currentSectionIndex != record.sections.length -1"
                />
            </div>
        </div>
    </div>    
</template>

<script setup>
import { useVModel } from '@vueuse/core';
import { computed, onMounted , ref  } from 'vue';
import { v4 as uuidv4 } from 'uuid';
import { cloneDeep } from 'lodash';
import FormBuilderHeader from './FormBuilderHeader.vue';
import PlfButton from '@/components/shared/button/PlfButton.vue';
import FormBuilderSection from './FormBuilderSection.vue';
import FormBuilderQuestions from './FormBuilderQuestions.vue';
import { useToast } from '@/components/shared/toast/useToast';

const toast = useToast();
const emit = defineEmits(['update:answers'])
const props = defineProps({
    record: {
        type: Object,
        required: true,
    } ,
    changeMode : {
        type : Function
    } ,
    isForPreview : {
        type : Boolean ,
        default : false 
    } ,
    isForPreInscription : {
        type : Boolean ,
        default : false 
    } ,
    answers : {
        type : Object ,
    } ,
    disabled : {
        type : Boolean
    } ,
    validation: {
        type: Object,
   },
   initializeAnswers : {
    type : Boolean ,
    default : true
   } ,
   showSubmitModal : {
    type : Function ,
   } ,
   updatingMode : {
    type : Boolean,
    default : false
   } ,
   update : {
    type : Function
   } ,
   updating : {
    type : Boolean ,
    default : false
   }
});

const answers = useVModel(props , 'answers' , emit , {
    passive : true ,
    deep : true ,
    defaultValue : {
        sections : []
    }
});
const record = ref(cloneDeep(props.record ?? {sections: []}));

const currentSectionIndex = ref(0);

const nextSection = () => {
    const currentSection = answers.value.sections[currentSectionIndex.value] ;
    const currentQuestions = currentSection.questions ?? null;
    const invalidRequiredQuestions  = currentQuestions ? currentQuestions.filter((q) => q.is_required && q.answer.trim().length === 0) : [];
    if(invalidRequiredQuestions.length > 0){
        return toast.add({
        severity: 'error',
        summary: 'Error',
        detail: 'please fill all the required questions',
        position: 'bottom-right'
      });
    }
    currentSectionIndex.value++;
}
const previousSection = () =>{
    currentSectionIndex.value--;
}
const submit = () => {
    const currentSection = answers.value.sections[currentSectionIndex.value] ;
    const currentQuestions = currentSection.questions ?? null;
    const invalidRequiredQuestions  = currentQuestions ? currentQuestions.filter((q) => q.is_required && q.answer.trim().length === 0) : [];
    if(invalidRequiredQuestions.length > 0){
        return toast.add({
        severity: 'error',
        summary: 'Error',
        detail: 'please fill all the required questions',
        position: 'bottom-right'
      });
    }
    if(props.isForPreInscription && !props.updatingMode){
        props.showSubmitModal();
    }
    if(props.isForPreview){
        return toast.add({
        severity: 'success',
        summary: 'Success',
        detail: record.value.preferences.confirmation_message ?? '',
        position: 'bottom-right'
      });
    }
}
// progress for answers
const progress = computed(() => {
    let totalQuestions = 0;
    record.value.sections.forEach((section) => {
    totalQuestions += section.questions.length;
    });

    let answeredQuestions = 0;
    answers.value.sections.forEach((section) => {
    answeredQuestions += section.questions.filter((question) => question.answer != '').length;
    });
  return (answeredQuestions / totalQuestions) * 100;
});

const progressBarWidth = computed(() => {
  return `${progress.value}%`;
});
onMounted(() => {
    record.value.sections = record.value.sections.map((section) => {
        if (!Object.prototype.hasOwnProperty.call(section, 'id')) {
            section.id = uuidv4();
        }
        if (section.questions) {
            if (section.questions.length > 0) {
                section.questions = section.questions.map((question) => {
                    if (!Object.prototype.hasOwnProperty.call(question, 'id')) {
                        question.id = uuidv4();
                    }
                    return question;
                });
                if(record.value.preferences.shuffle_question_order){
                    section.questions = section.questions.sort(() => Math.random() - 0.5)
                }else {
                    section.questions = section.questions.sort((a, b) => a.order - b.order);
                }
            }
        }
        return section;
    });
    record.value.sections = record.value.sections.sort((a, b) => a.order - b.order);
    // initialize answers
    if(props.initializeAnswers){
        answers.value.sections = record.value.sections.map((section ) => {
        const answerSection = {id : section.id , questions : []}
        answerSection.questions = section.questions.map((question) => {
            return {id : question.id , is_required : question.is_required ,type : question.type , answer :''}
        })
        return answerSection;
    })
    }
});
</script>

<style scoped>
</style>