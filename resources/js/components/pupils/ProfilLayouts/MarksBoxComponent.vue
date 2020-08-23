<template>
	<div class="onetable w-100">
		<h5>Les détails suplémentaires</h5>
		<table class="table-profil ">

			<tr>
				<td>Moyenne 1er Trimestre :</td>
				<td>15</td>
			</tr>
			<tr>
				<td>Moyenne 2eme Trimestre :</td>
				<td>14.55</td>
			</tr>
			<tr>
				<td>Moyenne 3eme Trimestre :</td>
				<td>16.05</td>
			</tr>
			<tr>
				<td>Moyenne Générale :</td>
				<td>15.55</td>
			</tr>
			<tr>
				<td>Observation :</td>
				<td>Bonne</td>
			</tr>
		</table>
		<span>
			<router-link :to="'/admin/director/pupilsm/' + this.$route.params.id + '/marks/index/trimestre/1'" class="btn btn-news my-1 p-1 float-right">Mettre à jour
            </router-link>
		</span>
	</div>
</template>

<script>
	export default{
		props: ['visible', 'pupil'],

	}
</script>