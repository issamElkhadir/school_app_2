<script>
import { h } from 'vue';
import { useMainLayout } from './layout';

export default {
  name: 'PlfMain',

  props: {
    scrollable: {
      type: Boolean,
      default: false,
    }
  },

  setup(props, { slots }) {

    const {
      mainStyles
    } = useMainLayout();

    return () => {
      return h('main', {
        class: [
          'plf-main',
          { 'plf-main-scrollable': props.scrollable }
        ],
        style: {
          ...mainStyles.value
        }
      }, [
        slots.default && slots.default()
      ])
    }
  }
}
</script>

<style scoped>
.plf-main {
  flex: 1 0 auto;
  max-width: 100%;
  transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  padding-left: var(--plf-layout-left);
  padding-right: var(--plf-layout-right);
  padding-top: var(--plf-layout-top);
  padding-bottom: var(--plf-layout-bottom);
}

.plf-main-scrollable {
  overflow: auto;
}
</style>
