const pupils_actions = {
	getPupilsData: (store) => {
		axios.get('/admin/director/pupilsm/DATA&for&pupils')
             .then(response => {
             	store.commit('GET_PUPILS_DATA', response.data)
        })
	},
    getAPupilData: (store, pupil) => {
        axios.get('/admin/director/pupilsm/get&classe&of&pupil&with&data&credentials/id=' + pupil.id)
            .then(response => {
                store.commit('GET_A_PUPIL_DATA', response.data)
            })
            .catch(e => {
               store.commit('ALERT_MAKER', "L'opération a échoué: Echec de connexion au serveur! Veuillez réessayer!")
            })
    },
    getAPupilDataAndMarks: (store, pupil) => {
        axios.post('/admin/director/pupilsm/' + pupil.route + '/marks/index/trimestre/' + pupil.trimestre)
            .then(response => {
                store.commit('SET_TARGET_PUPIL_MARKS', {data: response.data, trimestre: pupil.trimestre})
            })
    },
    updateAPupilMarks: (store, inputs) => {
        axios.put('/admin/director/pupilsm/update/marks/update&marks/p=' + inputs.pupil.id + '&s=' + inputs.keys.subject + '&c=' + inputs.keys.classe , {
            epe1: inputs.notes.epe1,
            epe2: inputs.notes.epe2,
            epe3: inputs.notes.epe3,
            epe4: inputs.notes.epe4,
            epe5: inputs.notes.epe5,
            dev1: inputs.notes.dev1,
            dev2: inputs.notes.dev2,
            trimestre: inputs.trimestre,
            token: inputs.token
        })
        .then(response => {
            if(response.data.invalidInputs == undefined){
                store.commit('RESET_INVALID_INPUTS')

                $('#editPupilMarks .buttons-div').hide('size', function(){
                    $('#editPupilMarks form').hide('fade', function(){
                        $('#editPupilMarks').animate({
                            top: '150'
                        }, function(){
                            $('#editPupilMarks .div-success').show('fade', 200)
                            $('#editPupilMarks .div-success h4').text('Mise à jour des notes reussie')
                        })
                        
                    })
                })
                store.dispatch('getAPupilDataAndMarks', {route: inputs.pupil.id, trimestre: inputs.trimestre})
            }
            else{
                store.commit('INVALID_INPUTS', response.data.invalidInputs)
            }
        })
        
    },
    
    updateAPupilData: (store, inputs) => {
        axios.put('/admin/director/pupilsm/update/update&perso/id=' + inputs.pupil.id, {
            token: inputs.token,
            name: inputs.pupil.name,
            birth: inputs.pupil.birth,
            classe_id: inputs.pupil.classe_id,
            month: inputs.pupil.month,
            year: inputs.pupil.year,
            sexe: inputs.pupil.sexe
        })
        .then(response => {
            if(response.data.invalidInputs == undefined){
                store.commit('RESET_INVALID_INPUTS')
                store.commit('GET_PUPILS_DATA', response.data)
                store.commit('UPDATE_TARGET_PUPIL', {pupil: response.data.pupilEdited, dataFMT: {classe: response.data.classeFMT, birth: response.data.birthFMT, fist: response.data.firstName, last: response.data.lastName}})
                store.commit('SUCCESSED', 'Mis à jour des données réussie')

                if(inputs.route !== undefined && inputs.route.name == "classesProfil"){
                    let id = inputs.route.params.id
                    store.dispatch('getAClasseData', id)
                }
                
                
                $('#editPupilPersoModal .buttons-div').hide('size', function(){
                    $('#editPupilPersoModal form').hide('fade', function(){
                        $('#editPupilPersoModal').animate({
                            top: '150'
                        }, function(){
                            $('#editPupilPersoModal .div-success').show('fade', 200)
                            $('#editPupilPersoModal .div-success h4').text('Mise à jour reussi')
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
    addANewPupil: (store, inputs) => {
        axios.post('/admin/director/pupilsm', {
            token: inputs.token,
            name: inputs.newPupil.name,
            birth: inputs.newPupil.birth,
            level: inputs.newPupil.level,
            classe_id: inputs.newPupil.classe_id,
            month: inputs.newPupil.month,
            year: inputs.newPupil.year,
            sexe: inputs.newPupil.sexe,
            status: 0
        })
        .then(response => {
            if(response.data.invalidInputs == undefined){
                store.commit('RESET_INVALID_INPUTS')
                store.commit('GET_PUPILS_DATA', response.data)
                store.commit('RESET_NEW_PUPIL')
                store.commit('SUCCESSED', 'Insertion des données réussie')
                
                $('#newPupilPersoModal .buttons-div').hide('size', function(){
                    $('#newPupilPersoModal form').hide('fade', function(){
                        $('#newPupilPersoModal').animate({
                            top: '150'
                        }, function(){
                            $('#newPupilPersoModal .div-success').show('fade', 200)
                            $('#newPupilPersoModal .div-success h4').text('Mise à jour reussi')
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

	lazyDeletePupils: (store, pupil) => {
		axios.delete('/admin/director/pupilsm/' + pupil.id)
             .then(response => {
            	store.commit('GET_PUPILS_DATA', response.data)
                store.commit('ALERT_MAKER', "L'élève " + pupil.name + " a été envoyé dans la corbeille avec succès!")
            	
        })
	},

    restorePupils: (store, pupil) => {
        axios.put('/admin/director/pupilsm/restore/id=' + pupil.id)
            .then(response => {
                store.commit('GET_PUPILS_DATA', response.data)
                store.commit('ALERT_MAKER', "L'élève " + pupil.name + " a été restauré avec succès!")
            })
            .catch(e => {
               store.commit('ALERT_MAKER', "L'opération a échoué: Echec de connexion au serveur! Veuillez réessayer!")
            })
    }

}

export default pupils_actions
