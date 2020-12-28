<template>
	<div class="modal fade" id="newTeacherModal" tabindex="-1" role="dialog" aria-labelledby="newTeacherModalLabel" aria-hidden="true" v-show="!errors.status">
  		<div class="modal-dialog modal-lg" role="document" style="background-image: url(/media/silouhette.jpg) !important; width: 100%; background-position: -200px -400px; padding: 0px;">
	    	<div class="bg-linear-official-50 modal-content" :class="(invalidInputs !== undefined)? 'border-danger' : ''" style="border-style: solid; border-radius: 0;">
		    	<span class="d-inline-block text-white close py-2 px-3 align-self-end modalCloser" data-dismiss="modal" aria-label="Close" @click="resetNewTeacher()">x</span>
		      	<div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
			        <div class="modal-header w-100 d-flex justify-content-between p-0 pl-2 m-0">
		                <h4 class="modal-title w-100 mb-0 text-left pr-2">Ajout d'un nouvel enseignant</h4>
		            </div>
		      	</div>
	      		<div class="modal-body">
	      		<h5 class="w-100 mx-auto p-1 h5-title text-danger text-center bg-linear-official-50 border border-danger p-2" v-if="invalidInputs !== undefined">
	      			<span v-if="invalidInputs.token == undefined && invalidInputs.user == undefined">
	      				Le formulaire est invalide
	      			</span>
	      			<span v-if="invalidInputs.token !== undefined">
	      				{{invalidInputs.token[0]}}
	      			</span>
	      			<span class="text-warning" v-if="invalidInputs.user !== undefined">
	      				<i>SECURITE: Le formulaire ne peut-être pris en compte</i><br>
	      				{{invalidInputs.user[0]}}
	      			</span>
	      		</h5>
		        <form class="opac-form" id="teacher-perso-new" style="display: none;" method="post">
		        	<input type="text" name="token" v-model="token" hidden="hidden">
			        <div class="mx-auto mt-2 d-flex justify-content-between" style="width: 85%">
                        <div class="" style="width: 70%">
                            <label for="n_t_name" class="m-0 p-0">Nom et Prénoms de l'enseignant</label>
                            <input v-model.lazy="newTeacher.name" type="text" class="m-0 p-0 form-control p-1" :class="getInvalids('name', invalidInputs)" name="name" id="n_t_name" placeholder="Veuillez renseigner le nom et les prénoms de l'enseignant">
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.name !== undefined"> {{ invalidInputs.name[0] }} </i>
                        </div>
                        <div class="" style="width: 28%">
                            <label for="n_t_level" class="m-0 p-0">Cycle de l'enseignant</label>
                            <select v-model.lazy="newTeacher.level" name="level" id="n_t_level" class="custom-select" :class="getInvalids('level', invalidInputs)">
                                <option value="">Choisir le cycle</option>
                                <option value="primary" >Le Primaire</option>
                                <option value="secondary">Le Secondaire</option>
                                <option value="superior">Le Supérieur</option>
                            </select>
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.level !== undefined"> {{ invalidInputs.level[0] }} </i>
                        </div>
                    </div>
                    <div class="mx-auto mt-2 d-flex justify-content-between" style="width: 85%">
                        <div class="" style="width: 60.2%">
                            <label for="n_t_email" class="m-0 p-0">Adresse mail de l'enseignant</label>
                            <input v-model.lazy="newTeacher.email" type="email" class="m-0 p-0 form-control p-1" :class="getInvalids('email', invalidInputs)" name="email" id="n_t_email" placeholder="Veuillez renseigner l'email l'enseignant">
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.email !== undefined"> {{ invalidInputs.email[0] }} </i>
                        </div>
                        <div style="width: 39%;">
                            <label for="n_t_subject" class="m-0 p-0">La spécialité</label>
                            <select v-model="newTeacher.subject_id" name="subject_id" id="n_t_subject" class="custom-select" :class="getInvalids('subject_id', invalidInputs)">
                                <option :value="null">Choisissez la spécialité</option>
                                <option :value="subject.id" v-for="subject in subjects" > {{ subject.name }} </option>
                            </select>
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.subject_id !== undefined"> {{ invalidInputs.subject_id[0] }} </i>
                        </div>
                    </div>
			        <div class="mx-auto mt-2 d-flex justify-content-between" style="width: 85%">
			        	<div style="width: 65.4%">
                            <label for="n_t_contact" class="m-0 p-0">Contacts de l'enseignant</label>
                            <input v-model.lazy="newTeacher.contact" type="text" class="m-0 p-0 form-control p-1" :class="getInvalids('contact', invalidInputs)" name="contact" id="n_t_contact" placeholder="Veuillez renseigner les contacts l'enseignant">
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.contact !== undefined"> {{ invalidInputs.contact[0] }} </i>
                        </div>
                        <div style="width: 32.5%;">
                            <label for="n_t_birth" class="mb-0">La date de naissance</label>
                            <input v-model.lazy="newTeacher.birth" type="date" name="birth" class="m-0 p-0 form-control p-1" :class="getInvalids('birth', invalidInputs)" id="n_t_birth">
                             <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.birth !== undefined"> {{ invalidInputs.birth[0] }} </i>
                        </div>
                    </div>
                    <div class=" mx-auto mt-2 d-flex justify-content-around" style="width: 85%">
                        <div style="width: 49.5%;">
                            <label for="n_t_month" class="m-0 p-0">Le mois d'inscription</label>
                            <select v-model="newTeacher.month" name="month" id="n_t_month" class="custom-select" :class="getInvalids('month', invalidInputs)">
                                <option :selected="newTeacher.month == ''" value="">Choisissez le mois</option>
                                <option :value="month" v-for="month in months" > {{ month }} </option>
                            </select>
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.month !== undefined"> {{ invalidInputs.month[0] }} </i>
                        </div>
                        <div style="width: 49.2%;">
                            <label for="n_t_year" class="mb-0">L'année d'inscription</label>
                            <select v-model.lazy="newTeacher.year" name="year" id="n_t_year" class="custom-select" :class="getInvalids('year', invalidInputs)">
                                <option value="">Choisissez l'année</option>
                                <option :value="year" v-for="year in getYears()">{{ year }}</option>
                            </select>
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.year !== undefined"> {{ invalidInputs.year[0] }} </i>
                        </div>
                    </div>
                    <div class=" mx-auto mt-2 d-flex justify-content-between" style="width: 85%">
                    	<div class="" style="width: 29%;">
                            <label for="n_t_sexe" class="m-0 p-0">Sexe</label>
                            <select v-model.lazy="newTeacher.sexe" name="sexe" id="n_t_sexe" class="custom-select" :class="getInvalids('sexe', invalidInputs)">
                                <option value="">Choisir le sexe</option>
                                <option value="male" >Masculin</option>
                                <option value="female">Féminin</option>
                            </select>
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.sexe !== undefined"> {{ invalidInputs.sexe[0] }} </i>
                        </div>
                        <div class="" style="width: 69%;">
                            <label for="n_t_residence" class="m-0 p-0">La Résidence</label>
                            <input v-model.lazy="newTeacher.residence" type="text" class="m-0 p-0 form-control p-1" :class="getInvalids('residence', invalidInputs)" name="residence" id="n_t_residence" placeholder="Veuillez renseigner la résidence l'enseignant">
                            <i class="h5-title" v-if="invalidInputs !== undefined && invalidInputs.residence !== undefined"> {{ invalidInputs.residence[0] }} </i>
                        </div>
                    </div>
			    </form>
	      		</div>
			    <div class="mx-auto mt-2 p-1 pb-2 buttons-div" style="width: 85%">
			        <button type="button" class="btn btn-secondary border border-white mx-1 float-right w-25" data-dismiss="modal" @click="resetNewTeacher()">Annuler</button>
			        <button type="button" class="btn btn-primary float-right border border-white w-25" @click="createNewTeacher(token)">Insérer</button>
			    </div>
			    <div class="mx-auto mt-2 p-1 pb-2 div-success" style="width: 85%; display: none">
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
            this.$store.dispatch('getTOOLS')
        },

		
		methods: {

			wasSelected(tag, target){
				return tag == target ? 'selected' : ''
			},

			resetNewTeacher(){
				this.$store.commit('RESET_NEW_TEACHER')
			},

			createNewTeacher(token){
				let route = this.$route
				this.admin === true ? this.newTeacher.creator = this.user.name : this.newTeacher.creator = null
				this.admin === true ? this.newTeacher.authorized = true : this.newTeacher.authorized = false
				let newTeacher = this.newTeacher
				this.$store.dispatch('addANewTeacher', {newTeacher, token, route})
			},
			getYears(){
				let $tab = []
				let now = (new Date).getFullYear()
				for (var i = 1995; i <= now; i++) {
					$tab.push(i)
				}
				return $tab
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
            'newTeacher', 'invalidInputs', 'successed', 'token', 'errors', 'months', 'primaryClasses', 'secondaryClasses', 'subjects', 'user', 'admin'
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

