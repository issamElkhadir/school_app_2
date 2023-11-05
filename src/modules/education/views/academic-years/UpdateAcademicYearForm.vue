<template>
  <ResourceUpdate resource="education/academic-years"
                  :id="id"
                  :title="$t('')">

    <template #subtitle="{ original }">
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage" />

        <PlfBreadcrumbEl label="Academic Years"
                         :to="{ name: 'admin.academic-years.table' }" />

        <PlfBreadcrumbEl :label="original.name || 'Edit'" />
      </PlfBreadcrumb>
    </template>

    <template #actions="{ disabled, saving, save, toggleEdit }">
      <template v-if="disabled">
        <PlfButton label="Edit"
                   @click="toggleEdit" />

        <PlfButton label="New"
                   :to="{ name: 'admin.academic-years.create' }"
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
          <PlfSelect label="Is Locked"
                     required
                     :disabled="disabled"
                     v-model="record.is_locked"
                     :options="is_locked"
                     emit-value
                     close-on-select
                     :errors="validation.is_locked"
                     :invalid="'is_locked' in validation">
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
          <BelongsToField label="Parent Academic Year"
                          resource="education/academic-year"
                          required
                          :disabled="disabled"
                          v-model="record.parentAcademicYear"
                          :errors="validation['parentAcademicYear.id']"
                          :invalid="'parentAcademicYear.id' in validation"/>
        </div>

        <div class="col-md-4">
          <PlfInput label="Parent Academic Year Name"
                    :disabled="disabled"
                    v-model="record.parent_academic_year_name"
                    :errors="validation.parent_academic_year_name"
                    :invalid="'parent_academic_year_name' in validation"
          />
        </div>


        <div class="col-md-4">
          <DateField label="Start Date"
                     required
                     :disabled="disabled"
                     v-model="record.start_date"
                     :errors="validation.start_date"
                     :invalid="'start_date' in validation"/>
        </div>

        <div class="col-md-4">
          <DateField label="End Date"
                     required
                     :disabled="disabled"
                     v-model="record.end_date"
                     :errors="validation.end_date"
                     :invalid="'end_date' in validation"/>
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
import DateField from "@/fields/filters/DateField.vue";

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


const is_locked = [
  {value: true, label: 'Locked', color: 'bg-secondary'},
  {value: false, label: 'Not Locked', color: 'bg-success'}
];

</script>