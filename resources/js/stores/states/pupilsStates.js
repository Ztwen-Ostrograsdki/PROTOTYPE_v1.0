const pupils_states = {
	pupilsArray : [], //With her classes formatted
    secondaryPupils : {},
    targetPupil : {},
    targetPupilName: '',
    targetPupilLastName: '',
    targetPupilFirstName: '',
    targetPupilClasseFMT: {},
    targetPupilBirthFMT: '',
    trimestre: 0,
    age: '',

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

    targetPupilMarksObject: {
        first :{
            epe1: {},
            epe2: {},
            epe3: {},
            epe4: {},
            epe5: {},
            dev1: {},
            dev2: {},
        },
        second: {
            epe1: {},
            epe2: {},
            epe3: {},
            epe4: {},
            epe5: {},
            dev1: {},
            dev2: {},
        },
        third: {
            epe1: {},
            epe2: {},
            epe3: {},
            epe4: {},
            epe5: {},
            dev1: {},
            dev2: {},
        },
        
    }
}

export default pupils_states