<script>
import { computed, h } from 'vue';
import { RouterLink, useRoute } from 'vue-router';
import PlfIcon from '../icon/PlfIcon.vue';
import { toUnit } from '../../../composables/utils';

export default {
  name: 'PlfListItem',
  emits: ['itemClick'],
  props: {
    prependIcon: {
      type: String
    },

    bordered: {
      type: Boolean,
      default: false,
    },

    appendIcon: {
      type: String
    },

    prependAvatar: {
      type: String,
    },

    appendAvatar: {
      type: String,
    },

    subtitle: {
      type: String,
    },

    title: {
      type: String,
    },

    to: {
      type: [Object, String]
    },

    value: {
      type: [String, Number, Object]
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

    replace: {
      type: Boolean,
      default: false,
    },

    active: {
      type: Boolean,
      default: false,
    },

    disabled: {
      type: Boolean,
      default: false,
    },

    square: {
      type: Boolean,
    },

    nav: {
      type: Boolean,
      default: false,
    },

    tabindex: {
      type: [String, Number],
    },

    activeColor: {
      type: String,
      default: 'primary'
    },

    activeBgColor: {
      type: String,
      default: 'primary'
    },

    rounded: {
      type: [String, Boolean, Number],
      validator: val => {
        if (typeof val === 'boolean') {
          return true;
        }

        if (typeof val === 'number') {
          return val >= 0 && val <= 6;
        }

        return ['1', '2', '3', '4', '5', '6', 'pill'].includes(val)
      }
    },

    contentClasses: {
      type: [String, Object, Array]
    }
  },

  setup(props, { emit, slots }) {
    const route = useRoute();

    const colors = computed(() => {
      const vars = {};

      if (props.activeBgColor) {
        vars['--plf-list-item-bg-color'] = `var(--tblr-${props.activeBgColor}-rgb)`
      }

      if (props.activeColor) {
        vars['--plf-list-item-text-color'] = `var(--tblr-${props.activeColor})`
      }

      return vars;
    });

    const bindingProps = computed(() => {

      const radius = typeof props.rounded === 'boolean' ? 'rounded-2' : `rounded-${props.rounded}`;

      const attributes = {
        class: {
          clickable: props.to || props.nav || typeof props.value !== 'undefined',
          active: props.active,
          'plf-list-item': true,
          'plf-list-item-nav': props.nav,
          disabled: props.disabled === true,
          bordered: props.bordered,
          square: props.square === true || props.nav !== true,
          [radius]: !!props.rounded
        },

        style: {
          ...colors.value,
          width: toUnit(props.width),
          minWidth: toUnit(props.minWidth),
          maxWidth: toUnit(props.maxWidth),

          height: toUnit(props.height),
          minHeight: toUnit(props.minHeight),
          maxHeight: toUnit(props.maxHeight),
        }
      };

      if (props.to && !props.disabled) {
        attributes.to = props.to;
        attributes.replace = props.replace;
        attributes.class.active = route.path === props.to;
      }

      return attributes;
    });

    const onClick = (evt) => {
      if (props.disabled) return;

      emit('itemClick', evt);
    }

    const generatePrepend = () => {
      if (!slots.prepend && !props.prependAvatar && !props.prependIcon) return undefined;

      return h('div', {
        class: 'plf-list-item-prepend',
        active: props.active
      }, h(() => {
        if (slots.prepend) {
          return slots.prepend(props);
        }

        const children = [];

        if (props.prependAvatar) {
          children.push(h('img', { class: 'avatar avatar-sm rounded-circle', src: props.prependAvatar }));
        }

        if (props.prependIcon) {
          children.push(h(PlfIcon, { name: props.prependIcon }));
        }

        return children;
      }));
    }

    const generateDefault = () => {
      const classes = ['plf-list-item-content'];

      if (typeof props.contentClasses === 'string') {
        classes.push(props.contentClasses);
      } else if (Array.isArray(props.contentClasses)) {
        classes.push(...props.contentClasses);
      } else if (typeof props.contentClasses === 'object') {
        classes.push(props.contentClasses);
      }

      return h('div', { class: classes, style: { minWidth: 0 } }, h(() => {
        if (slots.default) {
          return slots.default(props);
        }

        return [
          h('div', { class: 'plf-list-item-title text-truncate', innerText: props.title }),

          h('small', { title: props.subtitle, class: 'plf-list-item-subtitle text-truncate', innerText: props.subtitle })
        ];
      }));
    }

    const generateAppend = () => {
      if (!slots.append && !props.appendAvatar && !props.appendIcon) return undefined;

      return h('div', { class: 'plf-list-item-append' }, h(() => {
        if (slots.append) {
          return slots.append(props);
        }

        const children = [];

        if (props.appendAvatar) {
          children.push(h('img', { class: 'avatar avatar-sm rounded-circle', src: props.appendAvatar }));
        }

        if (props.appendIcon) {
          children.push(h(PlfIcon, { name: props.appendIcon }));
        }

        return children;
      }));
    }

    return () => {
      const wrapperProps = {
        title: props.title,
        tabindex: props.tabindex,
        ...bindingProps.value,
        onClick: onClick
      };

      const children = [
        generatePrepend(),
        generateDefault(),
        generateAppend()
      ];

      if (props.to && props.disabled !== true) {
        return h(RouterLink, {
          ...wrapperProps,
          exactActiveClass: 'active',
        }, () => children);
      }

      return h('div', wrapperProps, children);
    };
  }
}
</script>

<style scoped>
.plf-list-item {
  padding: 10px;
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
  overflow: hidden;
  color: var(--tblr-gray-600);
  outline: none;
}

.plf-list-item.plf-list-item-nav:not(.square),
.plf-list-item:not(.square) {
  border-radius: var(--tblr-border-radius);
}

.plf-list-item.plf-list-item-nav {
  margin-top: 4px;
}

.plf-list-item.clickable:not(.plf-list-item.disabled) {
  cursor: pointer;
  transition: background-color .2s;
}

.plf-list-item.disabled {
  cursor: not-allowed;
  user-select: none;
}

.plf-list-item.bordered {
  border: 1px solid var(--tblr-gray-300);
}

.plf-list-item.disabled {
  color: var(--tblr-gray-500);
}

.plf-list-item.disabled .plf-list-item-subtitle {
  color: var(--tblr-gray-400);
}

.plf-list-item.clickable:hover:not(.disabled):not(.active) {
  background-color: var(--tblr-gray-100);
}

.plf-list-item-content {
  display: flex;
  flex-direction: column;
  flex: 1;
  white-space: nowrap;
}

.plf-list-item-subtitle {
  color: var(--tblr-gray-500);
}

.plf-list-item .plf-list-item-prepend,
.plf-list-item .plf-list-item-append {
  display: flex;
  align-items: center;
  gap: .25rem;
}

.plf-list-item.active {
  color: var(--plf-list-item-text-color) !important;
  font-weight: 500;
}

.plf-list-item.active .plf-list-item-subtitle {
  color: rgba(var(--plf-list-item-text-color), .5);
}

.plf-list-item.active {
  background-color: rgba(var(--plf-list-item-bg-color), .1);
}


.plf-list-item.clickable:hover.active {
  background-color: rgba(var(--plf-list-item-bg-color), .16);
}

.plf-list-item .plf-list-item-prepend {
  flex-shrink: 0;
  align-self: center;
  display: flex;
}

/* Dark Mode */
[data-bs-theme='dark'] .plf-list-item {
  color: var(--tblr-gray-300);
}

[data-bs-theme='dark'] .plf-list-item.active {
  background-color: rgba(var(--plf-list-item-bg-color), .2);
}

[data-bs-theme='dark'] .plf-list-item.clickable:hover.active {
  background-color: rgba(var(--plf-list-item-bg-color), .15);
}

[data-bs-theme='dark'] .plf-list-item.clickable:hover:not(.disabled):not(.active) {
  background-color: var(--tblr-gray-700);
}
</style>
