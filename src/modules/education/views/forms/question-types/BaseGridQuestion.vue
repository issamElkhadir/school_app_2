<template>
  <div class="row">
    <div class="col d-flex flex-column">
      <h4>{{ $t('Rows') }}</h4>

      <ol class="d-flex flex-column gap-2">
        <li v-for="(row, index) in rows"
            :key="`row-${row.value}`">
          <PlfInput borderless
                    :disabled="disabled"
                    v-model="rows[index].label"
                    input-classes="rounded-bottom-0 border-bottom">
            <template v-if="rows.length > 1"
                      #suffix>
              <PlfButton class="btn-action rounded-circle"
                         @click="handleRemoveRow(index)"
                         :disabled="disabled"
                         icon="mdi.IconRemove" />
            </template>
          </PlfInput>
        </li>
      </ol>

      <PlfButton class="btn-action align-self-end"
                 @click="addRow"
                 :disabled="disabled"
                 icon="mdi.IconPlus" />
    </div>

    <div class="col d-flex flex-column">
      <h4>{{ $t('Columns') }}</h4>

      <ul class="list-unstyled d-flex flex-column gap-2">
        <li v-for="(col, index) in cols"
            :key="`col-${col.value}`">
          <PlfInput borderless
                    :disabled="disabled"
                    v-model="cols[index].label"
                    input-classes="rounded-bottom-0 border-bottom">
            <template #prefix>
              <PlfIcon v-if="!preferences.make_form_as_quiz" name="mdi.IconRadioButtonUnchecked"
              class="text-muted"/>
         <input v-if="preferences.make_form_as_quiz && (questionType === 'checkboxgridquestion' || questionType === 'multiplechoicegridquestion') " 
           :type="questionType === 'checkboxgridquestion' ? 'checkbox' : 'radio'" 
           rounded
           name="option"
           :value="cols[index].is_correct"
           @click="handleOptionClick(index)"
           class="form-check-input" />
            </template>
            <template v-if="cols.length > 1"
                      #suffix>
              <PlfButton class="btn-action rounded-circle"
                         @click="handleRemoveColumn(index)"
                         :disabled="disabled"
                         icon="mdi.IconRemove" />
            </template>
          </PlfInput>
        </li>
      </ul>

      <PlfButton class="btn-action align-self-end"
                 @click="addColumn"
                 :disabled="disabled"
                 icon="mdi.IconPlus" />
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const emit = defineEmits(['update:modelValue']);
import PlfButton from '@/components/shared/button/PlfButton.vue';
import PlfInput from '@/components/shared/input/PlfInput.vue';

const props = defineProps({
  disabled: {
    type: Boolean,
    default: false
  },

  modelValue: {
    type: Object,
    default: () => ({})
  } ,
  preferences : {
    type : Object ,
    required : true
  } ,
  questionType : {
    type : String ,
    required : true
  }
});

const rows = ref([
  {
    label: 'Row 1',
    value: 'row-1'
  }
]);

const cols = ref([
  {
    label: 'Column 1',
    value: 'column-1'
  }
]);

const addRow = () => {
  rows.value.push({
    label: `Row ${rows.value.length + 1}`,
    value: `row-${rows.value.length + 1}`
  });
};

const addColumn = () => {
  cols.value.push({
    label: `Column ${cols.value.length + 1}`,
    value: `column-${cols.value.length + 1}` ,
    is_correct : (props.questionType === 'checkboxgridquestion' || props.questionType === 'multiplechoicegridquestion') ? false :null 
  });
};

const handleOptionClick = (index) => {
  if(props.questionType === "multiplechoicegridquestion") {
    cols.value.map((option) => option.is_correct = false );
    cols.value[index].is_correct = true ;
  }else if(props.questionType === "checkboxgridquestion") {
    cols.value[index].is_correct = cols.value[index].is_correct ? false : true ;
  }
}

const handleRemoveColumn = (index) => {
  cols.value = cols.value.filter((_, i) => i !== index);
};

const handleRemoveRow = (index) => {
  rows.value = rows.value.filter((_, i) => i !== index);
};
watch([rows, cols], () => {
  emit('update:modelValue', {
    ...props.modelValue,
    options: {
      rows: rows.value,
      cols: cols.value
    }
  });
}, { deep: true });

watch(() => props.modelValue, (newVal) => {
  if (newVal?.options?.rows) {
    rows.value = newVal.options.rows;
  }

  if (newVal?.options?.cols) {
    cols.value = newVal.options.cols;
  }
}, { immediate: true });
</script>