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

const classes_states = {
	pupilsArray : [], //With her classes formatted
    secondaryClasses : {},
    newClasse: {
        name: '',
        level: 'secondary',
        month: MONTHS[(new Date).getMonth()],
        year: (new Date).getFullYear(),
    },

    targetedClasse : {
        classe: {},
        classeFMT: {
            name: '',
            idc: '',
            sup: '',
            id: 0
        },
        heads: {
            teacher: {},
            respo2: {},
            respo1: {},
        },
        pupils: [],
        subjects: [],

    },
    targetedClasseSubject: 10,
    targetClasseFMT: [],
    targetedClasseMarks: [],
    targetedClasseSubjectsCoef: [],

    cl : 0,
    pcl : 0,
    scl : 0,
    CBLength : 0,
    CBPLength : 0,
    CBSLength : 0,

    editedClasse : {},
    editedClasseSubjects: [],
    classesSecondary : [],
    classesPrimary : [],
    classes: [],
    classesAll: [], 
    classesBlockedsAll: [],
    classesBlockeds: [],
    CSBlockeds: [],
    CPBlockeds: [],
    alertClassesSearch: 'Toutes les classes',

    marks: {
        first: {},
        second: {},
        third: {},
    }
}

export default classes_states