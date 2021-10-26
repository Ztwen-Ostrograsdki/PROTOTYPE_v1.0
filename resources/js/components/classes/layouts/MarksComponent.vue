<template>
	<div class="w-100 p-1 mx-auto">
		<div class="w-100 d-flex justify-content-center bg-linear-official-180 border my-1 pb-2">
			<div class="w-100">
				<div class="w-100">
					<div class="d-flex w-100 my-1 py-1 justify-content-start">
			            <div class="mx-1 my-0 w-100">
			                <h5 class="d-flex justify-content-between w-100 p-2">
				                <span>
				                	<span class="text-white-50">CSP LA PRUNELLE</span>
				                </span> 
				                <div class="d-flex justify-content-between">
				                	<div class="mr-2">
				                		<span class="text-white-50">Classe :</span> {{targetedClasse.classeFMT.name}}<sup>{{ targetedClasse.classeFMT.sup }}</sup> {{ targetedClasse.classeFMT.idc }}
				                	</div>
				                	<div class="ml-2">
				                		<span> <span class="text-white-50">Principal: </span>{{ 'Mr TOGAN Martin' }}</span>
				                	</div>
				                </div>
				                <span>
				                	<span class="text-white-50">Année Scolaire:</span> 2020 - 2021
				                </span>
				            </h5>
			            </div>
			        </div>
			        <div class="profil-admin d-lg-inline-block d-sm-flex d-md-flex justify-content-sm-around justify-content-md-around float-left">
						<div class="w-100 float-left">
							<div class="d-flex justify-content-around w-50 mx-auto">
								<div class="text-right m-0 p-0 px-2">
								<router-link :to="{name: 'classesProfil',params: {id:targetedClasse.classe.id}}" class="w-100 hover link-float" style="border-radius: 30px;">
		                            	<span class="fa fa-home fa-2x"></span>
	            					</router-link>
								</div>
								<div class="text-right pl-1" @click="toggleOptions()" v-if="!showOptions">
									<span class="fa fa-sliders fa-2x"></span>
								</div>
								<div class="text-right pl-1" @click="toggleOptions()" v-if="showOptions">
									<span class="fa fa-chevron-up fa-2x"></span>
								</div>
							</div>
							<transition name="scalefade" appear>
							<div class="login-profil  position-absolute border border-white" style="width: 250px; top: 200px; left:18px; z-index: 100; background-image: url(/media/img/art-2578353_1920.jpg) !important; background-position: -400px 300px;" v-if="showOptions">
				                <div class="w-100 border" style="">
				                    <a class="w-100 link-float d-inline-block border m-0 py-1" href="#">
				                        <i class="fa fa-sliders fa-sm fa-fw mr-2"></i>
				                        <span>Options</span>
				                        <span class="mr-2 d-none d-lg-inline text-dark float-right"></span>
				                    </a>
				                      <!-- Dropdown - User Information -->
				                    <div class="w-100 border" v-if="targetedClasse.classe">
				                            <a class="w-100 my-1 hover link-float" href="" style="border-radius: 30px;">
				                                <i class="fas fa-cogs fa-sm fa-fw mr-2"></i>
				                              Administation
				                            </a>
				                            <router-link :to="'/admin/director/classesm/' + targetedClasse.classe.id + '/marks/index' " class="w-100 my-1 hover link-float" style="border-radius: 30px;">
				                            	<i class="fa fa-file-text fa-sm fa-fw mr-2"></i>
				                              Les notes
			            					</router-link>
			            					<span @click="updateTargetedTrimestre(1)">
				                            	<router-link :to="{name: 'classeSubjectMarks',params: {id:targetedClasse.classe.id, s: targetedClasseSubject, t: 1}}" class="w-100 my-1 hover link-float" style="border-radius: 30px;">
				                            	<i class="fa fa-line-chart fa-sm fa-fw mr-2"></i>
				                              	1<sup>er</sup> Trimestre
			            					</router-link>
				                            </span>
			            					
				                            <span @click="updateTargetedTrimestre(2)">
				                            	<router-link :to="{name: 'classeSubjectMarks',params: {id:targetedClasse.classe.id, s: targetedClasseSubject, t: 2}}" class="w-100 my-1 hover link-float" style="border-radius: 30px;">
				                            	<i class="fa fa-line-chart fa-sm fa-fw mr-2"></i>
				                              	2<sup>ème</sup> Trimestre
			            					</router-link>
				                            </span>
				                            <span @click="updateTargetedTrimestre(3)">
				                            	<router-link :to="{name: 'classeSubjectMarks',params: {id:targetedClasse.classe.id, s: targetedClasseSubject, t: 3}}" class="w-100 my-1 hover link-float" style="border-radius: 30px;">
				                            	<i class="fa fa-line-chart fa-sm fa-fw mr-2"></i>
				                              	3<sup>ème</sup> Trimestre
			            					</router-link>
				                            </span>
				                            
				                            <a class="w-100 my-1 hover link-float" href="" style="border-radius: 30px;">
				                                <i class="fa fa-line-chart fa-sm fa-fw mr-2"></i>
				                              Scolarité
				                            </a>
				                        <a class="w-100 py-1 hover link-float" href="#">
				                             <i class="fas fa-list fa-sm fa-fw mr-2"></i>
				                          Activity Log
				                        </a>
				                        <a class="w-100 py-1 pb-2 hover border-top link-float" href="">
				                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
				                          Fermer cette classe
				                        </a>
				                        <form action=""  style="display: none;">
				                        </form>
				                    </div>
				                </div> 
				            </div>
				            </transition>
						</div>
					</div>
					<div class="w-50 ml-5 mb-1 float-right">
						<span class="d-flex justify-content-start w-100">
							<span v-if="$route.params.s" class="btn btn-primary border border-white p-0 w-25 px-1 m-0" @click="updateTargetedTrimestre(1)">
	                            <router-link :to="{name: 'classeSubjectMarks',params: {id:$route.params.id, s: $route.params.s, t: 1}}" class="w-100 my-1 hover link-float" style="border-radius: 30px;">
	                              	1<sup>er</sup> Trim
	        					</router-link>
                            </span>
                            <span v-if="!$route.params.s" class="btn border pt-1 border-white p-0 w-25 px-1 m-0">
	                            <span class="w-100 hover text-white-50 link-float" style="border-radius: 30px;">
	                              	1<sup>er</sup> Trim
	        					</span>
                            </span>


							<span v-if="$route.params.s" class="btn btn-primary border border-white w-25 p-0 px-1 m-0 mx-1" @click="updateTargetedTrimestre(2)">
	                            <router-link :to="{name: 'classeSubjectMarks',params: {id:$route.params.id, s: $route.params.s, t: 2}}" class="w-100 my-1 hover link-float" style="border-radius: 30px;">
	                              	2<sup>ème</sup> Trim
	        					</router-link>
                            </span>
                            <span v-if="!$route.params.s" class="btn border pt-1 border-white p-0 w-25 px-1 m-0 mx-1">
	                            <span class="w-100 hover text-white-50 link-float" style="border-radius: 30px;">
	                              	2<sup>ème</sup> Trim
	        					</span>
                            </span>


							<span v-if="$route.params.s" class="btn btn-primary w-25 border border-white p-0 px-1 m-0" @click="updateTargetedTrimestre(3)">
                            	<router-link :to="{name: 'classeSubjectMarks',params: {id:$route.params.id, s: $route.params.s, t: 3}}" class="w-100 my-1 hover link-float" style="border-radius: 30px;">
                              	3<sup>ème</sup>Trim
        					</router-link>
                            </span>
                            <span v-if="!$route.params.s" class="btn border pt-1 border-white p-0 w-25 px-1 m-0">
	                            <span class="w-100 hover text-white-50 link-float" style="border-radius: 30px;">
	                              	3<sup>ème</sup> Trim
	        					</span>
                            </span>
						</span>
					</div>
					<transition name="fadelow" appear>
						<div class="d-flex w-100">
							<div class="float-left " style="width: 20%">
								<h4 class="ml-2 h5-title"> Les notes de <strong class="text-warning"> {{ getTargetedSubjectName() == undefined ? '...' : getTargetedSubjectName().name }} </strong>du <i class="text-primary">Trim. {{getTargetedSubjectName() == undefined ? '...' : getTargetedSubjectName().trim}}</i></h4>
							</div>
							<div class="d-flex float-right justify-content-end pr-2" style="width: 90%">
								<span class="text-muted mt-2 mr-2 cursive">Coef: <i>{{ targetedClasseSubjectsCoef[targetedClasseSubject] }}</i></span>
								<span v-for="subject in targetedClasse.subjects" @click="updateTargetedSubject(subject.id)">
									<router-link :to="{name: 'classeSubjectMarks', params: {id: $route.params.id, s:subject.id, t: trimestre}}"   class="card-link d-inline-block btn border p-1 ml-1" :class="isTheTargetedSubject(subject.id)">
	                                    <span  class="w-100 d-inline-block link-profiler">
	                                        {{ subject.name }}
	                                	</span>
	                            	</router-link>
								</span>
							</div>
						</div>
					</transition>
				</div>
			</div>
		</div>
		
		<div class="w-100 mx-auto d-flex justify-content-center bg-linear-official-180 border border-white">
			<!-- LOADER LOADER LOADER LOADER LOADER LOADER -->
			<div class="w-100 m-0 p-0 mx-auto d-flex justify-content-center bg-linear-official-180" v-if="LoadedPage">
				<div class="m-0 p-0 mx-auto w-100 bg-transparent border border-white" style="height: 400px">
					<img src="/media/loader/load2.gif" class="w-100 d-inline-block" style="position:relative; height: 400px; z-index: 0">
					<h4 class="text-center mx-auto" style="position:relative; top: -350px; z-index: 3000">
						Chargement en cours... Veuillez patienter quelques secondes... 
					</h4>

				</div>
			</div>
			<!-- en loader -->
			<div class="w-100 p-2 mx-auto d-flex justify-content-center bg-linear-official-180" v-if="!$route.params.s && !LoadedPage">
				<h6 class="m-0 p-0 mx-auto text-muted">
					Veuillez sélectionner une matière, pour voir ou éditer les notes, moyennes et rangs
				</h6>
			</div>
			<table class="table-table table-striped w-100 classes-marks" v-if="$route.params.s && !LoadedPage">
				<transition name="justefade" appear>
                    <thead>
                        <th class="no-tag">No</th>
                        <th class=" pupils-tag">Elèves</th>
                        <th class="subjects-tag">
                        	<span>Les notes
                        		<span class="d-inline-block m-0 p-0" v-if="!modality">
                        			<span class="h5-title text-white-50 m-0 p-0" v-if="subjectWithModalities[$route.params.s] !== undefined">
                        			Seulement les {{subjectWithModalities[$route.params.s]}} meilleurs notes sont prises en comptes
                        		</span>
                        		<span class="h5-title text-white-50 m-0 p-0" v-if="subjectWithModalities[$route.params.s] == undefined">
                        			Toutes les notes sont prises en comptes
                        		</span>
                        		</span>
                        	</span>
                        	<span class="float-right mr-1 d-flex flex-column justify-content-between" v-if="modality">
                        		<span class="fa fa-check text-success mb-2" title="Lancer les modalités" @click="updateModality()"></span>
                        		<span class="fa fa-mail-reply text-info" title="Annuler la proccédure" @click="changeModality('reset')"></span>
                        	</span>
                        	<span class="float-left ml-1 d-flex flex-column justify-content-center" v-if="modality">
                        		<span class="fa fa-close text-danger mb-2" title="Annuler toutes les modalités" @click="resetAllModality()"></span>
                        	</span>
                        	<span class="fa fa-filter float-right m-0 p-0 mr-2" title=" Définisser la modalité de calcule des moyennes" @click="changeModality()" v-if="!modality"></span>
                        	<transition name="justefade" appear>
                        		<span class="float-right m-0 p-0 mr-1" v-if="modality">
                        			<form id="classe-modality" class="d-inline opac-form m-0 p-0">
                        				<input style="color: orange" :class="alertModality.status == false ? 'is-invalid' : ''" max="5" min="1" class="form-control m-0 p-0 text-center" type="number" name="modalityLength" title="Veuillez renseigner le nombre de notes à prendre en compte">
                        			</form>
                        		</span>
                        	</transition>
                        	<span v-if="modality && alertModality.message == ''" class="h5-title text-warning d-block p-0 m-0">
	                        	Indiquer le nombre de notes à prendre en compte
	                        </span>
	                        <span v-if="modality && alertModality.message !== ''" :class="alertModality.status == false ? 'text-danger' : 'text-success'" class="h5-title d-block p-0 m-0">
	                        	{{alertModality.message}}
	                        </span>
                        </th>
                        <th class="subjects-tag">
                        	<span>Moyennes</span>
                        	<span @click="toggleComputing()" class="fa fa-desktop float-right mr-2" title="calculer les moyennes maintenant"></span>
                        </th>
                        <th class="actions-tag">Classer</th>
                    </thead>
                </transition>
               	<transition name="justefade" appear>
                    <tbody class="w-100 marks-td">
                    	<tr class="border-bottom border-white">
                    		<td class=" bg-linear-official-180">x</td>
                    		<td class=" bg-linear-official-180">x</td>
                    		<td class="text-center ">
                    			<table class="text-center w-100 text-white-50">
	                    			<tbody class="w-100 notes">
	                    				<tr class="text-center w-100">
	                    					<td class="text-center ">Int 1</td>
	                    					<td class="text-center ">Int 2</td>
	                    					<td class="text-center ">Int 3</td>
	                    					<td class="text-center ">Int 4</td>
	                    					<td class="text-center ">Int 5</td>
	                    					<td class="text-primary">Moy Int</td>
	                    					<td class="text-primary">Dev 1</td>
	                    					<td class="text-primary">Dev 2</td>
	                    				</tr>
	                    			</tbody>
	                    		</table>
                    		</td>
                    		<td class="text-center">
                    			<table class="text-center w-100 text-white-50">
	                    			<tbody class="w-100 moyennes">
	                    				<tr class="text-center w-100">
	                    					<td class="text-center text-success">Moy</td>
	                    					<td class="text-center text-warning">Moy Coef</td>
	                    					<td class="text-center text-info">Rang</td>
	                    				</tr>
	                    			</tbody>
	                    		</table>
                    		</td>
                    		<td>
                    			<span class="fa fa-recycle" @click="oderer($route.params.id, targetedClasseSubject)"></span>
                    		</td>
                    	</tr>
                    	<tr class="border-bottom border-white-50" v-for="(pupil, k) in targetedClasse.pupils">
                    		<td>{{ k + 1 }}</td>
                    		<td class="text-left p-2">
	                    		<router-link :to="{name: 'pupilsProfil', params: {id: pupil.id}}"   class="card-link d-inline-block" >
	                                    <span  class="w-100 d-inline-block link-profiler"  @click="setEdited(pupil)">
	                                        {{pupil.name}}
                                    	</span>
                                </router-link>
                                	<a href="#" title="card-link Editer les informations de" class="fa fa-edit text-white-50 float-right" style="font-size: 10px!important; font-weight: 200!important" data-toggle="modal" data-target="#editPupilMarks" @click="editedPupilClasseAndSubjectMarks(pupil, $route.params.s)" ></a>
                    		</td>
                    		<td>
                    			<table class="w-100">
                    				<tbody class="w-100 notes">
                    					<tr class="w-100">
		                    				<td>{{ getMarks(pupil.id, 'epe', 0, targetedClasseMarks) }}</td>
		                    				<td >{{ getMarks(pupil.id, 'epe', 1, targetedClasseMarks) }}</td>
		                    				<td>{{ getMarks(pupil.id, 'epe', 2, targetedClasseMarks) }}</td>
		                    				<td >{{ getMarks(pupil.id, 'epe', 3, targetedClasseMarks) }}</td>
		                    				<td >{{ getMarks(pupil.id, 'epe', 4, targetedClasseMarks) }}</td>
		                    				
		                    				<td class="text-primary">{{getAverage(pupil.id, targetedClasseMarks).avgEPE}}</td>
		                    				<td class="text-primary">{{ getMarks(pupil.id, 'devoir', 0, targetedClasseMarks) }}</td>
		                    				<td class="text-primary">{{ getMarks(pupil.id, 'devoir', 1, targetedClasseMarks) }}</td>
		                    			</tr>
                    				</tbody>
                    			</table>
                    		</td>
                    		<td>
                    			<table class="w-100">
                    				<tbody class="w-100">
                    					<tr class="w-100">
		                    				<td class="text-success">{{getAverage(pupil.id, targetedClasseMarks, targetedClasseSubjectsCoef, targetedClasseSubject).avg}}</td>
		                    				<td class="text-warning">{{getAverage(pupil.id, targetedClasseMarks, targetedClasseSubjectsCoef, targetedClasseSubject).avgCoef}}</td>

		                    				<td class="text-info" v-if="getRange(k + 1, getAverage(pupil.id, targetedClasseMarks, targetedClasseSubjectsCoef, targetedClasseSubject).avg) !== '-'">
		                    					{{getRange(k + 1, getAverage(pupil.id, targetedClasseMarks, targetedClasseSubjectsCoef, targetedClasseSubject).avg).num}}
		                    					<sup>
		                    						{{getRange(k + 1, getAverage(pupil.id, targetedClasseMarks, targetedClasseSubjectsCoef, targetedClasseSubject).avg).sup}}
		                    					</sup>
		                    				</td>
		                    				<td class="text-info" v-if="getRange(k + 1, getAverage(pupil.id, targetedClasseMarks, targetedClasseSubjectsCoef, targetedClasseSubject).avg) == '-'">
		                    					-
		                    				</td>
		                    			</tr>
                    				</tbody>
                    			</table>
                    		</td>
                    		<td>
                    			<span class="fa fa-recycle text-muted"></span>
                    		</td>
                    	</tr>
                    </tbody>
                </transition>
			</table>
		</div>
		<div class="d-flex flex-column w-100 m-0 p-0 my-2">
			
		</div>
	</div>
</template>
<script>
	import { mapState } from 'vuex'
	// import averageComputor from '../../../helpers/helpers.js'

	export default{
		data() {
            return {
            	showOptions: false,
            	range: false,
            	modality: false,
            	computedAVG: false,
            	trimestre: 1,
            	LoadedPage: false
            }   
        },
        created(){
        	let id

        	if (this.$route.params.s) {
        		this.$store.commit('RESET_TARGETED_CLASSE_SUBJECT_TARGETED', this.$route.params.s)
				this.$store.commit('RESET_TARGETED_PUPIL_SUBJECT_MARKS', this.$route.params.s)
				this.$store.dispatch('getAClasseMarks', {classe: this.$route.params.id, subject: this.$route.params.s, trimestre: this.trimestre})
        	}
        	if (!this.$route.params.id) {
        		id = this.targetedClasse.classe.id
        	}
        	else{
        		id = this.$route.params.id
        	}
            this.$store.dispatch('getAClasseData', id)
            
        },

		methods: {
			toggleOptions(){
				return this.showOptions = !this.showOptions
			},
			toggleComputing(){
				this.LoadedPage = true
				this.$store.commit('RESET_TARGETED_CLASSE_SUBJECT_TARGETED', this.$route.params.s)
				this.$store.commit('RESET_TARGETED_PUPIL_SUBJECT_MARKS', this.$route.params.s)
				this.$store.dispatch('getAClasseMarks', {classe: this.$route.params.id, subject: this.$route.params.s, trimestre: this.trimestre})
				setTimeout(() =>{
					this.LoadedPage = false
				}, 1000)
				return this.computedAVG = !this.computedAVG
				
			},
			editedPupilClasseAndSubjectMarks(pupil, subject){
				this.computedAVG = !this.computedAVG
				this.$store.commit('RESET_TARGETED_CLASSE_SUBJECT_TARGETED', this.$route.params.s)
				this.$store.commit('RESET_TARGETED_PUPIL_SUBJECT_MARKS', this.$route.params.s)
				this.$store.commit('SET_EDITED_PUPIL', pupil)
				this.$store.dispatch('getAPupilDataAndMarks', {route: pupil.id, trimestre: this.$route.params.t})
				$('#editPupilMarks .div-success').hide('slide', 'up')
                $('#editPupilMarks .div-success h4').text('')
                $('#editPupilMarks').animate({
                    top: '1px'
                })
                
                $('#editPupilMarks form').show('slide', {direction: 'up'}, 1, function(){
                    $('#editPupilMarks form').animate({
                        opacity: '0'
                    }, function(){
                        $('#editPupilMarks form').animate({
                            opacity: '1'
                        }, 800)
                        $('#editPupilMarks .buttons-div').show('fade')
                    })
                })
			},
			updateTargetedSubject(subject){
				this.LoadedPage = true
				this.$store.commit('RESET_TARGETED_CLASSE_SUBJECT_TARGETED', subject)
				this.$store.commit('RESET_TARGETED_PUPIL_SUBJECT_MARKS', subject)
				this.$store.dispatch('getAClasseMarks', {classe: this.$route.params.id, subject: this.$route.params.s, trimestre: this.trimestre})
				setTimeout(() =>{
					this.LoadedPage = false
				}, 2000)
			},
			updateTargetedTrimestre(trimestre){
				this.trimestre = trimestre
				this.LoadedPage = true
				this.$store.dispatch('getAClasseMarks', {classe: this.$route.params.id, subject: this.$route.params.s, trimestre: this.trimestre})
				setTimeout(() =>{
					this.LoadedPage = false
				}, 2000)
				
			},

			isTheTargetedSubject(subject){
				return subject == this.$route.params.s ? 'border-warning btn-primary' : 'btn-secondary'
			},
			getMarks(pupil, type, index, targetedClasseMarks){
				if(targetedClasseMarks[pupil] == null){
					return '-'
				}
				else{
					let marks = targetedClasseMarks[pupil]
					let interros = []
					let devoirs = []

					for (var i = 0; i < marks.length; i++) {
						if(marks[i].type == 'epe' || marks[i].type == 'interrogations'){
							interros.push(marks[i])
						}
						else if (marks[i].type == 'devoir' || marks[i].type == 'dev') {
							devoirs.push(marks[i])
						}
						
					}
					if(type == 'epe' || type == 'interrogations'){
						if(interros.length > 0){
							if(interros[index] == undefined){
								return '-'
							}
							else{
								return interros[index].value
							}
							
						}
						else{
							return '-'
						}
						
					}
					else if (type == 'dev' || type == 'devoir') {
						if(devoirs.length > 0){
							if(devoirs[index] == undefined){
								return '-'
							}
							else{
								return devoirs[index].value
							}
						}
						else{
							return '-'
						}
					}
				}
				
			},
			getAverage(pupil, targetedClasseMarks, coefs = this.targetedClasseSubjectsCoef, subject = this.targetedClasseSubject, subjectWithModalities = this.subjectWithModalities){
				this.$store.commit('RESET_TARGETED_CLASSE_SUBJECT_TARGETED', subject)
				this.$store.commit('RESET_TARGETED_PUPIL_SUBJECT_MARKS', subject)
				let marksAll = targetedClasseMarks
				let type = "epe"
				let interros = []
				let devoirs = []
				let som = 0
				let somEPE = 0
				let coef = coefs[subject]
				
				let avgEPE = 0
				let avg = 0

				if(!this.computedAVG){
					return {avgEPE: '-', avg: '-', avgCoef: '-'}
				}
				
				if(marksAll[pupil] !== null && marksAll[pupil] !== undefined){
					let marks = marksAll[pupil]
					for (var i = 0; i < marks.length; i++) {
						if(marks[i].type == 'epe' || marks[i].type == 'interrogations'){
							interros.push(marks[i].value)
						}
						else{
							devoirs.push(marks[i].value)
						}
					}

					if(interros.length > 0){
						if(subjectWithModalities[subject] !== undefined){
							let modality = subjectWithModalities[subject]
							if(interros.length <= modality){
								for (var i = 0; i < interros.length; i++) {
									somEPE += interros[i]
								}
								avgEPE = somEPE / interros.length
							}
							else{
								interros = this.getBest(interros, modality)
								for (var i = 0; i < interros.length; i++) {
									somEPE += interros[i]
								}
								avgEPE = somEPE / interros.length
							}
							
						}
						else{
							for (var i = 0; i < interros.length; i++) {
								somEPE += interros[i]
							}
							avgEPE = somEPE / interros.length
						}
					}

					let somDEV = 0
					if(devoirs.length > 0){
						for (var i = 0; i < devoirs.length; i++) {
							somDEV = somDEV + devoirs[i]
						}

						if(avgEPE !== 0){
							avg = (somDEV + avgEPE) / (devoirs.length + 1)
						}
						else{
							avg = somDEV / devoirs.length
						}
					}

					else{
						avg = avgEPE
					}

					if(avgEPE == 0){
						avgEPE = '-'
					}
					if(avg == 0){
						avg = '-'
					}

					avgEPE !== '-' ? avgEPE = Number.parseFloat(avgEPE).toFixed(2) : avgEPE = '-'

					return {avgEPE: avgEPE, avg: Number.parseFloat(avg).toFixed(2), avgCoef: Number.parseFloat(avg * coef).toFixed(2)}

				}
				else{
					return {avgEPE: '-', avg: '-', avgCoef: '-'}
				}


			},

			oderer(classe, subject = this.$route.params.s){
				let trimestre = this.$route.params.t
				this.LoadedPage = true
				this.$store.commit('RESET_TARGETED_CLASSE_SUBJECT_TARGETED', this.$route.params.s)
				this.$store.commit('RESET_TARGETED_PUPIL_SUBJECT_MARKS', this.$route.params.s)
				this.$store.dispatch('getOderer', {classe: classe, subject: this.$route.params.s, trimestre: trimestre})
				this.range = true
				this.computedAVG = true
				this.$store.dispatch('getAClasseMarks', {classe: this.$route.params.id, subject: this.$route.params.s, trimestre: trimestre})
				setTimeout(() =>{
					this.LoadedPage = false
				}, 2000)

			},

			changeModality(action = null){
				this.range = false
				this.$store.commit('RESET_MODALITY_ALERT', {status: true, message: ''})
				this.modality = !this.modality
			},

			resetAllModality(){

			},

			getBest(tab, limit){
				let bestMarks = []
				while (bestMarks.length < limit) {
					for (var i = 0; i < tab.length; i++) {
						if(tab[i] == Math.max(...tab)){
							bestMarks.push(tab[i])
							tab.splice(i, 1)
						}
						
					}
				}

				return bestMarks
			},

			isInTheBestMarks(pupil, subjectWithModalities, subject, markIndex, targetedClasseMarks = this.targetedClasseMarks){
				let mark = this.getMarks(pupil, 'epe', 0, targetedClasseMarks)
				let modality = subjectWithModalities[subject]

				let marksAll = targetedClasseMarks
				let type = "epe"
				let interros = []

				if(mark == '-'){
					return ''
				}
				
				
				if(marksAll[pupil] !== null && marksAll[pupil] !== undefined){
					let marks = marksAll[pupil]
					for (var i = 0; i < marks.length; i++) {
						if(marks[i].type == 'epe' || marks[i].type == 'interrogations'){
							interros.push(marks[i].value)
						}
					}
					if(modality !== undefined){
						let bestMarks = this.getBest(interros, modality)
						if(bestMarks.indexOf(mark) == -1){
							return 'text-danger'
						}
						return 'text-success'
						
					}
					else{
						return 'text-success'
					}
				}
			},

			updateModality(){
				this.$store.commit('RESET_MODALITY_ALERT', {status: true, message: 'Traitement en cours...'})
				let modality = $('form#classe-modality input[name=modalityLength]').val()
				let subject = this.targetedClasseSubject
				let classe = this.targetedClasse.id

				modality = parseInt(modality, 10)
				if(modality !== null){
					if(modality > 0 && modality < 6){
						this.$store.dispatch('updateClasseModality', {classe: this.$route.params.id, subject: subject, trimestre: this.$route.params.t, modality, token: this.token})
					}
					else{
						this.$store.commit('RESET_MODALITY_ALERT', {status: true, message: "La valeur renseignée est invalide"})
					}
				}
			},

			getRange(key, avg){
				if(this.range){
					if(avg !== '-'){
						if(key == 1){
							return {num: 1, sup: 'er'}
						}
						else{
							return {num: key, sup: 'ème'}
						}
					}
					else{
						return '-'
					}
					
					
				}
				else{
					return '-'
				}
				
			},
            setEdited(pupil){
            	let subject = this.$route.params.s
                this.$store.commit('SET_EDITED_PUPIL', pupil)
            },
            getTargetedSubjectName(){
            	let id = this.$route.params.s
            	let trim = this.$route.params.t
            	let name = ' ...'
            	let tables =  this.targetedClasse.subjects

            	for (var i = 0; i < tables.length; i++) {
            		if (tables[i].id == id) {
            			name = tables[i].name
            			if (name == 'Physique-Chimie-Technologie') {
            				return {name: 'PCT', trim}
            			}
            			return {name, trim}
            		}
            	}
            }

		},
		

		computed: mapState([
            'allClasses', 'successed', 'invalidInputs', 'errors', 'targetedClasse', 'targetedClasseMarks', 'targetedClasseSubject', 'targetedClasseSubjectsCoef', 'targetPupilMarks', 'editedPupil', 'editedPupilSubjectMarks', 'editedPupilClasseMarks', 'targetedClasseModality', 'token', 'alertModality', 'subjectWithModalities'
        ])

	}
</script>

<style>
	.no-tag{
		width: 1%;
	}
	.pupils-tag{
		width: 20%;
	}
	.subjects-tag{
		
	}
	.actions-tag{
		width: 5%;
	}
	.border-white-50{
		border-color: rgba(200, 200, 200, 0.5) !important;
	}

	td{
		border-right: thin solid rgba(200, 200, 200, 0.5);
		padding-bottom: 2px;
		padding-top: 2px;
	}
	.classes-marks .notes td{
		width: 12.49% !important;
	}
	.classes-marks .moyennes td{
		min-width: 33.3% !important;
	}

	tr:nth-child(even){
		background: linear-gradient(60deg,rgba(0, 0, 0, 0.8), rgba(100, 100, 150, 0.7), rgba(0, 0, 0, 0.8)) !important;

	}

	
</style>