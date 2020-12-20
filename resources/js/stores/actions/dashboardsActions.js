const dashboards_actions = {
	getHoraires: (state, year) => {
        axios.get('/admin/director/master/dashbords/data&emploi&du&temps/all&data/year=' + year)
			.then(response => {
				state.commit('GET_HORAIRES', response.data)
			})      
	},

	resetHoraires: (state, data) => {
		axios.delete('/admin/director/master/dashbords/reset&horaires/reset&now/reset', {
				classe: data.classe,
				year: data.year
			})
            .then(response => {
            	console.log(response.data)
    //         	state.dispatch('getTOOLS')
				// state.dispatch('getHoraires', 2020)
        })
	},

	addANewHoraire: (store, inputs) => {
        axios.post('/admin/director/master/dashbords/data&emploi&du&temps/all&data', {
            token: inputs.token,
            year: inputs.newHoraire.year,
        })
        .then(response => {
            if(response.data.invalidInputs == undefined){
                store.commit('RESET_INVALID_INPUTS')
                store.commit('GET_CLASSES_DATA', response.data)
                store.commit('RESET_NEW_HORAIRE', {
                	start: 7,
				    end: 8,
			        classe_id: null,
			        subject_id: null,
			        level: 'secondary',
			        year: (new Date).getFullYear(),
                })
                store.commit('SUCCESSED', 'Insertion des données réussie')
                
                $('#newHoraireModal .buttons-div').hide('size', function(){
                    $('#newHoraireModal form').hide('fade', function(){
                        $('#newHoraireModal').animate({
                            top: '90'
                        }, function(){
                            $('#newHoraireModal .div-success').show('fade', 200)
                            $('#newHoraireModal .div-success h4').text('Mise à jour réussie')
                        })
                        
                    })
                    
                })
                
            }
            else{
                store.commit('INVALID_INPUTS', response.data.invalidInputs)
            }
            
        })
        .catch(e => {
           store.commit('ALERT_MAKER', "L'opération a échoué: Echec de connexion au serveur! Veuillez réessayer!")
        })
    },


}


export default dashboards_actions