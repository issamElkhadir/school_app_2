<template>
  <BaseOptionQuestion list-class="list-unstyled" :preferences="preferences" question-type="checkboxquestion"/>
</template>

<script setup>
import BaseOptionQuestion from './BaseOptionQuestion.vue';

defineProps({
  preferences : {
    type : Object
  }
})
</script>