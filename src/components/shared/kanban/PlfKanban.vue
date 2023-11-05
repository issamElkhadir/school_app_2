<template>
  <div class="d-flex gap-3">
    <PlfKanbanColumn style="min-width: 250px; width: 25%"
                     v-for="column in columns"
                     :key="`kanban-column-${column.id}`"
                     :status-column="statusColumn"
                     :description-column="descriptionColumn"
                     :name-column="nameColumn"
                     @delete="emit('delete', $event)"
                     :data="data[column.id] ?? []"
                     :legend="column.label"
                     :title="title"
                     :color="column.color"
                     :value="column.id"
                     :edit-link="editLink"
                     :editable="editable"
                     :deletable="deletable"
                     :square="square"
                     :load-more="loadMore"
                     :loading="loadings[column.id]">
      <template #item="props">
        <slot name="item"
              v-bind="props"></slot>
      </template>
    </PlfKanbanColumn>
  </div>
</template>

<script setup>
import PlfKanbanColumn from './PlfKanbanColumn.vue';
import 'dragula/dist/dragula.min.css';
import dragula from 'dragula/dist/dragula.min.js';
import { ref, provide } from 'vue';

const emit = defineEmits(['delete', 'ondrop']);

const props = defineProps({
  columns: {
    type: Array
  },

  data: {
    type: Object
  },

  editable: Boolean,

  deletable: Boolean,

  draggable: {
    type: Boolean,
    default: true,
  },

  editLink: Function,

  isDragging: Boolean,

  loadings: Object,

  statusColumn: {
    type: String,
    default: 'status'
  },

  nameColumn: {
    type: String,
    default: 'name',
  },

  descriptionColumn: {
    type: String,
    default: 'description'
  },

  loadMore: {
    type: Function,
    default: () => { }
  },

  square: Boolean,

  title: String,
});

const containers = ref({});

const drake = ref();

const init = () => {
  if (props.draggable) {
    drake.value = dragula({
      containers: [],
      isContainer: function () {
        // console.log('isContainer', el);
        return false; // only elements in drake.containers will be taken into account
      },
      moves: function (/* el, source */) {
        // const sourceColumn = Object.values(containers.value).find(e => e.container === source);

        // if (sourceColumn) {
        //   const { items } = sourceColumn;

        //   const recordIndex = items.findIndex(e => e.el === el);

        //   const item = items[recordIndex];

        //   if (item) {
        //     const { record } = item;

        //     return record.authorizedToUpdate;
        //   } else {
        //     return false;
        //   }
        // }

        // console.log('moves', el, source, handle, sibling);
        return Object.values(props.loadings).every(e => !e); // elements are always draggable by default
      },
      accepts: function () {
        // console.log('accepts', el, target, source, sibling);
        return true; // elements can be dropped in any of the `containers` by default
      },
      invalid: function () {
        // console.log('invalid', el, handle);
        return false; // don't prevent any drags from initiating by default
      },
      direction: 'vertical',              // Y axis is considered when determining where an element would be dropped
      copy: false,                        // elements are moved by default, not copied
      copySortSource: false,              // elements in copy-source containers can be reordered
      revertOnSpill: false,               // spilling will put the element back where it was dragged from, if this is true
      removeOnSpill: false,               // spilling will `.remove` the element, if this is true
      mirrorContainer: document.body,     // set the element that gets mirror elements appended
      ignoreInputTextSelection: true,     // allows users to select input text, see details below
      slideFactorX: 0,                    // allows users to select the amount of movement on the X axis before it is considered a drag instead of a click
      slideFactorY: 0,                    // allows users to select the amount of movement on the Y axis before it is considered a drag instead of a click
    }).on('drag', (el) => {
      el.style.transform = 'rotate(5deg)';
    }).on('dragend', (el) => {
      el.style.transform = null;
    }).on('drop', (el, target, source) => {

      const targetColumn = Object.values(containers.value).find(e => e.container === target);

      const sourceColumn = Object.values(containers.value).find(e => e.container === source);

      if (targetColumn && sourceColumn) {
        const { items } = sourceColumn;

        const recordIndex = items.findIndex(e => e.el === el);

        const item = items[recordIndex];

        items.splice(recordIndex, 1);

        const targetRecordIndex = targetColumn.items.findIndex(e => e.el === el);

        if (targetRecordIndex === -1) {
          targetColumn.items.push(item);
        }

        emit('ondrop', {
          destinationColumn: targetColumn.column,
          sourceColumn: sourceColumn.column,
          id: item.record.id
        });
      }
    });
  }
}

init();

const addContainer = ({ container, column, items }) => {
  if (!props.draggable) {
    return;
  }

  containers.value[column] = { container, items, column };
  drake.value.containers.push(container);
}

provide('addContainer', addContainer);
</script>

<style scoped>
:deep(.gu-transit) {
  transform: rotate(0) !important;
  border: 1px dashed var(--tblr-primary);
  background-color: rgba(var(--tblr-primary-rgb), .15);
  /* padding: 0 !important; */
  margin-bottom: var(--tblr-spacer-2) !important;
  /* margin: 10px; */
  border-radius: var(--tblr-border-radius);
  opacity: .5 !important;
}

:deep(.gu-transit *) {
  visibility: hidden;
}
</style>