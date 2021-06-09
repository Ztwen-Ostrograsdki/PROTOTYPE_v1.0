const parents_mutations = {

    RESET_ALL_PARENTS_ARRAY: (state, data) => {
        state.allParents = data.parents
    },
    GET_PARENTS_DATA: (state, data) => {
        state.parents = data.parents
    },

    RESET_NEW_PARENT: (state) =>{
    	state.newParent = {
    		name: '',
			email: '',
			birth: '',
	        sexe: '',
	        contact: '',
	        residence: '',
	        works: ''
    	}
    },
    RESET_PARENT_TO_PUPIL: (state, data) =>{
    	state.parentToPupil = data
    },
    RESET_PARENTS_SEARCHING: (state, data) =>{
        state.parentsSearching = data
    },
    RESET_EDITED_PARENT:(state, parent) =>{
        state.editedParent = parent
    }
    
}

export default parents_mutations