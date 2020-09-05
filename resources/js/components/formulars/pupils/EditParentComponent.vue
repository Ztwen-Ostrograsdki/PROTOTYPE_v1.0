<template>
	<div class="modal fade" id="editPupilParentsModal" tabindex="-1" role="dialog" aria-labelledby="editPupilParentsModalLabel" aria-hidden="true">
  		<div class="modal-dialog modal-lg" role="document" style="background-image: url(/media/silouhette.jpg) !important; width: 100%; background-position: -200px -400px; padding: 0px;">
	    	<div class="bg-linear-official-50 modal-content" style="border-style: solid; border-radius: 0;">
		    	<span class="d-inline-block text-white close py-2 px-3 align-self-end modalCloser" data-dismiss="modal" aria-label="Close">x</span>
		      	<div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
			        <div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
		                <h4 class="modal-title w-100 mb-0 text-left pr-2">Edition des informations parentales</h4>
		            </div>
		      	</div>
	      		<div class="modal-body">
	      		<h5 class="w-100 mx-auto p-1 h5-title text-danger text-center" v-if="invalidInputs !== undefined">
	      			Le formulaire est invalid
	      		</h5>
		        <form class="opac-form" id="add-pupil" method="post">
		        	<input type="text" name="token" v-model="token" hidden="hidden">
			        <div class="mx-auto mt-2 d-flex justify-content-between" style="width: 93%">
                        <div class="mx-auto" style="width: 69%">
                            <label for="edit_p_parent_address" class="m-0 p-0">Adresse électronique ou Contact du parent de l'apprenant</label>
                            <input type="text" @keyup="fetchTargets()" v-model="parent.identify" class="m-0 p-0 form-control p-1" name="address" id="edit_p_parent_address" placeholder="Veuillez renseigner l'adresse électronique ou le contact du parent de l'apprenant">
                            <i class="h5-title" v-if="invalidInputs !== undefined"> </i>
                        </div>
                        <div style="width: 30%;">
                            <label for="edit_p_parent_type" class="m-0 p-0">Le lien familiale</label>
                            <select name="relation" id="edit_p_parent_type" class="custom-select" v-model="parent.relation">
                                <option value="">Choisissez le lien</option>
                                <option :value="relation" v-for="relation in relations" > {{ relation }} </option>
                            </select>
                        </div>
                    </div>
                    <div class="mx-auto mt-1 d-flex justify-content-center" style="width: 93%" v-if="targets.length > 0">
                    	<div class="d-flex justify-content-start flex-column" style="width: 89%">
	                    	<span class="mx-1 text-white-50 h5-title">Voulez-vous parler de?</span>
							<span @click="resetIdentify(target.email)" class="h5-title text-warning indicators-search" v-for="target in targets">
								<span class="text-primary fa fa-chevron-right mr-1"></span>
								{{ target.name }}  <i class="text-white-50"> ({{ target.works }}) </i> <i class="mx-1 text-white-50"> Tel: {{target.contact}}</i>
							</span>
						</div>
                    </div>
                    <div class="mx-auto mt-1 d-flex justify-content-center" style="width: 93%" v-if="parent.identify.length > 7 && targets.length == 0">
                    	<div class="d-flex justify-content-start" style="width: 92%">
	                    	<span class="mx-1 text-white-50 h5-title">Le parent que vous essayer de renseigner n'existe pas dans la base de donner. Voulez-vous l'inserer maintenant?
								<span class="d-flex justify-content-start mx-1">
									<span @click="openNewParent()" class="text-primary mx-1 fa fa-user-plus border border-primary p-1 px-2" data-toggle="modal" data-target="#newParentModal" data-dismiss="modal" title="Ajouter ce parent maintenant"></span>
									<span @click="openNewParent()" class="text-danger border-danger fa fa-user-times border p-1 px-2" data-toggle="modal" title="Ne pas ajouter le parent" data-target="#newParentModal" data-dismiss="modal"></span>
								</span>
	                    	</span>
							
						</div>
                    </div>
			    </form>
	      		</div>
			    <div class="mx-auto mt-2 p-1 pb-2 buttons-div" style="width: 93%">
			        <button type="button" class="btn btn-primary w-25 float-right" @click="updateTargetedPupilParents()">Mettre à jour</button>
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
				parent: {
					identify: '',
					relation: 'Père',
				},
				targets: [],

				relations: ['Père', 'Mère', 'Tante', 'Oncle', 'Grand-père', 'Grand-Mère', 'Soeur', 'Frère', 'Beau-frère', 'Belle-sœur', 'Autres lien de parenté']

			}
		},
		created(){

        },

		
		methods: {

			getInvalids(input, invalids = this.invalidInputs){

				if(invalids !== undefined && invalids[input] !== undefined){
					return 'is-invalid'
				}
				else{
					return ''
				}
				
			},

			fetchTargets(){
				if(this.parent.identify.length > 4){
					axios.get('/admin/director/parentsm/search/get&only&parents&targeted/' + this.parent.identify)
			            .then(response => {
			            this.targets = response.data
			        })
				}
				else if(this.parent.identify.length < 2){
					this.targets = []
				}
			},

			resetIdentify(email){
				this.parent.identify = email
			},

			openNewParent(){
				$('#newParentModal .div-success').hide('slide', 'up')
                $('#newParentModal .div-success h4').text('')
                $('#newParentModal form').show('fade', function(){
                    $('#newParentModal .buttons-div').show('fade')
                })
			},

			updateTargetedPupilParents(){
				this.$store.dispatch('updateTargetedPupilParents')
			}
			
		},

		computed: mapState([
            'invalidInputs', 'successed', 'token', 'targetPupil', 'targetPupilParents', 'allParents', 'newParent'
        ]),



	}



</script>

<style>
	input + i, select + i{
		color: rgb(160, 0, 0);
		font-style: normal;
		text-shadow: 0 1px 1px gray;
	}

	.indicators-search:hover{
		color: rgb(0, 0, 0) !important;
		cursor: pointer;
	}
</style>

