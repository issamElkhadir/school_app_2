import { h } from 'vue';

const PlfTr = (props, { slots }) => {
  const renderSlot = () => {
    if (slots.default) {
      return slots.default({
        columns: props.columns,
        row: props.row,
        rowIndex: props.rowIndex,
      });
    }
  }

  return h('tr', renderSlot());
}


PlfTr.props = {
  columns: {
    type: [Array, Object],
    default: () => [],
    required: true,
  },

  row: {
    type: Object,
    required: true,
    rowIndex: Number
  }
};

export default PlfTr;