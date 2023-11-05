<script>
import { h } from 'vue';

export default {
  name: 'PlfListSubheader',
  
  props: {
    title: {
      type: String
    }
  },

  setup (props, { slots }) {
    return () => h('div', {
      class: 'plf-list-subheader'
    }, slots.default ? slots.default() : props.title);
  }
};
</script>

<style scoped>
.plf-list-subheader {
  color: var(--tblr-gray-500);
  margin-block: 5px;
  padding-inline: 10px;
}
</style>
