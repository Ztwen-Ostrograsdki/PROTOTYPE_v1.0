<template>
	<div class="w-100 m-0 p-0">
		<div class="w-100 m-0 p-2 bg-linear-official-180 border border-warning">
			<div class="w-100 m-0 p-0">
				<div class="d-flex justify-content-between px-2">
					<div class="w-25">
						<span class="cursive mx-1">Nous suivre</span>
						<span class="fa fa-chevron-right mr-1"></span>
						<span class="fa fa-facebook-square mx-1"></span>
						<span class="fa fa-telegram mx-1"></span>
						<span class="fa fa-twitter mx-1 text-primary"></span>
						<span class="fa fa-whatsapp mx-1 text-success"></span>
						<span class="fa fa-youtube mx-1 text-danger"></span>
						<span class="fa fa-phone mx-1 text-dark"></span>
					</div>
				</div>
			</div>
			<div class="w-100 m-0 p-0 mt-1 d-flex justify-content-center">
				<span class="cursive text-white-50">
					Le Complexe Scolaire LA PRUNELLE, c'est la Joie au travail et la Réussite assurée!
				</span>
			</div>
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