<template>
	<div class="container-profil bg-linear-official-180 mx-1 p-0 border">
		<div id="text-profil-container-opac">
			<h3 class="text-profil-opac mx-auto text-center">

			</h3>
		</div>
		<div class="justify-content-center w-100 m-0 p-0">
			<transition name="fade" appear>
				<!-- <pupil-profil-main></pupil-profil-main> -->
			</transition>
		</div>
		<div class="d-flex w-100 my-1 py-1 justify-content-start">
            <div class="mx-1 my-0 w-100">
                <h5 class="d-flex justify-content-between w-100 p-2">
	                <span>
	                	<span class="text-white-50">Relevés de notes de :</span> {{ editedPupil.name }} <span>du trimestre {{ this.$route.params.trimestre }} </span>
	                </span> 
	                <div class="d-flex justify-content-between">
	                	<div class="mr-2">
	                		<router-link :to="{name: 'classesProfil', params: {id: classeID}}"   class="card-link text-white-50 d-inline-block">
	                			<span class="text-white-50">Classe :</span> {{targetPupilClasseFMT.name}}<sup>{{ targetPupilClasseFMT.sup }}</sup> {{ targetPupilClasseFMT.idc }}
	                		</router-link>
	                	</div>
	                	<div class="ml-2" v-if="editedPupil.level == 'primary'">
	                		<span> <span class="text-white-50">Maître: </span>{{ 'Mr TOGAN Martin' }}</span>
	                	</div>
	                </div>
	                <span>
	                	<span class="text-white-50">Année Scolaire:</span> 2020 - 2021
	                </span>
	            </h5>
            </div>
        </div>
		<div class="d-flex w-100 my-1 py-1 justify-content-between">
            <div class="mx-1 my-0 trimestrielle">
                <span :class="'btn btn-secondary text-white-50 py-1 light-parent'" @click="setTrimestre(1)">
                	<hr :class="'light m-0 p-0'">
	                <router-link :to="'/admin/director/pupilsm/' + this.$route.params.id + '/marks/index/trimestre/1'"  class="text-white">Trimestre 1
	            	</router-link>
            	</span>
                <span :class="'btn btn-secondary text-white-50 py-1'" @click="setTrimestre(2)">
                	<hr :class="'light m-0 p-0'">
                	<router-link :to="'/admin/director/pupilsm/' + this.$route.params.id + '/marks/index/trimestre/2'" class="text-white">Trimestre 2
	            	</router-link>
	            </span>
                <span class="btn btn-secondary text-white-50 py-1" @click="setTrimestre(3)">
                	<hr :class="'light m-0 p-0'">
                	<router-link :to="'/admin/director/pupilsm/' + this.$route.params.id + '/marks/index/trimestre/3'" class="text-white">Trimestre 3
	            	</router-link>
	            </span>
                <span class="btn btn-warning text-dark py-1" v-if="targetPupilClasseFMT.name == '3' || targetPupilClasseFMT.name == 'T' || targetPupilClasseFMT.name == 'CM2'">Les notes d'examens</span>
            </div>
            <div class="mx-1 d-flex justify-content-between flex-column font-italic">
            	<div class="mx-1 d-flex justify-content-between font-italic">
	            	<div class="mx-2">
	            		<h5 class="text-white-50 h5-title">
	            			Plus Faible note: <span class="text-danger" v-if="targetPupilWeakMark !== undefined && targetPupilWeakMark !== 0">{{ targetPupilWeakMark == undefined ? '...' : targetPupilWeakMark }} ({{ targetPupilWeakMarkSuject == undefined ? '...' : targetPupilWeakMarkSuject }})</span>
	            		</h5>
	            	</div>
	            	<div>
	            		<h5 class="text-white-50 h5-title">
	            			Plus Forte note: <span class="text-success" v-if="targetPupilBestMark !== undefined && targetPupilBestMark !== 0">
	            			{{ targetPupilBestMark == undefined ? '...' : targetPupilBestMark }} ({{ targetPupilBestMarkSuject == undefined ? '...' : targetPupilBestMarkSuject }})
	            		</span>
	            		</h5>
	            	</div>
	            </div>
	            <div class="mx-1 d-flex justify-content-between font-italic">
	            	<div class="mx-2">
	            		<h5 class="text-white-50 h5-title">Dernière Evaluation: <span class="text-warning" v-if="targetPupilLastMark !== undefined && targetPupilLastMark !== 0"> {{ targetPupilLastMark == undefined ? '...' : targetPupilLastMark }} ({{ targetPupilLastMarkSuject == undefined ? '...' : targetPupilLastMarkSuject }}) </span></h5>
	            	</div>
	            	<div>
	            		<h5 class="text-white-50 h5-title">Réussite des Evaluations: <span class="text-success">
	            			<span>{{ targetPupilPercentageSuccedMarks == undefined ? '...'  : targetPupilPercentageSuccedMarks + '%'}}</span></span>
	            		</h5>
	            	</div>
	            </div>
            </div>
        </div>
		<div class="mt-1" id="pupil-profil">
			<div class="d-flex justify-content-between">
				<transition name="justefade" appear>
					<marks-table></marks-table>
				</transition>
			</div>
		</div>
	</div>
</template>

<script>
	import { mapState } from 'vuex'

	export default{
		data() {
            return {
            	classeID: 0,
            }   
        },

        created(){
        	this.$store.dispatch('getAPupilDataAndMarks', {route: this.$route.params.id, trimestre: this.$route.params.trimestre})
        	axios.get('/admin/director/pupilsm/get&classe&of&pupil&with&data&credentials/id=' + this.$route.params.id)
                .then(response => {
                    this.$store.commit('GET_A_PUPIL_DATA', response.data)
                    this.classeID = this.editedPupil.classe_id
                }
            )
        },
		


		methods: {

			setTrimestre(trimestre){
				this.$store.dispatch('getAPupilDataAndMarks', {route: this.$route.params.id, trimestre:trimestre})
			},

			getTrimestre(trimestre){
				return trimestre == this.$route.params.trimestre ? 'btn-primary' : 'btn-secondary'
				
			}

		},
		computed: mapState([
          	'targetPupilLastName', 'targetPupilFirstName', 'targetPupilClasseFMT', 'targetPupilBirthFMT', 'targetPupilMarks', 'editedPupilSubjects', 'editedPupil', 'targetPupilLastMark', 'targetPupilLastMarkSuject', 'targetPupilBestMark', 'targetPupilBestMarkSuject', 'targetPupilWeakMark', 'targetPupilWeakMarkSuject', 'targetPupilPercentageSuccedMarks'
        ])

	}

$(function(){
	$('.trimestrielle > span').click(function(){
		$('.trimestrielle').removeClass('.increase-opacity')
		$(this).addClass('.increase-opacity')
	})
})
</script>

<style>
.light{
	position: relative;
	background-color: #8fde62;
	box-shadow: 0px 7px 7px #8fde62;
	top: 0;
	width: 100%;
	border-bottom-right-radius: 100%;
	border-bottom-left-radius: 100%;
	border: thin solid #8fde62;
	opacity: 0;
}

.increase-opacity hr.light{
	opacity: 1 !important;
}


</style>
