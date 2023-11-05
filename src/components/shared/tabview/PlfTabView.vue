<script>
import { computed, ref, watch, h } from "vue";

export default {
  name: 'PlfTabView',

  emits: ['update:activeIndex', 'tab-change', 'tab-click'],

  props: {
    activeIndex: {
      type: Number,
      default: 0
    },
  },

  setup(props, { slots, emit }) {
    const activeIndexMutation = ref(props.activeIndex);

    const nav = ref(null);

    const isTabPanel = (child) => {
      return child.type.__name === "PlfTabPanel";
    };

    const generateTabs = () => {
      const items = [];
      slots.default().forEach(child => {
        if (isTabPanel(child)) {
          items.push(child);
        } else if (child.children && child.children instanceof Array) {
          child.children.forEach(nestedChild => {
            if (isTabPanel(nestedChild)) {
              items.push(nestedChild);
            }
          });
        }
      });

      return items;
    }

    const tabs = computed(() => {
      return generateTabs();
    });

    const onTabClick = (event, i) => {
      if (!isTabDisabled(tabs.value[i]) && i !== activeIndexMutation.value) {
        activeIndexMutation.value = i;

        emit('tab-change', {
          originalEvent: event,
          index: i
        });

        emit('update:activeIndex', i);

        updateScrollBar(i);
      }
      emit('tab-click', {
        originalEvent: event,
        index: i
      });
    };

    const updateScrollBar = (index) => {
      const tabHeader = nav.value.children[index];
      tabHeader.scrollIntoView({ block: 'nearest' })
    };

    const getKey = (tab, i) => {
      return (tab.props && tab.props.header) ? tab.props.header : i;
    };

    const isTabDisabled = (tab) => {
      return (tab.props && !!tab.props.disabled);
    };

    watch(() => props.activeIndex, val => {
      activeIndexMutation.value = val;
      updateScrollBar(val);
    });

    const generateHeaders = () => {
      return tabs.value.map((tab, i) => {
        return h('li', { class: 'nav-item m-0', key: getKey(tab, i) }, [
          h('button', {
            type: 'button',
            class: {
              'nav-link bg-transparent rounded-0 px-3': true,
              disabled: isTabDisabled(tab),
              active: (activeIndexMutation.value === i)
            },
            onClick: (event) => onTabClick(event, i)
          }, tab.props.header)
        ])
      })
    };

    const generateTabContent = () => {
      return tabs.value.map((tab, i) => {
        return h('div', {
          class: {
            'h-100': true,
            'tab-pane': true,
            active: activeIndexMutation.value === i
          }
        }, tab)
      });
    };

    return () => {
      return h('div', { class: 'card rounded-0 w-100' }, [
        h('div', { class: 'card-body d-flex flex-column p-0' }, [
          h('ul', { ref: nav, class: 'nav nav-tabs nav-bordered' }, generateHeaders()),

          h('div', { class: 'tab-content flex-fill' }, generateTabContent())
        ])
      ]);
    };
  }
}
</script>
