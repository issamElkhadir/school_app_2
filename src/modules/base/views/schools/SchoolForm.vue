<template>
  <div class="row row-cards">
    <PlfTabView>
      <div class="col-12 col-md-10 mx-auto">

        <PlfTabPanel header="General">
          <div class="row p-3">
            <div class="col-md-6">

              <div class="d-flex space-y-3 flex-column">

                <TextField label="Name"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.name"
                           :errors="validation.name"
                           :invalid="'name' in validation"
                           required/>

                <TextField label="RTL Name"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.rtl_name"
                           :errors="validation.rtl_name"
                           :invalid="'rtl_name' in validation"/>

                <TextField label="Short Name"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.short_name"
                           :errors="validation.short_name"
                           :invalid="'short_name' in validation"/>

              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex space-y-3 flex-column">

                <TextField label="RTL Name"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.rtl_name"
                           :errors="validation.rtl_name"
                           :invalid="'rtl_name' in validation"/>

                <BooleanField label="Active"
                              inline
                              :disabled="disabled"
                              v-model="recordMutation.active"
                              :true-label="$t('general.status.active')"
                              :false-label="$t('general.status.inactive')"
                              close-on-select
                              :errors="validation.active"
                              :invalid="'active' in validation"/>

              </div>

            </div>
          </div>
        </PlfTabPanel>


        <PlfDivider class="mt-3"/>

        <!--  Classrooms Fields  -->
        <PlfTabPanel header="Classrooms">
          <div class="row p-3">
            <div class="d-flex space-y-3 flex-column">
              <div class="col-12">
                <HasManyField v-model="recordMutation.classrooms"
                              :columns="cols"
                              :label="$t('school.fields.classrooms')"
                              :disabled="disabled"
                              :validation="validation"
                              attribute="classrooms">
                  <template #body-cell-name="{ row, invalid, errors }">
                    <TextField v-model="row.name"
                               :disabled="disabled"
                               :invalid="invalid"
                               :errors="errors"/>
                  </template>

                  <template #body-cell-capacity="{ row, invalid, errors }">
                    <TextField v-model="row.capacity"
                               type="number"
                               :invalid="invalid"
                               :disabled="disabled"
                               :errors="errors"/>
                  </template>

                  <template #body-cell-rtl_name="{ row, invalid, errors }">
                    <TextField v-model="row.rtl_name"
                               :invalid="invalid"
                               :disabled="disabled"
                               :errors="errors"/>
                  </template>

                  <template #body-cell-classroomType="{ row, invalid, errors }">

                    <BelongsToField resource="education/classroom-types"
                                    required
                                    :disabled="disabled"
                                    v-model="row.classroomType"
                                    :errors="errors"
                                    :invalid="invalid"/>

                  </template>

                  <template #body-cell-image="{ row, invalid, errors }">
                    <AvatarField v-model="row.image"
                                 :invalid="invalid"
                                 class="avatar avatar-sm"
                                 :disabled="disabled"
                                 :errors="errors"/>
                  </template>

                </HasManyField>
              </div>
            </div>
          </div>

        </PlfTabPanel>


        <!--  Other Fields  -->
        <PlfTabPanel header="Other">
          <div class="row p-3">
            <div class="col-md-6">
              <div class="d-flex space-y-3 flex-column">

                <DateField label="Authorization Date"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.authorization_date"
                           :errors="validation.authorization_date"
                           :invalid="'authorization_date' in validation"
                           required/>

                <TextField label="Authorization Number"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.authorization_number"
                           :errors="validation.authorization_number"
                           :invalid="'authorization_number' in validation"/>

                <TextField label="Authorization Information"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.authorization_information"
                           :errors="validation.authorization_information"
                           :invalid="'authorization_information' in validation"/>

                <TextField label="RTL Authorization Information"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.rtl_authorization_information"
                           :errors="validation.rtl_authorization_information"
                           :invalid="'rtl_authorization_information' in validation"/>

                <TextField label="CNSS"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.cnss"
                           :errors="validation.cnss"
                           :invalid="'cnss' in validation"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="d-flex space-y-3 flex-column">

                <TextField label="RC"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.rc"
                           :errors="validation.rc"
                           :invalid="'rc' in validation"/>

                <TextField label="ICE"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.ice"
                           :errors="validation.ice"
                           :invalid="'ice' in validation"/>

                <TextField label="Establishment Type"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.establishment_type"
                           :errors="validation.establishment_type"
                           :invalid="'establishment_type' in validation"/>

                <TextField label="Responsible Name"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.responsible_name"
                           :errors="validation.responsible_name"
                           :invalid="'responsible_name' in validation"/>

                <TextField label="Responsible Phone Number"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.responsible_phone_number"
                           :errors="validation.responsible_phone_number"
                           :invalid="'responsible_phone_number' in validation"/>
              </div>
            </div>
          </div>

        </PlfTabPanel>

        <!--  Contact Info -->

        <PlfTabPanel header="Contact">
          <div class="row p-3">
            <div class="col-md-6">
              <div class="d-flex space-y-3 flex-column">

                <TextField label="Contact Address"
                           inline
                           :disabled="disabled"
                           type="textarea"
                           v-model="recordMutation.contact_address"
                           :errors="validation.contact_address"
                           :invalid="'contact_address' in validation"/>

                <TextField label="Contact RTL Address"
                           inline
                           :disabled="disabled"
                           type="textarea"
                           v-model="recordMutation.contact_rtl_address"
                           :errors="validation.contact_rtl_address"
                           :invalid="'contact_rtl_address' in validation"/>

                <TextField label="Contact Name"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.contact_name"
                           :errors="validation.contact_name"
                           :invalid="'contact_name' in validation"/>

                <TextField label="Contact Email"
                           inline
                           :disabled="disabled"
                           type="email"
                           v-model="recordMutation.contact_email"
                           :errors="validation.contact_email"
                           :invalid="'contact_email' in validation"/>

                <TextField label="Contact Whatsapp"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.contact_whatsapp"
                           :errors="validation.contact_whatsapp"
                           :invalid="'contact_whatsapp' in validation"/>

                <TextField label="Contact Website"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.contact_website"
                           :errors="validation.contact_website"
                           :invalid="'contact_website' in validation"/>

                <TextField label="Contact Phone 1"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.contact_phone_1"
                           :errors="validation.contact_phone_1"
                           :invalid="'contact_phone_1' in validation"/>

                <TextField label="Contact Phone 2"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.contact_phone_2"
                           :errors="validation.contact_phone_2"
                           :invalid="'contact_phone_2' in validation"/>


              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex space-y-3 flex-column">

                <TextField label="Contact Mobile 1"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.contact_mobile_1"
                           :errors="validation.contact_mobile_1"
                           :invalid="'contact_mobile_1' in validation"/>

                <TextField label="Contact Mobile 2"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.contact_mobile_2"
                           :errors="validation.contact_mobile_2"
                           :invalid="'contact_mobile_2' in validation"/>

                <TextField label="Contact Fax 2"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.contact_fax_1"
                           :errors="validation.contact_fax_1"
                           :invalid="'contact_fax_1' in validation"/>

                <TextField label="Contact Fax 2"
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.contact_fax_2"
                           :errors="validation.contact_fax_2"
                           :invalid="'contact_fax_2' in validation"/>

                <BelongsToField label="Country"
                                resource="countries"
                                required
                                inline
                                :disabled="disabled"
                                v-model="recordMutation.country"
                                :errors="validation['country.id']"
                                :invalid="'country.id' in validation"/>

                <BelongsToField label="City"
                                resource="cities"
                                required
                                inline
                                :disabled="disabled"
                                v-model="recordMutation.city"
                                :errors="validation['city.id']"
                                :invalid="'city.id' in validation"/>

                <TextField label="Contact Street"
                           required
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.contact_street"
                           :errors="validation.contact_street"
                           :invalid="'contact_street' in validation"/>

                <TextField label="Contact Zip"
                           required
                           inline
                           :disabled="disabled"
                           v-model="recordMutation.contact_zip"
                           :errors="validation.contact_zip"
                           :invalid="'contact_zip' in validation"/>
              </div>
            </div>
          </div>
        </PlfTabPanel>


      </div>
    </PlfTabView>

  </div>
</template>

<script setup>
import PlfDivider from '@/components/shared/divider/PlfDivider.vue';
import BelongsToField from '@/fields/forms/BelongsToField.vue';
import BooleanField from '@/fields/forms/BooleanField.vue';
import DateField from '@/fields/forms/DateField.vue';
import TextField from '@/fields/forms/TextField.vue';
import {useVModel} from '@vueuse/core';
import PlfTabView from "@/components/shared/tabview/PlfTabView.vue";
import PlfTabPanel from "@/components/shared/tabview/PlfTabPanel.vue";
import HasManyField from "@/fields/forms/HasManyField.vue";
import SelectField from "@/fields/forms/SelectField.vue";
import AvatarField from "@/fields/forms/AvatarField.vue";

const emit = defineEmits(['update:record']);

const props = defineProps({
  record: {
    type: Object,
    required: true
  },

  validation: {
    type: Object,
    required: true
  },

  disabled: {
    type: Boolean,
    default: false
  }
});

const recordMutation = useVModel(props, 'record', emit);

const cols = [
  {name: 'name', field: 'name', label: 'Name'},
  {name: 'capacity', field: 'capacity', label: 'Capacity'},
  {name: 'rtl_name', field: 'rtl_name', label: 'RTL Name'},
  {name: 'image', field: 'image', label: 'image'},
  {name: 'classroomType', field: 'image', label: 'classroom Type'},
];

</script>