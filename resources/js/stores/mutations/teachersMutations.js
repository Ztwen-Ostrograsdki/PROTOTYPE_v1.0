let months  = [
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

let getAge = function(theDate){
    let parts = (theDate.split("-")).reverse()
    let d = parseInt(parts[0], 10)
    let m = parseInt(parts[1], 10)
    let y = parseInt(parts[2], 10)
    let date = new Date(y, m, d)
    let diff = Date.now() - date.getTime()
    let age = new Date(diff)

    return Math.abs(age.getUTCFullYear() - 1970)

}

let getSubject = function(subject){
    if(subject === 'Physique-Chimie-Technologie'){
        return 'PCT'
    }
    else if (subject === 'Histoire-Géographie') {
        return 'Hist-Géo'
    }
    return subject
    
}
let birthday = function(user){
    let tab = {birthday: '', age: 0}
    let date = user.birth
    let parts = (date.split("-")).reverse()
    let day = parts[0]
    let m = (months[parts[1] - 1]).length > 5 ? (months[parts[1] - 1]).substring(0, 3) : months[parts[1] - 1]
    let year = parts[2]

    let theAge = getAge(date)


    tab = {birthday: day + " " + m + " " + year, age: theAge}

    return tab
}


const teachers_mutations = {

	GET_TEACHERS_DATA: (state, data) => {
        state.errors = data.errors
        state.user = data.user
        state.admin = data.admin
        state.teachers = data.t
        state.teachersAll = data.t
        state.AllTeachersWithSubject = data.allTWS
        state.AllTeachersWithClasses = data.allTWC
        state.secondaryTeachers = data.tSec
        state.primaryTeachers = data.tPrim
        state.tl = data.t.length
        state.tpl = data.tPrim.length
        state.tsl = data.tSec.length

        state.teachersBlockeds = data.tblockeds
        state.teachersBlockedsAll = data.tblockeds
        state.TSBlockeds = data.TSBlockeds
        state.TPBlockeds = data.TPBlockeds
        state.teachersBlockedsLength = data.tblockeds.length
        state.TBPLength = data.TBPLength
        state.TBSLength = data.TBSLength
    }, 

    GET_A_TEACHER_DATA: (state, data) => {
        state.editedTeacher = data.teacher
        state.targetedTeacher = data.teacher
        state.targetedTeacherFirstName = data.targetedTeacherFirstName
        state.targetedTeacherLastName = data.targetedTeacherLastName
        state.targetedTeacherBirthFMT = birthday(data.teacher).birthday
        state.targetedTeacherAge = birthday(data.teacher).age
        state.targetedTeacherSubject = getSubject(data.teacher.subject.name)
        state.targetedTeacherClassesFMT = data.targetedTeacherClassesFMT
        state.targetedTeacherClasses = data.classes

        state.editedTeacherClasses = data.classes
        state.classesConcernedByATeacher = data.classesConcerned
        state.classesRefused = data.classesRefused
        state.token = data.token
        state.editedTeacherIsAE = data.isAE
        
    },

    SET_EDITED_TEACHER_CLASSES: (state, classes) => {
        state.cl1 = classes.c1
        state.cl2 = classes.c2
        state.cl3 = classes.c3
        state.cl4 = classes.c4
        state.cl5 = classes.c5
    },

    UNSET_EDITED_TEACHER_CLASSES: (state) =>{
        state.cl1 = ''
        state.cl2 = ''
        state.cl3 = ''
        state.cl4 = ''
        state.cl5 = ''
    },

    RESET_EDITED_TEACHER_CLASSES1_CONFIRM: (state) => {
        state.teacherHasNewClasse = undefined
        state.confirm_primary_classe = false
    },
    SET_EDITED_TEACHER_CLASSES1_CONFIRM: (state, data) =>{
        state.teacherHasNewClasse = data
        state.confirm_primary_classe = true
    },

    SET_CLASSES_CONFIRM: (state, data) =>{
        state.confirmTeacherClasses = data
    },
    RESET_CLASSES_CONFIRM: (state, data) =>{
        state.confirmTeacherClasses = false
    },

    UPDATE_EDITED_TEACHER: (state, teacher) => {
        state.editedTeacher = teacher
    },
    UPDATE_TARGET_TEACHER: (state, object) => {
        state.targetTeacher = object.teacher
        state.targetTeacherBirthFMT = object.dataFMT.birth
        state.targetTeacherFirstName = object.dataFMT.fist
        state.targetTeacherLastName = object.dataFMT.last
    },
    GET_A_TARGETED_TEACHER: (state, data) => {
        state.token = data.token
        state.targetedTeacher = data.targetedTeacher
    },
    SET_EDITED_TEACHER: (state, teacher) => {
        state.editedTeacher = teacher
    },

    RESET_NEW_TEACHER: (state) => {
        state.newTeacher = {
            name: '',
            birth: '',
            sexe: '',
            level: 'secondary',
            month: '',
            year: (new Date).getFullYear(),
        }
    },
    
    RESET_EDITED_TEACHER: (state) => {
        state.editedTeacher = {}
    },

    RESET_ALERT_CLASSE_DETACH: (state, data) =>{
        state.classeDetachAlert = {status: data.status, msg: data.msg}
    },


    SHOW_TEACHERS_BY_LEVEL: (state, level, notBlockedSpace = true) => {
        if(notBlockedSpace == true){
            if(level == 'secondary'){
                state.teachers = state.secondaryTeachers
                state.alertTeachersSearch = "Les enseignants du secondaire"
            }
            else if (level == 'primary') {
                state.teachers = state.primaryTeachers
                state.alertTeachersSearch = "Les enseignants du primaire"
            }
            else if (level == 'all') {
                state.teachers = state.teachersAll
                state.alertTeachersSearch = "Tous les apprenants"  
            }
        }
        else{
            if(level == 'secondary'){
                state.teacherBlockeds = state.TSBlockeds
                state.alertTeachersSearch = "Les enseignants du secondaire"
            }
            else if (level == 'primary') {
                state.teacherBlockeds = state.TPBlockeds
                state.alertTeachersSearch = "Les enseignants du primaire"
            }
            else if (level == 'all') {
                state.teacherBlockeds = state.teacherBlockedsAll
                state.alertTeachersSearch = "Tous les enseignants"  
            }
        }
        
    }
}

export default teachers_mutations