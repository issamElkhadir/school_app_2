import { h } from "vue"

const StringField = (props) => {
  return h('span', props.value);
}

StringField.props = {
  value: {
    type: [String, Number, Boolean],
    default: ''
  },

  column: {
    type: Object,
    default: () => ({})
  },

  record: {
    type: Object,
    default: () => ({})
  }
}

export default StringField