import pupils_actions from './pupilsActions.js'
import teachers_actions from './teachersActions.js'
import classes_actions from './classesActions.js'
import auth_actions from './authActions.js'
import parents_actions from './parentsActions.js'


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
	getHoraires: (state, year) => {
        axios.get('/admin/director/master/dashbords/data&emploi&du&temps/all&data/year=' + year)
			.then(response => {
				state.commit('GET_HORAIRES', response.data)
			})      
	}

}

const actions = {
	...teachers_actions, ...parents_actions, ...pupils_actions, ...classes_actions, ...auth_actions, ...default_actions
}

export default actions