import guardians from './guardians.json';
import staff from './staff.json';
import views from './views.json';
import classroomTypes from './classroom-types.json';
import classrooms from './classrooms.json';
import cycles from './cycles.json';
import branches from './branches.json';
import levels from './levels.json';
import unities from './unities.json';
import periods from './periods.json';
import subjects from './subjects.json';
import classes from './classes.json';
import students from './students.json';
import subjectSequences from './subject-sequences.json';
import academicYear from './academic-years.json';

export default {
    ...guardians,
    ...staff,
    ...students,
    ...classroomTypes,
    ...classrooms,
    ...cycles,
    ...branches,
    ...levels,
    ...unities,
    ...periods,
    ...subjects,
    ...subjectSequences,
    ...academicYear,
    ...classes,
    ...views
};