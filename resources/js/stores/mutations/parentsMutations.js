const parents_mutations = {

    RESET_ALL_PARENTS_ARRAY: (state, data) => {
        state.allParents = data.parents
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
    }
    
}

export default parents_mutations