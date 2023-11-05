<script>
import { ref, computed, watch, Comment, h, isVNode, provide, reactive } from 'vue';
import PlfListItem from './PlfListItem.vue';
import PlfListSubheader from './PlfListSubheader.vue';
import { toUnit } from '../../../composables/utils';
import { isEqual } from 'lodash';
import PlfDivider from '../divider/PlfDivider.vue';

export default {
  name: 'PlfList',

  emits: ['update:selected', 'update:opened'],

  props: {
    items: {
      type: Array,
    },

    bordered: {
      type: Boolean,
      default: false,
    },

    disabled: {
      type: Boolean,
      default: false
    },

    height: {
      type: [String, Number]
    },

    width: {
      type: [String, Number]
    },

    maxHeight: {
      type: [String, Number]
    },

    maxWidth: {
      type: [String, Number]
    },

    minHeight: {
      type: [String, Number]
    },

    minWidth: {
      type: [String, Number]
    },

    nav: {
      type: Boolean,
      default: false
    },

    opened: {
      type: Array
    },

    openStrategy: {
      type: String,
      default: 'list',
      validator: val => ['single', 'multiple', 'list'].includes(val)
    },

    square: {
      type: Boolean,
    },

    selected: {
      type: [Array, String, Number, Object],
      default: () => []
    },

    selectStrategy: {
      type: String,
      default: 'single',
      validator: (val) => ['single', 'multiple'].includes(val)
    },

    mandatory: {
      type: Boolean,
      default: false,
    },

    itemTitle: {
      type: String,
      default: 'name',
    },

    itemValue: {
      type: String,
      default: 'value',
    }
  },

  setup(props, { slots, emit }) {
    const internalSelected = ref([]);

    const openedGroups = ref([]);

    const open = (value, valuePath) => {
      if (openedGroups.value.includes(value)) return;

      // collapse all groups that are not under current group
      if (props.openStrategy === 'single') {
        openedGroups.value = openedGroups.value.filter(value => valuePath.includes(value));
      }
      openedGroups.value.push(value);
    }

    const close = (value) => {
      const i = openedGroups.value.indexOf(value);
      if (i !== -1) {
        openedGroups.value.splice(i, 1);
      }
    }

    const subgroups = ref({});

    const addListGroup = (group) => {
      subgroups.value[group.value] = group;
    }

    watch(() => props.opened, (val) => {
      if (isEqual(openedGroups.value, val)) return;

      if (val && !Array.isArray(val)) {
        val = [val];
      } else if (!val) {
        val = [];
      }

      openedGroups.value = val;
    }, { deep: true, immediate: true });

    watch(openedGroups, val => {
      emit('update:opened', val);
    }, { deep: true });

    watch(() => props.selected, val => {
      let internalValue = internalSelected.value;

      if (props.selectStrategy === 'single') {
        internalValue = internalValue[0];
      }

      if (isEqual(val, internalValue)) return;

      if (!Array.isArray(val)) {
        if (val) {
          val = [val];
        } else {
          val = [];
        }
      }

      internalSelected.value = val;

    }, { immediate: true, deep: true });

    watch(internalSelected, val => {
      if (props.selectStrategy === 'single') {
        val = val[0] || null;
      }

      emit('update:selected', val);
    }, { deep: true });

    const generateListItems = () => {

      if (slots.default && slots.default().some(e => e.type !== Comment)) {
        const children = [];

        slots.default({
          selected: internalSelected.value
        }).forEach(function renderListElement(child) {
          if (isListItem(child)) {
            children.push(h(child, {
              nav: props.nav,
              title: child.props?.title,
              value: child.props?.value,
              ...(child.props ?? {}),
              active: ['', true].includes(child.props?.active) || internalSelected.value.includes(child.props?.value),
              onClick: evt => onItemClicked(evt, child.props),
            }));
          } else if (isSubheader(child)) {
            children.push(child);
          } else if (isListGroup(child)) {
            children.push(h(child));
          } else if (Array.isArray(child.children) && child.children.length > 0) {
            child.children.forEach(renderListElement);
          } else {
            children.push(h(child));
          }
        });

        return children;
      } else if (slots.item) {
        return props.items.map(item => {
          if (item.type === 'subheader') {
            return h(PlfListSubheader, {
              title: item[props.itemTitle],
            });
          } else if (item.type === 'divider') {
            return h(PlfDivider, item.props);
          } else if (isListItem(item)) {

            const itemProps = {
              ...item,
              nav: props.nav,
              title: item[props.itemTitle],
              value: item[props.itemValue],
              active: internalSelected.value.includes(item[props.itemValue]),
              onClick: evt => onItemClicked(evt, { disabled: item.disabled, value: item[props.itemValue] }),
            };

            return slots.item(h(item, itemProps));
          } else {
            return h(item);
          }
        });
      }

      if (Array.isArray(props.items)) {
        return props.items.map((item) => {
          if (item.type === 'subheader') {
            return h(PlfListSubheader, {
              title: item[props.itemTitle]
            });
          } else if (item.type === 'divider') {
            return h(PlfDivider, item.props);
          }

          const onClick = item.props.onClick;

          item = {
            ...item.props,
            title: item[props.itemTitle],
            value: item[props.itemValue],
            nav: props.nav === true || item.nav === true,
            active: internalSelected.value.includes(item[props.itemValue]),
            onClick: evt => onItemClicked(evt, {...item, onClick}),
          }

          return h(PlfListItem, item);
        });
      }

      return [];
    }

    const onItemClicked = (evt, item) => {
      const { value, disabled } = item;

      if (disabled === true) return;

      if (value) {

        if (props.selectStrategy === 'single') {
          if (internalSelected.value.includes(value) && !props.mandatory) {
            internalSelected.value = [];
          } else {
            internalSelected.value = [value];
          }

        } else {
          const index = internalSelected.value.indexOf(value);
          if (index > -1) {
            if (!props.mandatory || internalSelected.value.length > 1) {
              internalSelected.value.splice(index, 1);
            }
          } else {
            internalSelected.value.push(value);
          }
        }
      }
    }

    const isSubheader = (item) => {
      if (isVNode(item)) {
        return item.type.name === 'PlfListSubheader';
      }

      return item.type === 'subheader';
    };

    const isListItem = (item) => {
      if (isVNode(item)) {
        return item.type.name === 'PlfListItem';
      }

      return !isSubheader(item);
    };

    const isListGroup = (item) => {
      if (isVNode(item)) {
        return item.type.name === 'PlfListGroup';
      }

      return !(isListItem(item) || isSubheader(item));
    };

    const bindingProps = computed(() => {
      return {
        class: {
          bordered: props.bordered,
          'plf-list-nav': props.nav,
          'plf-list': true,
          'square': props.square === true || props.nav !== true,
        },

        style: {
          width: toUnit(props.width),
          minWidth: toUnit(props.minWidth),
          maxWidth: toUnit(props.maxWidth),

          height: toUnit(props.height),
          minHeight: toUnit(props.minHeight),
          maxHeight: toUnit(props.maxHeight),
        }
      }
    });

    provide('rootList', reactive({
      open,
      close,
      openedGroups,
      props,
      addListGroup,
      onItemClicked,
      internalSelected,
    }));

    return () => {
      return h('div', bindingProps.value, generateListItems());
    };
  }
}

</script>

<style scoped>
.plf-list {
  display: flex;
  flex-direction: column;

  border-bottom-left-radius: var(--tblr-border-radius);
  border-bottom-right-radius: var(--tblr-border-radius);
}

.plf-list:not(.square) {
  border-radius: var(--tblr-border-radius);
}

.plf-list.bordered {
  border: 1px solid var(--tblr-gray-400);
}

:deep(.plf-list:not(.square) .plf-list-item:last-child) {
  border-bottom-left-radius: var(--tblr-border-radius);
  border-bottom-right-radius: var(--tblr-border-radius);
}

:deep(.plf-list:not(.square) .plf-list-item:first-child) {
  border-top-left-radius: var(--tblr-border-radius);
  border-top-right-radius: var(--tblr-border-radius);
}

.plf-list.plf-list-nav {
  padding: 10px;
  padding-top: 5px;
}
</style>

<style>
.plf-list {
  --indent-padding: 0px;
}
</style>
