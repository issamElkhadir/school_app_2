<template>
  <div class="d-flex gap-2 align-items-center">
    <ul class="pagination align-items-center justify-content-center mb-0">
      <li v-if="boundaryLinks"
          class="page-item"
          :class="{ disabled: generatedPagination.startPage === generatedPagination.currentPage }"
          @click="setPage(1)">
        <button class="page-link bg-transparent"
                tabindex="-1"
                aria-disabled="true">
          <PlfIcon name="mdi.IconChevronDoubleLeft"
                   class="icon" />
        </button>
      </li>

      <li v-if="directionLinks"
          class="page-item"
          :class="{ disabled: generatedPagination.startPage === generatedPagination.currentPage }"
          @click="previous">
        <button class="page-link bg-transparent"
                tabindex="-1"
                aria-disabled="true">
          <PlfIcon name="mdi.IconChevronLeft" />
        </button>
      </li>

      <template v-if="!input">
        <li v-for="page in generatedPagination.pages"
            :key="`page-${page}`"
            :class="{ 'active': page === generatedPagination.currentPage }"
            class="page-item"
            @click="setPage(page)">
          <button class="page-link no-transitions bg-transparent"
                  :class="{ [`bg-${color}`]: page === generatedPagination.currentPage }">
            {{ page }}
          </button>
        </li>
      </template>

      <li v-else>
        <input :placeholder="`${currentPage} / ${generatedPagination.totalPages}`"
               class="text-center w-5 form-control form-control-sm form-control-flush"
               type="number"
               @change="onPageChange">
      </li>

      <li v-if="directionLinks"
          class="page-item"
          :class="{ disabled: generatedPagination.endPage === generatedPagination.currentPage }"
          @click="next">
        <button class="page-link bg-transparent">
          <PlfIcon name="mdi.IconChevronRight"
                   class="icon" />
        </button>
      </li>

      <li v-if="boundaryLinks"
          class="page-item"
          :class="{ disabled: generatedPagination.endPage === generatedPagination.currentPage }"
          @click="setPage(generatedPagination.totalPages)">
        <button class="page-link bg-transparent"
                tabindex="-1">
          <PlfIcon name="mdi.IconChevronDoubleRight"
                   class="icon" />
        </button>
      </li>
    </ul>
  </div>
</template>

<script setup>

import { computed } from "vue";
import PlfIcon from "../icon/PlfIcon.vue";
import { useVModel } from '@vueuse/core';

const emit = defineEmits(['update:page']);

const props = defineProps({
  page: {
    type: Number,
    default: 1
  },

  input: {
    type: Boolean,
    default: () => false,
  },

  loading: {
    type: Boolean,
  },

  boundaryLinks: {
    type: Boolean,
    default: () => false
  },

  directionLinks: {
    type: Boolean,
    default: () => false
  },

  color: {
    type: String,
    default: () => 'primary',
  },

  maxPages: {
    type: Number,
    default: () => 0
  },

  rowsPerPage: {
    type: Number,
    default: () => 10
  },

  rowsNumber: {
    type: Number,
    default: () => 0
  },
});

function paginate(
  totalItems,
  currentPage = 1,
  pageSize = 10,
  maxPages = 10
) {
  // calculate total pages
  let totalPages = Math.ceil(totalItems / pageSize);

  // ensure current page isn't out of range
  if (currentPage < 1) {
    currentPage = 1;
  } else if (currentPage > totalPages) {
    currentPage = totalPages;
  }

  let startPage, endPage;
  if (totalPages <= maxPages) {
    // total pages less than max so show all pages
    startPage = 1;
    endPage = totalPages;
  } else {
    // total pages more than max so calculate start and end pages
    let maxPagesBeforeCurrentPage = Math.floor(maxPages / 2);
    let maxPagesAfterCurrentPage = Math.ceil(maxPages / 2) - 1;
    if (currentPage <= maxPagesBeforeCurrentPage) {
      // current page near the start
      startPage = 1;
      endPage = maxPages;
    } else if (currentPage + maxPagesAfterCurrentPage >= totalPages) {
      // current page near the end
      startPage = totalPages - maxPages + 1;
      endPage = totalPages;
    } else {
      // current page somewhere in the middle
      startPage = currentPage - maxPagesBeforeCurrentPage;
      endPage = currentPage + maxPagesAfterCurrentPage;
    }
  }

  // calculate start and end item indexes
  let startIndex = (currentPage - 1) * pageSize;
  let endIndex = Math.min(startIndex + pageSize - 1, totalItems - 1);

  // create an array of pages to ng-repeat in the pager control
  let pages = Array.from(Array((endPage + 1) - startPage).keys()).map(i => startPage + i);

  if (pages.length === 0) {
    pages = [1];
    currentPage = 1;
    endPage = 1;
    startPage = 1;
  }

  // return object with all pager properties required by the view
  return {
    totalItems: totalItems,
    currentPage: currentPage,
    pageSize: pageSize,
    totalPages: totalPages,
    startPage: startPage,
    endPage: endPage,
    startIndex: startIndex,
    endIndex: endIndex,
    pages: pages,
  };
}

const currentPage = useVModel(props, 'page', emit);

const generatedPagination = computed(() => {
  const perPage = props.rowsPerPage === 0 ? props.rowsNumber : props.rowsPerPage;
  let maxPages = props.maxPages === 0 ? Math.ceil(props.rowsNumber / perPage) : props.maxPages;

  return paginate(
    props.rowsNumber,
    currentPage.value,
    perPage,
    maxPages
  );
});

const setPage = (page) => {
  if (page === currentPage.value) {
    return;
  }

  if (page <= generatedPagination.value.totalPages && page >= 1) {
    currentPage.value = page;
  }
};

const next = () => setPage(currentPage.value + 1);

const previous = () => setPage(currentPage.value - 1);

const onPageChange = (e) => {
  const page = +e.target.value;
  if (page <= generatedPagination.value.totalPages && page >= 1) {
    currentPage.value = page;
    e.target.value = '';
  }
};
</script>

<style scoped>
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="number"] {
  -moz-appearance: textfield;
}


::placeholder {
  /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: var(--tblr-muted);
  opacity: 1;
  /* Firefox */
}

:-ms-input-placeholder {
  /* Internet Explorer 10-11 */
  color: var(--tblr-muted);
}

::-ms-input-placeholder {
  /* Microsoft Edge */
  color: var(--tblr-muted);
}
</style>
