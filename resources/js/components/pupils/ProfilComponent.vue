<template>
	<div class="bg-linear-official-180 p-2 px-3 border border-white" style="height: 560px;">
		<profil-pupil-box></profil-pupil-box>
	</div>
</template>

<script>
    import { mapState } from 'vuex'
	export default{


		data() {
            return {
                
                
            }   
        },
        created(){
            this.$store.dispatch('resetTargetedPupil', this.$route.params.id)
        },

        computed: mapState([
           'editedPupil', 'targetPupil', 'primaryClasses', 'secondaryClasses', 'primarySubjects', 'secondarySubjects', 'allSubjects', 'allRoles', 'allClasses', 'months', 'successed', 'invalidInputs', 'errors', 'targetPupilLastName', 'targetPupilFirstName', 'targetPupilClasseFMT', 'targetPupilBirthFMT', 'editedPupilSubjects'
        ])




	}
	
</script>