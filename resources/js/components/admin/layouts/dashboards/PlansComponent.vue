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
		<div class="w-100 mt-2 bg-linear-official-50 border border-white mx-auto p-1">
			<h5 class="w-100 text-center">Emploi du temps</h5>
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
								<!-- <tbody class="td-days">
									<tr class="w-100">
										<table class="w-100">
											<thead class="w-100">
												<th>L</th>
												<th>M</th>
												<th>M</th>
												<th>J</th>
												<th>V</th>
											</thead>
											<tbody>
												<tr>
													<td>svt</td>
													<td>maths</td>
													<td>maths</td>
													<td>pct</td>
													<td>pct</td>
												</tr>
												<tr>
													<td>svt</td>
													<td>maths</td>
													<td>maths</td>
													<td>pct</td>
													<td>pct</td>
												</tr>
											</tbody>
										</table>
									</tr>
								</tbody> -->
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
						<tr v-for="hour in hours" class="t-contents w-100">
							<td>{{ hour }}</td>
							<td v-for="classe in secondaryClassesFormatted">
								<table class="w-100">
									<tbody class="w-100">
										<tr class="w-100">
											<td>svt</td>
											<td>svt</td>
											<td>svt</td>
											<td>svt</td>
											<td>svt</td>
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
            	hours : [
                    "08h - 09h",
                    "09h - 10h",
                    "10h - 11h",
                    "11h - 12h",
                    "12h - 13h",
                    "13h - 14h",
                ],
            }   
        },
		created(){
			this.$store.dispatch('getTOOLS')
        },

		computed: mapState([
			'user', 'admin', 'secondaryClasses', 'secondaryClassesFormatted'
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