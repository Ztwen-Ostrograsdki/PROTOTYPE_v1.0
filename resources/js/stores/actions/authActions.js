const auth_actions = {
	logout: (state) => {
        axios.post('/admin/director/master/logout&user')
			.then(response => {
				state.commit('LOGOUT', response.data)
			})      
	},
	login: (state, user) => {
        axios.post('login/user&get&auth', user)
		.then(response => {
			if(response.data.invalidInputs == undefined){
				state.commit('RESET_INVALID_INPUTS')
				state.commit('SET_USER', response.data)
				$('#loginModal .buttons-div').hide('size', function(){
	                $('#loginModal form').hide('fade', function(){
		                $('#loginModal .div-success').show('fade', 200)
		                $('#loginModal .div-success h4').text('Vous êtes connecté')
	                })
	            })
			}
			else{
                state.commit('INVALID_INPUTS', response.data.invalidInputs)
            }
		})
		.catch(err => {
			console.log(err)
		})     
	},  
	getUsers: (state) => {
		axios.post('/admin/director/master/get&all&users')
			.then(response => {
				state.commit('GET_USERS', {users: response.data.users, addresses: response.data.addresses})
			})    
	},

}


export default auth_actions