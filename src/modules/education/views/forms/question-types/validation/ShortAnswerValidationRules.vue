<template>
  <div class="d-flex">

    <PlfDropdown placement="bottom-start"
                 hide-arrow
                 popper-classes="shadow"
                 :z-index="5000"
                 tag="button"
                 toggle-classes="btn btn-action cursor-pointer border-0 bg-transparent px-0">
      <template #menu>
        <PlfList>
          <PlfListItem value="Number"
                       title="Number" />
          <PlfListItem value="Text"
                       title="Text" />
          <PlfListItem value="Length"
                       title="Length" />
          <PlfListItem value="Regular Expression"
                       title="Regular Expression" />
        </PlfList>
      </template>

      <template #default>
        <!-- <PlfButton class="px-0 border-0 bg-transparent"
                   label="Number"
                   icon-right="mdi.IconChevronDown" /> -->

        <div class="text-muted w-100 border-0">
          <span>Number</span>
          <PlfIcon name="mdi.IconChevronDown" />
        </div>
      </template>
    </PlfDropdown>
  </div>
</template>

<script setup>
import PlfDropdown from '@/components/shared/dropdown/PlfDropdown.vue';
import PlfIcon from '@/components/shared/icon/PlfIcon.vue';
import PlfListItem from '@/components/shared/list/PlfListItem.vue';
import PlfList from '@/components/shared/list/PlfList.vue';

</script>