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
		
	},



	updateTargetedPupilParents: (store) =>{


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



}


export default parents_actions