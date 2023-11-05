<template>
  <BaseOptionQuestion list-class="list-unstyled" :preferences="preferences" question-type="multiplechoicequestion"/>
</template>

<script setup>
import BaseOptionQuestion from './BaseOptionQuestion.vue';

defineProps({
  preferences : {
    type : Object
  }
})
</script>