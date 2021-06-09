<template>
	<div class="onetable" style="width:48%">
		<div class="w-100 m-0 p-0" v-if="targetPupilParents.length">
			<h5>
				Les infos parentales (<span class="mx-1 text-muted">{{ (parentIndex + 1 ) + '|' +targetPupilParents.length }}</span>)
				<span @click="addParents()" class="btn btn-news px-1 py-0 mr-2 float-right" data-toggle="modal" data-target="#editPupilParentsModal"> <i class="fa fa-plus mr-2"></i>Ajouter</span>
				<span class="d-inline float-right fa fa-edit mx-1 mt-1" title="Editer les informations de ce parent" style=""></span>
			</h5>
			<div class="">
				<div class="mx-auto" style="width:100%">
					<table v-if="parentIndex == k" class="table-profil " v-for="(parent, k) in targetPupilParents">
						<tr>
							<td>{{parent.relation}} :</td>
							<td>{{ parent.parent.name }}</td>
						</tr>
						<tr>
							<td>Profession :</td>
							<td>{{ parent.parent.works }}</td>
						</tr>
						<tr>
							<td>Contacts :</td>
							<td>{{ parent.parent.contact }}</td>
						</tr>
						<tr>
							<td>Localité :</td>
							<td>{{ parent.parent.residence }}</td>
						</tr>
					</table>
				</div>
				<span class="d-flex justify-content-between w-25 mx-auto py-1">
					<span class="cursor p-1 px-2 hover" @click="decreaseIndex()" :title="'Voir les autres parents de ' +  targetPupil.name ">
						<span class="fa fa-chevron-left"></span>
						<span class="fa fa-chevron-left"></span>
					</span>
					<span class="cursor p-1 px-2" @click="increaseIndex()" :title="'Voir les autres parents de ' +  targetPupil.name ">
						<span class="fa fa-chevron-right"></span>
						<span class="fa fa-chevron-right"></span>
					</span>
				</span>
			</div>
			
		</div>
		<div class="w-100 m-0 p-0" v-if="!targetPupilParents.length">
			<h5>Les infos parentales</h5>
			<div class="bg-linear-official-180 d-flex justify-content-center p-2 border-white-50 border">
				<h5 class="cursive text-white-50">Non renseignées</h5>
			</div>
			<span>
				<i @click="addParents()" class="btn btn-news my-1 p-1 pr-2 float-right" data-toggle="modal" data-target="#editPupilParentsModal"> <i class="fa fa-edit mr-2"></i>Mettre à jour</i>

			</span>
		</div>
	</div>
</template>

<script>
	import { mapState } from 'vuex'
	export default{


		data() {
            return {
                parentIndex: 0,
            }   
        },

        methods: {
        	addParents(){
        		this.$store.dispatch('addNewParentForTargetedPupil')
        		$('#editPupilParentsModal input#edit_p_parent_address').val('')
        		this.$store.commit('RESET_PARENTS_SEARCHING', null)
        		this.$store.commit('RESET_INVALID_INPUTS')
        		$('#editPupilParentsModal .div-success').hide('slide', 'up')
                $('#editPupilParentsModal .div-success h4').text('')
                $('#editPupilParentsModal form').show('fade', function(){
                    $('#editPupilParentsModal .buttons-div').show('fade')
                })
        	},
        	increaseIndex(){
        		let index = this.parentIndex
        		if (index == this.targetPupilParents.length - 1) {
        			this.parentIndex = 0
        		}
        		else{
        			this.parentIndex = this.parentIndex + 1
        		}
        	},
        	decreaseIndex(){
        		let index = this.parentIndex
        		if (index == 0) {
        			this.parentIndex = this.targetPupilParents.length - 1
        		}
        		else{
        			this.parentIndex = this.parentIndex - 1
        		}
        	},
        },

        computed: mapState([
           'targetPupilParents', 'allParents', 'targetPupil'
        ])




	}
</script>