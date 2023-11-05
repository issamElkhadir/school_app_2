export default {
  label: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: ''
  },
  borderless: {
    type: Boolean,
    default: false
  },
  filled: {
    type: Boolean,
    default: false
  },
  standout: {
    type: Boolean,
    default: false
  },
  outlined: {
    type: Boolean,
    default: false
  },
  transparent: {
    type: Boolean,
    default: false
  },
  options: {
    type: Array,
    required: false
  },
  rounded: {
    type: Boolean,
    default: false
  },
  square: {
    type: Boolean,
    default: false
  },
  optionsHeight: {
    type: String,
    default: '185px'
  },
  modelValue: {
    default: null
  },
  clearable: {
    type: Boolean,
    default: false
  },
  multiselect: {
    type: Boolean,
    default: false
  },

  inline: {
    type: Boolean,
    default: false
  },

  hideOptionsHeader: {
    type: Boolean,
    default: false
  },

  hideArrow: {
    type: Boolean,
    default: false
  },

  zIndex: {
    type: Number,
    default: null
  },
  searchable: {
    type: Boolean,
    default: false
  },
  maxValues: {
    type: Number,
    default: null
  },
  useChips: {
    type: Boolean,
    default: false
  },
  optionLabel: {
    type: String,
    default: 'label'
  },
  optionValue: {
    type: String,
    default: 'value'
  },
  emitValue: {
    type: Boolean,
    default: false
  },
  classes: {
    type: [Array, Object, String],
    default: null
  },
  style: {
    type: [Array, Object, String]
  },
  closeOnSelect: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  },
  hideLabel: {
    type: Boolean,
    default: false
  },
  filterFn: {
    type: Function,
    default: null
  },
  filterFields: {
    type: Array,
    default: null
  },
  debounce: {
    type: Number,
    default: 0
  },

  inputDebounce: {
    type: Number,
    default: 0
  },

  loading: {
    type: Boolean,
    default: false
  },
  noMatchText: {
    type: String,
    default: 'No Match Found'
  },
  noDataText: {
    type: String,
    default: 'No Options Found'
  },
  errors: {
    type: Array,
    default: () => []
  },

  invalid: {
    type: Boolean
  },

  dropdownFitContent: {
    type: Boolean,
    default: false
  },

  maxWidth: {
    type: [Number, String]
  },

  size: {
    type: String,
    default: 'md'
  },

  required: {
    type: Boolean,
    default: false
  }
}
