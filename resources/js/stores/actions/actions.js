import pupils_actions from './pupilsActions.js'
import teachers_actions from './teachersActions.js'
import classes_actions from './classesActions.js'
import auth_actions from './authActions.js'
import parents_actions from './parentsActions.js'
import dashboards_actions from './dashboardsActions.js'


const default_actions = {
	getCounter: (state) => {
        axios.get('/admin/director/master/get&counter&for&all&data&with&authorization')
			.then(response => {
				state.commit('GET_DATA_LENGTH', response.data)
			})
            
	},
	getTOOLS: (state) => {
        axios.get('/admin/director/master/get&all&data&tools&with&authorization')
			.then(response => {
				state.commit('GET_TOOLS', response.data)
			})      
	},
	
}

const actions = {
	...teachers_actions, ...parents_actions, ...dashboards_actions, ...pupils_actions, ...classes_actions, ...auth_actions, ...default_actions
}

export default actions