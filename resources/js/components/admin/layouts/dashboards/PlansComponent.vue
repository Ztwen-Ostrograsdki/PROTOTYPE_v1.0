<template>
	<div class="w-100">
		<div class="w-100 p-1 mx-auto bg-linear-official-50 border border-white">
			<div class="d-flex p-1">
				<span class="mx-1">
					<router-link to="/admin/director/master/dashboards/emplois-du-temps">
						<span class="btn btn-secondary py-2 px-2 w-100 border border-white">Les emplois du temps</span>
	                </router-link>
				</span>
				<span>
					<span class="btn btn-info py-2 px-2 w-100 border border-white">Les tableaux synoptiques</span>
				</span>
			</div>
		</div>
		<div class="w-100 mt-2 bg-linear-official-180 border border-white mx-auto p-1">
			<h3 class="w-100 pt-2 d-flex justify-content-between">
				<span class="ml-1">
					Emploi du temps
				</span>
				<span class="cursive text-white-50">CEPG "LA PRUNELLE DE DIEU"</span>
				<span>
					<span class="float-right btn btn-news p-1 px-2 mx-2" data-toggle="modal" data-target="#newHoraireModal">Inserer une horaire</span>
					<span class="float-right fa fa-recycle mx-2 text-danger" title="Nettoyer le tableau de bord des emplois du temps" @click="resetHoraires({classe: null, year: 2020})"></span>
				</span>
			</h3>
			<div class="mx-auto w-100 mt-2">
				<table class="w-100 table-table table-striped table-plan">
					<thead>
						<th class="border border-right">Gpes Pque</th>
						<th class="h5-title border border-right" style="width: 12.5%" v-for="classe in secondaryClassesFormatted">
							<table class="w-100 text-center">
								<thead class="w-100">
									<th class="w-100 p-0 m-0" colspan="5">
										<span class="">
											{{ classe.name}}<sup>{{ classe.sup }}</sup> {{ classe.idc }} 
										</span>
									</th>
								</thead>
							</table>
						</th>
					</thead>
					<tbody class="text-center w-100 t-contents h5-title">
						<tr class="">
							<td>Jours</td>
							<td v-for="classe in secondaryClassesFormatted">
								<table class="w-100">
									<thead class="w-100">
										<th>L</th>
										<th>M</th>
										<th>M</th>
										<th>J</th>
										<th>V</th>
									</thead>
								</table>
							</td>
						</tr>
						<tr v-for="hour in first_mornings" class="t-contents w-100">
							<td>{{ hour }}</td>
							<td v-for="classe in secondaryClassesFormatted">
								<table class="w-100">
									<tbody class="w-100">
										<tr class="w-100">
											<td :style="'color:' + getSubject(classe['id'], hour, 'Lundi', horaires).color" v-if="getSubject(classe['id'], hour, 'Lundi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Lundi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Lundi', horaires) == 'x'" class="text-white-50"> x </td>
											<td :style="'color:' + getSubject(classe['id'], hour, 'Mardi', horaires).color" v-if="getSubject(classe['id'], hour, 'Mardi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Mardi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Mardi', horaires) == 'x'" class="text-white-50"> x </td>
											<td :style="'color:' + getSubject(classe['id'], hour, 'Mercredi', horaires).color" v-if="getSubject(classe['id'], hour, 'Mercredi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Mercredi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Mercredi', horaires) == 'x'" class="text-white-50"> x </td>
											<td :style="'color:' + getSubject(classe['id'], hour, 'Jeudi', horaires).color" v-if="getSubject(classe['id'], hour, 'Jeudi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Jeudi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Jeudi', horaires) == 'x'" class="text-white-50"> x </td>
											<td :style="'color:' + getSubject(classe['id'], hour, 'Vendredi', horaires).color" v-if="getSubject(classe['id'], hour, 'Vendredi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Vendredi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Vendredi', horaires) == 'x'" class="text-white-50"> x </td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>

						<tr class="t-contents w-100 py-2">
							<td colspan="8" class="py-2 cursive bg-linear-official-180 border border-primary"> RECREATION </td>
						</tr>

						<tr v-for="hour in second_mornings" class="t-contents w-100">
							<td>{{ hour }}</td>
							<td v-for="classe in secondaryClassesFormatted">
								<table class="w-100">
									<tbody class="w-100">
										<tr class="w-100">
											<td :style="'color:' + getSubject(classe['id'], hour, 'Lundi', horaires).color" v-if="getSubject(classe['id'], hour, 'Lundi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Lundi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Lundi', horaires) == 'x'" class="text-white-50"> x </td>
											<td :style="'color:' + getSubject(classe['id'], hour, 'Mardi', horaires).color" v-if="getSubject(classe['id'], hour, 'Mardi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Mardi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Mardi', horaires) == 'x'" class="text-white-50"> x </td>
											<td :style="'color:' + getSubject(classe['id'], hour, 'Mercredi', horaires).color" v-if="getSubject(classe['id'], hour, 'Mercredi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Mercredi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Mercredi', horaires) == 'x'" class="text-white-50"> x </td>
											<td :style="'color:' + getSubject(classe['id'], hour, 'Jeudi', horaires).color" v-if="getSubject(classe['id'], hour, 'Jeudi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Jeudi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Jeudi', horaires) == 'x'" class="text-white-50"> x </td>
											<td :style="'color:' + getSubject(classe['id'], hour, 'Vendredi', horaires).color" v-if="getSubject(classe['id'], hour, 'Vendredi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Vendredi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Vendredi', horaires) == 'x'" class="text-white-50"> x </td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>

						<tr class="t-contents w-100 py-2">
							<td colspan="8" class="py-2 cursive bg-linear-official-180 border border-success"> APRES-MIDI </td>
						</tr>

						<tr v-for="hour in afternoon" class="t-contents w-100">
							<td>{{ hour }}</td>
							<td v-for="classe in secondaryClassesFormatted">
								<table class="w-100">
									<tbody class="w-100">
										<tr class="w-100">
											<td :style="'color:' + getSubject(classe['id'], hour, 'Lundi', horaires).color" v-if="getSubject(classe['id'], hour, 'Lundi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Lundi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Lundi', horaires) == 'x'" class="text-white-50"> x </td>
											<td :style="'color:' + getSubject(classe['id'], hour, 'Mardi', horaires).color" v-if="getSubject(classe['id'], hour, 'Mardi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Mardi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Mardi', horaires) == 'x'" class="text-white-50"> x </td>
											<td :style="'color:' + getSubject(classe['id'], hour, 'Mercredi', horaires).color" v-if="getSubject(classe['id'], hour, 'Mercredi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Mercredi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Mercredi', horaires) == 'x'" class="text-white-50"> x </td>
											<td :style="'color:' + getSubject(classe['id'], hour, 'Jeudi', horaires).color" v-if="getSubject(classe['id'], hour, 'Jeudi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Jeudi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Jeudi', horaires) == 'x'" class="text-white-50"> x </td>
											<td :style="'color:' + getSubject(classe['id'], hour, 'Vendredi', horaires).color" v-if="getSubject(classe['id'], hour, 'Vendredi', horaires) !== 'x'"> {{ getSubject(classe['id'], hour, 'Vendredi', horaires).name }} </td>
											<td v-if="getSubject(classe['id'], hour, 'Vendredi', horaires) == 'x'" class="text-white-50"> x </td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>


					</tbody>

				</table>
			</div>
		</div>
	</div>
</template>

<script>
	import {mapState} from 'vuex'

	export default {

		data() {
            return {
            	
                first_mornings : [
                    "08h - 09h",
                    "09h - 10h",
                ],
                second_mornings : [
                    "10h - 11h",
                    "11h - 12h",
                    "12h - 13h",
                ],
                afternoon : [
                    "13h - 14h",
                    "14h - 15h",
                    "15h - 16h",
                    "16h - 17h",
                    "17h - 18h",
                    "18h - 19h",
                ],
            }   
        },
		created(){
			this.$store.dispatch('getTOOLS')
			this.$store.dispatch('getHoraires', 2020)
        },

        methods: {
        	getSubject(classe, horaire, day, horaires){
        		let validHoraires = []
        		if(horaires !== undefined && classe !== undefined){
        			let emploi = horaires[classe]
        			if(emploi !== null && emploi !== undefined ){
        				for (var i = 0; i < emploi.length; i++) {
        					if(emploi[i].day == day){
        						validHoraires.push(emploi[i])
        					}
        				}
        				if(validHoraires.length !== 0){
        					let the_valid_horaire = null
        					let parts = (horaire.split("-"))
        					let debut = parseInt(parts[0].substring(0, 2), 10)
        					let fin = parseInt(parts[1].substring(1, 3), 10)

        					for (var i = 0; i < validHoraires.length; i++) {
        						let v_h = validHoraires[i]
        						let start = parseInt(v_h.start, 10)
        						let end = parseInt(v_h.end, 10)
        						
        						if((debut >= start && debut <= end) && fin <= end ){
        							the_valid_horaire = v_h
        						}
        					}

        					if(the_valid_horaire !== null){
        						return this.subjectFormattor(the_valid_horaire.subject.name)
        					}
        					else{
        						return 'x'
        					}
        					

        				}
        				else{
        					return 'x'
        				}
        						
        			}
        			else{
        				return 'x'
        			}
        		}
        		
        		
        	},

        	subjectFormattor(subject){
        		if(subject !== null && subject !== undefined){
        			if(subject == "Physique-Chimie-Technologie"){
        				return {name: 'PCT', color: 'aqua'}
        			}
        			else if (subject == "Histoire-Géographie") {
        				return {name: 'HG', color: 'white'}
        			}
        			else if (subject == "Français") {
        				return {name: 'Fra', color: 'rgb(200, 100, 100)'}
        			}
        			else if(subject == "Mathématiques"){
        				return {name: 'Math', color: 'orange'}
        			}
        			else{
        				return {name: subject.substring(0, 3), color: 'black'}
        			}
        			
        			
        		}
        		return {name: '?', color: 'red'}
        		
        	},

        	resetHoraires(data){
        		this.$store.dispatch('resetHoraires', data)
        	}

        },

		computed: mapState([
			'user', 'admin', 'secondaryClasses', 'secondaryClassesFormatted', 'horaires'
		])

	}


</script>

<style>
	.table-plan th{
		padding: 0 !important;
		padding-bottom: 1px !important;
		padding-top: 1px !important;
	}

	.td-days td{
		border-right: thin solid white;
	}

	.t-contents tbody tr td{
		width: 20%;
	}
	</style>