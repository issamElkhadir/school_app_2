import { h } from "vue"
import PlfIcon from "@/components/shared/icon/PlfIcon.vue"

const BooleanField = (props) => {
  const { value } = props

  if (value === null || value === undefined) {
    return h('span', '')
  } else if (value) {
    return h(PlfIcon, { name: 'mdi.IconCheckCircleOutline', class: 'text-success' });
  } else {
    return h(PlfIcon, { name: 'mdi.IconCloseCircleOutline', class: 'text-danger' });
  }
}

BooleanField.props = {
  value: {
    type: Boolean,
    default: null
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

export default BooleanField