const classes_mutations = {

	GET_CLASSES_DATA: (state, data) => {
        state.errors = data.errors
        state.user = data.user
        state.classes = data.classes
        state.classesAll = data.classesAll
        state.teachers = data.teachers
        state.pupils = data.pupils

        state.classesBlockeds = data.classesBlockeds

        state.classesSecondary = data.cSec
        state.classesPrimary = data.cPrim
        state.admin = data.admin
        
	}, 

    GET_A_CLASSE_DATA: (state, data) => {
        state.token = data.token
        state.targetedClasse = data.targetedClasse
        state.targetedClasseSubject = data.targetedClasse.targetedSubject.id
    },
    GET_A_CLASSE_TEACHERS: (state, data) => {
        state.targetedClasseTeachers = data
    },
    GET_A_CLASSE_PUPILS: (state, data) => {
        state.targetedClassePupils = data
    },
    RESET_EDITING_CLASSE: (state, data) =>{
        state.editingClasse = {
            classe : data.classe,
            respo1 : data.classe.respo1,
            respo2 : data.classe.respo2,
            classe_name: data.classe.name,
            teacher_id: data.classe.teacher_id,
            tag : data.tag
        }
    },

    RESET_BLOCKED_CLASSSES: (state, data) => {
        state.classesBlockedsAll = data
    },
    RESET_TARGETED_CLASSE_SUBJECT_TARGETED: (state, subject) =>{
        state.targetedClasseSubject = subject.id
    },
    RESET_TARGETED_CLASSE_MARKS: (state, data) =>{
        state.targetedClasseMarks = data.classesMarks
        state.targetedClasseSubjectsCoef = data.coefTables
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
	},

    RESET_NEW_CLASSE: (state) =>{
        state.newClasse = {
            name: '',
            level: 'secondary',
            month: '',
            year: (new Date).getFullYear(),
        }
    }
}

export default classes_mutations