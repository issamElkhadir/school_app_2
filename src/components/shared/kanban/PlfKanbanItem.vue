<template>
  <div :class="{ border: bordered }"
       class="plf-kanban-item">
       <pre>{{ item }}</pre>
    <div class="d-flex flex-column w-full gap-2 p-2">
      <div class="plf-kanban-item-header align-items-center justify-content-between gap-2 d-flex">
        <h4 class="m-0 text-truncate">
          {{ item[nameColumn] }}
        </h4>

        <div class="plf-kanban-item-actions d-flex align-items-center gap-2">
          <RouterLink v-if="editable"
                      class="text-reset lh-1"
                      to="#">
            <PlfIcon name="mdi.IconEdit"
                     class="icon-sm cursor-pointer" />
          </RouterLink>

          <PlfIcon v-if="deletable"
                   name="mdi.IconTrash"
                   @click="onDeleteClicked"
                   class="icon-sm cursor-pointer text-danger" />
        </div>
      </div>

      <div v-if="item[descriptionColumn]"
           class="plf-kanban-item-body">
        <p class="plf-kanban-item-content m-0 text-muted">
          {{ item[descriptionColumn] }}
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import PlfIcon from '../icon/PlfIcon.vue';

const emit = defineEmits(['delete']);

const props = defineProps({
  item: {
    type: Object
  },

  value: {
    type: [Object, String, Number, Array, Boolean]
  },

  bordered: {
    type: Boolean,
  },

  editable: {
    type: Boolean,
  },

  deletable: {
    type: Boolean,
  },

  editLink: {
    type: Function
  },

  color: {
    type: String,
  },

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
});

const onDeleteClicked = () => {
  emit('delete', {
    value: props.value,
    id: props.item.id
  });
}

const color = computed(() => {
  if (props.color) return `${props.color}`;

  return null;
});

</script>

<style scoped>
.plf-kanban-item {
  display: flex;
  overflow: hidden;
  background-color: var(--tblr-white);
  border-radius: var(--tblr-border-radius);
  transition: all .1s;
}

body[data-bs-theme='dark'] .plf-kanban-item {
  background-color: var(--tblr-dark);
}

.plf-kanban-item:hover {
  border-color: var(--tblr-gray-400) !important;
}

.plf-kanban-item:before {
  content: '';
  display: block;
  width: 3px;
  background-color: v-bind(color);
  top: 0;
  bottom: 0;
  border-top-left-radius: var(--tblr-border-radius);
  border-bottom-left-radius: var(--tblr-border-radius);
}

.plf-kanban-item-footer {
  display: flex;
  border-bottom-left-radius: var(--tblr-border-radius);
  border-bottom-right-radius: var(--tblr-border-radius);
}

.plf-kanban-item-content {
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  /* number of lines to show */
  line-clamp: 2;
  -webkit-box-orient: vertical;
}</style>