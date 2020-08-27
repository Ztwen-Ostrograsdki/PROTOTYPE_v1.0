<template>
	<div class="w-100 m-0 p-0" style="z-index: 3000">
		<home-nav></home-nav>
		<login></login>
	</div>
</template>


<script>
	import { mapState } from 'vuex'
	export default{

		data(){
			return {
				isConnected: false
			}
		},

		created(){
			axios.post('/admin/director/master/getCurrentUser&auth')
			.then(response => {
				if (response.data) {
					this.$store.dispatch('getCounter')
            		this.$store.dispatch('getTOOLS')
				}
				
			}) 
            
            
        },
		computed: mapState([
            'user', 'admin', 'errors', 'userSettings', 'logout', 'users', 'loginNotif'
        ])

	}
</script>

<style>
	
</style>