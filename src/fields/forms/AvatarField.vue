<template>
  <div>
    <PlfUpload v-model="value"
               :drag="true"
               accept="image/*"
               hide-file-list
               :disabled="disabled"
               ref="uploadRef">
      <template #default>
        <div @click.stop
             :class="{ 'avatar-preview-disabled': disabled, 'border-danger': invalid }"
             class="position-relative avatar shadow-none border avatar-xl overflow-hidden avatar-preview">
          <img :src="base64" />

          <div class="position-absolute start-0 end-0 bottom-0 avatar-actions">
            <div class="d-flex align-items-end p-0">
              <PlfButton square
                         color="primary"
                         icon="mdi.IconSquareEditOutline"
                         class="flex-grow-1"
                         @click="$refs.uploadRef?.trigger" />

              <PlfButton square
                         color="danger"
                         class="flex-grow-1"
                         icon="mdi.IconTrash"
                         @click.stop="$refs.uploadRef?.clearAll" />
            </div>
          </div>

        </div>
        <div v-if="errors"
             class="invalid-feedback d-block">
          <div v-for="(error, key) in errors"
                 :key="`error-${key}`">
            {{ error }}
          </div>
        </div>
      </template>
    </PlfUpload>
  </div>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfUpload from '@/components/shared/upload/PlfUpload.vue';
import { useBase64 } from '@vueuse/core';
import { computed, ref, watch } from 'vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {
    type: String,
  },

  disabled: {
    type: Boolean,
    default: false
  },

  invalid: {
    type: Boolean,
    default: false
  },

  errors: {
    type: Array,
    default: () => []
  }
});

const uploadRef = ref();

const value = ref({});

function dataURLtoFile(dataurl, filename) {
  const arr = dataurl.split(','),
    mime = arr[0].match(/:(.*?);/)[1],
    bstr = atob(arr[arr.length - 1]);

  let n = bstr.length;
  const u8arr = new Uint8Array(n);
  while (n--) {
    u8arr[n] = bstr.charCodeAt(n);
  }

  return new File([u8arr], filename, { type: mime });
}

const file = computed(() => {
  if (value.value?.raw instanceof File) {
    return value.value.raw;
  }

  if (value.value?.url) {
    return dataURLtoFile(value.value.url, 'avatar');
  }

  return null;
});

const { base64 } = useBase64(file);

watch(() => props.modelValue, newVal => {
  if (!newVal || newVal === value.value.url) return;

  if (newVal) {
    value.value.url = newVal;
  }

  console.log('Watch props.modelValue', {});
}, { immediate: true });

watch(base64, (newVal) => {
  emit('update:modelValue', newVal);
});
</script>

<style scoped>
.avatar-preview .avatar-actions {
  display: none;
}

.avatar-preview:not(.avatar-preview-disabled):hover .avatar-actions {
  display: block;
}
</style>