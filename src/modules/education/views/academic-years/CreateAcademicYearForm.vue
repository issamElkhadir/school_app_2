<template>
  <ResourceCreate resource="education/academic-years"
                  :title="$t('')"
                  @saved="onSaved">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl label="Academic Years"
                         :to="{ name: 'admin.academic-years.table' }"/>

        <PlfBreadcrumbEl label="New"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.academic-years.table' }"/>

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary"/>
    </template>

    <template #form="{ record, validation }">
      <h3 class="card-title">New Academic Year</h3>

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
                          resource="education/academic-years"
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
  </ResourceCreate>
</template>

<script setup>
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';
import {useRouter} from 'vue-router';
import ResourceCreate from '@/components/ResourceCreate.vue';
import PlfBreadcrumb from '@/components/shared/breadcrumb/PlfBreadcrumb.vue';
import PlfBreadcrumbEl from '@/components/shared/breadcrumb/PlfBreadcrumbEl.vue';
import PlfSelect from "@/components/shared/select/PlfSelect.vue";
import BelongsToField from "@/fields/forms/BelongsToField.vue";
import DateField from "@/fields/filters/DateField.vue";

const router = useRouter();


const status = [
  {value: true, label: 'Active', color: 'bg-success'},
  {value: false, label: 'Inactive', color: 'bg-secondary'}
];

const is_locked = [
  {value: true, label: 'Locked', color: 'bg-secondary'},
  {value: false, label: 'Not Locked', color: 'bg-success'}
];

const onSaved = ({id}) => {
  router.push({name: 'admin.academic-years.update', params: {id}});
}
</script>