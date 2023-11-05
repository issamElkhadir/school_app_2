import { ref } from "vue";

const toasts = ref();

const init = () => {
  toasts.value = {
    "top-left": [],
    "top-right": [],
    "top-center": [],

    "bottom-left": [],
    "bottom-right": [],
    "bottom-center": [],

    center: [],
  };
};

init();

export function useToast() {
  const getPosition = (toast) => {
    if (toast.position && toast.position in toasts.value) {
      return toast.position;
    }
    return "bottom-center";
  };

  return {
    /**
     * Add a toast to the list of toasts.
     * 
     * @param {import("./toast").Toast} toast 
     */
    add(toast) {
      const position = getPosition(toast);
      toast.id = toasts.value[position].length + 1;
      toasts.value[position].push(toast);

      if (!("life" in toast)) {
        toast.life = 5000;
      }
      if (toast.life > 0) {
        setTimeout(
          () => this.remove(toast),
          toast.life + /* show duration */ 1000
        );
      }
    },

    /**
     * Remove a toast from the list
     *
     */
    remove(toast) {
      const position = getPosition(toast);
      toasts.value[position] = toasts.value[position].filter(
        (t) => t.id !== toast.id
      );
    },

    /**
     * Remove all toasts
     */
    removeAll() {
      init();
    },

    toasts,
  };
}

export const ToastSeverity = {
  INFO: "info",
  SUCCESS: "success",
  WARN: "warn",
  ERROR: "error",
};
