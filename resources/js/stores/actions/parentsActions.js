const parents_actions = {
	
	getParentsData: (store) => {
		axios.get('/admin/director/parentsm/auth/get&all&parents')
            .then(response => {
             	store.commit('RESET_ALL_PARENTS_ARRAY', response.data)
        })
	},

	addNewParentForTargetedPupil: (store) => {
		store.dispatch('getParentsData')
	},

	createNewParent: (store, inputs) => {
		axios.post('/admin/director/parentsm', {
            token: inputs.token,
            name: inputs.newParent.name,
            birth: inputs.newParent.birth,
            email: inputs.newParent.email,
            works: inputs.newParent.works,
            contact: inputs.newParent.contact,
            residence: inputs.newParent.residence,
            sexe: inputs.newParent.sexe,
            status: 0
        })
		.then(response => {
			if(response.data.invalidInputs == undefined){
				if(inputs.route !== undefined && inputs.route !== null){
					if(inputs.route.name == 'pupilsProfil'){
						// store.commit('RESET_ALL_PARENTS_ARRAY', response.data)
						store.commit('RESET_PARENT_TO_PUPIL', {identify: inputs.newParent.email, relation: 'Père'})
						
						$('#newParentModal .buttons-div').hide('size', function(){
				            $('#newParentModal form').hide('fade', function(){
				                $('#newParentModal').animate({
				                    top: '50'
				                }, function(){
				                    $('#newParentModal .div-continue').show('fade', 200)
				                })
				                
				            })
				            
				        })
					}
					
				}
			}
			else{
                store.commit('INVALID_INPUTS', response.data.invalidInputs)
            }
			
		})
		
	},



	updateTargetedPupilParents: (store, inputs) =>{
		axios.post('/admin/director/parentsm/myChildren/related&to/' + inputs.route.params.id + '/joined', {
            token: inputs.token,
            identify: inputs.parentToPupil.identify,
            relation: inputs.parentToPupil.relation,
            pupil: inputs.pupil.id,
        })
		.then(response => {
			if(response.invalidInputs == undefined){
				store.commit('RESET_INVALID_INPUTS')
				store.dispatch('resetTargetedPupil', inputs.route.params.id)
				$('#editPupilParentsModal .buttons-div').hide('size', function(){
		            $('#editPupilParentsModal form').hide('fade', function(){
		                $('#editPupilParentsModal').animate({
		                    top: '90'
		                }, function(){
		                    $('#editPupilParentsModal .div-success').show('fade', 200)
		                    $('#editPupilParentsModal .div-success h4').text('Mise à jour réussie')
		                })
		                
		            })
		            
		        })
			}
			else{
				store.commit('INVALID_INPUTS', response.data.invalidInputs)
			}
			
		})
		
	}



}


export default parents_actions