<template>
  <PlfUpload v-model="value"
              :value="answerValue"
             :label="question.title"
             :multiple="question.options.maxNumberOfFiles > 1"
             :limit="question.options.maxNumberOfFiles"
             :on-exceed="onExceed"
             :on-error="onError"
             :max-file-size="question.options.maxFileSize * 1024 * 1024"
             :accept="accept"
             :errors="validation"
             :data="{ module: 'platform', model: 'pre-registration' }"
             color="teal" />
</template>

<script setup>
import { useToast } from '@/components/shared/toast/useToast';
import PlfUpload from '@/components/shared/upload/PlfUpload.vue';
import { computed, ref, watch } from 'vue';



const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  question: {
    type: Object
  },

  modelValue: {
    type: Array
  },

  validation: {
    type: Object
  },
  answerValue : {
    type: String
  }
});

const toast = useToast();

const value = ref();

watch(value, (newValue) => {
  emit('update:modelValue', newValue);
}, { deep: true });

watch(() => props.modelValue, (newValue) => {
  value.value = newValue;
}, { immediate: true });

const onExceed = () => {
  toast.add({
    summary: 'Max number of files exceeded',
    severity: 'error',
    detail: 'You have exceeded the maximum number of files allowed for this question.',
    life: 5000,
    position: 'bottom-right',
  });
};

const onError = (err) => {
  toast.add({
    summary: 'File upload error',
    severity: 'error',
    detail: err.response.data.message,
    life: 5000,
    position: 'bottom-right',
  });
};

const mimeTypes = {
  'image': 'image/*',
  'document': 'application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.oasis.opendocument.text,application/vnd.openxmlformats-officedocument.wordprocessingml.template,text/plain',
  'pdf': 'application/pdf',
  'spreadsheet': 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.oasis.opendocument.spreadsheet',
  'presentation': 'application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.oasis.opendocument.presentation',
  'audio': 'audio/mpeg,audio/wav,audio/ogg,audio/mp4,audio/x-ms-wma,audio/aac,audio/flac',
  'video': 'video/mp4,video/webm,video/ogg,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/x-flv,video/3gpp,video/x-matroska',
  'drawing': 'application/vnd.oasis.opendocument.graphics',
}

const accept = computed(() => {
  if (props.question.options.allowSpecificFileTypes) {
    return props.question.options.allowedFileTypes.map((type) => {
      return mimeTypes[type];
    }).join(',');
  }

  return Object.values(mimeTypes).join(',');
});
</script>