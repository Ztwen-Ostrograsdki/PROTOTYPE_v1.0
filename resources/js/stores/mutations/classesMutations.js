const classes_mutations = {

	GET_CLASSES_DATA: (state, data) => {
        state.errors = data.errors
        state.user = data.user
        state.classes = data.classes
        state.classesAll = data.classesAll

        state.classesSecondary = data.cSec
        state.classesPrimary = data.cPrim
        state.admin = data.admin
        
	}, 

    GET_A_CLASSE_DATA: (state, data) => {
        state.token = data.token
        state.targetedClasse = data.targetedClasse
        // state.editedPupilSubjects = data.subjects
        // state.token = data.token
        // state.targetPupilClasseFMT = data.classeFMT
        // console.log(data)
        
    },
    

	SHOW_CLASSES_BY_LEVEL: (state, level, notBlockedSpace = true) => {
		if(notBlockedSpace){
            if(level == 'secondary'){
                state.classes = state.classesSecondary
                state.alertClassesSearch = "Les classes du secondaire"
            }
            else if (level == 'primary') {
                state.classes = state.classesPrimary
                state.alertClassesSearch = "Les classes du primaire"
            }
            else if (level == 'all') {
                state.classes = state.classesAll
                state.alertClassesSearch = "Toutes les classes"  
            }
        }
	}
}

export default classes_mutations