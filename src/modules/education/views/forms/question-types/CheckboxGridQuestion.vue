<template>
  <BaseGridQuestion :preferences="preferences" question-type="checkboxgridquestion"/>
</template>

<script setup>
import BaseGridQuestion from './BaseGridQuestion.vue';

defineProps({
  preferences : {
    type : Object
  }
})
</script>