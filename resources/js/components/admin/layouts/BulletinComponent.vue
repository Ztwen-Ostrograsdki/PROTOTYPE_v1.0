<template>
	<div class="w-100 row px-3" style="height: 560px;">
		<div class="col-1 position-fixed" v-if="!showOptions" style="z-index: 300">
			<span class="fa fa-chevron-down" @click="toggleOptions()" title="Dérouler les options"></span>
		</div>
		<transition name="justefade">
		<div class="col-2 px-1 d-flex flex-column position-fixed" style="z-index: 300" v-if="showOptions">
			<span class="fa fa-close m-2" @click="toggleOptions()" title="Masquer les options"></span>
			<span class="float-right bg-linear-official-180 p-2 border border-white cursor">
				<span class="fa fa-mail-reply"></span>
				<router-link :to="'/admin/director/pupilsm/' + this.$route.params.id + '/marks/index/trimestre/1'" class="card-link text-white ml-2">
                  Revenir aux notes
				</router-link>
			</span>
			<span class="float-right bg-linear-official-180 p-2 border border-white cursor my-1">
				<span class="fa fa-send"></span>
				<span class="mx-2">Envoyez le bulletin aux parents</span>
			</span>
			<span class="float-right bg-linear-official-180 p-2 border border-white cursor">
				<span class="fa fa-print"></span>
				<span class="mx-2">Convertir en PDF puis Imprimer</span>
			</span>
		</div>
		</transition>

		<div class="border border-white rounded w-50 mx-auto p-2 bg-linear-official-50" id="bulletin">
			<div class="w-100 border-white text-white-50 border mx-auto bg-linear-official-180 p-2 my-1" style="border-style: double;">
				<div class="w-100 text-center p-0 m-0 mx-auto d-flex justify-content-center flex-column">
					<div class="mb-1">
						<h4 class="m-0 p-0 border-bottom border-white d-inline">République du Bénin</h4>
					</div>
					<div class="mb-1">
						<h5 class="m-0 p-0 border-bottom border-white d-inline">Ministère de l'enseignement Secondaire</h5>
					</div>
					<div class="mb-1">
						<h5 class="m-0 p-0 border-bottom border-white d-inline">Complexe Scolaire LA PRUNELLE</h5>
					</div>
				</div>
			</div>
			<div class="w-100 border-white border mx-auto bg-linear-official-180 p-2">
				<h5 class="mx-auto w-100 text-uppercase text-white-50 text-center text-title" style="font-size: 20px;">Bulletin de notes - 1<sup>er</sup> Trimestre</h5>
				<div class="w-100 bg-linear-official-180 py-1 my-1 border" style="border-color: rgb(170, 170, 170) !important;"></div>

				<div class="mx-auto d-flex justify-content-between">
					<div class="">
						<h5 class="text-title text-white-50" style="font-size: 12px"><span>BP 15 Contacts:</span> <span>95 95 35 35</span></h5>
					</div>
					<div class="">
						<h5 class="text-title text-white-50" style="font-size: 12px"><span>Année-Scolaire :</span> <span>2020-2021</span></h5>
					</div>
				</div>
				<hr class="p-0 m-0 bg-white">
				<div class="mx-auto d-flex justify-content-between">
					<div class="">
						<h5 class="text-title text-white-50" style="font-size: 12px"><span>Nom et Prénoms:</span> <i>{{ targetPupil.name }}</i></h5>
						<h5 class="text-title text-white-50" style="font-size: 12px"><span>Classe: </span><span>{{targetPupilClasseFMT.name}}<sup>{{ targetPupilClasseFMT.sup }}</sup> {{ targetPupilClasseFMT.idc }}</span></h5>
					</div>
					<div class="">
						<h5 class="text-title text-white-50" style="font-size: 12px"><span>Redoublant :</span> <span>Non</span></h5>
						<h5 class="text-title text-white-50" style="font-size: 12px"><span>Effectif :</span> <span>30</span></h5>
					</div>
				</div>
				<hr class="p-0 m-0 bg-white">
				<hr class="p-0 m-0 my-1 bg-white">
				<div class="mx-auto d-flex justify-content-between w-100">
					<table class="text-white-50 w-100">
						<thead class="bg-linear-official-180">
							<th>Discipline</th>
							<th>Coef</th>
							<th>Moy</th>
							<th>Moy. Coef.</th>
							<th>Appréciation</th>
							<th>Nom et Signature</th>
						</thead>
						<tbody>
							<tr>
								<td class="text-left">Mathématiques</td>
								<td>3</td>
								<td>45</td>
								<td>15</td>
								<td class="cursive">A Bien</td>
								<td>Geraud MATA</td>
							</tr>
							<tr>
								<td class="text-left">SVT</td>
								<td>3</td>
								<td>47.25</td>
								<td>15.50</td>
								<td class="cursive">A Bien</td>
								<td>Gitia MOSES</td>
							</tr>
							<tr>
								<td class="text-left">PCT</td>
								<td>3</td>
								<td>50</td>
								<td>16</td>
								<td class="cursive">Bien</td>
								<td>Parvard TOGBE</td>
							</tr>
							<tr>
								<td class="text-left">Anglais</td>
								<td>2</td>
								<td>14</td>
								<td>12</td>
								<td class="cursive">A Bien</td>
								<td>Odilon ODJEVI</td>
							</tr>
							<tr>
								<td class="text-left">Français</td>
								<td>2</td>
								<td>34</td>
								<td>17</td>
								<td class="cursive">T brien</td>
								<td>Germain GBEDJA</td>
							</tr>
							<tr>
								<td class="text-left">Philosophie</td>
								<td>2</td>
								<td>36</td>
								<td>18</td>
								<td class="cursive">T bien</td>
								<td>Fernad TODILA</td>
							</tr>
							<tr>
								<td class="text-left">Histoire Géographie</td>
								<td>2</td>
								<td>28</td>
								<td>14</td>
								<td class="cursive">Bien</td>
								<td>Hugues VIKEY</td>
							</tr>
							<tr>
								<td class="text-left">Education Physique</td>
								<td>1</td>
								<td>18</td>
								<td>18</td>
								<td class="cursive">Excellent</td>
								<td>Varan HEYIMOHAN</td>
							</tr>
							<tr>
								<td class="text-left">Conduite</td>
								<td>1</td>
								<td>18</td>
								<td>18</td>
								<td class="cursive">Excellent</td>
								<td>-</td>
							</tr>
							<tr class="bg-linear-official-180">
								<td class="text-left py-2">TOTAL</td>
								<td>22</td>
								<td>-</td>
								<td>450.25</td>
								<td>-</td>
								<td>-</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="w-100 bg-linear-official-180 py-1 my-1 border" style="border-color: rgb(170, 170, 170) !important;"></div>
				<div class="mx-auto d-flex justify-content-between text-white-50">
					<div class="border-white border" style="width: 43%;">
						<h5 class="bg-linear-official-180 p-1 w-100 text-center border-bottom border-white" style="font-size: 14px;">MOYENNE TRIMESTRIELLE</h5>
						<div class="w-100 p-1 d-flex justify-content-between text-center">
							<div class="w-25 border mr-1">
								<h5 class="h5-title">En chiffres</h5>
								<h5 style="font-size: 14px;">17.75</h5>
							</div>
							<div class="w-75">
								<h5 class="h5-title">En lettres</h5>
								<h5 style="font-size: 14px;">Dix-Sept soixante-quinze</h5>
								<h5 class="border-top">
									<h5 class="m-0 px-3 d-flex justify-content-between" style="font-size: 14px;">
										<span>Rang:</span>
										<span>
											1<sup>er</sup>
										</span>
									</h5>
								</h5>
							</div>
						</div>
					</div>
					<div class="border-white border text-center" style="width: 55%;">
						<h5 class="bg-linear-official-180 p-1 w-100 text-center border-bottom border-white" style="font-size: 14px;">MENTIONS DU CONSEIL DES PROFS</h5>
						<div class="w-100 d-flex flex-column justify-content-center p-1">
							<div class="w-100 border d-flex justify-content-between p-0">
								<h5 class="bg-linear-official-180 p-2 m-0 border-right" style="font-size: 14px;">Appréciation</h5>
								<h5 class="p-2 pr-5 m-0" style="font-size: 14px; font-style: italic; font-family: cursive;">Tres Bon Travail</h5>
							</div>
							<div class="w-100 my-1 border">
								<table class="w-100 h5-title">
									<thead class="bg-linear-official-180">
										<th>Félicitaton</th>
										<th>Encourag.</th>
										<th>Tableau d'hon.</th>
										<th>Avertis</th>
										<th>Blame</th>
									</thead>
									<tbody>
										<tr>
											<td> X </td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import { mapState } from 'vuex'
	export default{
		props: [],

		data() {
			return{
				showOptions: false,
			}
		},
		created(){
        	this.$store.dispatch('getAPupilDataAndMarks', {route: this.$route.params.id, trimestre: this.$route.params.trimestre})
        	axios.get('/admin/director/pupilsm/get&classe&of&pupil&with&data&credentials/id=' + this.$route.params.id)
                .then(response => {
                	this.$store.commit('UPDATE_TARGET_PUPIL', {pupil: response.data.p, dataFMT: {classe: response.data.classeFMT, birth: response.data.birthFMT, first: response.data.firstName, last: response.data.lastName}})
                    this.$store.commit('GET_A_PUPIL_DATA', response.data)
                }
            )
        },

		methods: {
			toggleOptions(){
				return this.showOptions = !this.showOptions
			}
		},


		computed: mapState([
           'errors', 'targetPupil', 'targetPupilLastName', 'targetPupilFirstName', 'targetPupilClasseFMT', 'targetPupilBirthFMT'
        ])

	}
</script>
<style>
	#bulletin .text-title{
		text-shadow: 2px 0px 0px black; 
		font-size: 20px; 
		font-weight: bold; 
		font-family: verdana; 
		letter-spacing: 1.5px; 
		word-spacing: 3px
	}

	#bulletin td, #bulletin th{
		text-align: center;
	}

	#bulletin td, #bulletin th{
		border: solid thin white;
	}
	
	.cursive{
		font-family: cursive !important;
		font-style: italic;
	}

	#bulletin td.cursive{
		font-size: 14px;
	}
	.cursor{
		cursor: pointer !important;
	}

</style>