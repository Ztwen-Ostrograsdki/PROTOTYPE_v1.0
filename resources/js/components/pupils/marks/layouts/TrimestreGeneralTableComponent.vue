<template>
	<div class="m-0 p-0 trimestre-general">
		<h5 class="text-center px-0 mx-0 pb-2 text-dark">Moyenne Générale</h5>
		<div class="row mx-auto col-12 px-0 text-center border">
			<div class="col-2 border-right m-0 p-0 border-white p-1">
				<h5 class="border-bottom text-white-50 w-100">
					Total
				</h5>
				<h5 class="w-100 text-white pt-1">
					256
				</h5>
			</div>
			<div class="col-2 border-right m-0 p-0 border-white p-1">
				<h5 class="border-bottom text-white-50 w-100">
					Moyenne
				</h5>
				<h5 class="w-100 text-white pt-1">
					12.56
				</h5>
			</div>
			<div class="col-2 border-right m-0 p-0 border-white p-1">
				<h5 class="border-bottom text-white-50 w-100">
					Rang
				</h5>
				<h5 class="w-100 text-white pt-1">
					10 <sup>ème</sup>
				</h5>
			</div>
			
			<div class="col-3 border-right m-0 p-0 border-white p-1">
				<h5 class="border-bottom text-white-50 w-100">
					Mention
				</h5>
				<h5 class="w-100 text-white pt-1">
					Assez Bien
				</h5>
			</div>
			<div class="col-3 m-0 p-0 p-1">
				<h5 class="border-bottom text-white-50 w-100">
					Décision du Jury
				</h5>
				<h5 class="w-100 text-white pt-1">
					Assez Bien
				</h5>
			</div>
		</div>
	</div>
</template>

<script>
	import { mapState } from 'vuex'

	export default{
		props: ['trimestreName', 'border'],

		data() {
            return {

            }   
        },

		methods: {
			
		},
		computed: mapState([
          	'targetPupilLastName', 'targetPupilFirstName', 'targetPupilClasseFMT', 'targetPupilBirthFMT', 'editedPupilSubjects', 'editedPupil'
        ])

	}
</script>

<style>
	.trimestre-general h5{
		font-size: 12px;
		margin: 0px;
		padding: 2;
	}
</style>