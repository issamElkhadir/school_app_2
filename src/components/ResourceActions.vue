<template>
  <div class="text-end d-flex align-items-center">
    <slot v-bind="props"
          @delete="handleDelete">
      <slot name="prepend"
            v-bind="props"
            @delete="handleDelete"></slot>

      <PlfButton v-if="editable"
                 icon="tblr.IconPencil"
                 class="btn-action btn-sm"
                 :to="editLink" />

      <PlfButton icon="tblr.IconTrash"
                 @click="handleDelete"
                 class="btn-action btn-sm text-danger" />

      <slot name="append"
            v-bind="props"
            @delete="handleDelete"></slot>
    </slot>
  </div>
</template>

<script setup>
import PlfButton from './shared/button/PlfButton.vue';

const emit = defineEmits(['delete']);

const props = defineProps({
  row: {
    type: Object,
    required: true
  },

  editable: {
    type: Boolean,
    default: true
  },

  editLink: {
    type: [String, Object],
    default: ''
  }
});

const handleDelete = () => {
  emit('delete', props.row);
};
</script>