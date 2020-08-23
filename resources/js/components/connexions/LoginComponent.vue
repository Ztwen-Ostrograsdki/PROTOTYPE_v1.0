<template>
	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true" style="top: 100px">
  		<div class="modal-dialog modal-lg" role="document" style="background-image: url(/media/silouhette.jpg) !important; width: 100%; background-position: -200px -400px; padding: 0px;">
	    	<div class="bg-linear-official-50 modal-content" style="border-style: solid; border-radius: 0;">
		    	<span class="d-inline-block text-white close py-2 px-3 align-self-end modalCloser" data-dismiss="modal" aria-label="Close" >x</span>
		      	<div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
			        <div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
		                <h4 class="modal-title w-100 mb-0 text-left pr-2" v-if="noUser">Connection</h4>
		                <h4 class="modal-title w-100 mb-0 text-left pr-2" v-if="!noUser">Connection réussie <span class="fa fa-circle text-success ml-3 mt-2" style="font-size: 10px"></span></h4>
		            </div>
		      	</div>
	      		<div class="modal-body">
	      		<h5 class="w-100 mx-auto p-1 h5-title text-danger text-center" v-if="invalidInputs !== undefined">
	      			{{ invalidInputs }}
	      		</h5>
		        <form class="opac-form" id="login-form" method="post">
		        	<div class="mx-auto mt-2 d-flex justify-content-between" style="width: 93%">
                        <div class="mx-auto w-100">
                            <label for="log_add" class="m-0 p-0">Adresse E-mail</label>
                            <input type="text" class="m-0 p-0 form-control p-1" :class="emailIsValid()" name="add" id="log_add" placeholder="Veuillez renseigner votre adresse électronique" v-model="valideAdd">
                            <i class="h5-title" v-if="wrongAdd"> L'adresse que vous renseigner est invalide </i>
                        </div>
                    </div>
                    <div class="mx-auto mt-2 d-flex justify-content-between" style="width: 93%">
                        <div class="mx-auto w-100">
                            <label for="log_pwd" class="m-0 p-0">Mot de Passe</label>
                            <input type="password" class="m-0 p-0 form-control p-1" :class="getInvalids(invalidInputs)" name="pwd" id="log_pwd" placeholder="Veuillez renseigner votre mot de passe" v-model="password">
                        </div>
                        
                    </div>
			    </form>
	      		</div>
			    <div class="mx-auto mt-2 p-1 pb-2 buttons-div" style="width: 93%">
			        <button type="button" class="btn btn-primary w-25 float-right" @click="login()">Se connecter</button>
			        <button type="button" class="btn btn-secondary w-25 mx-1 float-right" data-dismiss="modal">Annuler</button>
			    </div>
			    <div class="mx-auto mt-2 p-1 pb-2 div-success" style="width: 85%; display: none">
			    	<div class="d-flex justify-content-center w-100 p-2 my-1">
			    		<div class="text-center">
			    			<span class="fa fa-user text-primary" style="font-size: 30px"></span>
			    			<h4 class="d-block"></h4>
			    		</div>
			    	</div>
			        <div class="w-75 mx-auto d-flex justify-content-center">
			        	<button type="button" class="btn w-50 bg-transparent border shadow mx-1 px-1" data-dismiss="modal">Terminer</button>
			        </div>
			    </div>
	    	</div>
	  	</div>
	</div>
</template>

<script>
	import { mapState } from 'vuex'
	
	export default{
		data(){
			return {
				valideAdd: '',
				password: '',
				wrongAdd: false
			}
		},
		created(){

        },

		
		methods: {

			
			getYears(){
				let $tab = []
				let now = (new Date).getFullYear()
				for (var i = 1995; i <= now; i++) {
					$tab.push(i)
				}
				return $tab
			},
			getInvalids(invalids = this.invalidInputs){

				if(invalids !== undefined){
					return 'is-invalid'
				}
				else{
					return ''
				}
				
			},
			emailIsValid(){
				if(this.valideAdd !== ""){
					if(this.addresses[this.valideAdd] !== undefined){
						this.wrongAdd = false
						return ""
					}
					this.wrongAdd = true
					return 'is-invalid'
				}
				else{
					this.wrongAdd = false
					return ""
				}
				
				
			},

			login(){
				if(!this.wrongAdd){
					this.$store.dispatch('login', {email: this.valideAdd, password: this.password})
				}
			}
			
		},

		computed: mapState([
            'newTeacher', 'invalidInputs', 'successed', 'token', 'errors', 'months', 'users', 'addresses', 'loginNotif', 'noUser'
        ]),



	}



</script>

<style>
	input + i, select + i{
		color: rgb(160, 0, 0);
		font-style: normal;
		text-shadow: 0 1px 1px gray;
	}
</style>

