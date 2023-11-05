<template>
  <div class="page-wrapper lvh-100">
    <!-- Page header -->
    <slot name="header" :record="record" :original="original" :disabled="disabled">
      <div class="page-header mt-3 d-print-none">
        <div class="container-fluid">
          <div class="row g-2 align-items-center">
            <div class="col">

              <slot name="title" :title="title">
                <h2 class="page-title">
                  {{ title }}
                </h2>
              </slot>

              <slot name="subtitle" :subtitle="subtitle" :record="record" :original="original">
                <div v-if="subtitle" class="page-pretitle">
                  {{ subtitle }}
                </div>
              </slot>
            </div>

            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
              <div class="btn-list">
                <!-- Actions -->
                <slot name="actions" :disabled="disabled" :toggle-edit="handleEditMode" :save="edit" :saving="saving">
                </slot>
              </div>
            </div>
          </div>
        </div>
      </div>
    </slot>

    <!-- Page body -->
    <div class="flex-fill page-body">
      <div class="container-fluid d-flex mb-2 flex-column h-100">
        <div class="row row-cards h-100">
          <div class="col-12 h-100">
            <form class="card h-100">
              <div class="card-body h-100">
                <slot name="form" :validation="validation" :record="record" :original="original" :disabled="disabled"
                  :undo="undo" :redo="redo" :canUndo="canUndo" :canRedo="canRedo">
                </slot>
              </div>

              <PlfLoading v-if="loading" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script setup>
import { nextTick, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useRefHistory } from '@vueuse/core';
import { useToast } from '@/components/shared/toast/useToast';
import { useApiShow } from '@/composables/network/resources/useApiShow';
import { useApiSave } from '@/composables/network/resources/useApiSave';
import PlfLoading from '@/components/shared/loading/PlfLoading.vue';

const emit = defineEmits(['saved']);

const props = defineProps({
  id: {
    type: Number,
    required: true
  },

  title: {
    type: String,
  },

  subtitle: {
    type: String,
  },

  resource: {
    type: String,
    required: true,
  },

  redirectAfterSave: {
    type: [String, Object],
  }
});

const router = useRouter();

// Edit mode flag
const disabled = ref(true);

// Original record to rollback changes on cancel
let original = {};

// Record to edit
const record = ref({});


const { undo, redo, canUndo, canRedo, clear } = useRefHistory(record, { deep: true });


const toast = useToast();

// Network requests
const {
  load,
  loading,
} = useApiShow(props.resource);

const {
  save,
  saving,
  error,
  validation
} = useApiSave(props.resource);

// Load record on mount
onMounted(() => {

  load(+props.id, {
    onSuccess: (response) => {
      record.value = response.data;
      original = structuredClone(response.data);
      nextTick(() => {
        clear();
      });
    }
  });
});

// Edit record
const edit = () => {
  save({
    id: record.value.id,
    payload: record.value,
    onSuccess: ({ data }) => {
      toast.add({
        severity: 'success',
        summary: 'Success',
        detail: 'Resource updated',
        position: 'bottom-right'
      });

      original = structuredClone(data);

      record.value = data;

      disabled.value = true;

      emit('saved', data);

      if (props.redirectAfterSave) {
        router.push(props.redirectAfterSave);
      }
    },

    onError: () => {
      toast.add({
        severity: 'error',
        summary: 'Error',
        detail: error.value ?? 'Something went wrong',
        position: 'bottom-right'
      });
    },
  });
};

// Toggle edit mode
const handleEditMode = () => {
  disabled.value = !disabled.value;

  record.value = structuredClone(original);
};
</script>