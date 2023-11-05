<script>
import { h, computed } from 'vue';
import { useLayoutItem } from './layout';

export default {
  name: 'PlfAppBar',

  emits: ['update:modelValue'],

  props: {
    absolute: {
      type: Boolean,
      default: false,
    },

    border: {
      type: [String, Number, Boolean],
      default: false,
    },

    collapse: {
      type: Boolean,
      default: false,
    },

    color: {
      type: String,
    },

    height: {
      type: [String, Number],
      default: 64,
    },

    image: {
      type: String,
    },

    location: {
      type: String,
      default: 'top',
      validator: val => ['top', 'bottom'].includes(val)
    },

    modelValue: {
      type: Boolean,
      default: true
    },

    name: {
      type: String
    },

    order: {
      type: Number,
      default: 0,
    },

    tag: {
      type: String,
      default: 'header'
    },

    title: {
      type: String,
    }
  },

  setup(props, { slots }) {

    const { layoutItemStyles } = useLayoutItem({
      id: props.name,
      order: computed(() => parseInt(props.order, 10)),
      position: computed(() => props.location),
      layoutSize: computed(() => props.height),
      elementSize: computed(() => parseInt(props.height, 10)),
      absolute: computed(() => props.absolute),
      active: computed(() => props.modelValue),
    });

    return () => {
      return h(props.tag, {
        class: 'plf-app-bar',
        style: layoutItemStyles.value
      },
        [
          slots.default ? slots.default() : undefined
        ]);
    }
  }
}
</script>

<style scoped>
.plf-app-bar {
  transition: all .2s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
