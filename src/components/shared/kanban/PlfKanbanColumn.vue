<template>
  <div ref="columnRef"
       class="plf-kanban-column">

    <div class="mb-1 mx-2">
      <div class="kanban-column-header"
           :class="{ 'rounded': !square }">
        <span :style="{ color }">
          <span class="badge me-1"
                :style="{ backgroundColor: color }">
          </span>
          {{ legend }}
        </span>

        <span class="ms-auto text-secondary bg-gray-500 p-1"
              :class="{ 'rounded': !square }">
          {{ data.pagination?.total }} {{ title }}
        </span>
      </div>
    </div>

    <div class="position-relative h-100 pb-2 overflow-hidden">
      <div @scroll="onScroll"
           class="overflow-auto h-100 flex-fill d-flex flex-column">
        <PlfList ref="dragContainer"
                 class="flex-fill mx-2 gap-2">

          <PlfListItem :ref="el => addDraggableItem(el, item)"
                       class="cursor-move p-0"
                       v-for="item in data.data"
                       :key="`item-${value}-${item.id}`"
                       :content-classes="{ 'kanban-column-item-content': true, 'w-full': true, 'rounded': !square }">
            <slot name="item"
                  :item="item"
                  :status-column="statusColumn"
                  :description-column="descriptionColumn"
                  :name-column="nameColumn"
                  :edit-link="editLink"
                  @delete="emit('delete', $event)"
                  :color="color">
              <PlfKanbanItem :color="color"
                             @delete="emit('delete', $event)"
                             :value="value"
                             :editable="editable"
                             :deletable="deletable"
                             :status-column="statusColumn"
                             :description-column="descriptionColumn"
                             :name-column="nameColumn"
                             :edit-link="editLink"
                             bordered
                             :item="item" />
            </slot>
          </PlfListItem>
        </PlfList>
      </div>

      <PlfLoading v-if="loading" />
    </div>
  </div>
</template>

<script setup>
import { ref, inject, onMounted, computed, nextTick } from 'vue';
import PlfKanbanItem from './PlfKanbanItem.vue';
import PlfList from '../list/PlfList.vue';
import PlfListItem from '../list/PlfListItem.vue';
import PlfLoading from '../loading/PlfLoading.vue';


const emit = defineEmits(['delete']);

const props = defineProps({
  title: String,
  
  legend: String,

  color: String,

  value: [String, Boolean, Number, Object, Array],

  data: {
    type: Object
  },

  editable: Boolean,

  deletable: Boolean,

  editLink: Function,

  isDragging: Boolean,

  loading: Boolean,

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

  square: Boolean
});

const columnRef = ref();
const dragContainer = ref();
const draggableElements = ref([]);

const addContainer = inject('addContainer');

onMounted(() => {

  addContainer({
    container: dragContainer.value.$el,
    column: props.value,
    items: draggableElements.value
  });
});

const addDraggableItem = (el, record) => {
  if (el) {
    draggableElements.value.push({ el: el.$el, record });
  }
}

const color = computed(() => `var(--tblr-${props.color ?? 'secondary'})`);

const onScroll = async (evt) => {
  if (props.loading || props.data.pagination?.to >= props.data.pagination?.total) {
    return;
  }

  const { scrollTop, scrollHeight, clientHeight } = evt.target;

  if (scrollTop + clientHeight >= scrollHeight) {
    await props.loadMore({ column: props.value });

    await nextTick(() => {
      const { scrollHeight } = evt.target;

      evt.target.scrollTo({
        top: scrollHeight - clientHeight
      });
    });
  }
}
</script>

<style scoped>
.plf-kanban-column {
  background-color: var(--tblr-gray-100);
  overflow: hidden;
  display: flex;
  border-radius: var(--tblr-border-radius);
  flex-direction: column;
}

[data-bs-theme='dark'] .plf-kanban-column {
  background-color: rgba(var(--tblr-gray-700-rgb), .5);
}

.plf-kanban-column .kanban-column-header {
  display: flex;
  align-items: center;
  padding: var(--tblr-spacer-2);
  font-weight: 600;
  margin-block: var(--tblr-spacer-2);
  box-shadow: var(--tblr-box-shadow-sm);
  background-color: var(--tblr-white);
}

[data-bs-theme='dark'] .plf-kanban-column .kanban-column-header {
  background-color: var(--tblr-dark);
}

.kanban-column-item-content {
  background-color: var(--tblr-white);
}

[data-bs-theme='dark'] .kanban-column-item-content {
  background-color: var(--tblr-dark);
}
</style>