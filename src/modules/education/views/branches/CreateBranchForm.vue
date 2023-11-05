<template>
  <ResourceCreate resource="education/branches"
                  :title="$t('')"
                  @saved="onSaved">
    <template #subtitle>
      <PlfBreadcrumb>
        <PlfBreadcrumbEl label="Education"
                         class="text-danger"
                         icon="tblr.IconPackage"/>

        <PlfBreadcrumbEl label="Branches"
                         :to="{ name: 'admin.branches.table' }"/>

        <PlfBreadcrumbEl label="New"/>
      </PlfBreadcrumb>
    </template>

    <template #actions="{ save, storing }">
      <PlfButton label="Cancel"
                 :to="{ name: 'admin.branches.table' }"/>

      <PlfButton label="Save"
                 @click="save"
                 :loading="storing"
                 icon="mdi.IconContentSave"
                 color="primary"/>
    </template>

    <template #form="{ record, validation }">
      <h3 class="card-title">New Branch</h3>

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
          <PlfInput label="Short Name"
                    :disabled="disabled"
                    v-model="record.short_name"
                    :errors="validation.short_name"
                    :invalid="'short_name' in validation"
          />
        </div>

        <div class="col-md-4">
          <PlfInput label="Description"
                    :disabled="disabled"
                    v-model="record.description"
                    :errors="validation.description"
                    :invalid="'description' in validation"
          />
        </div>

        <div class="col-md-4">
          <BelongsToField label="Cycle"
                          resource="education/cycles"
                          required
                          :disabled="disabled"
                          v-model="record.cycle"
                          :errors="validation['cycle.id']"
                          :invalid="'cycle.id' in validation"/>
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

const router = useRouter();

const status = [
  {value: true, label: 'Active', color: 'bg-success'},
  {value: false, label: 'Inactive', color: 'bg-secondary'}
];
const onSaved = ({id}) => {
  router.push({name: 'admin.branches.update', params: {id}});
}
</script>