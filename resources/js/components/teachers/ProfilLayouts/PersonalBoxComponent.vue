<template>
	<div class="onetable" style="width:100%">
		<div class="w-100 m-0 p-0">
			<h5>Les infos personelles</h5>
			<table class="table-profil ">
				<tr>
					<td>Nom:</td>
					<td> {{ targetedTeacherLastName }} </td>
				</tr>
				<tr>
					<td>Prénoms:</td>
					<td>{{ targetedTeacherFirstName }}</td>
				</tr>
				<tr>
					<td>Age:</td>
					<td>{{ targetedTeacherAge + " ans"}}</td>
				</tr>
				<tr>
					<td>Date de Naissance:</td>
					<td>{{ targetedTeacherBirthFMT }}</td>
				</tr>
				<tr>
					<td>Sexe:</td>
					<td>M</td>
				</tr>
				<tr>
					<td>Spécialité:</td>
					<td>
						{{ targetedTeacher.level !== 'primary' ? targetedTeacher.subject.name : 'Maître'}}
					</td>
				</tr>
			</table>
			<span>
				<i class="btn btn-news my-1 p-1 pr-2 float-right" data-toggle="modal" data-target="#editTeacherPersoModal" @click="openEdited()"> <i class="fa fa-edit mr-2"></i>Mettre à jour</i>
			</span>
		</div>
	</div>


</template>

<script>
	import { mapState } from 'vuex'
	// import helpers from '../../../helpers/helpers'
	export default{
		props: ['visible'],
		data() {
            return {
				preEdited: {},
				            
            }   
        },

		


		methods: {
			openEdited(){
				axios.get('/admin/director/teachersm/get&classes&of&teacher&with&data&credentials/id=' + this.$route.params.id)
	                .then(response => {
	                    this.preEdited = response.data.teacher
	                    this.$store.commit('SET_TOKEN', response.data.token)
	                    this.$store.commit('SET_EDITED_TEACHER', this.preEdited)
	                })
	            
                
                $('#editTeacherPersoModal .div-success').hide('slide', 'up')
                $('#editTeacherPersoModal .div-success h4').text('')
                $('#editTeacherPersoModal').animate({
                    top: '10'
                })
                
                $('#editTeacherPersoModal form').show('slide', {direction: 'up'}, 1, function(){
                    $('#editTeacherPersoModal form').animate({
                        opacity: '0'
                    }, function(){
                        $('#editTeacherPersoModal form').animate({
                            opacity: '1'
                        }, 800)
                        $('#editTeacherPersoModal .buttons-div').show('fade')
                    })
                })
            },
            
		},
		computed: mapState([
           'editedTeacher', 'errors', 'targetedTeacherLastName', 'targetedTeacherFirstName', 'targetedTeacherBirthFMT', 'targetedTeacher', 'targetTeacherBirthFMT', 'targetedTeacherAge'
        ])

	}
</script>