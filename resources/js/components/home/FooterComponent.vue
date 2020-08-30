<template>
	<div class="w-100 m-0 p-0">
		<div class="w-100 m-0 p-2 bg-linear-official-180 border border-warning">
			<p>je suis le footer</p>
		</div>
	</div>
</template>


<script>
	import { mapState } from 'vuex'
	export default{

		data(){
			return {
				
			}
		},

		created(){
			
        },
		computed: mapState([
            'user', 'admin', 'errors', 'userSettings', 'logout', 'users', 'loginNotif'
        ])

	}
</script>

<style>
	
</style>