<template>
	<div class="modal fade" id="newParentModal" tabindex="-1" role="dialog" aria-labelledby="newParentModalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-lg" role="document" style="background-image: url(/media/silouhette.jpg) !important; width: 100%; background-position: -200px -400px; padding: 0px;">
	    	<div class="bg-linear-official-50 modal-content" style="border-style: solid; border-radius: 0;">
		    	<span class="d-inline-block text-white close py-2 px-3 align-self-end modalCloser" data-dismiss="modal" aria-label="Close" @click="resetNewParent()">x</span>
		      	<div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
			        <div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
		                <h4 class="modal-title w-100 mb-0 text-left pr-2">Ajout d'un parent d'apprenant</h4>
		            </div>
		      	</div>
	      		<div class="modal-body">
	      		<h5 class="w-100 mx-auto p-1 h5-title text-danger text-center" v-if="invalidInputs !== undefined">
	      			Le formulaire est invalid
	      		</h5>
		        <form class="opac-form" id="add-parent" method="post">
		        	<input type="text" name="token" v-model="token" hidden="hidden">
		        	<div class="mx-auto mt-2 d-flex justify-content-between" style="width: 93%">
                        <div class="mx-auto" style="width: 69%">
                            <label for="add_parent_name" class="m-0 p-0">Nom et Prénoms du parent</label>
                            <input type="text" class="m-0 p-0 form-control p-1" name="name" id="add_parent_name" placeholder="Veuillez renseigner le nom et les prénoms du parent">
                            
                        </div>
                        <div style="width: 30%;">
                            <label for="" class="m-0 p-0">Le Sexe</label>
                            <select v-model.lazy="newParent.sexe" name="sexe" id="add_parent_sexe" class="custom-select" :class="getInvalids('sexe', invalidInputs)">
                                <option value="">Choisir le sexe</option>
                                <option value="male" >Masculin</option>
                                <option value="female">Féminin</option>
                            </select>
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.sexe !== undefined"> {{ invalidInputs.sexe[0] }} </i>
                        </div>
                    </div>
			        <div class="mx-auto mt-2 d-flex justify-content-between" style="width: 93%">
                        <div class="mx-auto" style="width: 49%">
                            <label for="add_parent_email" class="m-0 p-0">Adresse électronique du parent</label>
                            <input type="email" class="m-0 p-0 form-control p-1" name="email" id="add_parent_email" placeholder="Veuillez renseigner l'adresse électronique du parent">
                        </div>
                        <div class="mx-auto" style="width: 49%">
                            <label for="add_parent_contact" class="m-0 p-0">Contacts du parent</label>
                            <input type="text" class="m-0 p-0 form-control p-1" name="contact" id="add_parent_contact" placeholder="Veuillez renseigner les contacts du parent les séparer par un /">
                        </div>
                    </div>
                    <div class="mx-auto mt-2 d-flex justify-content-between" style="width: 93%">
                        <div class="mx-auto" style="width: 33.3%">
                            <label for="add_parent_residence" class="m-0 p-0">Localité du parent</label>
                            <input type="text" class="m-0 p-0 form-control p-1" name="residence" id="add_parent_residence" placeholder="Veuillez renseigner la localité du parent">
                        </div>
                        <div class="mx-auto" style="width: 33.3%">
                            <label for="add_parent_works" class="m-0 p-0">Fonction du parent</label>
                            <input type="text" class="m-0 p-0 form-control p-1" name="works" id="add_parent_works" placeholder="Veuillez renseigner la fonction du parent">
                        </div>
                        <div class="mx-auto" style="width: 32%">
                            <label for="add_parent_birth" class="m-0 p-0">Date de naissance du parent</label>
                            <input type="date" class="m-0 p-0 form-control p-1" name="works" id="add_parent_birth" placeholder="Veuillez renseigner la date de naissance du parent">
                        </div>
                    </div>
			    </form>
	      		</div>
			    <div class="mx-auto mt-2 p-1 pb-2 buttons-div" style="width: 93%">
			        <button type="button" class="btn btn-primary w-25 float-right">Inserer</button>
			        <button type="button" class="btn btn-secondary w-25 mx-1 float-right" data-dismiss="modal">Annuler</button>
			    </div>
			    <div class="mx-auto mt-2 p-1 pb-2 div-success" style="width: 93%; display: none">
			    	<div class="d-flex justify-content-center w-100 p-2 my-1">
			    		<h4></h4>
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
				show: true,
			}
		},
		created(){
            this.$store.dispatch('getParentsData')
        },

		
		methods: {

			resetNewParent(){
				this.$store.commit('RESET_NEW_PARENT')
			},
			createNewParent(token){
				let newParent = this.newParent
				this.$store.dispatch('createNewParent', {newParent, token})
			},
			getInvalids(input, invalids = this.invalidInputs){

				if(invalids !== undefined && invalids[input] !== undefined){
					return 'is-invalid'
				}
				else{
					return ''
				}
			}
			
		},

		computed: mapState([
            'newParent', 'invalidInputs', 'successed', 'token', 'allParents'
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

