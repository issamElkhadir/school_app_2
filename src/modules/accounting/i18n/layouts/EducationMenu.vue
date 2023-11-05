<template>
  <PlfList nav>
    <PlfListItem :to="{ name: 'admin.guardians.table' }"
                 title="Guardians"/>

    <PlfListItem :to="{ name: 'admin.staff.table' }"
                 title="Staff"/>

    <PlfListItem :to="{ name: 'admin.students.table' }"
                 title="Student"/>

    <PlfListItem :to="{ name: 'admin.classroom-types.table' }"
                 title="Classroom Types"/>

    <PlfListItem :to=" { name: 'admin.classrooms.table' } "
                 title=" Classrooms "/>

    <PlfListItem :to=" { name: 'admin.cycles.table' } "
                 title=" Cycles "/>

    <PlfListItem :to=" { name: 'admin.branches.table' } "
                 title=" Branches "/>

    <PlfListItem :to=" { name: 'admin.levels.table' } "
                 title=" Levels "/>

    <PlfListItem :to=" { name: 'admin.periods.table' } "
                 title=" Periods "/>

    <PlfListItem :to=" { name: 'admin.unities.table' } "
                 title=" Unities "/>

    <PlfListItem :to=" { name: 'admin.subjects.table' } "
                 title=" Subjects "/>

    <PlfListItem :to="{ name: 'admin.subject-sequences.table' }"
                 title="Subject Sequences"/>

    <PlfListItem :to="{ name: 'admin.classes.table' }"
                 title="Classes"/>

    <PlfListItem :to="{ name: 'admin.academic-years.table' }"
                 title="Academic Years"/>


    <PlfListItem :to="{ name: 'admin.categories.table' }"
                 title="Categories"/>

    <PlfListItem :to="{ name: 'admin.articles.table' }"
                 title="Articles"/>

    <PlfListItem :to="{ name: 'admin.packs.table' }"
                 title="Packs"/>

    <PlfListItem :to="{ name: 'admin.subscriptions.table' }"
                 title="Subscriptions"/>

  </PlfList>
</template>

<script setup>
import PlfList from '@/components/shared/list/PlfList.vue';
import PlfListItem from '@/components/shared/list/PlfListItem.vue';

</script>