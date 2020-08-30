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
							<div class="text-right w-100 ml-2" @click="toggleOptions(showOptions)" v-if="!showOptions">
								<span class="fa fa-sliders float-right"></span>
							</div>
							<div class="text-right w-100 ml-2" @click="toggleOptions(showOptions)" v-if="showOptions">
								<span class="fa fa-chevron-up float-right"></span>
							</div>
							<transition name="scalefade" appear>
							<div class="login-profil  position-absolute border border-white" style="width: 250px; top: 165px; left:18px; z-index: 100; background-image: url(/media/img/art-2578353_1920.jpg) !important; background-position: -200px 300px;" v-if="showOptions">
				                <div class="w-100 border" style="">
				                    <a class="w-100 link-float d-inline-block border m-0 py-1" href="#">
				                        <i class="fa fa-sliders fa-sm fa-fw mr-2"></i>
				                        <span>Options</span>
				                        <span class="mr-2 d-none d-lg-inline text-dark float-right"></span>
				                    </a>
				                      <!-- Dropdown - User Information -->
				                    <div class="w-100 border">
				                            <a class="w-100 my-1 hover link-float" href="" style="border-radius: 30px;">
				                                <i class="fas fa-cogs fa-sm fa-fw mr-2"></i>
				                              Administation
				                            </a>
				                            <router-link :to="'/admin/director/classesm/' + this.$route.params.id + '/marks/index' " class="w-100 my-1 hover link-float" style="border-radius: 30px;">
				                            	<i class="fa fa-file-text fa-sm fa-fw mr-2"></i>
				                              Les notes
			            					</router-link>
			            					
				                            <a class="w-100 my-1 hover link-float" href="" style="border-radius: 30px;">
				                                <i class="fa fa-line-chart fa-sm fa-fw mr-2"></i>
				                              1<sup>er</sup> Trimestre
				                            </a>
				                            <a class="w-100 my-1 hover link-float" href="" style="border-radius: 30px;">
				                                <i class="fa fa-line-chart fa-sm fa-fw mr-2"></i>
				                              2<sup>ème</sup> Trimestre
				                            </a>
				                            <a class="w-100 my-1 hover link-float" href="" style="border-radius: 30px;">
				                                <i class="fa fa-line-chart fa-sm fa-fw mr-2"></i>
				                              3<sup>ème</sup> Trimestre
				                            </a>
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
					<transition name="fadelow" appear>
						<div class="d-flex w-75 float-right justify-content-end pr-2">
							<span class="btn border p-1 ml-1" :class="isTheTargetedSubject(subject)" v-for="subject in targetedClasse.subjects" @click="updateTargetedSubject(subject)">{{ subject.name }}</span>
						</div>
					</transition>
				</div>
			</div>
		</div>
		<div class="w-100 mx-auto d-flex justify-content-center bg-linear-official-180">
			<table class="table-table table-striped w-100 classes-marks">
				<transition name="justefade" appear>
                    <thead>
                        <th class=" no-tag">No</th>
                        <th class=" pupils-tag">Elèves</th>
                        <th class="subjects-tag">Notes</th>
                        <th class="subjects-tag">Moyennes</th>
                        <th class="actions-tag">Actions</th>
                    </thead>
                </transition>
               	<transition name="fadelow" appear>
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
                    			<span class="fa fa-recycle"></span>
                    		</td>
                    	</tr>
                    	<tr class="border-bottom border-white" v-for="(pupil, k) in targetedClasse.pupils">
                    		<td>{{ k + 1 }}</td>
                    		<td>{{pupil.name}}</td>
                    		<td>
                    			<table class="w-100">
                    				<tbody class="w-100 notes">
                    					<tr class="w-100">
		                    				<td>{{ getMarks(pupil.id, 'epe', 0, targetedClasseMarks) }}</td>
		                    				<td>{{ getMarks(pupil.id, 'epe', 1, targetedClasseMarks) }}</td>
		                    				<td>{{ getMarks(pupil.id, 'epe', 2, targetedClasseMarks) }}</td>
		                    				<td>{{ getMarks(pupil.id, 'epe', 3, targetedClasseMarks) }}</td>
		                    				<td>{{ getMarks(pupil.id, 'epe', 4, targetedClasseMarks) }}</td>
		                    				
		                    				<td class="text-primary">{{getAverage(pupil.id, targetedClasseMarks).avgEPE}}</td>
		                    				<td>{{ getMarks(pupil.id, 'devoir', 0, targetedClasseMarks) }}</td>
		                    				<td>{{ getMarks(pupil.id, 'devoir', 1, targetedClasseMarks) }}</td>
		                    			</tr>
                    				</tbody>
                    			</table>
                    		</td>
                    		<td>
                    			<table class="w-100">
                    				<tbody class="w-100">
                    					<tr class="w-100">
		                    				<td class="text-success">12</td>
		                    				<td class="text-warning">45</td>
		                    				<td class="text-info">1er</td>
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
	import averageComputor from '../../../helpers/helpers.js'

	export default{
		data() {
            return {
            	showOptions: false,
            	trimestre: 1,
            }   
        },
        created(){
            this.$store.dispatch('getAClasseData', this.$route.params.id)
            this.$store.dispatch('getAClasseMarks', {classe: this.$route.params.id, subject: this.targetedClasseSubject, trimestre: this.trimestre})
        },

		methods: {
			toggleOptions(){
				return this.showOptions = !this.showOptions
			},
			editedPupilClasseAndSubjectMarks(subject){
				this.$store.commit('RESET_TARGETED_PUPIL_SUBJECT_MARKS', subject)
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
				this.$store.commit('RESET_TARGETED_CLASSE_SUBJECT_TARGETED', subject)
				this.$store.dispatch('getAClasseMarks', {classe: this.$route.params.id, subject: this.targetedClasseSubject, trimestre: this.trimestre})
			},

			isTheTargetedSubject(subject){
				return subject.id == this.targetedClasseSubject ? 'border-warning btn-primary' : 'btn-secondary'
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
			getAverage(pupil, targetedClasseMarks){
				let marksAll = targetedClasseMarks
				let type = "epe"
				let interros = []
				let devoirs = []
				let som = 0
				let somEPE = 0
				let somDEV = 0
				let avgEPE = 0
				let avg = 0
				if(marksAll[pupil] !== null){
					let marks = marksAll[pupil]
					for (var i = 0; i < marks.length; i++) {
						if(marks[i].type == 'epe' || marks[i].type == 'interrogations'){
							interros.push(marks[i])
						}
						else if (marks[i].type == 'devoir' || marks[i].type == 'dev') {
							devoirs.push(marks[i])
						}
					}

					if(interros.length > 0){
						for (var i = 0; i < interros.length; i++) {
							somEPE += interros[i].value
						}
						avgEPE =  parseFloat(somEPE / interros.length).toFixed(2)
					}
					else{
						avgEPE = 0
					}

					if(devoirs.length > 0){
						for (var i = 0; i < devoirs.length; i++) {
							somDEV += devoirs[i].value
						}

						if(avgEPE > 0){
							avg = Number.parseFloat((somDEV + avgEPE) / (devoirs.length + 1)).toFixed(2)
						}
						else{
							avg = Number.parseFloat(somDEV / devoirs.length).toFixed(2)
						}
					}
					else{
						avg = avgEPE
					}

					
					
					return {avgEPE: avgEPE, avg: avg}

				}
				else{
					return {avgEPE: '-', avg: '-'}
				}
			},

		},

		computed: mapState([
            'allClasses', 'successed', 'invalidInputs', 'errors', 'targetedClasse', 'targetedClasseMarks', 'targetedClasseSubject'
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

	.classes-marks tr td{
		border-right: thin solid white;
	}
	.classes-marks .notes td{
		width: 12.49% !important;
	}
	.classes-marks .moyennes td{
		min-width: 33.3% !important;
	}

	
</style>