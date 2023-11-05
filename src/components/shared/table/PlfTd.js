import { get } from 'lodash';
import { computed, h } from 'vue';

const PlfTd = (props, { slots }) => {
  const value = computed(() => {
    if (props.column.field && typeof props.column.field === 'function') {
      return props.column.field(props.row);
    } else if (props.column.format && typeof props.column.format === 'function') {
      return props.column.format(props.row);
    } else {
      return get(props.row, props.column?.field);
    }
  });

  const renderSlot = () => {
    if (slots.default) {
      return slots.default({
        column: props.column,
        columns: props.columns,
        filters: props.row.filters,
        rowKey: props.rowKey,
        rowIndex: props.rowIndex,
        row: props.row,
        value: value.value,
      });
    }

    return value.value;
  }

  return h('td', {
    dir: 'auto',
    class: 'text-nowrap text-truncate',
  }, renderSlot());
}

PlfTd.props = {
  row: Object,

  column: {
    type: Object,
    required: true,
  },

  rowIndex: Number,

  rowKey: {
    required: true
  },

  columns: {
    type: [Object, Array],
  }
};

export default PlfTd;