<template>
    <div class="position-relative w-full">
        <div class="w-full d-flex flex-column space-x-2 p-1">
            <div class="form-info-section bg-light h-33 p-2 mt-2 rounded-3">
                <div class="row row-cards">
                    <div class="col-md-9">
                        <TextField :label="$t('forms.fields.name')" v-model="record.name"
                            :invalid="'name' in props.validation" :errors="props.validation.name"
                            :disabled="props.disabled" required />
                    </div>
                    <div v-if="preferences.make_form_as_quiz" class="col-md-3">
                        <NumberField :label="$t('forms.fields.duration (min)')" v-model="record.duration"
                            :invalid="'duration' in props.validation" :errors="props.validation.duration"
                            :disabled="props.disabled" />
                    </div>
                    <div class="col-md-12">
                        <TextField :label="$t('forms.fields.description')" v-model="record.description"
                            type="textarea" :invalid="'description' in props.validation"
                            :errors="props.validation.description" :disabled="props.disabled" />
                    </div>
                </div>
            </div>
            <QuestionList :undo="undo" :redo="redo" :canUndo="canUndo" :canRedo="canRedo" v-model:sections="record.sections"
                v-model:active-question-index="activeQuestionIndex"
                v-model:active-section-index="activeSectionIndex" :disabled="props.disabled"
                :validation="props.validation"  v-model:preferences="record.preferences" :change-mode="changeMode"/>
        </div>
    </div>
</template>
<script setup>
import TextField from "@/fields/forms/TextField.vue";
import QuestionList from "./QuestionList.vue"
import NumberField from "@/fields/forms/NumberField.vue";
import { ref } from 'vue';
import { useVModel } from "@vueuse/core";


const emit = defineEmits(['update:record']);
const props = defineProps({
  record : {
    type : Object
  },
  validation: {
    type: Object
  },

  disabled: {
    type: Boolean,
    default: false
  },
  undo: {
    type: Function
  },
  redo: {
    type: Function
  },
  canUndo: {
    type: Boolean
  },
  canRedo: {
    type: Boolean
  }  ,
  preferences : {
        type : Object ,
        required : true
  } ,
  changeMode : {
    type : Function
  }
});
const record = useVModel(props , 'record' , emit , {
  deep: true ,
  passive : true
})
const activeQuestionIndex = ref(null);
const activeSectionIndex = ref(null);
</script>