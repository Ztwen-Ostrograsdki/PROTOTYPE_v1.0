const selfMonths = [
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

const helpers = {
	methods: {

		birthday(user, limit = 3){
			let m
	        let date = user.birth
	        let parts = (date.split("-")).reverse()
	        let day = parts[0]

	        if(limit > 5 || limit == 0){
	        	m = (selfMonths[parts[1] - 1]).length > 5 ? (selfMonths[parts[1] - 1]) : selfMonths[parts[1] - 1]
	        }
	        else{
	        	m = (selfMonths[parts[1] - 1]).length > 5 ? (selfMonths[parts[1] - 1]).substring(0, limit) : selfMonths[parts[1] - 1]

	        }
	        
	        let year = parts[2]

	        return day + " " + m + " " + year
		}
	}
}

const averageComputor = function(subject, marks = []){
	if(marks[subject.id] !== undefined){
		let typeEpe = "epe"
		let all = []
		let som = 0

		let APEAgvValidate = 0
		let devoirs = []
		let devoirsSom = 0

		let type = "devoirs"
		for (var i = 0; i < marks[subject.id][typeEpe].length; i++) {
			if(marks[subject.id][typeEpe][i] !== undefined && marks[subject.id][typeEpe][i] !== 0 && marks[subject.id][typeEpe][i] !== '0' && marks[subject.id][typeEpe][i] !== null){
				all.push(marks[subject.id][typeEpe][i].value)
			}
		}
		for (var i = 0; i < all.length; i++) {
			som += all[i]
		}
		if(som !== 0){
			APEAgvValidate = som / all.length
		}
		else{
			APEAgvValidate = 0
		}

		for (var i = 0; i < marks[subject.id][type].length; i++) {
			if(marks[subject.id][type][i] !== undefined && marks[subject.id][type][i] !== 0 && marks[subject.id][type][i] !== '0' && marks[subject.id][type][i] !== null){
				devoirs.push(marks[subject.id][type][i].value)
			}
		}
		for (var i = 0; i < devoirs.length; i++) {
			devoirsSom += devoirs[i]
		}
		return devoirs.length !== 0 ? Number.parseFloat((devoirsSom + APEAgvValidate) / (devoirs.length + 1)).toFixed(2): APEAgvValidate
	}
	return "-"
	
}

export default averageComputor