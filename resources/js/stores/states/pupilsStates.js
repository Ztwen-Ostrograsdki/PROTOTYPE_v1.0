let MONTHS = [
    "Janvier",
    "Février",
    "Mars",
    "Avril",
    "Mai",
    "Juin",
    "Juillet",
    "Août",
    "Septembre",
    "Octobre",
    "Novembre",
    "Décembre"
]

const pupils_states = {
    deletingPupilConfirmation: {status: false, confirm: false},
    deletingPupil: {},
	pupilsArray : [], //With her classes formatted
    secondaryPupils : {},
    targetPupil : {},
    targetPupilName: '',
    targetPupilLastName: '',
    targetPupilFirstName: '',
    targetPupilClasseFMT: {},
    targetPupilBirthFMT: '',
    targetPupilAge: '',
    trimestre: 0,

    newPupil: {
        name: '',
        classe_id: '',
        birth: '',
        sexe: '',
        level: 'secondary',
        month: '',
        year: (new Date).getFullYear(),
    },

    editedPupil : {
        classe: {}
    },
    editedPupilSubjects: [],
    primaryPupils : {},
    pupils: {},
    pupilsAll: [], 
    pupilsBlockedsAll: {},
    pupilsBlockeds: {},
    PSBlockeds: [],
    PPBlockeds: [],
    alertPupilsSearch: 'Tous les apprenants',

    editedPupilClasseMarks : null,
    editedPupilSubjectMarks : {},
    targetPupilMarks : null,
    targetPupilLastMark : undefined,
    targetPupilLastMarkSuject : '',
    targetPupilBestMark : undefined,
    targetPupilBestMarkSuject : '',
    targetPupilWeakMark : undefined,
    targetPupilWeakMarkSuject : '',
    targetPupilPercentageSuccedMarks : undefined,
    editedPupilCoefTables: [],

    targetPupilParents: [],
    
        
}

export default pupils_states