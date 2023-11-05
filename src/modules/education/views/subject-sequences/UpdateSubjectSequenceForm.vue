<template>
  <ResourceUpdate resource="education/subject-sequences"
                  :id="id"
                  :title="$t('')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl label="Subject Sequence"
                         :to="{ name: 'admin.subject-sequences.table' }"/>

        <PlfBreadcrumbEl :label="original.name || 'Edit'"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit"/>

        <PlfButton label="New"
                   :to="{ name: 'admin.subject-sequences.create' }"
                   icon="mdi.IconPlus"
                   color="primary"/>
      </template>

      <template v-else>
        <PlfButton label="Cancel"
                   @click="toggleEdit"/>

        <PlfButton label="Save"
                   @click="save"
                   :loading="saving"
                   icon="mdi.IconContentSave"
                   color="primary"/>
      </template>
    </template>

    <template #form="{ record, original, validation, disabled }">
      <h3 class="card-title">Update Subject Sequence {{ original.name }}</h3>

      <div class="row row-cards">

        <div class="col-md-4">
          <BelongsToField label="Subject"
                          resource="education/subjects"
                          required
                          :disabled="disabled"
                          v-model="record.subject"
                          :errors="validation['subject.id']"
                          :invalid="'subject.id' in validation"/>
        </div>

        <div class="col-md-4">
          <PlfInput label="NBH"
                    :disabled="disabled"
                    v-model="record.nbh"
                    :errors="validation.nbh"
                    :invalid="'nbh' in validation"
          />
        </div>

        <div class="col-md-4">
          <PlfSelect label="Status"
                     required
                     :disabled="disabled"
                     v-model="record.status"
                     :options="status"
                     emit-value
                     close-on-select
                     :errors="validation.status"
                     :invalid="'status' in validation">
            <template #option="{ option, onSelect }">
              <div class="p-2"
                   @click="onSelect(option)">
                <span class="badge"
                      :class="option.color"></span>
                {{ option.label }}
              </div>
            </template>

            <template #select-header="{ option }">
              <div v-if="option"
                   class="flex-fill cursor-pointer d-flex align-items-center">
                <span class="me-1 badge"
                      :class="option.color"></span>
                {{ option.label }}
              </div>
            </template>
          </PlfSelect>
        </div>

        <div class="col-md-4">
          <PlfInput label="Content"
                    type="textarea"
                    :disabled="disabled"
                    v-model="record.content"
                    :errors="validation.content"
                    :invalid="'content' in validation"
                    required/>
        </div>

      </div>

    </template>
  </ResourceUpdate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import ResourceUpdate from '@/components/ResourceUpdate.vue';
import PlfSelect from "@/components/shared/select/PlfSelect.vue";
import BelongsToField from "@/fields/forms/BelongsToField.vue";

defineProps({
  id: {
    type: Number,
    required: true
  }
});

const status = [
  {value: true, label: 'Active', color: 'bg-success'},
  {value: false, label: 'Inactive', color: 'bg-secondary'}
];

</script>