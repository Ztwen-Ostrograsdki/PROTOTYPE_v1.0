const pupils_states = {
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
    
        
}

export default pupils_states