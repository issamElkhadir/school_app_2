export const removeClasses = (el, classes = []) => {
  el.classList.remove(...classes);
};

export const mergeClasses = (...classes) => {
  const value = [];

  for (const clazz of classes) {
    if (Array.isArray(clazz)) {
      value.push(...clazz);
    } else if (["string", "object"].includes(typeof clazz)) {
      value.push(clazz);
    }
  }

  return value;
};

export const addClasses = (el, classes) => {
  classes.forEach((className) => {
    if (!el.classList.contains(className)) {
      el.classList.add(className);
    }
  });
};