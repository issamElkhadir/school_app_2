<template>
    <div class="shadow-sm rounded-top-3" >
        <div style="font-size: 18.5px;" class="bg-primary rounded-top-3 p-3 ps-5 text-white fw-semibold">
          {{ section.title }}
        </div>
        <div class="p-2 ps-5 py-5" style="font-size: 17px;">
          {{ section.description }}
        </div>
    </div>
</template>

<script setup>
defineProps({
    section  :{
        type : Object ,
        required : true
    }
})
</script>