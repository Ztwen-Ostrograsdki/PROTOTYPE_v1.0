<template>
	<div class="w-100 d-flex justify-content-center">
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
						<div class="text-right w-100" @click="toggleOptions(showOptions)" v-if="!showOptions">
							<span class="fa fa-sliders float-right"></span>
						</div>
						<div class="text-right w-100" @click="toggleOptions(showOptions)" v-if="showOptions">
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
		        <span class="fa fa-close float-right mb-2 text-right d-inline-block" v-if="!hideGrandPanel" @click="toggleGrandPanel()" title="Masquer le panel"></span>
		        <span class="fa fa-chevron-down float-right mb-2 text-right d-inline-block" v-if="hideGrandPanel" @click="toggleGrandPanel()" title="Afficher le panel"></span>
		        <transition name="scale" appear>
				<div class="d-flex w-100 my-1 py-1 justify-content-end border" v-if="!hideGrandPanel">
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
				            		<h5 class="text-white-50 h5-title">1<sup>er</sup> Responsable: <span class="">HOUNGHO Haner</span></h5>
				            	</div>
				            	<div>
				            		<h5 class="text-white-50 h5-title">2<sup>ème</sup> Responsable: <span class="">GAGA Qoner</span></h5>
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
			}
        },


        computed: mapState([
           'classes', 'classesAll', 'tl', 'alertClassesSearch', 'alert', 'message', 'months', 'successed', , 'errors', 'targetedClasse'
        ])
    }

    
</script>
<style>
    
</style>

