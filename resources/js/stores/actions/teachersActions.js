const teachers_actions = {
	getTeachersData: (store) => {
		axios.get('/admin/director/teachersm/DATA&for&teachers')
            .then(response => {
             	store.commit('GET_TEACHERS_DATA', response.data)
        })
	},
    getATeacherData: (store, teacher) => {
        let id = null
        id = !isNaN(teacher) ? teacher : teacher.id
        
        axios.get('/admin/director/teachersm/get&classes&of&teacher&with&data&credentials/id=' + id)
            .then(response => {
                store.commit('GET_A_TEACHER_DATA', response.data)
            })
            .catch(e => {
               store.commit('ALERT_MAKER', "L'opération a échoué: Echec de connexion au serveur! Veuillez réessayer!")
            })
    },
    updateTeacherClasses: (store, inputs) => {
        if(inputs.teacher.level == "secondary"){
        	axios.put('/admin/director/teachersm/update/update&classes&with&authorization/id=' + inputs.teacher.id, {
	        	token: inputs.token,
	        	classe1: parseInt(inputs.classes.c1, 10),
	        	classe2: parseInt(inputs.classes.c2, 10),
	        	classe3: parseInt(inputs.classes.c3, 10),
	        	classe4: parseInt(inputs.classes.c4, 10),
	        	classe5: parseInt(inputs.classes.c5, 10)
	        })
	        .then(response => {
	        	store.commit('RESET_INVALID_INPUTS')
	            store.commit('GET_TEACHERS_DATA', response.data)

                $('#editTeacherClassesModal .buttons-div').hide('size', function(){
                    $('#editTeacherClassesModal form').hide('fade', function(){
                        $('#editTeacherClassesModal').animate({
                            top: '150'
                        }, function(){
                            $('#editTeacherClassesModal .div-success').show('fade', 200)
                            $('#editTeacherClassesModal .div-success h4').text('Mise à jour reussi')
                        })
                        
                    })
                    
                })

                if(inputs.route !== undefined && inputs.route.name == "teachersProfil"){
                    let id = inputs.route.params.id
                    store.dispatch('getATeacherData', id)
                }
                
	        })
        }
        else if(inputs.teacher.level == "primary"){
        	axios.put('/admin/director/teachersm/update/update&classes&with&authorization/id=' + inputs.teacher.id, {
	        	token: inputs.token,
	        	classe: parseInt(inputs.classes.classe, 10)
	        })
	        .then(response => {
	        	store.commit('RESET_INVALID_INPUTS')
	            store.commit('GET_TEACHERS_DATA', response.data)


                $('#editTeacherClassesModal .buttons-div').hide('size', function(){
                    $('#editTeacherClassesModal form').hide('fade', function(){
                        $('#editTeacherClassesModal').animate({
                            top: '150'
                        }, function(){
                            $('#editTeacherClassesModal .div-success').show('fade', 200)
                            $('#editTeacherClassesModal .div-success h4').text('Mise à jour reussi')
                        })
                        
                    })
                    
                })

                if(inputs.route !== undefined && inputs.route.name == "teachersProfil"){
                    let id = inputs.route.params.id
                    store.dispatch('getATeacherData', id)
                }
	        })
        }
        
       
           
    },
    updateATeacherData: (store, inputs) => {

    	
    	console.log(inputs)
        // axios.put('/admin/director/teachersm/update/update&perso/id=' + inputs.teacher.id, {
        //     // token: inputs.token,
        //     // name: inputs.pupil.name,
        //     // birth: inputs.pupil.birth,
        //     // classe_id: inputs.pupil.classe_id,
        //     // month: inputs.pupil.month,
        //     // year: inputs.pupil.year,
        //     // sexe: inputs.pupil.sexe
        // })
        // .then(response => {
        //     if(response.data.invalidInputs == undefined){
        //         store.commit('RESET_INVALID_INPUTS')
        //         store.commit('GET_TEACHERS_DATA', response.data)
        //         store.commit('UPDATE_TARGET_TEACHER', {})
        //         store.commit('SUCCESSED', 'Mis à jour des données réussie')
                
        //         $('#exampleModal .buttons-div').hide('size', function(){
        //             $('#exampleModal form').hide('fade', function(){
        //                 $('#exampleModal').animate({
        //                     top: '150'
        //                 }, function(){
        //                     $('#exampleModal .div-success').show('fade', 200)
        //                     $('#exampleModal .div-success h4').text('Mise à jour reussi')
        //                 })
                        
        //             })
                    
        //         })
                
        //     }
        //     else{
        //         store.commit('INVALID_INPUTS', response.data.invalidInputs)
        //     }
            
        // })
        // .catch(e => {
        //    store.commit('ALERT_MAKER', "L'opération a échoué: Echec de connexion au serveur! Veuillez réessayer!")
        // })
    },
    addANewTeacher: (store, inputs) => {
        axios.post('/admin/director/teachersm', {
            token: inputs.token,
            name: inputs.newTeacher.name,
            route: inputs.route.path,
            email: inputs.newTeacher.email,
            contact: inputs.newTeacher.contact,
            subject_id: inputs.newTeacher.subject_id,
            birth: inputs.newTeacher.birth,
            level: inputs.newTeacher.level,
            month: inputs.newTeacher.month,
            year: inputs.newTeacher.year,
            sexe: inputs.newTeacher.sexe,
            residence: inputs.newTeacher.residence,
            creator: inputs.newTeacher.creator,
            authorized: inputs.newTeacher.authorized,
            status: 0
        })
        .then(response => {
            if(response.data.invalidInputs == undefined){
                store.commit('RESET_INVALID_INPUTS')
                store.commit('GET_TEACHERS_DATA', response.data)
                store.commit('RESET_NEW_TEACHER')
                store.commit('SUCCESSED', 'Insertion des données réussie')
                
                $('#newTeacherModal .buttons-div').hide('size', function(){
                    $('#newTeacherModal form').hide('fade', function(){
                        $('#newTeacherModal').animate({
                            top: '150'
                        }, function(){
                            $('#newTeacherModal .div-success').show('fade', 200)
                            $('#newTeacherModal .div-success h4').text("Création de l'enseignant réussie!")
                        })
                        
                    })
                    
                })
                
            }
            else{
                store.commit('INVALID_INPUTS', response.data.invalidInputs)
            }
            
        })
        .catch(e => {
           // store.commit('ALERT_MAKER', "L'opération a échoué: Echec de connexion au serveur! Veuillez réessayer!")
        })
    },

	lazyDeleteTeachers: (store, teacher) => {
		axios.delete('/admin/director/teachersm/' + teacher.id)
             .then(response => {
            	store.commit('GET_TEACHERS_DATA', response.data)
                store.commit('ALERT_MAKER', "L'enseignant " + teacher.name + " a été envoyé dans la corbeille avec succès!")
            	
        })
	},
    disjoinedClasses: (store, data) => {
        axios.delete('/admin/director/teachersm/disjoined&classe&with&this&teacher/t=' + data.teacher.id + '/c=' + data.classe.id)
            .then(response => {
                if(response.data.success !== undefined){
                    store.commit('RESET_ALERT_CLASSE_DETACH', {status: true, msg: response.data.success})
                }
                else if (response.data.failed !== undefined) {
                    store.commit('RESET_ALERT_CLASSE_DETACH', {status: true, msg: response.data.failed})
                }
                
                // store.commit('GET_TEACHERS_DATA', response.data)

                if(data.route !== undefined && data.route.name == "teachersProfil"){
                    let id = parseInt(data.route.params.id, 10)
                    store.dispatch('getATeacherData', id)
                }
                
        })
    },

    restoreTeacher: (store, teacher) => {
        // axios.put('/admin/director/teachersm/restore/id=' + teacher.id)
        //     .then(response => {
        //         store.commit('GET_TEACHERS_DATA', response.data)
        //         store.commit('ALERT_MAKER', "L'enseignant " + teacher.name + " a été restauré avec succès!")
        //     })
        //     .catch(e => {
        //        store.commit('ALERT_MAKER', "L'opération a échoué: Echec de connexion au serveur! Veuillez réessayer!")
        //     })
    }

}

export default teachers_actions