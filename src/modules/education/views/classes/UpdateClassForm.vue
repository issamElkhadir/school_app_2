<template>
  <ResourceUpdate resource="education/classes"
                  :id="id"
                  :title="$t('')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Classes"
                         :to="{ name: 'admin.classes.table' }" />

        <PlfBreadcrumbEl :label="original.name || 'Edit'" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit" />

        <PlfButton label="New"
                   :to="{ name: 'admin.classes.create' }"
                   icon="mdi.IconPlus"
                   color="primary" />
      </template>

      <template v-else>
        <PlfButton label="Cancel"
                   @click="toggleEdit" />

        <PlfButton label="Save"
                   @click="save"
                   :loading="saving"
                   icon="mdi.IconContentSave"
                   color="primary" />
      </template>
    </template>

    <template #form="{ record, original, validation, disabled }">
      <h3 class="card-title">Update Classroom Types {{ original.name }}</h3>

      <div class="row row-cards">
        <div class="col-md-4">
          <PlfInput label="Name"
                    :disabled="disabled"
                    v-model="record.name"
                    :errors="validation.name"
                    :invalid="'name' in validation"
                    required/>
        </div>

        <div class="col-md-4">
          <PlfInput label="RTL Name"
                    :disabled="disabled"
                    v-model="record.rtl_name"
                    :errors="validation.rtl_name"
                    :invalid="'rtl_name' in validation"
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
          <BelongsToField label="School"
                          resource="schools"
                          required
                          :disabled="disabled"
                          v-model="record.school"
                          :errors="validation['school.id']"
                          :invalid="'school.id' in validation"/>
        </div>

        <div class="col-md-4">
          <BelongsToField label="Level"
                          resource="education/levels"
                          required
                          :disabled="disabled"
                          v-model="record.level"
                          :errors="validation['level.id']"
                          :invalid="'level.id' in validation"/>
        </div>

        <div class="col-md-4">
          <BelongsToField label="Parent Class"
                          resource="education/classes"
                          :disabled="disabled"
                          v-model="record.parentClass"
                          :errors="validation['parentClass.id']"
                          :invalid="'parentClass.id' in validation"/>
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
  { label: 'Active', value: 'active', color: 'bg-success' },
  { label: 'Inactive', value: 'inactive', color: 'bg-danger' }
];

</script>