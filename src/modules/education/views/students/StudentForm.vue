<template>
  <div class="row row-cards">

    <PlfTabView>
      <div class="col-12 col-md-10 mx-auto">

        <PlfTabPanel header="General">
          <div class="d-flex w-full justify-content-between align-items-center p-3">

            <div class="display-6 d-none d-md-block fw-bold">
              {{ record.first_name }} {{ record.last_name }}
            </div>

            <!--            <AvatarField :label="$t('Image')"
                                     v-model="record.image"
                                     :disabled="disabled"
                                     with-credentials

                                     :accept="'image/*'"
                                     :action="`${backEndUrl}/upload`"
                                     id="image"
                        />-->
          </div>
          <div class="row p-3">
            <div class="col-md-6">
              <div class="d-flex gap-3 flex-column">
                <TextField id="first_name"
                           required
                           :disabled="disabled"
                           :label="$t('First Name')"
                           :errors="validation.first_name"
                           :class="{ 'is-invalid': 'first_name' in validation }"
                           v-model="record.first_name"/>

                <TextField id="last_name"
                           required
                           :disabled="disabled"
                           :label="$t('Last Name')"
                           :errors="validation.last_name"
                           :class="{ 'is-invalid': 'last_name' in validation }"
                           v-model="record.last_name"/>

                <TextField id="rtl-first-name"

                           :disabled="disabled"
                           :label="$t('RTL First Name')"
                           :errors="validation.rtl_first_name"
                           :class="{ 'is-invalid': 'rtl_first_name' in validation }"
                           v-model="record.rtl_first_name"/>

                <TextField id="rtl-name"

                           :disabled="disabled"
                           :label="$t('RTL Last Name')"
                           :errors="validation.rtl_last_name"
                           :class="{ 'is-invalid': 'rtl_last_name' in validation }"
                           v-model="record.rtl_last_name"/>

                <BooleanField v-model="record.has_scholarship"
                              label="Has Scholarship"
                              :disabled="disabled"
                />

                <GenderField v-model="record.gender"
                             :label="$t('Gender')"
                             :disabled="disabled"
                             :errors="validation.gender"
                             :invalid="'gender' in validation"/>

              </div>
            </div>

            <div class="col-md-6">
              <div class="d-flex space-y-3 flex-column">

                <BelongsToField :label="$t('students.fields.nativeLanguage')"
                                v-model="record.nativeLanguage"
                                resource="languages"
                                :invalid="'nativeLanguage.id' in validation"
                                :errors="validation['nativeLanguage.id']"
                                :disabled="disabled"
                                required
                />

                <BelongsToField :label="$t('students.fields.secondLanguage')"
                                v-model="record.secondLanguage"
                                resource="languages"
                                :invalid="'secondLanguage.id' in validation"
                                :errors="validation['secondLanguage.id']"
                                :disabled="disabled"
                                required
                />


                <TextField id="cin"
                           :disabled="disabled"
                           :label="$t('CIN')"
                           :errors="validation.cin"
                           :class="{ 'is-invalid': 'cin' in validation }"
                           v-model="record.cin"/>

                <TextField id="cne"
                           :disabled="disabled"
                           :label="$t('CNE')"
                           :errors="validation.cne"
                           :class="{ 'is-invalid': 'cne' in validation }"
                           v-model="record.cne"/>

                <DateField :label="$t('Birthday')"
                           :disabled="disabled"
                           v-model="record.birthday"
                />
              </div>

              <div>
                <label class="invisible">&nbsp;</label>
                <PlfCheckbox :disabled="disabled"
                             label="Has Account ?"
                             class="w-full ps-0"
                             v-model="withAccount"
                />
              </div>
            </div>
          </div>


        </PlfTabPanel>

        <!--        <PlfTabPanel header="Guardians">
                  <div class="row p-3">
                    <BelongsToManyWithPivotField :label="$t('Student Guardians')"
                                                 v-model="record.guardians"
                                                 v-bind="fields.guardians.component.props"
                                                 name="guardians"
                                                 :validation="validation"
                                                 :disabled="disabled" />
                  </div>
                </PlfTabPanel>-->

        <PlfTabPanel header="Address">
          <div class="row p-3">
            <div class="col-md-6">
              <div class="d-flex space-y-3 flex-column">
                <BelongsToField :label="$t('students.fields.country')"
                                v-model="record.country"
                                resource="countries"
                                :invalid="'country.id' in validation"
                                :errors="validation['country.id']"
                                :disabled="disabled"
                                required
                />

                <BelongsToField :label="$t('students.fields.city')"
                                v-model="record.city"
                                resource="cities"
                                :invalid="'city.id' in validation"
                                :errors="validation['city.id']"
                                :disabled="disabled"
                                required
                />

                <TextField type="textarea"
                           :disabled="disabled"
                           :label="$t('fields.address.label')"
                           :errors="validation.address"
                           :invalid="'address' in validation"
                           v-model="record.address"/>

              </div>
            </div>

            <div class="col-md-6">
              <div class="d-flex mt-3 mt-md-0 space-y-3 flex-column">

                <BelongsToField :label="$t('students.fields.nationality')"
                                v-model="record.nationality"
                                resource="countries"
                                :invalid="'nationality.id' in validation"
                                :errors="validation['nationality.id']"
                                :disabled="disabled"
                                required
                />

                <BelongsToField :label="$t('students.fields.birthCity')"
                                v-model="record.birthCity"
                                resource="cities"
                                :invalid="'birthCity.id' in validation"
                                :errors="validation['birthCity.id']"
                                :disabled="disabled"
                                required
                />

                <TextField id="postal-code"
                           :disabled="disabled"
                           :label="$t('Postal Code')"
                           :errors="validation.postal_code"
                           :invalid="'postal_code' in validation"
                           v-model="record.postal_code"/>


              </div>
            </div>
          </div>
        </PlfTabPanel>

        <PlfTabPanel header="Contact">
          <div class="row p-3">
            <div class="col-md-6">
              <div class="d-flex space-y-3 flex-column">
                <TextField type="email"
                           id="email"
                           :disabled="disabled"
                           :label="$t('Email')"
                           :errors="validation.contact_email"
                           :class="{ 'is-invalid': 'contact_email' in validation }"
                           v-model="record.contact_email"/>

                <TextField id="phone"
                           :disabled="disabled"
                           :label="$t('Phone')"
                           :errors="validation.contact_phone_1"
                           :class="{ 'is-invalid': 'contact_phone' in validation }"
                           v-model="record.contact_phone"/>

                <TextField id="mobile"
                           :disabled="disabled"
                           :label="$t('Mobile')"
                           :errors="validation.contact_mobile_1"
                           :class="{ 'is-invalid': 'contact_mobile' in validation }"
                           v-model="record.contact_mobile"/>

              </div>
            </div>

            <div class="col-md-6">
              <div class="d-flex mt-3 mt-md-0 space-y-3 flex-column">

                <TextField id="whatsapp"
                           :disabled="disabled"
                           :label="$t('Whatsapp')"
                           :errors="validation.contact_whatsapp"
                           :class="{ 'is-invalid': 'contact_whatsapp' in validation }"
                           v-model="record.contact_whatsapp"/>

                <TextField id="website"
                           :disabled="disabled"
                           :label="$t('Website')"
                           :errors="validation.contact_website"
                           :class="{ 'is-invalid': 'contact_website' in validation }"
                           v-model="record.contact_website"/>

              </div>
            </div>
          </div>
        </PlfTabPanel>

        <PlfTabPanel header="Others">
          <div class="row p-3">
            <div class="col-md-6">
              <div class="d-flex space-y-3 flex-column">

                <TextField id="quotation"
                           :disabled="disabled"
                           :label="$t('Quotation')"
                           :errors="validation.quotation"
                           :class="{ 'is-invalid': 'quotation' in validation }"
                           v-model="record.quotation"/>

                <TextField id="insurance_name"
                           :disabled="disabled"
                           :label="$t('Insurance Name')"
                           :errors="validation.insurance_name"
                           :class="{ 'is-invalid': 'insurance_name' in validation }"
                           v-model="record.insurance_name"/>

                <TextField id="insurance_number"
                           :disabled="disabled"
                           :label="$t('Insurance Number')"
                           :errors="validation.insurance_number"
                           :class="{ 'is-invalid': 'insurance_number' in validation }"
                           v-model="record.insurance_number"/>

                <TextField id="old_school"
                           :disabled="disabled"
                           :label="$t('Old School')"
                           :errors="validation.old_school"
                           :class="{ 'is-invalid': 'old_school' in validation }"
                           v-model="record.old_school"/>

              </div>
            </div>

            <div class="col-md-6">
              <div class="d-flex mt-3 mt-md-0 space-y-3 flex-column">

                <TextField id="old_delegation"
                           :disabled="disabled"
                           :label="$t('Old Delegation')"
                           :errors="validation.old_delegation"
                           :class="{ 'is-invalid': 'old_delegation' in validation }"
                           v-model="record.old_delegation"/>

                <TextField id="scholarship_holder"
                           :disabled="disabled"
                           :label="$t('Scholarship Holder')"
                           :errors="validation.scholarship_holder"
                           :class="{ 'is-invalid': 'scholarship_holder' in validation }"
                           v-model="record.scholarship_holder"/>

                <TextField type="textarea"
                           id="notes"
                           :disabled="disabled"
                           :label="$t('Notes')"
                           :errors="validation.notes"
                           :class="{ 'is-invalid': 'notes' in validation }"
                           v-model="record.notes"/>

                <TextField type="textarea"
                           id="how_he_knew_the_school"
                           :disabled="disabled"
                           :label="$t('How He Knew The School')"
                           :errors="validation.how_he_knew_the_school"
                           :class="{ 'is-invalid': 'how_he_knew_the_school' in validation }"
                           v-model="record.how_he_knew_the_school"/>

              </div>
            </div>
          </div>
        </PlfTabPanel>

        <PlfTabPanel v-if="withAccount"
                     header="Account Details">
          <ProfileAccount v-model="record.user"
                          :validation="validation"
                          :disabled="disabled"/>
        </PlfTabPanel>

      </div>
    </PlfTabView>

  </div>
</template>

<script setup>
import BelongsToField from '@/fields/forms/BelongsToField.vue';
import {useVModel} from '@vueuse/core';
import TextField from "@/fields/forms/TextField.vue";
import PlfTabPanel from "@/components/shared/tabview/PlfTabPanel.vue";
import PlfTabView from "@/components/shared/tabview/PlfTabView.vue";
import {computed, ref, watch} from "vue";
import DateField from "@/fields/forms/DateField.vue";
import GenderField from "@/fields/forms/GenderField.vue";
import PlfCheckbox from "@/components/shared/checkbox/PlfCheckbox.vue";
import ProfileAccount from "@education/views/ProfileAccount.vue";
import BooleanField from "@/fields/forms/BooleanField.vue";

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {
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

const record = useVModel(props, 'modelValue', emit);


const withAccount = ref(false);
let user = {};

watch(withAccount, (value) => {
  if (value) {
    record.value.user = record.value.user || user;

    delete record.value.user.password;
    delete record.value.user.password_confirmation;
  } else {
    user = record.value.user;

    record.value.user = null;
  }
}, {flush: 'pre'});

watch(() => record.value.user, (value) => {
  if (value) {
    withAccount.value = true;
  }
}, {immediate: true});

const fullName = computed(() => `${record.value.first_name ?? ''} ${record.value.last_name ?? ''}`.trim());

watch(fullName, (value) => {
  if (withAccount.value) {
    record.value.user.name = value;
  }
}, {immediate: true, flush: 'pre'});


</script>