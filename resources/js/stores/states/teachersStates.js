const teachers_states = {
    AllTeachersWithClasses : [], //With her classes formatted
    AllTeachersWithSubject : [], //With her subject formatted
    secondaryTeachers : {},
    targetedTeacher : {
        subject: {},
    },
    targetedTeacherLastName: '',
    targetedTeacherFirstName: '',
    targetedTeacherSubject: "",
    targetedTeacherClasseFMT: {},
    targetedTeacherBirthFMT: '',
    targetedTeacherAge: '',
    targetedTeacherClassesFMT : [],
    targetedTeacherClasses : [],
    classeDetachAlert: {status: false, msg: ""},


    newTeacher: {
        name: '',
        email: '',
        contact: '',
        creator: '',
        residence: '',
        birth: '',
        sexe: '',
        subject_id: null,
        level: 'secondary',
        month: '',
        year: (new Date).getFullYear(),
    },

    editedTeacher : {},
    editedTeacherIsAE: false,
    classesConcernedByATeacher : [],
    confirm_primary_classe: false,
    confirmTeacherClasses: false,
    refusedTeacherClasses: false,
    teacherHasNewClasse: undefined,
    classesRefused : [],
    editedTeacherClasses : [],
    cl1: '',
    cl2: '',
    cl3: '',
    cl4: '',
    cl5: '',
    primaryTeachers : {},
    teachers: {},
    teachersAll: [], 
    teachersBlockedsAll: {},
    teachersBlockeds: {},
    TSBlockeds: [],
    TPBlockeds: [],
    alertTeachersSearch: 'Tous les enseignants'
}

export default teachers_states