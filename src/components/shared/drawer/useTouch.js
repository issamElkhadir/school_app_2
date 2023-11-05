import { onMounted, onBeforeUnmount, computed, ref } from "vue";

export function useTouch({ isActive, isTemporary, width, position, touchless }) {
  onMounted(() => {
    window.addEventListener('touchstart', onTouchstart, {
      passive: true
    });
    window.addEventListener('touchmove', onTouchmove, {
      passive: false
    });
    window.addEventListener('touchend', onTouchend, {
      passive: true
    });
  });
  onBeforeUnmount(() => {
    window.removeEventListener('touchstart', onTouchstart);
    window.removeEventListener('touchmove', onTouchmove);
    window.removeEventListener('touchend', onTouchend);
  });

  const isDragging = ref(false);
  const dragProgress = ref(0);

  let start;
  let maybeDragging;

  const offset = ref(0);

  const isHorizontal = computed(() => position.value !== 'bottom');

  function getOffset(pos, active) {
    return (position.value === 'left' ? pos : position.value === 'right' ? document.documentElement.clientWidth - pos : position.value === 'bottom' ? document.documentElement.clientHeight - pos : oops()) - (active ? width.value : 0);
  }

  function getProgress(pos) {
    let limit = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
    const progress = position.value === 'left' ? (pos - offset.value) / width.value : position.value === 'right' ? (document.documentElement.clientWidth - pos - offset.value) / width.value : position.value === 'bottom' ? (document.documentElement.clientHeight - pos - offset.value) / width.value : oops();
    return limit ? Math.max(0, Math.min(1, progress)) : progress;
  }

  const onTouchstart = (e) => {
    if (touchless.value) return;

    const touchX = e.changedTouches[0].clientX;
    const touchY = e.changedTouches[0].clientY;

    const touchZone = 25;
    const inTouchZone = position.value === 'left' ? touchX < touchZone : position.value === 'right' ? touchX > document.documentElement.clientWidth - touchZone : position.value === 'bottom' ? touchY > document.documentElement.clientHeight - touchZone : oops();
    const inElement = isActive.value && (position.value === 'left' ? touchX < width.value : position.value === 'right' ? touchX > document.documentElement.clientWidth - width.value : position.value === 'bottom' ? touchY > document.documentElement.clientHeight - width.value : oops());

    if ((inTouchZone || inElement) || (isActive.value && isTemporary.value)) {
      maybeDragging = true;
      start = [touchX, touchY];
      offset.value = getOffset(isHorizontal.value ? touchX : touchY, isActive.value);

      dragProgress.value = getProgress(isHorizontal.value ? touchX : touchY);
    }
  }

  const onTouchmove = (e) => {
    const touchX = e.changedTouches[0].clientX;
    const touchY = e.changedTouches[0].clientY;

    if (maybeDragging) {
      if (!e.cancelable) {
        maybeDragging = false;
        return;
      }
      const dx = Math.abs(touchX - start[0]);
      const dy = Math.abs(touchY - start[1]);
      const thresholdMet = isHorizontal.value ? dx > dy && dx > 3 : dy > dx && dy > 3;
      if (thresholdMet) {
        isDragging.value = true;
        maybeDragging = false;
      } else if ((isHorizontal.value ? dy : dx) > 3) {
        maybeDragging = false;
      }
    }
    if (!isDragging.value) return;
    e.preventDefault();

    const progress = getProgress(isHorizontal.value ? touchX : touchY, false);
    dragProgress.value = Math.max(0, Math.min(1, progress));
    if (progress > 1) {
      offset.value = getOffset(isHorizontal.value ? touchX : touchY, true);
    } else if (progress < 0) {
      offset.value = getOffset(isHorizontal.value ? touchX : touchY, false);
    }
  }

  const onTouchend = () => {
    maybeDragging = false;
    if (!isDragging.value) return;

    isDragging.value = false;

    isActive.value = dragProgress.value >= .5;
  }

  const dragStyles = computed(() => {
    return isDragging.value ? {
      transform: position.value === 'left' ? `translateX(calc(-100% + ${dragProgress.value * width.value}px))` : position.value === 'right' ? `translateX(calc(100% - ${dragProgress.value * width.value}px))` : position.value === 'bottom' ? `translateY(calc(100% - ${dragProgress.value * width.value}px))` : oops(),
      transition: 'none'
    } : undefined;
  });

  return {
    isDragging,
    dragProgress,

    dragStyles
  }
}

function oops() {
  throw new Error();
}