<template>
  <!-- Start: Delete Modal Confirmation -->
  <PlfDialog :model-value="visible"
             @update:modelValue="onCancelClicked"
             :square="square"
             persistent
             seamless
             modal-dialog-classes="modal-sm">
    <template #default>
      <div class="modal-status rounded-0 bg-danger"></div>

      <div class="modal-body text-center py-4">
        <PlfIcon class="mb-2 icon icon-lg text-danger"
                 name="tblr.IconAlertTriangle" />
        <h3>{{ $t('Are you sure?') }}</h3>
        <div class="text-muted">
          {{ $t(message, { count: selectedCount }) }}
        </div>
      </div>

      <div class="modal-footer">
        <div class="w-100">
          <div class="row">
            <div class="col">
              <PlfButton class="btn w-100"
                         :square="square"
                         :disabled="deleting"
                         @click="onCancelClicked">
                {{ $t('Cancel') }}
              </PlfButton>
            </div>

            <div class="col">
              <PlfButton class="btn btn-danger w-100"
                         :square="square"
                         :loading="deleting"
                         :disabled="deleted"
                         :class="{ 'btn-icon': deleted }"
                         @click="onDeleteClicked">
                <PlfIcon v-if="deleted"
                         name="tblr.IconCircleCheck" />

                <template v-else>
                  <slot name="delete-button-text">
                    {{ $t(deleteButtonText, { count: selectedCount }) }}
                  </slot>
                </template>

              </PlfButton>
            </div>
          </div>
        </div>
      </div>
    </template>
  </PlfDialog>
  <!-- End: Delete Modal Confirmation -->
</template>

<script setup>
import PlfDialog from './shared/dialog/PlfDialog.vue';
import PlfIcon from './shared/icon/PlfIcon.vue';
import PlfButton from './shared/button/PlfButton.vue';

const emit = defineEmits(['delete', 'cancel', 'update:visible']);

defineProps({
  visible: Boolean,

  message: {
    type: String,
    default: 'general.delete'
  },

  selectedCount: {
    type: Number,
    default: 0
  },

  deleting: Boolean,
  deleted: Boolean,

  deleteButtonText: {
    type: String,
    default: 'general.btn-delete'
  },

  square: {
    type: Boolean,
    default: () => false
  }
});

const onDeleteClicked = () => {
  emit('delete');
};

const onCancelClicked = () => {
  emit('cancel');
  emit('update:visible', false);
};
</script>

<style scoped></style>
