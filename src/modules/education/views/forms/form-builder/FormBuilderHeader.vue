<template>
    <div class="w-full d-flex justify-content-start align-items-start">
        <PlfButton
            v-if="isForPreview || isForPreInscription"
            class="btn-outline-primary"
            :title="$t('Back')"
            @click="handleButtonClick"
            icon="mdi.IconArrowLeft"/>
    </div>
    <div class="w-full d-flex justify-content-center align-items-center">
        <div style="width: 85%;" class="shadow-sm rounded-top-4" >
            <div class="w-full bg-primary py-2 rounded-top-4"></div>
            <div class="w-full d-flex flex-column space-x-2">
                <div class="w-full p-3 pb-1 border-bottom border-secondary">
                    <h1>{{ record.name }}</h1>
                </div>
                <div class="w-full p-3 pb-1 border-bottom border-secondary">
                    <h3>{{ record.description }}</h3>
                </div>
                <div class="w-full p-3 ">
                    <h3 class="text-danger">* {{ $t('Indicates required question') }}</h3>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
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
        required : true
    },
    isForPreInscription : {
        type : Boolean ,
        required : true
    } ,
});

const handleButtonClick = () =>{
    if(props.isForPreview){
        props.changeMode('questions');
        return;
    }
    if(props.isForPreInscription){
        props.changeMode();
    }
}
</script>