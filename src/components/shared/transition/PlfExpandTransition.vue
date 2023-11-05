<script >
import { h, Transition } from 'vue';

export default {
  name: 'PlfExpandTransition',

  props: {
    name: {
      type: String,
      default: 'expand'
    },

    duration: {
      type: String,
      default: '500ms'
    }
  },

  setup(props, { slots }) {
    const data = {
      name: props.name,
      onAfterEnter(element) {
        // eslint-disable-next-line no-param-reassign
        element.style.height = `auto`;
      },

      onEnter(element) {
        const { width } = getComputedStyle(element);
        /* eslint-disable no-param-reassign */
        element.style.width = width;
        element.style.position = `absolute`;
        element.style.visibility = `hidden`;
        element.style.height = `auto`;
        /* eslint-enable */
        const { height } = getComputedStyle(element);
        /* eslint-disable no-param-reassign */
        element.style.width = null;
        element.style.position = null;
        element.style.visibility = null;
        element.style.height = 0;
        /* eslint-enable */
        // Force repaint to make sure the
        // animation is triggered correctly.
        // eslint-disable-next-line no-unused-expressions
        getComputedStyle(element).height;
        requestAnimationFrame(() => {
          // eslint-disable-next-line no-param-reassign
          element.style.height = height;
        });
      },
      onLeave(element) {
        const { height } = getComputedStyle(element);
        // eslint-disable-next-line no-param-reassign
        element.style.height = height;
        // Force repaint to make sure the
        // animation is triggered correctly.
        // eslint-disable-next-line no-unused-expressions
        getComputedStyle(element).height;
        requestAnimationFrame(() => {
          // eslint-disable-next-line no-param-reassign
          element.style.height = 0;
        });
      },
    };

    return () => h(Transition, data, () => slots.default());
  },
};
</script>

<style scoped>
* {
  will-change: height;
  transform: translateZ(0);
  backface-visibility: hidden;
  perspective: 1000px;
}
</style>

<style>
.expand-enter-active,
.expand-leave-active {
  transition: height ease-in-out;
  transition-duration: v-bind(duration);
  overflow: hidden;
}

.expand-enter,
.expand-leave {
  height: 0;
}
</style>
