<template>
  <DeleteModal :message="$t('Are you sure you want to delete this section? All questions in this section will be deleted as well.')"
               :title="$t('Delete Section')"
               v-model:visible="showDeleteSectionModal"
               :delete-button-text="$t('Delete Section')"
               @cancel="onCancelDeleteSection"
               @delete="onDeleteSection" />

  <div @click="onClick" class="d-flex flex-column align-items-start">
    <div style="margin-bottom: -1px;"
         class="z-1 rounded-top border-0 p-2 px-3 bg-primary text-white w-auto">
      {{ $t('Section {index} of {count}', { index: index + 1, count: sectionsCount }) }}
    </div>

    <div class="d-flex shadow-sm align-self-stretch border rounded-bottom rounded-end">
      <div class="border border-2 rounded-start"
           style="margin-inline-start: -1px; border-top-left-radius: 0 !important;"
           :class="{ 'border-primary': active, 'border-transparent': !active }">
      </div>

      <div class="p-4 flex-fill d-flex flex-column gap-3">
        <div class="d-flex align-items-center gap-3">
          <div class="flex-fill">
            <PlfInput :label="$t('Section title')"
                      v-model="value.title"
                      :disabled="disabled"
                      floating />
          </div>

          <PlfDropdown hide-arrow
                       v-if="index > 0"
                       :disabled="disabled"
                       popper-classes="shadow">
            <template #menu>
              <PlfList>

                <PlfListItem nav
                             @click="mergeWithPreviousSection"
                             class="mt-0 rounded-0"
                             :title="$t('Merge with previous section')" />

                <PlfListItem nav
                             @click="move('up')"
                             class="mt-0 rounded-0"
                             :title="$t('Move Section Up')" />

                <PlfListItem nav
                             @click="move('down')"
                             class="mt-0 rounded-0"
                             :title="$t('Move Section Down')" />

                <PlfListItem nav
                             @click="duplicate"
                             class="mt-0 rounded-0"
                             :title="$t('Duplicate Section')" />

                <PlfListItem nav
                             @click="removeSection"
                             class="mt-0 rounded-0"
                             :title="$t('Delete Section')" />
              </PlfList>
            </template>

            <template #default>

              <PlfButton icon="mdi.IconDotsVertical"
                         class="btn-action"
                         :disabled="disabled" />
            </template>
          </PlfDropdown>
        </div>

        <PlfInput :label="$t('Section description')"
                  v-model="value.description"
                  :disabled="disabled"
                  floating />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useModel } from '../../composables/ui/useModel';
import DeleteModal from '../DeleteModal.vue';
import PlfButton from '../shared/button/PlfButton.vue';
import PlfDropdown from '../shared/dropdown/PlfDropdown.vue';
import PlfInput from '../shared/forms/PlfInput.vue';
import PlfList from '../shared/list/PlfList.vue';
import PlfListItem from '../shared/list/PlfListItem.vue';

const emit = defineEmits([
  'update:modelValue',
  'remove-section',
  'merge-with-previous-section',
  'move',
  'duplicate',
  'click'
]);

const props = defineProps({
  active: {
    type: Boolean,
    default: false,
  },

  modelValue: {
    type: Object,
    required: true,
  },

  index: {
    type: Number,
    required: true,
  },

  disabled: {
    type: Boolean,
    default: false,
  },

  sectionsCount: {
    type: Number,
    required: true,
  },
});

const value = useModel(props, 'modelValue', emit, {
  defaultValue: {
    title: '',
    description: '',
  },
});

const showDeleteSectionModal = ref(false);

const removeSection = () => {
  showDeleteSectionModal.value = true;
};

const onCancelDeleteSection = () => {
  showDeleteSectionModal.value = false;
};

const onDeleteSection = () => {
  showDeleteSectionModal.value = false;
  emit('remove-section');
};

const mergeWithPreviousSection = () => {
  emit('merge-with-previous-section');
};

const move = (direction) => {
  emit('move', direction);
};

const duplicate = () => {
  emit('duplicate');
}

const onClick = () => {
  emit('click');
};
</script>

<style scoped>
.border-transparent {
  border-color: transparent !important;
}
</style>