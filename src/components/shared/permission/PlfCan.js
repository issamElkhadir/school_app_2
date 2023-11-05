import { computed, h } from "vue";
// import { usePermissions } from "../../../composables/security/usePermissions";

export function PlfCan(props, { slots }) {
  // const { can, cannot } = usePermissions();

  const can = () => true;
  const cannot = () => false;

  const allowed = computed(() => {
    if (props.not) {
      return cannot(props.name);
    }

    return can(props.name);
  });

  if (props.passThrough || allowed.value) {
    return h(slots.default, { allowed: allowed.value });
  }

  return null;
}

PlfCan.props = {
  // The permission name
  name: [String, Object],

  // Pass through the permission to the child component
  passThrough: Boolean,

  // Invert the permission check
  not: Boolean,
};
