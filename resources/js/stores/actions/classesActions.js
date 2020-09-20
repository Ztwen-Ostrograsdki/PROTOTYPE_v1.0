const classes_actions = {
	getClassesData: (store) => {
		axios.get('/admin/director/classesm/DATA&for&classes')
             .then(response => {
             	store.commit('GET_CLASSES_DATA', response.data)
        })
	},
    getAClasseData: (store, id) => {
        axios.get('/admin/director/classesm/get&classe&data&credentials/id=' + id)
            .then(response => {
                store.commit('GET_A_CLASSE_DATA', response.data)
            })
            .catch(e => {
               store.commit('ALERT_MAKER', "L'opération a échoué: Echec de connexion au serveur! Veuillez réessayer!")
            })
    },

    getAClasseMarks: (store, target) => {
        axios.post('/admin/director/classesm/c=' + target.classe + '/marks/s=' + target.subject + '/trimestre/t=' + target.trimestre + '/index')
            .then(response => {
                store.commit('RESET_TARGETED_CLASSE_MARKS', response.data)
            })
            .catch(e => {
               store.commit('ALERT_MAKER', "L'opération a échoué: Echec de connexion au serveur! Veuillez réessayer!")
            })
    },

    addANewClasse: (store, inputs) => {
        axios.post('/admin/director/classesm', {
            token: inputs.token,
            name: inputs.newClasse.name,
            level: inputs.newClasse.level,
            month: inputs.newClasse.month,
            year: inputs.newClasse.year,
        })
        .then(response => {
            if(response.data.invalidInputs == undefined){
                store.commit('RESET_INVALID_INPUTS')
                store.commit('GET_CLASSES_DATA', response.data)
                store.commit('RESET_NEW_CLASSE')
                store.commit('SUCCESSED', 'Insertion des données réussie')
                
                $('#newClasseModal .buttons-div').hide('size', function(){
                    $('#newClasseModal form').hide('fade', function(){
                        $('#newClasseModal').animate({
                            top: '90'
                        }, function(){
                            $('#newClasseModal .div-success').show('fade', 200)
                            $('#newClasseModal .div-success h4').text('Création de classe reussie')
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

    getOderer: (store, target) =>{
        axios.get('/admin/director/classesm/c=' + target.classe + '/marks&with&order/s=' + target.subject + '/trimestre/t=' + target.trimestre + '/ordering')
            .then(response => {
                store.commit('GET_A_CLASSE_DATA', response.data)
            })
            .catch(e => {
               store.commit('ALERT_MAKER', "L'opération a échoué: Echec de connexion au serveur! Veuillez réessayer!")
            })
    },
    lazyDeleteClasse: (store, classe) => {
        axios.delete('/admin/director/classesm/' + classe.id + '-' + classe.forced)
        .then(response => {
            store.commit('GET_CLASSES_DATA', response.data)
        })
    },

}

export default classes_actions
