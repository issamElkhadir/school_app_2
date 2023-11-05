<template>
  <div class="d-flex flex-column flex-md-row gap-3">
    <div class="d-flex flex-fill gap-2">
      <div class="d-flex flex-column justify-content-center gap-2">
        <PlfButton :square="square"
                   @click="onMoveSelectedToTop(0)"
                   class="btn-secondary btn-icon">
          <PlfIcon name="tblr.IconSortAscending2" />
        </PlfButton>
        <PlfButton :square="square"
                   @click="onMoveSelectedUp(0)"
                   class="btn-secondary btn-icon">
          <PlfIcon name="tblr.IconSortAscending" />
        </PlfButton>
        <PlfButton :square="square"
                   @click="onMoveSelectedDown(0)"
                   class="btn-secondary btn-icon">
          <PlfIcon name="tblr.IconSortDescending" />
        </PlfButton>
        <PlfButton :square="square"
                   @click="onMoveSelectedToBottom(0)"
                   class="btn-secondary btn-icon">
          <PlfIcon name="tblr.IconSortDescending2" />
        </PlfButton>
      </div>

      <div class="d-flex w-100 flex-column">
        <!-- Left PickList Header -->
        <div class="d-flex flex-column">
          <div :class="{ 'rounded-top': !square, 'bg-gray-200': true }"
               class=" border d-flex align-items-center justify-content-between p-3">
            <PlfCheckbox :binary="false"
                         :model-value="allSelected[0]"
                         @update:modelValue="onSelectAll(0)"
                         :label="titles[0]"
                         class="ps-0 flex-grow-1"
                         :square="square" />

            <div class="text-muted text-small">{{ internalSelection[0].length }} / {{ options[0].length }}</div>
          </div>

          <div v-if="filterable"
               class="p-2 border-x">
            <PlfInput v-model="firstSearch"
                      clearable
                      :square="square"
                      hide-label>
              <template #prepend>
                <PlfIcon name="tblr.IconSearch" />
              </template>
            </PlfInput>
          </div>
        </div>

        <PlfList :square="true"
                 :items="filteredOptions[0]">
          <TransitionGroup ref="firstListRef"
                           tag="div"
                           name="fade"
                           class="border border-top-0 p-2 items-container"
                           @drop="onDrop(0)"
                           @dragover.prevent
                           @dragleave.prevent
                           @dragenter.prevent
                           tabindex="-1"
                           style="overflow: auto"
                           :style="{ height: toUnit(height) }">

            <div class="option-item"
                 ref="leftOptionsRef"
                 :value="e[optionValue]"
                 @click.prevent="onItemClicked($event, 0, e)"
                 :draggable="selectedValues[0].length < 2 && !e.disabled"
                 @dragstart="onDragStart(0, e)"
                 :disabled="e.disabled"
                 @keypress.space.prevent="onItemChecked($event, 0, e)"
                 :class="{ 'disabled': e.disabled, 'selected': selectedValues[0].includes(e[optionValue]) }"
                 :tabindex="e.disabled ? -1 : 0"
                 v-for="e in filteredOptions[0]"
                 :key="`left-option-${e[optionValue]}`">

              <slot :option="e"
                    name="option">
                <PlfListItem :square="square">
                  <template #prepend>
                    <PlfCheckbox :tab-index="-1"
                                 :disabled="e.disabled"
                                 @click.stop
                                 @click.prevent="onItemChecked($event, 0, e)"
                                 :model-value="selectedValues[0]"
                                 :value="e[optionValue]"
                                 class="ps-0"
                                 :square="square" />
                  </template>

                  <template #default>
                    {{ e[optionLabel] }}
                  </template>
                </PlfListItem>
              </slot>
            </div>
          </TransitionGroup>
        </PlfList>

        <!-- Left PickList Footer -->
        <div v-if="'left-footer' in $slots"
             class="border border-top-0 rounded-bottom">
          <slot name="left-footer"></slot>
        </div>
      </div>
    </div>

    <div class="d-flex flex-column justify-content-center gap-2">
      <PlfButton :square="square"
                 @click="onMoveSelectedToRight"
                 class="btn-primary btn-icon">
        <PlfIcon name="tblr.IconChevronRight" />
      </PlfButton>
      <PlfButton :square="square"
                 @click="onMoveAllToRight"
                 class="btn-primary btn-icon">
        <PlfIcon name="tblr.IconChevronsRight" />
      </PlfButton>

      <PlfButton :square="square"
                 @click="onMoveSelectedToLeft"
                 class="btn-primary btn-icon">
        <PlfIcon name="tblr.IconChevronLeft" />
      </PlfButton>
      <PlfButton :square="square"
                 @click="onMoveAllToLeft"
                 class="btn-primary btn-icon">
        <PlfIcon name="tblr.IconChevronsLeft" />
      </PlfButton>
    </div>

    <div class="d-flex flex-fill gap-2">
      <div class="d-flex w-100 flex-column">
        <!-- Right PickList Header -->
        <div class="d-flex flex-column">
          <div :class="{ 'rounded-top': !square, 'bg-gray-200': true }"
               class="d-flex border align-items-center justify-content-between p-3">
            <PlfCheckbox :binary="false"
                         :model-value="allSelected[1]"
                         @update:modelValue="onSelectAll(1)"
                         :label="titles[1]"
                         class="ps-0 flex-grow-1"
                         :square="square" />

            <div class="text-muted text-small">{{ internalSelection[1].length }} / {{ options[1].length }}</div>
          </div>

          <div v-if="filterable"
               class="p-2 border-x">
            <PlfInput v-model="secondSearch"
                      clearable
                      :square="square"
                      hide-label>
              <template #prepend>
                <PlfIcon name="tblr.IconSearch" />
              </template>
            </PlfInput>
          </div>
        </div>

        <PlfList :items="filteredOptions[1]">
          <TransitionGroup ref="secondListRef"
                           tag="div"
                           name="fade"
                           class="border border-top-0 p-2 items-container"
                           @drop="onDrop(1)"
                           @dragover.prevent
                           @dragleave.prevent
                           @dragenter.prevent
                           tabindex="-1"
                           style="overflow: auto"
                           :style="{ height: toUnit(height) }">

            <div class="option-item"
                 ref="rightOptionsRef"
                 :value="e[optionValue]"
                 @click.prevent="onItemClicked($event, 1, e)"
                 :draggable="selectedValues[1].length < 2 && !e.disabled"
                 @dragstart="onDragStart(1, e)"
                 :disabled="e.disabled"
                 @keypress.space.prevent="onItemChecked($event, 1, e)"
                 :class="{ 'disabled': e.disabled, 'selected': selectedValues[1].includes(e[optionValue]) }"
                 :tabindex="e.disabled ? -1 : 0"
                 v-for="e in filteredOptions[1]"
                 :key="`right-option-${e[optionValue]}`">

              <slot :option="e"
                    name="option">
                <PlfListItem :square="square">
                  <template #prepend>
                    <PlfCheckbox :tab-index="-1"
                                 :disabled="e.disabled"
                                 @click.stop
                                 @click.prevent="onItemChecked($event, 1, e)"
                                 :model-value="selectedValues[1]"
                                 :value="e[optionValue]"
                                 class="ps-0"
                                 :square="square" />
                  </template>

                  <template #default>
                    {{ e[optionLabel] }}
                  </template>
                </PlfListItem>
              </slot>
            </div>
          </TransitionGroup>
        </PlfList>

        <!-- Right PickList Footer -->
        <div v-if="'right-footer' in $slots"
             class="border border-top-0 rounded-bottom">
          <slot name="right-footer"></slot>
        </div>
      </div>

      <div class="d-flex flex-column justify-content-center gap-2">
        <PlfButton :square="square"
                   @click="onMoveSelectedToTop(1)"
                   class="btn-secondary btn-icon">
          <PlfIcon name="tblr.IconSortAscending2" />
        </PlfButton>
        <PlfButton :square="square"
                   @click="onMoveSelectedUp(1)"
                   class="btn-secondary btn-icon">
          <PlfIcon name="tblr.IconSortAscending" />
        </PlfButton>
        <PlfButton :square="square"
                   @click="onMoveSelectedDown(1)"
                   class="btn-secondary btn-icon">
          <PlfIcon name="tblr.IconSortDescending" />
        </PlfButton>
        <PlfButton :square="square"
                   @click="onMoveSelectedToBottom(1)"
                   class="btn-secondary btn-icon">
          <PlfIcon name="tblr.IconSortDescending2" />
        </PlfButton>
      </div>
    </div>
  </div>
</template>

<script setup>
import { isEqual } from 'lodash';
import { watch, ref, computed } from 'vue';
// import { useDark } from '../../../composables/ui/useDark';
import PlfButton from '../button/PlfButton.vue';
import PlfCheckbox from '../checkbox/PlfCheckbox.vue';
import PlfInput from '../input/PlfInput.vue';
import PlfIcon from '../icon/PlfIcon.vue';
import PlfList from '../list/PlfList.vue';
import PlfListItem from '../list/PlfListItem.vue';

const emit = defineEmits(['update:modelValue', 'update:selection', 'update:reorder']);

const props = defineProps({
  modelValue: {
    type: Array,
  },

  selection: {
    type: Array
  },

  optionLabel: {
    type: String,
    default: 'name'
  },

  optionValue: {
    type: String,
    default: 'id'
  },

  data: {
    type: Array,
  },

  emitValue: {
    type: Boolean,
    default: false,
  },

  filterable: {
    type: Boolean,
    default: true,
  },

  filterFn: {
    type: Function,
  },

  height: {
    type: [Number, String],
    default: '300px',
  },

  width: {
    type: [Number, String],
    default: '400px',
  },

  square: {
    type: Boolean,
    default: false,
  },

  titles: {
    type: Array,
    default: () => ['List 1', 'List 2']
  },

  selectionStrategy: {
    type: String,
    default: 'multiple',
    validator: (value) => ['multiple', 'single'].includes(value),
  },
});

const firstSearch = ref('');
const secondSearch = ref('');

// const { isActive: isDarkModeActive } = useDark();

const internalSelection = ref([[], []]);

const options = ref([[], []]);

const filteredOptions = computed(() => {
  let filterFn = props.filterFn;

  if (!filterFn) {
    filterFn = (search, option) => {
      return option[props.optionLabel].toLowerCase().includes(search.toLowerCase());
    };
  }

  return [
    options.value[0].filter((option) => filterFn(firstSearch.value, option)),
    options.value[1].filter((option) => filterFn(secondSearch.value, option)),
  ];
});

const enabledOptions = computed(() => {
  return [
    options.value[0].filter(o => !o.disabled),
    options.value[1].filter(o => !o.disabled),
  ]
});

const enabledOptionsValues = computed(() => {
  return [
    enabledOptions.value[0].map(o => o[props.optionValue]),
    enabledOptions.value[1].map(o => o[props.optionValue]),
  ]
});

const firstListRef = ref();
const secondListRef = ref();

const leftOptionsRef = ref([]);
const rightOptionsRef = ref([]);

watch([() => props.data, () => props.modelValue], ([val, modelValue]) => {
  let leftOptions = [];
  let rightOptions = [];

  if (val) {

    if (props.emitValue) {
      if (modelValue?.length > 0) {
        leftOptions = val.filter(item => {
          return !modelValue.includes(item[props.optionValue]);
        });

        rightOptions = val.filter(item => {
          return !leftOptions.includes(item);
        });
      } else {
        leftOptions = val;
      }
    } else {
      if (modelValue?.length > 0) {
        rightOptions = modelValue;

        const values = rightOptions.map(item => item[props.optionValue]);

        leftOptions = val.filter(e => !values.includes(e[props.optionValue]));
      } else {
        leftOptions = val;
      }
    }
  }

  options.value = [
    leftOptions,
    rightOptions,
  ];
}, { deep: true, immediate: true });

const optionsValues = computed(() => {
  const leftOptions = [];
  const rightOptions = [];

  if (props.emitValue && props.modelValue?.length > 0) {
    const items = props.data.filter(item => {
      return !props.modelValue.includes(item[props.optionValue]);
    });

    leftOptions.push(...items);

    rightOptions.push(...props.data.filter(item => {
      return !items.includes(item);
    }));
  } else {
    leftOptions.push(...props.data);
  }

  return [
    leftOptions.map(option => option[props.optionValue]),
    rightOptions.map(option => option[props.optionValue]),
  ];
});

const selectedValues = computed(() => {
  return [
    internalSelection.value[0].map(e => e[props.optionValue]),
    internalSelection.value[1].map(e => e[props.optionValue]),
  ];
});

const allSelected = computed(() => {

  return [
    enabledOptions.value[0].length > 0 && selectedValues.value[0].length === enabledOptions.value[0].length ? true : selectedValues.value[0].length > 0 ? null : false,
    enabledOptions.value[1].length > 0 && selectedValues.value[1].length === enabledOptions.value[1].length ? true : selectedValues.value[1].length > 0 ? null : false,
  ]
})

watch(() => props.selection, (val) => {
  if (isEqual(val, internalSelection.value)) return;

  if (val && Array.isArray(val) && val.length === 2 && val.every(e => Array.isArray(e))) {
    internalSelection.value = val;
  } else {
    internalSelection.value = [[], []];
  }
}, { deep: true, immediate: true });

watch(internalSelection, (val) => {
  // if (props.selectionStrategy === 'single') {
  //   val = val.map(e => e[0]);
  // }

  // console.log({ val: val, selection: props.selection });

  // if (isEqual(props.selection, val)) return;

  // console.log('internalSelection', val);

  // emit('update:selection', val);
}, { deep: true });

const onSelectAll = (index) => {
  if ([false, null].includes(allSelected.value[index])) {
    internalSelection.value[index] = options.value[index].filter(e => !e.disabled);
  } else {
    internalSelection.value[index] = [];
  }
}

const onItemDoubleClicked = (listIndex, e) => {
  let newValue;

  if (listIndex === 0) {
    newValue = props.modelValue ?? [];

    if (props.emitValue) {
      newValue = newValue.concat(e[props.optionValue]);
    } else {
      newValue = newValue.concat(e);
    }
  } else {
    newValue = props.modelValue.filter(item => {
      return item !== (props.emitValue ? e[props.optionValue] : e);
    });
  }

  internalSelection.value[listIndex] = [];

  emit('update:modelValue', newValue);
}

const onItemChecked = (event, index, e) => {
  if (e.disabled) return;

  const itemIndex = internalSelection.value[index].findIndex(item => item[props.optionValue] === e[props.optionValue]);

  // Double click event
  if (event.detail === 2) {
    onItemDoubleClicked(index, e);
  } else {
    if (itemIndex < 0) {
      internalSelection.value[index].push(e);
    } else {
      internalSelection.value[index].splice(itemIndex, 1);
    }
  }
}

const onItemClicked = (event, index, e) => {
  if (e.disabled) return;

  const itemIndex = internalSelection.value[index].findIndex(item => item[props.optionValue] === e[props.optionValue]);

  // Double click event
  if (event.detail === 2) {
    onItemDoubleClicked(index, e);
  } else {
    if (itemIndex < 0) {
      if (event.ctrlKey) {
        internalSelection.value[index].push(e);
      } else {
        internalSelection.value[index] = [e];
      }
    } else if (!event.ctrlKey) {
      internalSelection.value[index] = [e];
    } else {
      internalSelection.value[index].splice(itemIndex, 1);
    }
  }
}

const moveItemsToLeft = (items) => {
  const value = props.modelValue.filter(e => {
    return !items.includes(e);
  });

  emit('update:modelValue', value);

  internalSelection.value[1] = [];
}

const moveItemsToRight = (items) => {
  const modelValue = props.modelValue ?? [];

  emit('update:modelValue', modelValue.concat(items));

  internalSelection.value[0] = [];
}

const moveItemsToTop = (index, items) => {
  options.value[index] = options.value[index].filter(option => {
    return items.findIndex(item => {
      return item[props.optionValue] === option[props.optionValue];
    }) === -1;
  });

  options.value[index] = items.concat(options.value[index]);

  const listToScroll = index === 0 ? leftOptionsRef.value : rightOptionsRef.value;

  listToScroll[0].scrollIntoView({
    behavior: 'smooth',
    block: 'start'
  });
}

const moveItemsToBottom = (index, items) => {
  options.value[index] = options.value[index].filter(option => {
    return items.findIndex(item => {
      return item[props.optionValue] === option[props.optionValue];
    }) === -1;
  });

  options.value[index].push(...items);

  const listToScroll = index === 0 ? leftOptionsRef.value : rightOptionsRef.value;

  listToScroll[listToScroll.length - 1].scrollIntoView({
    behavior: 'smooth',
    block: 'end'
  });
}

const moveItemUp = (index, item) => {
  const itemIndex = options.value[index].findIndex(option => {
    return item[props.optionValue] === option[props.optionValue];
  });

  if (itemIndex > 0) {
    options.value[index].splice(itemIndex, 1);
    options.value[index].splice(itemIndex - 1, 0, item);

    const listToScroll = index === 0 ? leftOptionsRef.value : rightOptionsRef.value;

    listToScroll[itemIndex - 1].scrollIntoView({
      behavior: 'smooth',
      block: 'nearest'
    });
  }
}

const moveItemDown = (index, item) => {
  const itemIndex = options.value[index].findIndex(option => {
    return item[props.optionValue] === option[props.optionValue];
  });

  if (itemIndex > -1 && itemIndex < options.value[index].length - 1) {
    options.value[index].splice(itemIndex, 1);
    options.value[index].splice(itemIndex + 1, 0, item);

    const listToScroll = index === 0 ? leftOptionsRef.value : rightOptionsRef.value;

    listToScroll[itemIndex + 1].scrollIntoView({
      behavior: 'smooth',
      block: 'nearest'
    });
  }
}

const onMoveSelectedToTop = (index) => {
  moveItemsToTop(index, internalSelection.value[index]);
}

const onMoveSelectedToBottom = (index) => {
  moveItemsToBottom(index, internalSelection.value[index]);
}

const onMoveSelectedToRight = () => {
  moveItemsToRight(props.emitValue ? selectedValues.value[0] : internalSelection.value[0]);
}

const onMoveSelectedToLeft = () => {
  moveItemsToLeft(props.emitValue ? selectedValues.value[1] : internalSelection.value[1]);
}

const onMoveSelectedUp = (index) => {
  if (internalSelection.value[index].length === 1) {
    moveItemUp(index, internalSelection.value[index][0]);
  }
}

const onMoveSelectedDown = (index) => {
  if (internalSelection.value[index].length === 1) {
    moveItemDown(index, internalSelection.value[index][0]);
  }
}

const onMoveAllToLeft = () => {
  emit('update:modelValue', optionsValues.value[1].filter(o => options.value[1].find(i => i[props.optionValue] === o).disabled));

  internalSelection.value[1] = [];
}

const onMoveAllToRight = () => {
  const value = props.modelValue ?? [];

  if (props.emitValue) {
    emit('update:modelValue', value.concat(enabledOptionsValues.value[0]));
  } else {
    emit('update:modelValue', value.concat(enabledOptions.value[0]));
  }

  internalSelection.value[0] = [];
}

let currentDraggingItem;
let currentDraggingList;

const onDragStart = (list, item) => {
  if (item.disabled) return;

  currentDraggingItem = item;
  currentDraggingList = list;
}

const onDrop = (list) => {
  if (list === currentDraggingList) return;

  const value = currentDraggingItem[props.optionValue];

  if (list === 1) {
    moveItemsToRight([value]);
  } else {
    moveItemsToLeft([value]);
  }

  currentDraggingItem = null;
  currentDraggingList = null;
}

const toUnit = (value, unit = 'px') => {
  if (typeof value === 'number') return `${value}${unit}`;

  if (typeof value === 'string' && value.includes('%')) return value;

  return `${parseInt(value)}${unit}`;
}
</script>

<style scoped>
.option-item {
  outline: none;
  cursor: pointer;
  transition: all .1s;
  border: 1px solid transparent;
  user-select: none;
  opacity: 1 !important;
}

.option-item:focus:not(.disabled) {
  border-color: rgba(var(--tblr-primary-rgb), .5);
  /* color: var(--tblr-primary); */
}

.option-item.selected {
  background-color: rgba(var(--tblr-primary-rgb), .16);
  color: var(--tblr-primary);
}

.option-item.disabled {
  color: rgba(var(--tblr-dark-rgb), .3);
  cursor: not-allowed
}


.items-container {
  position: relative;
}

/* 1. declare transition */
.fade-move,
.fade-enter-active

/* .fade-leave-active */
  {
  transition: all 0.5s cubic-bezier(0.55, 0, 0.1, 1);
}

/* 2. declare enter from and leave to state */
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: scaleY(0.01) translate(30px, 0);
}

/* 3. ensure leaving items are taken out of layout flow so that moving
      animations can be calculated correctly. */
.fade-leave-active {
  /* position: absolute; */
}
</style>