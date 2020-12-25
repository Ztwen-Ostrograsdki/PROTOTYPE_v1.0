<template>
	<div class="modal fade" id="editClasseModal" tabindex="-1" role="dialog" aria-labelledby="editClasseModalLabel" aria-hidden="true" v-show="!errors.status">
  		<div class="modal-dialog modal-lg" role="document" style="background-image: url(/media/silouhette.jpg) !important; width: 100%; background-position: -200px -400px; padding: 0px;">
	    	<div class="bg-linear-official-50 modal-content" :class="(invalids.status || invalidInputs !== undefined)? 'border-danger' : ''" style="border-style: solid; border-radius: 0;">
		    	<span class="d-inline-block text-white close py-2 px-3 align-self-end modalCloser" data-dismiss="modal" aria-label="Close" @click="resetNewClasse()">x</span>
		      	<div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
			        <div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
		                <h4 class="modal-title w-100 mb-0 text-left pr-2">Edition de la classe de <i class="cursive"> la {{ editingClasse.classe.name }} </i></h4>
		            </div>
		      	</div>
	      		<div class="modal-body">
	      		<h5 class="w-100 mx-auto p-1 h5-title text-danger text-center" v-if="invalids.status || invalidInputs !== undefined">
	      			<span class="fa fa-warning text-danger mx-2"></span>
	      			Le formulaire est invalid
	      		</h5>
		        <form class="opac-form" id="add-classe" method="post">
		        	<input type="text" name="token" v-model="token" hidden="hidden">
			        <div v-if="editingClasse.tag == 'name'" class="mx-auto mt-2 d-flex justify-content-between" style="width: 93%">
                        <div class="mx-auto" style="width: 76%">
                            <label for="edit_c_name" class="m-0 p-0">Nom de la classe</label>
                            <input :class="invalids.name.status ? 'is-invalid' : ''" type="text" class="m-0 p-0 form-control p-1" name="name" id="edit_c_name" placeholder="Veuillez renseigner le nom de la classe" v-model.lazy="editingClasse.classe_name">
                            <i class="h5-title" v-if="invalids.name.status"> {{ invalids.name.msg }} </i>
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.name !== undefined"> {{ invalidInputs.name[0] }} </i>
                        </div>
                    </div>
                    <div v-if="editingClasse.tag == 'year'" class=" mx-auto mt-2 d-flex justify-content-start" style="width: 93%">
                        <div style="width: 45%;">
                            <label for="edit_c_month" class="m-0 p-0">Le mois de création</label>
                            <select :class="invalids.month.status ? 'is-invalid' : ''" v-model="editingClasse.classe.month" name="month" id="edit_c_month" class="custom-select">
                                <option value="">Choisissez le mois</option>
                                <option :value="month" v-for="month in months" > {{ month }} </option>
                            </select>
                            <i class="h5-title" v-if="invalids.month.status"> {{ invalids.month.msg }} </i>
                        </div>
                        <div style="width: 45%;" class="mx-2">
                            <label for="add_c_year" class="mb-0">L'année de Création</label>
                            <select :class="invalids.year.status ? 'is-invalid' : ''" v-model="editingClasse.classe.year" name="year" id="add_c_year" class="custom-select">
                                <option value="">Choisissez l'année</option>
                                <option :value="year" v-for="year in getYears()">{{ year }}</option>
                            </select>
                            <i class="h5-title" v-if="invalids.year.status"> {{ invalids.year.msg }} </i>
                        </div>
                    </div>
                    <div v-if="editingClasse.tag == 'teacher'" class=" mx-auto mt-2 d-flex justify-content-start" style="width: 93%">
                        <div style="width: 90%;">
                            <label for="edit_c_teacher" class="m-0 p-0">Le professeur principal</label>
                            <select v-model="editingClasse.teacher_id" name="teacher_id" id="edit_c_teacher" class="custom-select">
                                <option value="null" :selected="wasSelected(editingClasse.teacher_id, null)" >Choisissez le prof</option>
                                <option :selected="wasSelected(editingClasse.teacher_id, teacher.id)" :value="teacher.id" v-for="teacher in targetedClasseTeachers" > {{ teacher.name }} </option>
                            </select>
                            <i class="h5-title"> {{  }} </i>
                        </div>
                    </div>
                    
			    </form>
	      		</div>
			    <div class="mx-auto mt-2 p-1 pb-2 buttons-div" style="width: 93%">
			        <button type="button" class="btn btn-primary w-25 float-right" @click="editClasse(token, editingClasse.tag, editingClasse.classe)">Inserer</button>
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
				data: {},
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
				if(tag == target){
					return true
				}
				else{
					return false
				}
				
			},

			resetNewClasse(){
				this.$store.commit('RESET_NEW_CLASSE')
			},

			editClasse(token, tag, classe){
				let data = null
				let route = this.$route

				if(token !== null && tag !== null && classe !== null){
					if(tag === 'teacher'){
						data = this.editingClasse.teacher_id
					}
					if(tag == 'name'){
						data = this.editingClasse.classe_name

					}

					this.$store.dispatch('editAClasseByPart', {tag, classe, id: classe.id, inputs: data, token, route})
				}
				
			},
			getYears(){
				let $tab = []
				let now = (new Date).getFullYear()
				for (var i = 1995; i <= now; i++) {
					$tab.push(i)
				}
				return $tab
			},
		},

		computed: mapState([
            'newClasse', 'invalidInputs', 'successed', 'token', 'errors', 'months', 'primaryClasses', 'secondaryClasses', 'editingClasse', 'targetedClasseTeachers'
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

