<template>
	<div class="modal fade" id="editPupilMarks" tabindex="-1" role="dialog" aria-labelledby="editPupilMarksLabel" aria-hidden="true" v-show="!errors.status">
  		<div class="modal-dialog modal-lg" role="document" style="background-image: url(/media/silouhette.jpg) !important; width: 100%; background-position: -200px -400px; padding: 0px;">
	    	<div class="bg-linear-official-50 modal-content" style="border-style: solid; border-radius: 0;">
		    	<span class="d-inline-block text-white close py-2 px-3 align-self-end modalCloser" data-dismiss="modal" aria-label="Close">x</span>
		      	<div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
			        <div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
		                <h4 class="modal-title d-flex w-100 mb-0 text-left pr-2" style="font-size: 12px">
		                	<span class="d-inline-block w-50 mr-1">Edition des notes de l'apprenant...</span>
		                	<span class="text-danger text-right float-right h5-title" v-if="invalidInputs == undefined">Lorsqu'une note est validée elle ne peut être modifiée après une durée de <span class="text-warning">56 h</span> sans autorisation administrative <span class="text-warning">La note zéro 00 n'est pas prise ne compte</span></span>
		                </h4>
		            </div>
		      	</div>
	      		<div class="modal-body">
	      		<h5 class="w-100 mx-auto p-1 h5-title text-danger text-center" v-if="invalidInputs !== undefined">
	      			Les notes renseignées sont invalides!
	      		</h5>
		        <form class="opac-form" id="edit-pupil-marks" method="post">
		        	<input type="text" name="token" v-model="token" hidden="hidden">
			        <div class="mx-auto m-0 p-2 w-100 bg-linear-official-180 border">
			        	<span class="float-right fa fa-close" @click="toggleInputs(interrogations)" v-if="interrogations.status"></span>
			        	<span class="d-inline-block w-100 p-2" v-if="!interrogations.status">
			        		<span class="h5-title">Afficher les notes d'interrogations</span>
			        		<span class="float-right fa fa-chevron-down" @click="toggleInputs(interrogations)"></span>
			        	</span>
			        	
			        	<transition name="rapidScale" appear>
			        	<div class="w-100 my-2 d-flex flex-column p-1 pb-3" v-if="interrogations.status">
			        		<div class="w-100 my-2">
			        			<h5 class="text-center w-100 text-white-50 border-bottom border-dark">
			        				Les evaluations ponctuelles d'étapes
			        			</h5>
			        		</div>
			        		<div class="mx-auto mt-2 d-flex justify-content-around" style="width: 93%">
		                        <div class="mx-auto" style="width: 19.2%">
		                            <label for="edit_p_epe1" class="m-0 p-0">EPE 1</label>
		                            <input type="text" class="m-0 p-0 form-control p-1" :class="getInvalids('epe1', invalidInputs)" name="epe1" id="edit_p_epe1" placeholder="EPE 1" :value="getMarks(targetPupilMarks, editedPupilSubjectMarks.id, 'epe', 0)">
		                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.epe1 !== undefined"> {{ 'Valeur invalide!' }} </i>
		                        </div>
		                        <div class="mx-auto" style="width: 19.2%">
		                            <label for="edit_p_epe2" class="m-0 p-0">EPE 2</label>
		                            <input type="text" class="m-0 p-0 form-control p-1" :class="getInvalids('epe2', invalidInputs)" name="epe2" id="edit_p_epe2" placeholder="EPE 2" :value="getMarks(targetPupilMarks, editedPupilSubjectMarks.id, 'epe', 1)">
		                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.epe2 !== undefined"> {{ 'Valeur invalide!' }} </i>
		                        </div>
		                        <div class="mx-auto" style="width: 19.2%">
		                            <label for="edit_p_epe3" class="m-0 p-0">EPE 3</label>
		                            <input type="text" class="m-0 p-0 form-control p-1" :class="getInvalids('epe3', invalidInputs)" name="epe3" id="edit_p_epe3" placeholder="EPE 3" :value="getMarks(targetPupilMarks, editedPupilSubjectMarks.id, 'epe', 2)">
		                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.epe3 !== undefined"> {{ 'Valeur invalide!' }} </i>
		                        </div>
		                        <div class="mx-auto" style="width: 19.2%">
		                            <label for="edit_p_epe4" class="m-0 p-0">EPE 4</label>
		                            <input type="text" class="m-0 p-0 form-control p-1" :class="getInvalids('epe4', invalidInputs)" name="epe4" id="edit_p_epe4" placeholder="EPE 4" :value="getMarks(targetPupilMarks, editedPupilSubjectMarks.id, 'epe', 3)">
		                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.epe4 !== undefined"> {{ 'Valeur invalide!' }} </i>
		                        </div>
		                        <div class="mx-auto" style="width: 19.2%">
		                            <label for="edit_p_epe5" class="m-0 p-0">EPE 5</label>
		                            <input type="text" class="m-0 p-0 form-control p-1" :class="getInvalids('epe5', invalidInputs)" name="epe5" id="edit_p_epe5" placeholder="EPE 5" :value="getMarks(targetPupilMarks, editedPupilSubjectMarks.id, 'epe', 4)">
		                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.epe5 !== undefined"> {{ 'Valeur invalide!' }} </i>
		                        </div>
		                    </div>
			        	</div>
			        	</transition>
			        </div>
                    <div class="w-100 mx-auto p-2 m-0 mt-2 bg-linear-official-180 border">
                    	<span class="float-right fa fa-close" @click="toggleInputs(devoirs)" v-if="devoirs.status"></span>
			        	<span class="d-inline-block w-100 p-2" v-if="!devoirs.status">
			        		<span class="h5-title">Afficher les notes devoirs</span>
			        		<span class="float-right fa fa-chevron-down" @click="toggleInputs(devoirs)"></span>
			        	</span>
			        	<transition name="rapidScale" appear>
                    	<div class="w-100 my-2 d-flex flex-column p-1 pb-3" v-if="devoirs.status">
	                    	<div class="w-100 my-2">
			        			<h5 class="text-center text-white-50 w-100 border-bottom border-dark">
			        				Les devoirs
			        			</h5>
			        		</div>
                    		<div>
                    			<div class="mx-auto mt-2 d-flex justify-content-start" style="width: 93%">
		                        <div class="mr-2" style="width: 30%">
		                            <label for="edit_p_dev1" class="m-0 p-0">Devoir 1</label>
		                            <input type="text" class="m-0 p-0 form-control p-1" :class="getInvalids('dev1', invalidInputs)" name="dev1" id="edit_p_dev1" placeholder="Dev 1" :value="getMarks(targetPupilMarks, editedPupilSubjectMarks.id, 'devoirs', 0)">
		                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.dev1 !== undefined"> {{ 'Valeur invalide!' }} </i>
		                        </div>

		                        <div class="mr-2" style="width: 30%">
		                            <label for="edit_p_dev2" class="m-0 p-0">Devoir 2</label>
		                            <input type="text" class="m-0 p-0 form-control p-1" :class="getInvalids('dev2', invalidInputs)" name="dev2" id="edit_p_dev2" placeholder="Dev 2" :value="getMarks(targetPupilMarks, editedPupilSubjectMarks.id, 'devoirs', 1)">
		                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.dev2 !== undefined"> {{ 'Valeur invalide!' }} </i>
		                        </div>
		                    </div>
                    		</div>
                    	</div>
                    	</transition>
                    </div>
			    </form>
	      		</div>
			    <div class="mx-auto mt-2 p-1 pb-2 buttons-div" style="width: 93%">
			        <button type="button" class="btn btn-primary w-25 float-right" @click="updateTargetedPupilMarks(editedPupil, token, editedPupilSubjectMarks.id, editedPupilClasseMarks, targetPupilMarks, trimestre)">Inserer</button>
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
				interrogations: {name: "interrogations", status: true},
				devoirs: {name: "devoirs", status: true},
			}
		},
		created(){
            this.$store.dispatch('getTOOLS')
        },

		methods: {

			wasSelected(tag, target){
				return tag == target ? 'selected' : ''
			},

			toggleInputs(object)
			{
				object.status = !object.status
			},
			// getMarks(){
			// 	this.$store.commit('RESET_NEW_PUPIL')
			// },

			validateMarks(token){
				// let newPupil = this.newPupil
				// this.$store.dispatch('addANewPupil', {newPupil, token})
			},
			
			getInvalids(input, invalids = this.invalidInputs){

				if(invalids !== undefined && invalids[input] !== undefined){
					return 'is-invalid'
				}
				else{
					return ''
				}
				
			},
			getMarks(marks, subject, type, id){
				if(subject !== null && marks !== null){
					if(marks[subject] !== undefined){
						if(marks[subject][type] !== undefined){
							return marks[subject][type][id] !== undefined ? marks[subject][type][id].value : 0
						}
						return 0
						
					}
					return 0
					
				}
				return 0
			},
			updateTargetedPupilMarks(pupil, token, subject, classe, marks, trimestre){
				let cl = null
					if(subject !== null && marks !== null){
						if(marks[subject] !== undefined){
							if(marks[subject]['epe'] !== undefined){
								if(marks[subject]['epe'][0] !== undefined ){
									cl = marks[subject]['epe'][0].classe_id
								}
								else{
									cl = pupil.classe_id
								}
								
							}
							else if (marks[subject]['devoirs'] !== undefined) {
								if(marks[subject]['devoirs'][0] !== undefined ){
									cl = marks[subject]['devoirs'][0].classe_id
								}
								else{
									cl = pupil.classe_id
								}
							}
							else{
								cl = pupil.classe_id
							}
						}
						else{
							cl = pupil.classe_id
						}
					}
					else{
						cl = pupil.classe_id
					}
				let keys = {
					classe: cl,
					subject: subject
				}
				let notes = {
					epe1: $('form#edit-pupil-marks input[name=epe1]').val() == undefined ? this.getMarks(this.targetPupilMarks, this.editedPupilSubjectMarks.id, 'epe', 0) : $('form#edit-pupil-marks input[name=epe1]').val(),
					epe2: $('form#edit-pupil-marks input[name=epe2]').val() == undefined ? this.getMarks(this.targetPupilMarks, this.editedPupilSubjectMarks.id, 'epe', 1) : $('form#edit-pupil-marks input[name=epe2]').val(),
					epe3: $('form#edit-pupil-marks input[name=epe3]').val() == undefined ? this.getMarks(this.targetPupilMarks, this.editedPupilSubjectMarks.id, 'epe', 2) : $('form#edit-pupil-marks input[name=epe3]').val(),
					epe4: $('form#edit-pupil-marks input[name=epe4]').val() == undefined ? this.getMarks(this.targetPupilMarks, this.editedPupilSubjectMarks.id, 'epe', 3) : $('form#edit-pupil-marks input[name=epe4]').val(),
					epe5: $('form#edit-pupil-marks input[name=epe5]').val() == undefined ? this.getMarks(this.targetPupilMarks, this.editedPupilSubjectMarks.id, 'epe', 4) : $('form#edit-pupil-marks input[name=epe5]').val(),
					dev1: $('form#edit-pupil-marks input[name=dev1]').val() == undefined ? this.getMarks(this.targetPupilMarks, this.editedPupilSubjectMarks.id, 'devoirs', 0) : $('form#edit-pupil-marks input[name=dev1]').val(),
					dev2: $('form#edit-pupil-marks input[name=dev2]').val() == undefined ? this.getMarks(this.targetPupilMarks, this.editedPupilSubjectMarks.id, 'devoirs', 1) : $('form#edit-pupil-marks input[name=dev2]').val(),
					
				}
				let route = this.$route
				this.$store.dispatch('updateAPupilMarks', {pupil, token, keys, notes, trimestre, route})
				
				
			},

			beforeDestroy(){
				this.$store.commit('RESET_TARGETED_PUPIL_SUBJECT_MARKS', {})
			}
			
		},

		computed: mapState([
            'newPupil', 'invalidInputs', 'successed', 'token', 'errors', 'months', 'primaryClasses', 'secondaryClasses', 'newPupilName', 'targetPupilMarks', 'editedPupil', 'editedPupilSubjectMarks', 'editedPupilClasseMarks', 'trimestre'
        ]),



	}



</script>

<style>
	#edit-pupil-marks input + i{
		color: rgb(200, 0, 0);
		font-style: normal;
		text-shadow: 0 1px 1px black !important;
	}
</style>

