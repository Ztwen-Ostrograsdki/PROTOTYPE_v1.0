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

    editingClasse:{
        classe: {},
        classe_name: '',
        teacher_id: '',
        tag: null
    },
    targetedClasseTeachers: [],
    targetedClassePupils: [],
    teachers: [],
    pupils: [],

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
    targetedClasseModality: [],
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
    classesWithSubjects : [],
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
    },
    alertModality: {status: false, message: ''},
    subjectWithModalities: []
}

export default classes_states