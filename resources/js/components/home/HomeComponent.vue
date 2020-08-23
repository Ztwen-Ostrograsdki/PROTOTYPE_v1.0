<template>
	<div class="w-100 m-0 p-0">
		<home-nav></home-nav>
		<transition name="fade">
			<div class="position-absolute" style="right: 2px; top: 70px; width: 15%; background-image: url(/media/img/art-2578353_1920.jpg) !important;" v-if="userSettings">
				<user-main></user-main>
			</div>
		</transition>
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