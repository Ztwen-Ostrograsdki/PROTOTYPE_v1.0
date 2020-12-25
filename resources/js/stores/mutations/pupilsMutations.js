let months = [
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


let formattor = function(string) {
    if(string == 'Physique-Chimie-Technologie'){
        return 'PCT'
    }
    else if (string == 'Histoire-Géographie') {
        return 'Hist-Géo'
    }
    else{
        return string
    }
}

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
const pupils_mutations = {

	GET_PUPILS_DATA: (state, data) => {
        state.errors = data.errors
        state.user = data.user
        state.admin = data.admin
		state.pupils = data.p
		state.pupilsAll = data.p
		state.pupilsArray = data.all
		state.secondaryPupils = data.pSec
		state.primaryPupils = data.pPrim
        state.pl = data.p.length
        state.ppl = data.pPrim.length
        state.psl = data.pSec.length

        state.pupilsBlockeds = data.pblockeds
        state.pupilsBlockedsAll = data.pblockeds
        state.PSBlockeds = data.PSBlockeds
        state.PPBlockeds = data.PPBlockeds
        state.pupilsBlockedsLength = data.pblockeds.length
        state.PBPLength = data.PBPLength
        state.PBSLength = data.PBSLength
	}, 

    GET_A_PUPIL_DATA: (state, data) => {
        state.targetPupilParents = data.pupilParents
        state.editedPupil = data.p
        state.targetPupil = data.p
        state.editedPupilSubjects = data.subjects
        state.editedPupilCoefTables = data.coefTables
        state.token = data.token
        state.targetPupilClasseFMT = data.classeFMT

        state.targetPupilBirthFMT = birthday(data.p).birthday
        state.targetPupilAge = birthday(data.p).age
    },

    SET_TARGET_PUPIL_MARKS: (state, data) =>{

        state.targetPupilMarks = data.data.marks
        state.trimestre = data.trimestre
        state.targetPupilPercentageSuccedMarks = data.data.percentage

        state.targetPupilLastMark = data.data.last['mark'] == null ? undefined : data.data.last['mark'].value
        state.targetPupilBestMark = data.data.best['mark'] == null ? undefined : data.data.best['mark'].value
        state.targetPupilWeakMark = data.data.weak['mark'] == null ? undefined : data.data.weak['mark'].value
        state.targetPupilLastMarkSuject = formattor(data.data.last['subject'])
        state.targetPupilBestMarkSuject = formattor(data.data.best['subject'])
        state.targetPupilWeakMarkSuject = formattor(data.data.weak['subject'])

        
    },
    SET_EDITED_PUPIL_SUBJECTS: (state, data) =>{
        state.editedPupilSubjects = data.subjects
    },
    UPDATE_EDITED_PUPIL: (state, pupil) => {
        state.editedPupil = pupil
    },
    UPDATE_TARGET_PUPIL: (state, object) => {
        state.targetPupil = object.pupil
        state.targetPupilClasseFMT = object.dataFMT.classe
        state.targetPupilBirthFMT = object.dataFMT.birth
        state.targetPupilFirstName = object.dataFMT.first
        state.targetPupilLastName = object.dataFMT.last
        state.targetPupilBirthFMT = birthday(object.pupil).birthday
        state.targetPupilAge = birthday(object.pupil).age
    },
    SET_EDITED_PUPIL: (state, pupil) => {
        state.editedPupil = pupil
    },

    RESET_NEW_PUPIL: (state) => {
        state.newPupil = {
            name: '',
            classe_id: '',
            birth: '',
            sexe: '',
            level: 'secondary',
            month: '',
            year: (new Date).getFullYear(),
        }
    },
    
    RESET_EDITED_PUPIL: (state) => {
        state.editedPupil = {}
    },
    RESET_TARGETED_PUPIL_SUBJECT_MARKS: (state, subject) =>{
        state.editedPupilSubjectMarks = subject
    },


	SHOW_PUPILS_BY_LEVEL: (state, data) => {
		if(data.blockedSpace == false){
            if(data.level == 'secondary'){
                state.pupils = state.secondaryPupils
                state.alertPupilsSearch = "Les eleves du secondaire"
            }
            else if (data.level == 'primary') {
                state.pupils = state.primaryPupils
                state.alertPupilsSearch = "Les eleves du primaire"
            }
            else if (data.level == 'all') {
                state.pupils = state.pupilsAll
                state.alertPupilsSearch = "Tous les apprenants"  
            }
        }
        else{
            if(data.level == 'secondary'){
                state.pupilsBlockeds = state.PSBlockeds
                state.alertPupilsSearch = "Les eleves du secondaire"
            }
            else if (data.level == 'primary') {
                state.pupilsBlockeds = state.PPBlockeds
                state.alertPupilsSearch = "Les eleves du primaire"
            }
            else if (data.level == 'all') {
                state.pupilsBlockeds = state.pupilsBlockedsAll
                state.alertPupilsSearch = "Tous les apprenants"  
            }
        }
        
	}
}

export default pupils_mutations