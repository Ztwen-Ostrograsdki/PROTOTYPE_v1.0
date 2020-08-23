<template>
	<div class="border" :class="border">
		<h5 class="text-center border-bottom">{{ trimestreName }}</h5>
		<div class="row mx-auto col-12 px-0 text-center">
			<div class="col-3 border-right m-0 p-0 border-white p-1">
				<h5 class="border-bottom text-white-50 w-100">
					Total
				</h5>
				<h5 class="w-100 text-white pt-1">
					256
				</h5>
			</div>
			<div class="col-3 border-right m-0 p-0 border-white p-1">
				<h5 class="border-bottom text-white-50 w-100">
					Moyenne
				</h5>
				<h5 class="w-100 text-white pt-1">
					12.56
				</h5>
			</div>
			<div class="col-3 border-right m-0 p-0 border-white p-1">
				<h5 class="border-bottom text-white-50 w-100">
					Rang
				</h5>
				<h5 class="w-100 text-white pt-1">
					10 <sup>ème</sup>
				</h5>
			</div>
			
			<div class="col-3 m-0 p-0 p-1">
				<h5 class="border-bottom text-white-50 w-100">
					Mention
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