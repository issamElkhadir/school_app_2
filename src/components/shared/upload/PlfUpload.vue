<template>
  <!-- Remove uploaded file dialog -->
  <PlfDialog v-model="showConfirmDeleteModal"
             :square="square"
             seamless
             persistent>
    <div class="modal-header w-100 p-2">
      <div class="d-flex w-full align-items-center justify-content-between">
        <div class="modal-title">
          {{ $t('Confirmation') }}
        </div>
        <PlfButton icon="tblr.IconX"
                   class="btn-action"
                   @click="onRemoveUploadedFileCanceled" />
      </div>
    </div>
    <div class="modal-body px-2">
      <div>
        {{ $t('Cancel the transfer of {name} ?', { name: currentFile.name }) }}
      </div>
    </div>

    <div class="modal-footer p-2">
      <PlfButton :label="$t('Cancel')"
                 @click="onRemoveUploadedFileCanceled"
                 :square="square" />
      <PlfButton :label="$t('Remove')"
                 @click="onRemoveUploadedFileConfirmed"
                 :square="square"
                 :color="color" />
    </div>
  </PlfDialog>

  <input ref="fileChooser"
         type="file"
         @change="onChange"
         :multiple="multiple"
         :accept="accept"
         :name="name"
         class="d-none" />

  <label v-if="!hideLabel"
         class="form-label">
    {{ label }}
  </label>

  <div class="d-flex flex-column gap-3"
       @dragover.prevent="onDragOver"
       @dragleave.prevent="onDragLeave"
       @drop.prevent="onDrop">

    <div v-if="listType !== 'picture-card'">
      <div class="d-flex gap-3">
        <div v-if="'trigger' in $slots"
             @click="onFileChooserClicked">
          <slot name="trigger"></slot>
        </div>

        <div class="w-full"
             @click="'trigger' in $slots ? submit() : onFileChooserClicked()">
          <slot name="default"
                :files="files"
                :file="files[0]">
            <div v-if="drag"
                 :class="{
                   'rounded-3': !square,
                   disabled,
                   'cursor-pointer mb-1 w-full border-1 chooser-area': drag
                 }"
                 class="w-full d-flex h-100 py-5 w-full flex-column gap-3 align-items-center justify-content-center">
              <PlfIcon name="tblr.IconCloudUpload"
                       class="icon-lg" />

              <p class="m-0">
                Drop file here or <span :class="`text-${color}`">click to upload</span>
              </p>
            </div>

            <div v-else>
              <PlfButton :square="square"
                         :color="color">
                {{ selectFileButtonText }}
              </PlfButton>
            </div>
          </slot>
        </div>
      </div>

      <slot name="tip"></slot>

      <div v-if="errors"
           class="d-block text-danger">
        <small v-for="error in errors"
               :key="error">
          {{ error }}
        </small>
      </div>
    </div>

    <div v-if="!hideFileList">
      <div v-if="listType === 'text'">
        <div v-for="file in files"
             :key="`file-${file._uid}`">
          <slot name="file"
                :file="file">
            <div class="d-flex gap-2 w-100 flex-column">
              <div v-if="!file.uploading"
                   :class="{ 'rounded-0': square, 'rounded-2': !square }"
                   class="d-flex file-item cursor-pointer p-1 gap-2 justify-content-between align-items-center">

                <div class="text-truncate flex-grow-1">
                  <PlfIcon name="tblr.IconFileText"
                           class="icon me-1" />
                  {{ file.name }}
                </div>


                <div class="d-flex gap-2">
                  <PlfIcon name="tblr.IconZoomIn"
                           class="icon"
                           v-if="onPreview"
                           @click="handlePreview(file)" />
                  <div v-if="file.status !== 'success'"
                       class="d-flex gap-2">

                    <div v-if="file.status === 'ready'"
                         @click="upload(file)"
                         class="fw-bold">
                      <PlfIcon name="tblr.IconUpload"
                               class="icon" />
                    </div>

                    <div v-else-if="file.status === 'fail'">
                      <div @click="upload(file)"
                           class="fw-bold">
                        <PlfIcon name="tblr.IconRefresh"
                                 class="icon" />
                      </div>
                    </div>
                  </div>


                  <template v-else>
                    <PlfIcon name="tblr.IconCircleCheck"
                             class="text-success is-success" />
                  </template>

                  <PlfIcon name="tblr.IconX"
                           v-if="!disabled"
                           class="remove-button"
                           @click="onRemoveClick(file)" />
                </div>
              </div>

              <div class="px-2"
                   v-else>
                <div class="d-flex justify-content-between text-muted">
                  <span>{{ file.name }}</span>

                  <span>{{ file.uploaded }}%</span>
                </div>
                <div class="h-2"
                     :class="{ 'rounded-0': square, 'rounded-2': !square }">
                  <div class="h-1 bg-light"
                       :class="{ 'rounded-0': square, 'rounded-2': !square }">
                    <div :style="{ width: `${file.uploaded}% !important` }"
                         :class="{ [`bg-${color}`]: true, 'rounded-0': square, 'rounded-2': !square }"
                         class="h-1">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </slot>
        </div>
      </div>

      <div v-else-if="listType === 'picture'">
        <div v-for="file in files"
             :key="`file-${file._uid}`">
          <slot name="file"
                :file="file">
            <div class="position-relative">
              <div class="card mb-3">
                <div class="p-2 card-body">
                  <div class="d-flex gap-3 h-full">
                    <div class="avatar avatar-md">
                      <PlfImage v-if="isFileImage(file)"
                                :class="{ 'rounded-0': square }"
                                :src="file.url" />

                      <div v-else
                           class="avatar avatar-md">
                        <PlfIcon name="tblr.IconFileText"
                                 class="icon icon-sm" />
                      </div>
                    </div>

                    <div class="d-flex text-truncate flex-column mt-auto flex-grow-1">
                      <div v-if="file.status !== 'fail'"
                           class="d-flex flex-column">
                        <span class="text-end">{{ file.uploaded }}%</span>

                        <div class="bg-secondary-lt rounded-3 h-1">
                          <div class="h-1 rounded-3"
                               :class="`bg-${color}`"
                               :style="{ width: `${file.uploaded}%` }">
                          </div>
                        </div>
                      </div>

                      <small class="mt-1 text-muted text-truncate">
                        {{ file.name }}
                      </small>
                    </div>
                  </div>
                </div>
              </div>

              <div class="position-absolute end-0 top-0">
                <div class="h-4 w-full gap-1 d-flex justify-content-end pe-1 mt-1">
                  <PlfIcon name="tblr.IconZoomIn"
                           class="icon icon-sm cursor-pointer"
                           v-if="onPreview"
                           @click="handlePreview(file)" />

                  <PlfIcon name="tblr.IconRefresh"
                           v-if="file.status === 'fail'"
                           @click="upload(file)"
                           class="icon icon-sm cursor-pointer" />

                  <PlfIcon name="tblr.IconCircleCheck"
                           v-else-if="file.status === 'success'"
                           class="icon icon-sm text-success cursor-auto" />

                  <PlfIcon name="tblr.IconUpload"
                           v-else-if="file.status === 'ready'"
                           @click="upload(file)"
                           class="icon icon-sm cursor-pointer" />

                  <PlfIcon name="tblr.IconX"
                           v-if="!disabled && !['uploading', 'success'].includes(file.status)"
                           @click="onRemoveClick(file)"
                           class="icon-sm remove-button cursor-pointer" />
                </div>
              </div>
            </div>
          </slot>
        </div>
      </div>

      <div v-else-if="listType === 'picture-card'">
        <div class="d-flex flex-wrap gap-3">
          <slot v-for="file in files"
                :key="`file-${file._uid}`"
                name="file"
                :file="file">
            <div class="position-relative border file-item"
                 :class="{ 'rounded-0': square, 'rounded-2': !square }">
              <div class="avatar avatar-xl bg-transparent"
                   :class="{ 'rounded-0': square }">
                <PlfImage v-if="isFileImage(file)"
                          :src="file.url"
                          :class="{ 'rounded-0': square }"
                          class="avatar cursor-pointer avatar-xl" />

                <PlfIcon name="tblr.IconFileText"
                         v-else
                         class="icon icon-sm cursor-pointer" />
              </div>

              <div v-if="file.status === 'uploading'"
                   style="z-index: 1"
                   :style="{ height: `${file.uploaded}%` }"
                   :class="{ 'rounded-0': square, 'rounded-2': !square }"
                   class="position-absolute d-flex align-items-center justify-content-center file-item-upload-progress bottom-0 w-100">
                <span class="text-white">
                  {{ file.uploaded }}%
                </span>
              </div>

              <div :class="{ 'rounded-0': square, 'rounded-2': !square }"
                   class="d-none gap-2 file-item-actions position-absolute align-items-center justify-content-center top-0 end-0 start-0 bottom-0">

                <PlfIcon name="tblr.IconZoomIn"
                         @click="handlePreview(file)"
                         v-if="onPreview"
                         class="icon cursor-pointer" />

                <PlfIcon name="tblr.IconUpload"
                         v-if="file.status === 'ready'"
                         @click="upload(file)"
                         class="icon cursor-pointer" />

                <PlfIcon name="tblr.IconRefresh"
                         v-else-if="file.status === 'fail'"
                         @click="upload(file)"
                         class="icon cursor-pointer" />

                <PlfIcon name="tblr.IconX"
                         v-if="!disabled && !['uploading', 'success'].includes(file.status)"
                         @click="onRemoveClick(file)"
                         class="cursor-pointer remove-button" />
              </div>

              <PlfIcon name="tblr.IconCircleCheck"
                       v-if="file.status === 'success'"
                       class="icon position-absolute end-0 top-0 text-success" />
            </div>
          </slot>


          <div v-if="!disabled"
               @click="onFileChooserClicked"
               :class="{ 'rounded-0': square, [`border-hover-${color} hover-${color}-lt border-hover-${color}`]: true }"
               class="avatar bg-transparent cursor-pointer avatar-sm border-dashed avatar-xl">
            <PlfIcon name="tblr.IconPlus"
                     class="icon icon-sm"
                     style="height: 48px" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, inject, onMounted, computed } from "vue";
import PlfButton from "../button/PlfButton.vue";
import PlfImage from "../image/PlfImage.vue";
import { bytesToHumanReadableSize, addClasses, removeClasses } from "@/composables/utils";
import PlfDialog from "@/components/shared/dialog/PlfDialog.vue";
// import { useAxios } from "@/composables/network/axios.js";
import axios from "axios";
import PlfIcon from "../icon/PlfIcon.vue";

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  name: {
    type: String,
    default: 'file'
  },

  modelValue: {},

  url: {
    type: String,
  },

  multiple: Boolean,

  accept: String,

  disabled: {
    type: Boolean,
    default: false
  },

  autoUpload: Boolean,

  maxFileSize: {
    type: Number,
  },

  maxTotalSize: {
    type: Number,
  },

  label: String,

  hideLabel: {
    type: Boolean,
    default: false
  },

  noThumbnails: Boolean,

  square: {
    type: Boolean,
    default: false,
  },

  headers: {
    type: Object,
  },

  action: {
    type: String,
    required: false,
  },

  method: {
    type: String,
    default: 'post',
    validator: (value) => ['post', 'put'].includes(value?.toLowerCase())
  },

  withCredentials: {
    type: Boolean,
    default: false,
  },

  selectFileButtonText: {
    type: String,
    default: 'Select File'
  },

  // additions options of request.
  data: {
    type: Object,
    default: () => ({})
  },

  hideFileList: {
    type: Boolean,
    default: false,
  },

  drag: {
    type: Boolean,
    default: false,
  },

  limit: Number,

  listType: {
    type: String,
    default: () => 'text',

    validator(value) {
      return ['text', 'picture', 'picture-card'].includes(value)
    }
  },

  onRemove: {
    type: Function,
    default: () => {
      return true;
    },
  },

  onPreview: {
    type: Function,
    default: null
  },

  onSuccess: {
    type: Function,
    default: () => {
      return true;
    }
  },

  onError: {
    type: Function,
    default: () => {
      return true;
    }
  },

  onProgress: {
    type: Function,
    default: () => {
    }
  },

  beforeUpload: {
    type: Function,
    default: () => {
      return true;
    }
  },

  onExceed: {
    type: Function,
    default: () => {
      return true;
    }
  },

  onMaxSizeExceed: {
    type: Function,
    default: () => {
      return true;
    },
  },

  beforeRemove: {
    type: Function,
    default: () => {
      return true;
    }
  },

  errors: {
    type: Array,
    default: null,
  },

  color: {
    type: String,
    default: 'primary'
  },
});

const fileChooser = ref();

const files = ref([]);
const uploadFiles = ref([]);

const requester = { execute: () => {} };
// const requester = useAxios(props.action ?? import.meta.env.VITE_APP_UPLOAD_URL);


const tempIndex = ref(1);

const addUploadFileFn = inject('addUploadFileFn', () => { });

onMounted(() => {
  addUploadFileFn(submit);
});

const emitFiles = () => {
  if (props.multiple) {
    emit('update:modelValue', files.value);
  } else {
    emit('update:modelValue', files.value[0] ?? null);
  }
}

const showConfirmDeleteModal = ref(false);
const currentFile = ref(null);

const upload = async (file) => {
  file.uploading = true;
  file.status = 'uploading';

  const data = props.data;

  const formData = new FormData();

  for (const key in data) {
    formData.append(key, data[key]);
  }

  formData.append('file', file.raw);

  let headers = {
    'Content-Type': 'multipart/form-data'
  };

  if (props.headers) {
    headers = {
      ...headers,
      ...props.headers
    };
  }

  await requester.execute({
    method: props.method,
    data: formData,
    headers: headers,
    onUploadProgress: (e) => {
      file.uploaded = Math.round((e.loaded * 100) / e.total);
      props.onProgress && props.onProgress(e, file, uploadFiles.value);
    }
  }).then(response => {
    file.status = 'success';

    file.name = response.data.name;
    file.uid = response.data.uid;
    file.url = response.data.url;

    props.onSuccess && props.onSuccess(response, file, uploadFiles.value);

    emitFiles();
  }).catch(error => {
    file.status = 'fail';
    props.onError && props.onError(error, file, uploadFiles.value);
  }).finally(() => {
    file.uploading = false;
  });
}

const addFiles = (selectedFiles) => {
  if (!Array.isArray(selectedFiles)) {
    selectedFiles = [selectedFiles];
  }

  for (let i = 0; i < selectedFiles.length; i++) {
    const uploadFile = selectedFiles[i];

    if (props.accept) {
      const accept = props.accept.split(',');

      const index = accept.findIndex((type) => {
        const [mainType, subType] = type.split('/');
        const [mainType2] = uploadFile.type.split('/');

        if (subType === '*') {
          return mainType === mainType2;
        }

        return type === uploadFile.type;
      });

      if (index < 0) {
        continue;
      }
    }

    if (uploadFile.size > props.maxFileSize) {
      continue;
    }

    let url = null;

    try {
      url = URL.createObjectURL(uploadFile);
    } catch (err) {
      console.error('[Element Error][Upload]', err);
    }

    const file = ref({
      _uid: Date.now() + tempIndex.value++,
      uid: uploadFile.uid,
      uploaded: 0,
      name: uploadFile.name,
      lastModified: uploadFile.lastModified,
      lastModifiedDate: uploadFile.lastModifiedDate,
      size: uploadFile.size,
      type: uploadFile.type,
      humanSize: bytesToHumanReadableSize(uploadFile.size),
      uploading: false,
      raw: uploadFile,
      url: url,
      status: 'ready'
    });

    uploadFiles.value.push(uploadFile);

    if (!props.multiple) {
      files.value = [file.value];
    } else {
      files.value.push(file.value);
    }

    if (props.autoUpload) {
      upload(file.value, uploadFile);
    }
  }
}

const checkLimitExceed = (selectedFiles) => {
  if (props.limit && files.value.length + selectedFiles.length > props.limit) {
    props.onExceed && props.onExceed(files.value, selectedFiles);
    return true;
  }
}

const checkSizeExceed = (selectedFiles) => {
  const totalSize = files.value.reduce((total, file) => total + file.size, 0);
  const selectedFilesSize = [...selectedFiles].reduce((total, file) => total + file.size, 0);

  if (props.maxTotalSize && selectedFilesSize + totalSize > props.maxTotalSize) {
    props.onMaxSizeExceed && props.onMaxSizeExceed(files.value, selectedFiles);
    return true;
  }
}

const onChange = async (event) => {
  if (props.disabled) return;
  const selectedFiles = event.target.files;

  if (checkLimitExceed(selectedFiles) || checkSizeExceed(selectedFiles)) {
    return;
  }

  await processSelectedFiles(selectedFiles);

  // Clear input value
  fileChooser.value.value = null;

  emitFiles();
}

const onDragOver = (event) => {
  let isValid = true;
  if (props.accept) {
    const dataTransfer = event.dataTransfer;
    if (dataTransfer) {
      if (dataTransfer.items) {
        for (let i = 0; i < dataTransfer.items.length; i++) {
          if (dataTransfer.items[i].type !== props.accept) {
            isValid = false;
            break;
          }
        }
      }
    }
  }

  if (isValid) {
    addClasses(event.target, ['is-valid']);
  } else {
    addClasses(event.target, ['is-invalid']);
  }

  addClasses(event.target, ['dragging']);
}

const onDragLeave = (event) => {
  removeClasses(event.target, ['is-invalid', 'is-valid', 'dragging']);
}

const processSelectedFiles = async (selectedFiles) => {
  for (let i = 0; i < selectedFiles.length; i++) {
    const file = selectedFiles[i];

    let response = true;

    if (props.beforeUpload) {
      response = props.beforeUpload(file);
    }

    await Promise.resolve(response).then(response => {

      if (response) {
        addFiles(file);
      }
    });
  }
}

const onDrop = (event) => {
  if (props.disabled) return;

  const selectedFiles = event.dataTransfer.files;

  if (checkLimitExceed(selectedFiles) || checkSizeExceed(selectedFiles)) {
    return;
  }

  processSelectedFiles(selectedFiles);

  removeClasses(event.target, ['is-invalid', 'is-valid', 'dragging']);
}

const removeFile = (file) => {
  let response = true;

  if (props.beforeRemove) {
    response = props.beforeRemove(file, files.value);
  }

  Promise.resolve(response).then(response => {
    if (response) {
      const index = files.value.findIndex(item => item === file);

      if (index !== -1) {
        files.value.splice(index, 1);
        uploadFiles.value.splice(index, 1);

        if (props.onRemove) {
          props.onRemove(file, files.value);
        }

      }

      emitFiles();
    }
  });
}

const onRemoveUploadedFileCanceled = () => {
  showConfirmDeleteModal.value = false;
  currentFile.value = null;
}

const onRemoveUploadedFileConfirmed = () => {
  removeFile(currentFile.value);
  showConfirmDeleteModal.value = false;
  currentFile.value = null;
}

const onRemoveClick = (file) => {
  if (file.status === 'success') {
    currentFile.value = file;
    showConfirmDeleteModal.value = true;
  } else {
    removeFile(file);
  }
}

watch(() => props.listType, (newValue) => {
  if (['picture-card', 'picture'].includes(newValue)) {

    files.value = files.value.map(file => {
      if (!file.url && file.raw) {
        try {
          file.url = URL.createObjectURL(file.raw);
        } catch (err) {
          console.error('[Element Error][Upload]', err);
        }
      }
      return file;
    });
  }
});

const getFileExtension = (fileName) => {
  return fileName.replace(/^.*\./, '');
}

const isFileImage = (file) => {
  if (file) {
    if ('type' in file) {
      return file && file['type'].split('/')[0] === 'image';
    } else {
      const fileExt = getFileExtension(file.name ?? '');
      const imagesExtension = ["png", "jpg", "jpeg"];
      return imagesExtension.indexOf(fileExt) !== -1;
    }
  }

  return false;
}

const submit = async () => {
  const filesToUpload = files.value.filter(file => {
    return ['ready', 'fail'].includes(file['status']);
  });

  const requests = [];

  filesToUpload.forEach(file => {
    requests.push(upload(file));
  });

  await axios.all(requests).then(emitFiles);
}

const handlePreview = (file) => {
  if (file.url && props.onPreview) {
    props.onPreview(file);
  }
}

const onFileChooserClicked = () => {
  if (props.disabled) return;

  fileChooser.value.click();
}

const clearAll = () => {
  if (props.disabled) return;
  
  files.value = [];
  uploadFiles.value = [];
  emitFiles();
}

defineExpose({
  submit,
  upload,
  clearAll,
  trigger: onFileChooserClicked,

  name: props.name,
  multiple: props.multiple,
  files,
  uploadFiles,
});

watch(() => props.modelValue, (newValue) => {
  if (newValue) {
    if (!Array.isArray(newValue)) {
      newValue = [newValue];
    }

    const temp = [];

    for (const file of newValue) {
      if (!file.uid) return;

      temp.push({
        uid: file.uid,
        _uid: Date.now() + tempIndex.value++,
        name: file.name,
        url: file.url,
        status: file.status ?? 'success',
        raw: file.raw,
      });
    }

    files.value = temp;
  }
}, { immediate: true, deep: true });

const colorName = computed(() => {
  return `var(--tblr-${props.color}-rgb)`;
});
</script>

<style scoped>
.chooser-area {
  border: 1px dashed;
  display: flex;
  align-items: center;
  justify-content: center;
  color: rgba(var(--tblr-secondary-rgb), .9);
  transition: all .1s;
}

.chooser-area.dragging:not(.chooser-area.disabled) {
  border-width: 2px !important;
}

.chooser-area.is-valid:not(.chooser-area.disabled) {
  border-color: rgb(v-bind('colorName'));
  background-color: rgba(v-bind('colorName'), 0.05) !important;
}

.chooser-area.disabled {
  cursor: not-allowed !important;
  opacity: .5;
  user-select: none;
}

.chooser-area.is-invalid:not(.chooser-area.disabled) {
  border-color: var(--tblr-danger);
  background-color: rgba(var(--tblr-danger-rgb), 0.05) !important;
}

.chooser-area:hover:not(.chooser-area.disabled) {
  border-color: rgb(v-bind('colorName'));
  background-color: rgba(v-bind('colorName'), 0.05) !important;
}

.file-item {
  transition: background-color .1s ease;
}

.file-item:hover {
  background-color: rgba(v-bind('colorName'), 0.05);
  color: rgb(v-bind('colorName'));
}

.remove-button {
  transition: color .3s;
}

.remove-button:hover {
  color: var(--tblr-danger) !important;
}

.file-item:hover .file-item-actions {
  background-color: rgba(var(--tblr-secondary-rgb), 0.7);
  color: var(--tblr-white);
  display: flex !important;
}

.file-item-upload-progress {
  background-color: rgba(var(--tblr-secondary-rgb), 0.6) !important;
}
</style>