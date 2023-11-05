<template>
  <div class="page-wrapper lvh-100">
    <!-- Page header -->
    <slot name="header">
      <div class="page-header mt-3 d-print-none">
        <div class="container-fluid">
          <div class="row g-2 align-items-center">
            <div class="col">
              
              <slot name="title"
                    :title="title">
                <h2 class="page-title">
                  {{ title }}
                </h2>
              </slot>

              <slot name="subtitle"
                    :subtitle="subtitle">
                <div v-if="subtitle"
                     class="page-pretitle">
                  {{ subtitle }}
                </div>
              </slot>
            </div>

            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
              <div class="btn-list">
                <!-- Actions -->

                <slot name="actions"
                      :save="save"
                      :storing="storing">

                  <PlfButton label="Save"
                             @click="save"
                             :loading="storing"
                             icon="mdi.IconContentSave"
                             color="primary" />
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
                <slot name="form"
                      :validation="validation"
                      :save="save"
                      :record="internalRecord"></slot>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import PlfButton from './shared/button/PlfButton.vue';
import { useApiStore } from '../composables/network/resources/useApiStore';
import { useToast } from './shared/toast/useToast';
import { useRouter } from 'vue-router';
import { useVModel } from '@vueuse/core';

const emit = defineEmits(['saved']);

const props = defineProps({
  title: {
    type: String,
  },

  subtitle: {
    type: String,
  },

  resource: {
    type: String,
    required: true
  },

  redirectAfterSave: {
    type: [String, Object],
  },

  record: {
    type: Object
  }
});

const router = useRouter();

const internalRecord = useVModel(props, "record", emit, {
  defaultValue: {},
  passive: true
});

const toast = useToast();

const {
  store,
  storing,
  error,
  validation
} = useApiStore(props.resource);

const save = () => {
  store(internalRecord.value, {
    onSuccess: ({ data }) => {
      toast.add({
        severity: 'success',
        summary: 'Success',
        detail: 'Resource created successfully',
        position: 'bottom-right'
      });

      internalRecord.value = data;

      emit('saved', data);

      if (props.redirectAfterSave) {
        router.push(props.redirectAfterSave);
      }
    },

    onError: () => {
      toast.add({
        severity: 'error',
        summary: 'Error',
        detail: error.value ?? 'Resource could not be created',
        position: 'bottom-right'
      });
    },
  });
};
</script>