import auth_states from './authStates.js'
import pupils_states from './pupilsStates.js'
import teachers_states from './teachersStates.js'
import classes_states from './classesStates.js'
import notifications_states from './notificationsStates.js'
import parents_states from './parentsStates.js'
import dashboards_states from './dashboardsStates.js'

const default_states = {
	pl: 0,
	ppl: 0,
	psl: 0,
	tl: 0,
	tpl: 0,
	tsl: 0,
	ul: 0,
	classesWithPP: [],
	primaryClasses: [],
	secondaryClasses: {},
	allPrimaryClasses: {},
	allSecondaryClasses: {},
	secondaryClassesFormatted: {},
	allClasses: {},
	primarySubjects: {},
	subjects: {},
	secondarySubjects: {},
	allSubjects: {},
	allRoles: [],
	months: [],
	type: "border-success",
	PBPLength: 0,
	PBSLength: 0,
    pupilsBlockedsLength: 0,
    invalidInputs: undefined,
    errors: {status: false, message: ''},
    successed: {status: false, message: ''},
    

}

const states = {
	...auth_states, ...parents_states, ...dashboards_states, ...teachers_states, ...classes_states, ...pupils_states, ...notifications_states, ...default_states
}

export default states