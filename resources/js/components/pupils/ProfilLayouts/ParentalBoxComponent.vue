<template>
	<div class="onetable" style="width:48%">
		<div class="w-100 m-0 p-0" v-if="targetPupilParents.length !== 0">
			<h5>Les infos parentales</h5>
			<table class="table-profil ">

				<tr>
					<td>Père :</td>
					<td>Hubert</td>
				</tr>
				<tr>
					<td>Profession :</td>
					<td>Enseignant</td>
				</tr>
				<tr>
					<td>Mère :</td>
					<td>Germaine</td>
				</tr>
				<tr>
					<td>Profession :</td>
					<td>Enseignant</td>
				</tr>
				<tr>
					<td>Contacts :</td>
					<td>65547585/96857415</td>
				</tr>
				<tr>
					<td>Localité :</td>
					<td>Cotonou</td>
				</tr>
			</table>
			<span>
				<a href="#" class="btn btn-news my-1 p-1 float-right">Mettre à jour</a>
			</span>
		</div>
		<div class="w-100 m-0 p-0" v-if="targetPupilParents.length == 0">
			<h5>Les infos parentales</h5>
			<div class="bg-linear-official-180 d-flex justify-content-center p-2 border-white-50 border">
				<h5 class="cursive text-white-50">Non renseignées</h5>
			</div>
			<span @click="addParents()">
				<i class="btn btn-news my-1 p-1 pr-2 float-right" data-toggle="modal" data-target="#editPupilParentsModal"> <i class="fa fa-edit mr-2"></i>Mettre à jour</i>
			</span>
		</div>
	</div>
</template>

<script>
	import { mapState } from 'vuex'
	export default{


		data() {
            return {
                
            }   
        },

        methods: {
        	addParents(){
        		this.$store.dispatch('addNewParentForTargetedParent')
        		$('#editPupilParentsModal .div-success').hide('slide', 'up')
                $('#editPupilParentsModal .div-success h4').text('')
                $('#editPupilParentsModal form').show('fade', function(){
                    $('#editPupilParentsModal .buttons-div').show('fade')
                })
        	}
        },

        computed: mapState([
           'targetPupilParents', 'allParents'
        ])




	}
</script>