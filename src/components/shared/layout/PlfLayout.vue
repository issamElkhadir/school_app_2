<script>
import { h } from 'vue';
import { createLayout } from './layout';

export default {
  name: 'PlfLayout',

  props: {
    fullHeight: {
      type: Boolean,
      default: true,
    },

    scrollable: {
      type: Boolean,
      default: false,
    }
  },

  setup(props, { slots }) {
    const { layoutClasses, layoutStyles, layoutRef } = createLayout(props);

    return () => {
      return h('div', {
        ref: layoutRef,

        class: layoutClasses.value,

        style: layoutStyles.value

      }, h(slots.default));
    };
  }
}
</script>

<style scoped>
.plf-layout {
  position: relative;
  width: 100%;
  display: flex;
}

.plf-layout-full-height {
  height: 100svh;
}
</style>
