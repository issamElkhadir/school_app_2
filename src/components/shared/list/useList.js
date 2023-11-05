import { computed } from 'vue'

export default function useList(instance, currentValue) {
  const valuePath = computed(() => {
    let parent = instance.parent;

    const path = [currentValue.value];

    while (parent.type.name !== 'PlfList' || parent.type.__name !== 'PlfList') {
      if (parent.props.value) {
        path.unshift(parent.props.value)
      }

      parent = parent.parent;

      if (!parent) break;
    }

    return path;
  });

  const parentList = computed(() => {
    let parent = instance.parent;
    let name = parent.type.name || parent.type.__name;

    while (parent && !['PlfList', 'PlfListGroup'].includes(name)) {

      parent = parent.parent;
      name = parent.type.name || parent.type.__name;
    }

    return parent;
  });

  return {
    parentList,
    valuePath,
  }
}
