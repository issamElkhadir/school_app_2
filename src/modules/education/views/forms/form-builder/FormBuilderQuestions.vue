<template>
    <div class="w-full shadow-sm rounded p-3 py-5">
      <component 
        :is="questionType" 
        :question="question" 
        v-model="answer" 
        :disabled="disabled"
        :validation="validation"
        :value="answerValue"
      />
    </div>
  </template>
  
<script setup>
  import { computed, watch  , ref} from 'vue';
  import types from './question-types.js';
  import { useVModel } from '@vueuse/core';

  const answer = ref();
  const emit = defineEmits(['update:answers'])
  const props = defineProps({
    question: {
      type: Object,
      required: true,
    },
    answers: {
      type: Object,
      required: true,
    },
    sectionId: {
      required: true,
    },
    record : {
        type :Object ,
        required : true
    } ,
    disabled : {
        type : Boolean
    } , 
    validation: {
    type: Object,
  },
  });

  const questionType = computed(() => {
    return types[props.question.type]?.component;
  });
  const answersMutation  = useVModel(props , 'answers', emit);

  watch(answer , (newValue)=>{
    const section = answersMutation.value.sections.find((s) => s.id == props.sectionId);
    const question = section.questions.find((q) => q.id == props.question.id);
    question.answer = newValue
  });

  const answerValue = computed(()=> {
    const section = answersMutation.value.sections.find((s) => s.id == props.sectionId);
    const question = section.questions.find((q) => q.id == props.question.id);
    return question.answer
  })
</script>
  