<script>
import { computed, toRef, withDirectives, h, inject, isVNode, vShow, onMounted, getCurrentInstance, reactive } from 'vue';

import ExpandTransition from '../transition/PlfExpandTransition.vue';
import useList from './useList';

export default {

  name: 'PlfListGroup',

  props: {
    appendIcon: {
      type: String,
    },

    collapseIcon: {
      type: String,
      default: 'mdi.IconChevronUp'
    },

    expandIcon: {
      type: String,
      default: 'mdi.IconChevronDown'
    },

    prependIcon: {
      type: String,
    },

    title: {
      type: String
    },

    value: {
      type: [String, Number]
    },

    width: {
      type: [String, Number]
    },

    maxWidth: {
      type: [String, Number]
    },

    minWidth: {
      type: [String, Number]
    },

    height: {
      type: [String, Number]
    },

    maxHeight: {
      type: [String, Number]
    },

    minHeight: {
      type: [String, Number]
    },

    activeColor: {
      type: String,
      default: 'primary'
    },
  },

  setup(props, { slots }) {

    const instance = getCurrentInstance();

    const {/* parentList, */ valuePath } = useList(instance, toRef(props, 'value'));

    const rootList = inject('rootList');

    const item = reactive({
      value: props.value,
      valuePath,
      // active,
    });

    onMounted(() => {
      rootList.addListGroup(item);
    });

    const expanded = computed(() => {
      return rootList.openedGroups.includes(props.value);
    });

    const currentAppendIcon = computed(() => {
      if (props.appendIcon) return props.appendIcon;

      if (expanded.value) return props.collapseIcon;

      return props.expandIcon;
    });

    const isListItem = (item) => {
      if (isVNode(item)) {
        return item.type.name === 'PlfListItem';
      }

      return item.type === 'item';
    }

    const isListGroup = (item) => {
      if (isVNode(item)) {
        return item.type.name === 'PlfListGroup';
      }

      return item.type === 'group';
    }

    const renderElement = (el) => {
      if (isListItem(el)) {
        return h(el, {
          nav: rootList.props.nav,
          onClick: (evt) => {
            rootList.onItemClicked(evt, el.props);
          },

          class: {
            opened: expanded.value
          },

          active: rootList.internalSelected.includes(el.props.value)
        });
      } else if (isListGroup(el)) {
        return h(el, {
          ...(el.props ?? {}),
          nav: rootList.props.nav,
        });
      } else if (Array.isArray(el)) {
        return el.map(renderElement);
      } else if (Array.isArray(el.children)) {
        return el.children.map(renderElement);
      }

      return h(el);
    }

    return () => h('div', {
      class: [
        'plf-list-group',
        {
          opened: expanded.value
        }
      ],
    }, [
      slots.toggler({
        onItemClick: () => {
          if (expanded.value) {
            rootList.close(props.value, valuePath.value);
          } else {
            rootList.open(props.value, valuePath.value);
          }
        },

        nav: rootList.props.nav,
        activeColor: props.activeColor,
        title: props.title,
        value: props.value,
        appendIcon: currentAppendIcon.value,
        prependIcon: props.prependIcon,
        minHeight: props.minHeight,
        height: props.height,
        maxHeight: props.maxHeight,
        minWidth: props.minWidth,
        width: props.width,
        maxWidth: props.maxWidth,
      }),

      h(ExpandTransition, () => withDirectives(h('div', {
        class: {
          'plf-list-group-items': true,
          opened: expanded.value,
        }
      }, renderElement(slots.default())),
        [
          [vShow, expanded.value]
        ]))
    ]);
  }
}
</script>

<style scoped>
.plf-list-group {
  display: flex;
  flex-direction: column;
}

/* .plf-list-group.opened >>> > .plf-list-item {
  color: var(v-bind('props?.color')) !important;
} */

.plf-list-group-items :deep(.plf-list-item) {
  padding-inline-start: calc(16px + var(--indent-padding)) !important;
}
</style>

<style>
.plf-list-group {
  --parent-padding: var(--indent-padding);
  --prepend-width: 20px;
  --list-indent-size: 16px;
}

.plf-list-group-items {
  --indent-padding: calc(var(--parent-padding) + var(--list-indent-size));
}
</style>
