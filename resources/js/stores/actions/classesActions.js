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
    getAClasseTeachersAndPupils: (store, id) => {
        axios.get('/admin/director/classesm/get&classe&data&on&teachers&pupils/id=' + id)
            .then(response => {
                store.commit('GET_A_CLASSE_TEACHERS', response.data.teachers)
                store.commit('GET_A_CLASSE_PUPILS', response.data.pupils)
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

    updateClasseModality: (store, inputs) =>{
        axios.post('/admin/director/classesm/update/modality/for&c=' + inputs.classe + '/s=' + inputs.subject + '/t=' + inputs.trimestre, {
            token: inputs.token,
            classe_id: parseInt(inputs.classe, 10),
            value: inputs.modality,
            subject_id: inputs.subject,
            trimestre: inputs.trimestre,
            year: (new Date).getFullYear()
        })
        .then(response => {
            store.commit('GET_A_CLASSE_DATA', response.data)
            store.commit('RESET_MODALITY_ALERT', {status: "updated", message: "Mise à jour réussie. Les " + inputs.modality + " meilleures notes seront prises en comptes"})
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

    editAClasseByPart: (store, data) => {
        let name = null
        if(data.tag == 'name'){
            name = data.inputs
        }
        axios.put('/admin/director/classesm/' + data.id , {
            token: data.token,
            tag: data.tag,
            inputs: data.inputs,
            name: name
        })
        .then(response => {
            if(response.data.invalidInputs == undefined){
                store.commit('RESET_INVALID_INPUTS')
                store.commit('GET_CLASSES_DATA', response.data)
                store.commit('SUCCESSED', 'Mise à jour des données réussie')
                
                $('#editClasseModal .buttons-div').hide('size', function(){
                    $('#editClasseModal form').hide('fade', function(){
                        $('#editClasseModal').animate({
                            top: '90'
                        }, function(){
                            $('#editClasseModal .div-success').show('fade', 200)
                            $('#editClasseModal .div-success h4').text('Mise à jour de la classe reussie')
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
    restoreClasses: (store, classe) => {
        axios.put('/admin/director/classesm/restore/id=' + classe.id)
            .then(response => {
                store.commit('GET_CLASSES_DATA', response.data)
                store.commit('ALERT_MAKER', "La classe " + classe.name + " a été restauré avec succès!")
            })
            .catch(e => {
               store.commit('ALERT_MAKER', "L'opération a échoué: Echec de connexion au serveur! Veuillez réessayer!")
            })
    }

}

export default classes_actions
