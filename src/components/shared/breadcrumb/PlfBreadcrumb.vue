<script>
import { h } from 'vue';
import PlfIcon from '../icon/PlfIcon.vue';

export default {
  name: 'PlfBreadcrumb',

  props: {
    separator: {
      type: String,
    },

    gap: {
      required: false,
      default: () => 'gap-0',
      validator(value) {
        return ['gap-0', 'gap-1', 'gap-2', 'gap-3', 'gap-4', 'gap-5'].includes(value)
      }
    },

    activeColor: {
      default: () => 'text-primary',
    }
  },

  setup(props, { slots }) {

    const flatten = (arr) => {
      return arr.reduce((acc, item) => {
        if (Array.isArray(item.children)) {
          acc.push(...flatten(item.children));
        } else {
          acc.push(item);
        }

        return acc;
      }, []);
    };

    const generateItems = () => {
      if (slots.default) {
        const els = flatten(slots.default()).filter((item) => {
          return item?.type?.__name === 'PlfBreadcrumbEl';
        });

        const separator = slots.separator?.() ?? props.separator ?? h(PlfIcon, {
          inline: true,
          name: 'mdi.IconChevronRight',
        });

        // Insert separator between each two elements
        return els.reduce((acc, item, index) => {
          if (index > 0) {
            acc.push(h('li', {
              class: ['plf-breadcrumb-separator']
            }, separator));
          }

          acc.push(item);

          return acc;
        }, []);
      }

      return [];
    };

    return () => h('ol', {
      class: ['plf-breadcrumb', props.separator, props.gap]
    }, generateItems());
  }
}
</script>

<style scoped>
.plf-breadcrumb {
  display: flex;
  padding: 0;
  margin: 0;
  list-style: none;
  align-items: center;
}
</style>