<template>
	<div class="modal fade" id="newHoraireModal" tabindex="-1" role="dialog" aria-labelledby="newHoraireModalLabel" aria-hidden="true" v-show="!errors.status">
  		<div class="modal-dialog modal-lg" role="document" style="background-image: url(/media/silouhette.jpg) !important; width: 100%; background-position: -200px -400px; padding: 0px;">
	    	<div class="bg-linear-official-50 modal-content" :class="(invalids.status || invalidInputs !== undefined)? 'border-danger' : ''" style="border-style: solid; border-radius: 0;">
		    	<span class="d-inline-block text-white close py-2 px-3 align-self-end modalCloser" data-dismiss="modal" aria-label="Close" @click="resetNewHoraire()">x</span>
		      	<div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
			        <div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
		                <h4 class="modal-title w-100 mb-0 text-left pr-2">Ajout d'une nouvelle horaire</h4>
		            </div>
		      	</div>
	      		<div class="modal-body">
	      		<h5 class="w-100 mx-auto p-1 h5-title text-danger text-center" v-if="invalids.status || invalidInputs !== undefined">
	      			<span class="fa fa-warning text-danger mx-2"></span>
	      			Le formulaire est invalid
	      		</h5>
		        <form class="opac-form" id="add-classe" method="post">
		        	<input type="text" name="token" v-model="token" hidden="hidden">
			        <div class="mx-auto mt-2 d-flex justify-content-between" style="width: 93%">
                        <div style="width: 30%;">
                            <label for="add_hour_level" class="mb-0">Le cycle</label>
                            <select name="level" v-model="newHoraire.level" id="add_hour_level" class="custom-select">
                                <option value="">Choisissez le cycle</option>
                                <option value="primary"> Le primaire </option>
                                <option value="secondary"> Le secondaire </option>
                                <option value="superior"> Le supérieur </option>
                            </select>
                        </div>
                        <div style="width: 34%;">
                            <label for="add_hour_start" class="mb-0">Le debut</label>
                            <select name="start" v-model="newHoraire.start" id="add_hour_start" class="custom-select">
                                <option :value="null">Choisissez le debut</option>
                                <option :value="h_s" v-for="h_s in horaireMaker(7)">{{ h_s + 'h' }}</option>
                            </select>
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.start !== undefined"> L'heure choisie est invalide </i>
                        </div>
                        <div style="width: 34%;">
                            <label for="add_hour_end" class="mb-0">La fin</label>
                            <select name="end" v-model="newHoraire.end" id="add_hour_end" class="custom-select">
                                <option :value="null">Choisissez le debut</option>
                                <option :value="h_e" v-for="h_e in horaireMaker(newHoraire.start + 1)">{{ h_e + 'h' }}</option>
                            </select>
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.end !== undefined"> L'heure choisie est invalide </i>
                        </div>
                        
                    </div>
                    <div class=" mx-auto mt-2 d-flex justify-content-between" style="width: 93%">
                    	<div style="width: 39%;">
                            <label for="add_hour_classe" class="mb-0">La classe</label>
                            <select name="classe_id" v-model="newHoraire.classe_id" id="add_hour_classe" class="custom-select">
                                <option :value="null">Choisissez la classe</option>
                                <option v-if="newHoraire.level == 'secondary'" :value="classe.id" v-for="classe in secondaryClasses">{{classe.name}}</option>
                                <option v-if="newHoraire.level == 'primary'" :value="classe.id" v-for="classe in primaryClasses">{{classe.name}}</option>
                            </select>
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.classe_id !== undefined"> La classe choisie est invalide </i>
                        </div>
                        <div style="width: 40%;">
                            <label for="add_hour_subject" class="m-0 p-0">La discipline</label>
                            <select v-model="newHoraire.subject_id" name="subject_id" id="add_hour_subject" class="custom-select">
                                <option :value="null">Choisissez La discipline</option>
                                <option v-if="newHoraire.classe_id == null || newHoraire.classe_id == '' ||newHoraire.classe_id == undefined" :value="subject.name" v-for="subject in classesWithSubjects[0]" > {{ subject.name }} </option>
                                <option v-if="newHoraire.classe_id !== null && newHoraire.classe_id !== '' && newHoraire.classe_id !== undefined" :value="subject.name" v-for="subject in classesWithSubjects[newHoraire.classe_id]" > {{ subject.name }} </option>
                            </select>
                            <i class="h5-title" v-if="invalids.subject_id"> {{ 'invalide' }} </i>
                        </div>
                        <div style="width: 19.5%;">
                            <label for="add_hour_year" class="mb-0">L'année scolaire</label>
                            <select v-model="newHoraire.year" name="year" id="add_hour_year" class="custom-select">
                                <option value="">Choisissez l'année</option>
                                <option :value="year" v-for="year in getYears()">{{ year }}</option>
                            </select>
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
				classes: [],
				invalids: {
					status: false, 
					name: { status: false, msg: ''},
					month: { status: false, msg: ''},
					year: { status: false, msg: ''},
					level: { status: false, msg: ''}
				}
			}
		},
		created(){
            this.$store.dispatch('getTOOLS')
        },

		
		methods: {

			wasSelected(tag, target){
				return tag == target ? 'selected' : ''
			},

			resetNewHoraire(){
				this.$store.commit('RESET_NEW_HORAIRE')
			},

			createNewHoraire(token){
				
				
			},
			getYears(){
				let $tab = []
				let now = (new Date).getFullYear()
				for (var i = 1995; i <= now; i++) {
					$tab.push(i)
				}
				return $tab
			},

			horaireMaker(start = 7){
				let $HOURS = []
				for (var i = start; i < 20; i++) {
					$HOURS.push(i)
				}
				return $HOURS
			}
		},

		computed: mapState([
            'newHoraire', 'invalidInputs', 'successed', 'token', 'errors', 'months', 'primaryClasses', 'secondaryClasses', 'classesWithSubjects'
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

