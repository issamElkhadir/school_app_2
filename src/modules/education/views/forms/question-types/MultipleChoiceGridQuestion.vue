<template>
  <BaseGridQuestion :preferences="preferences" question-type="multiplechoicegridquestion"/>
</template>

<script setup>
import BaseGridQuestion from './BaseGridQuestion.vue';

defineProps({
  preferences : {
    type : Object
  }
})
</script>