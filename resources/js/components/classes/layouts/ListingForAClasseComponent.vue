<template>
	<div class="w-100 d-flex justify-content-center">
		<div class="w-100">
			<div class="w-100">
				<div class="m-0 p-0 d-flex w-100 my-1 py-1 justify-content-center">
		            <div class="p-0 m-0 mx-1 my-0 w-100">
		                <h5 class="d-flex justify-content-between w-100 p-2">
			                <span>
			                	<span class="text-white-50">CSP LA PRUNELLE</span>
			                </span> 
			                <div class="d-flex justify-content-center w-25">
			                	<div class="w-100 d-flex justify-content-center">
			                		<span style="font-size: 20px;">
			                			{{targetedClasse.classeFMT.name}}<sup>{{ targetedClasse.classeFMT.sup }}</sup> {{ targetedClasse.classeFMT.idc }}
			                		</span>
			                		<span title="Modifier le nom de cette classe" style="font-size: 10px ;" class="text-white-50 fa fa-edit mx-1" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(targetedClasse.classe, 'name')"></span>
			                	</div>
			                </div>
			                <span>
			                	<span class="text-white-50">Année Scolaire:</span> 2020 - 2021
			                </span>
			            </h5>
		        		<hr class="bg-white m-0 p-0">
		            </div>
		        </div>
		        <div class="profil-admin d-lg-inline-block d-sm-flex d-md-flex justify-content-sm-around justify-content-md-around float-left">
					<div class="w-100 float-left">
						<div class="w-50 d-flex justify-content-start" id="options">
							<div class="mx-2" @click="toggleOptions(showOptions)" v-if="!showOptions">
								<span class="fa fa-sliders fa-2x float-right"></span>
							</div>
							<div class="mx-2" @click="toggleOptions(showOptions)" v-if="showOptions">
								<span class="fa fa-2x fa-chevron-up float-right"></span>
							</div>
							<div class="mx-1">
								<span class="float-right fa fa-user-plus fa-2x" title="Ajouter un nouvel apprenant..." data-toggle="modal" data-target="#newPupilPersoModal" @click="addNewPupil()">
	                            </span>
							</div>
							<div class="mx-2 refresh">
								<span @click="resetRefreshClasseConfirm()" class="float-right fa-2x fa fa-refresh text-danger" title="Rafraichir cette classe..." data-toggle="modal" data-target="#confirmRefreshClassModal">
	                            </span>
							</div>
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
			                            <router-link :to="{name: 'classeMarks', params: {id: $route.params.id}}" class="w-100 my-1 hover link-float" style="border-radius: 30px;">
			                            	<i class="fa fa-file-text fa-sm fa-fw mr-2"></i>
			                              Les Notes
		            					</router-link>
		            					
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
				<div class="mx-auto d-flex border justify-content-center mt-0 p-1 w-25 bg-linear-official-180">
					<div class="m-0 p-0">
                		<span> 
                			<span class="text-white-50">Principal: </span>
                			<router-link v-if="targetedClasse.heads.teacher !== null" :to="{name: getRouteForTeacher(targetedClasse.heads.teacher).name, params: {id: getRouteForTeacher(targetedClasse.heads.teacher).id}}"   class="d-inline-block text-white card-link" style="font-size: 1em !important;">
                				{{ targetedClasse.heads.teacher.name }}
                			</router-link>
                			<span class="text-muted" v-if="targetedClasse.heads.teacher == null">
                				{{ 'Non défini'}}
                			</span>
                			<span title="Modifier le prof principal de cette classe" style="font-size: 10px ;" class="text-white-50 fa fa-edit float-right mx-1" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(targetedClasse.classe, 'teacher')"></span>
                		</span>
                	</div>
				</div>
		        <span class="fa fa-close float-right mb-2 text-right d-inline-block" v-if="!hideGrandPanel" @click="toggleGrandPanel()" title="Masquer le panel"></span>
		        <span class="fa fa-chevron-down float-right mb-2 text-right d-inline-block" v-if="hideGrandPanel" @click="toggleGrandPanel()" title="Afficher le panel"></span>
		        <transition name="scale" appear>
				<div class="d-flex w-100 my-1 py-1 justify-content-between border" v-if="!hideGrandPanel">
					<div class="mx-1 d-flex flex-column font-italic border border-dark ">
						<div class="mx-2">
		            		<h5 class="text-white-50 h5-title">1<sup>er</sup> Responsable: 
	                			<span v-if="targetedClasse.heads.respo1 !== null">
	                				<router-link :to="{name: getRouteForPupil(targetedClasse.heads.respo1).name, params: {id: getRouteForPupil(targetedClasse.heads.respo1).id}}"   class="d-inline-block text-white card-link" style="font-size: 1em !important;">
	                				{{ targetedClasse.heads.respo1.name }}
	                			</router-link>
	                				<span title="Modifier le responsable de cette classe" style="font-size: 10px ;" class="text-white-50 fa fa-edit float-right mx-1" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(targetedClasse.classe, 'respo1')">
	                				</span>
	                			</span>
	                			<span class="text-muted" v-if="targetedClasse.heads.respo1 == null">
	                				{{ 'Non défini'}}
	                				<span title="Définir maintenant le responsable de cette classe" style="font-size: 10px ;" class="text-white-50 fa fa-edit float-right mx-1" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(targetedClasse.classe, 'respo1')">
	                				</span>
	                			</span>
		            		</h5>
		            	</div>
		            	<div>
		            		<h5 class="text-white-50 h5-title">2<sup>ème</sup> Responsable: 
		            			<span v-if="targetedClasse.heads.respo2 !== null">
		            				<router-link :to="{name: getRouteForPupil(targetedClasse.heads.respo2).name, params: {id: getRouteForPupil(targetedClasse.heads.respo2).id}}"   class="d-inline-block text-white card-link" style="font-size: 1em !important;">
	                					{{ targetedClasse.heads.respo2.name }}
	                				</router-link>
	                				<span title="Définir maintenant le responsable de cette classe" style="font-size: 10px ;" class="text-white-50 fa fa-edit float-right mx-1" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(targetedClasse.classe, 'respo2')">
	                				</span>
		            			</span>
	                			<span class="text-muted" v-if="targetedClasse.heads.respo2 == null">
	                				{{ 'Non défini'}}
	                				<span title="Définir maintenant le responsable de cette classe" style="font-size: 10px ;" class="text-white-50 fa fa-edit float-right mx-1" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(targetedClasse.classe, 'respo2')">
	                				</span>
	                			</span>
		            		</h5>
		            	</div>
					</div>
					<div class="float-right d-flex justify-content-around pr-2 mt-1 mb-0 border py-1" :class="type" v-if="alert">
                        <p class="h5-title m-0 px-2 pt-2">
                            <span class="mx-2 fa fa-envelope-open"></span>{{ message }}
                        </p>
                        <span class="mx-1 fa fa-close text-danger" @click="resetAlert()"></span>
                    </div>
		            <div class="mx-1 d-flex flex-column font-italic border border-dark ">
		            	<span class="fa fa-close float-right text-right d-inline-block w-100" v-if="!hidePanel" @click="togglePanel()"></span>
		            	<span class="fa fa-chevron-down float-right text-right d-inline-block w-100" v-if="hidePanel" @click="togglePanel()"></span>
		            	<div class="mx-1 d-flex justify-content-between font-italic">
		            		<div class="mx-2">
			            		<h5 class="text-white-50 h5-title">Effectif: {{ targetedClasse.pupils.length}}</h5>
			            	</div>
			            	<div class="mr-2">
			            		<h5 class="text-white-50 h5-title">Filles: {{getLengths().girls >= 10 ? getLengths().girls : '0'+ getLengths().girls}}</h5>
			            	</div>
			            	<div>
			            		<h5 class="text-white-50 h5-title">Garçons: {{getLengths().boys >= 10 ? getLengths().boys : '0' + getLengths().boys}}</h5>
			            	</div>
		            	</div>
		            	<transition name="fadeR" appear>
		            		<div class="mx-1 d-flex justify-content-between font-italic" v-if="!hidePanel">
			            		<div class="mx-2">
				            		<h5 class="text-white-50 h5-title">Meilleur apprenant de la salle: <span class="text-success">Pierre Martin</span></h5>
				            	</div>
				            	<div>
				            		<h5 class="text-white-50 h5-title">Faible apprenant de la salle: <span class="text-danger">Hubert Jorges</span></h5>
				            	</div>
			            	</div>
		            	</transition>
		            	<transition name="fadeR" appear>
			            	<div class="mx-1 d-flex justify-content-between font-italic" v-if="!hidePanel">
			            		<div class="mx-2">
				            		<h5 class="text-white-50 h5-title">1<sup>er</sup> Responsable: 
			                			<span v-if="targetedClasse.heads.respo1 !== null">
			                				<router-link v-if="targetedClasse.heads.respo1 !== null" :to="{name: getRouteForPupil(targetedClasse.heads.respo1).name, params: {id: getRouteForPupil(targetedClasse.heads.respo1).id}}"   class="d-inline-block text-white card-link" style="font-size: 1em !important;">
				                				{{ targetedClasse.heads.respo1.name }}
				                			</router-link>
				                			<span title="Définir maintenant le responsable de cette classe" style="font-size: 10px ;" class="text-white-50 fa fa-edit float-right mx-1" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(targetedClasse.classe, 'respo1')">
	                						</span>
			                			</span>
			                			<span class="text-muted" v-if="targetedClasse.heads.respo1 == null">
			                				{{ 'Non défini'}}
			                				<span title="Définir maintenant le responsable de cette classe" style="font-size: 10px ;" class="text-white-50 fa fa-edit float-right mx-1" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(targetedClasse.classe, 'respo1')">
	                						</span>
			                			</span>
				            		</h5>
				            	</div>
				            	<div>
				            		<h5 class="text-white-50 h5-title">2<sup>ème</sup> Responsable: 
				            			<span v-if="targetedClasse.heads.respo2 !== null">
				            				<router-link :to="{name: getRouteForPupil(targetedClasse.heads.respo2).name, params: {id: getRouteForPupil(targetedClasse.heads.respo2).id}}"   class="d-inline-block text-white card-link" style="font-size: 1em !important;">
			                					{{ targetedClasse.heads.respo2.name }}
			                				</router-link>
			                				<span title="Définir maintenant le responsable de cette classe" style="font-size: 10px ;" class="text-white-50 fa fa-edit float-right mx-1" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(targetedClasse.classe, 'respo2')">
	                						</span>
				            			</span>
			                			<span class="text-muted" v-if="targetedClasse.heads.respo2 == null">
			                				{{ 'Non défini'}}
			                				<span title="Définir maintenant le responsable de cette classe" style="font-size: 10px ;" class="text-white-50 fa fa-edit float-right mx-1" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(targetedClasse.classe, 'respo2')">
	                						</span>
			                			</span>
				            		</h5>
				            	</div>
			            	</div>
			            </transition>
		            </div>
		        </div>
		        </transition>
			</div>
			<listing-pupils :redList="false" :isProfil="true" :thePupils="targetedClasse.pupils"></listing-pupils>
		</div>
	</div>
</template>


<script>
    import { mapState } from 'vuex'
    export default { 
        props : [],
        editedPupil: {}, 

        data() {
            return {
                selfMonths : [
                    "Janvier",
                    "Février",
                    "Mars",
                    "Avril",
                    "Mai",
                    "Juin",
                    "Juillet",
                    "Août",
                    "Septembre",
                    "Octobre",
                    "Novembre",
                    "Décembre"

                ],
                profiler: false,
                girlsLength: 0,
                boysLength: 0,
                hidePanel: true,
                hideGrandPanel: false,
                showOptions: false,
            }   
        },
        created(){
        	
        },

        methods :{
        	getRouteForPupil(pupil){
        		let id = 1
        		if(pupil !== null && pupil !== undefined){
        			id = pupil.id
        			return {name: 'pupilsProfil', id}
        		}
        	},
        	getRouteForTeacher(id){
        		if(id !== undefined){
        			return {name: 'teachersProfil', id: id}
        		}
        	},

        	getLengths(pupils = this.targetedClasse.pupils){

        		let girls = []
        		let boys = []
        		for (var i = 0; i < pupils.length; i++) {
        			if(pupils[i].sexe == "female"){
        				girls.push(pupils[i])
        			}
        			else{
        				boys.push(pupils[i])
        			}
        			
        		}

        		return {boys: boys.length, girls: girls.length}
        	},
        	resetAlert(){
                this.$store.commit('ALERT_RESET')
            },

        	togglePanel(){
        		return this.hidePanel = !this.hidePanel
        	},
        	toggleGrandPanel(){
        		return this.hideGrandPanel = !this.hideGrandPanel
        	},
        	getClasse(){
        		return this.hidePanel == true ? '' : 'flex-column'
        	},
        	toggleOptions(){
				return this.showOptions = !this.showOptions
			},

			getSubject(){
				let subjects = this.targetedClasse.subjects
				return subjects[0].id
			},
			addNewPupil(){
                this.$store.commit('RESET_NEW_PUPIL')
                this.newPupil.classe_id = this.$route.params.id
                this.newPupil.level = this.targetedClasse.classe.level
                this.newPupil.month = this.selfMonths[(new Date).getMonth()]
                this.$store.dispatch('getTOOLS')
                this.$store.commit('RESET_INVALID_INPUTS')
                
                $('#newPupilPersoModal .div-success').hide('slide', 'up')
                $('#newPupilPersoModal .div-success h4').text('')
                $('#newPupilPersoModal form').show('fade', function(){
                    $('#newPupilPersoModal .buttons-div').show('fade')
                })
            },
            resetRefreshClasseConfirm(){
            	this.$store.commit('RESET_REFRESH_CLASSE_CONFIRMATION', {status: false, confirm: false})
            },
            setEdited(classe, tag){
                this.$store.commit('RESET_INVALID_INPUTS')
                
                $('#editClasseModal .div-success').hide('slide', 'up')
                $('#editClasseModal .div-success h4').text('')
                $('#editClasseModal').animate({
                    top: '100'
                })
                
                $('#editClasseModal form').show('slide', {direction: 'up'}, 1, function(){
                    $('#editClasseModal form').animate({
                        opacity: '0'
                    }, function(){
                        $('#editClasseModal form').animate({
                            opacity: '1'
                        }, 800)
                        $('#editClasseModal .buttons-div').show('fade')
                    })
                })

                if(tag == 'teacher' || tag == 'respo1' || tag == 'respo2'){
                    this.$store.dispatch('getAClasseTeachersAndPupils', classe.id)
                }
                
                this.$store.commit('RESET_EDITING_CLASSE', {classe: classe, tag: tag}) 
            },
        },

        computed: mapState([
           'classes', 'classesAll', 'tl', 'alertClassesSearch', 'alert', 'message', 'type', 'months', 'successed', , 'errors', 'targetedClasse', 'newPupil', 'refreshClasse', 'editingClasse', 'targetedClasseTeachers', 'targetedClassePupils'
        ])
    }

    
</script>
<style>
    div#options span:hover, span.fa.fa-edit:hover{
    	transform: scale(1.1);
    }
</style>

