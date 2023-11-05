import { h } from 'vue'
import { RouterLink } from 'vue-router'

const BelongsToField = (props) => {
  if (!props.value) {
    return h('span', '')
  }

  const resource = props.column.resource
  const labelAttribute = props.column.nameAttribute || 'name'
  const valueAttribute = props.column.idAttribute || 'id'

  if (!resource || !props.value[valueAttribute]) {
    return h('span', props.value[labelAttribute])
  }

  const link =
    props.column.link ??
    function () {
      return `/admin/${resource}/${props.value[valueAttribute]}/update`
    }

  return h(
    RouterLink,
    {
      to: link(props.record, props.value)
    },
    () => props.value[labelAttribute]
  )
}

BelongsToField.props = {
  value: {
    type: [Object],
    default: () => ({})
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

export default BelongsToField
