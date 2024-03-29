import pupils_mutations from './pupilsMutations.js'
import teachers_mutations from './teachersMutations.js'
import classes_mutations from './classesMutations.js'
import auth_mutations from './authMutations.js'
import parents_mutations from './parentsMutations.js'
import dashboards_mutations from './dashboardsMutations.js'

const default_mutations = {

	GET_DATA_LENGTH: (state, data) => {

		state.user = data.user
		state.noUser = false
		state.admin = data.admin
		state.ul = data.ul
		state.pl = data.pl
		state.ppl = data.ppl
		state.psl = data.psl
		state.tl = data.tl
		state.tsl = data.tsl
		state.tpl = data.tpl
		state.allParents = data.parents

		state.cl = data.classes.length
		state.pcl = data.classesPrimary.length
		state.scl = data.classesSecondary.length
		state.CBLength = data.classesBlockeds.length
		state.CBPLength = data.classesPrimaryBlockeds.length
		state.CBSLength = data.classesSecondaryBlockeds.length

		state.pupilsBlockedsLength = data.pupilsblockedLength
		state.PBPLength = data.PBPLength
		state.PBSLength = data.PBSLength
		state.classesBlockedsAll = data.classesBlockeds
	},
	GET_TOOLS: (state, data) => {
		state.token = data.token
		state.allRoles = data.roles
		state.months = data.months
		state.subjects = data.subjects
		state.classesWithPP = data.classesWithPP
		state.primaryClasses = data.primaryClasses
		state.allPrimaryClasses = data.allPrimaryClasses
		state.allSecondaryClasses = data.allSecondaryClasses
		state.classesWithSubjects = data.classesWithSubjects
		state.secondaryClassesFormatted = data.secondaryClassesFormatted
		state.secondaryClasses = data.secondaryClasses
		state.allClasses = {...data.primaryClasses, ...data.secondaryClasses}
		state.primarySubjects = data.primarySubjects
		state.secondarySubjects = data.secondarySubjects
		state.allSubjects = {...data.primarySubjects, ...data.secondarySubjects}
		
	},

	ALERT_MAKER: (state, message) => {
		state.alert = true
		state.message = message
	},

	ALERT_RESET: (state) => {
		state.alert = false
		state.message = ""
	},

	INVALID_INPUTS: (state, errors) => {
		state.invalidInputs = errors
		state.successed.status = false
	},

	RESET_INVALID_INPUTS: (state) => {
		state.invalidInputs = undefined
	},
	ERRORS_SETTER: (state, advancedErrors) => {
		state.errors.status = advancedErrors.status
		state.errors.type = advancedErrors.type
	},

	SUCCESSED: (state, message) => {
		state.invalidInputs = undefined
		state.successed.status = true
		state.successed.message = message
	},


}

const mutations = {
	...pupils_mutations, ...parents_mutations, ...dashboards_mutations, ...teachers_mutations, ...classes_mutations, ...auth_mutations, ...default_mutations
}

export default mutations