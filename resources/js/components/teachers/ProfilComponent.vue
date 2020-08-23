<template>
	<div class="bg-linear-official-180 p-2 px-3 border border-white" style="height: 560px;">
		<profil-teacher-box></profil-teacher-box>
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
            this.$store.dispatch('getATeacherData', this.$route.params.id) 
        },

        computed: mapState([
           'editedTeacher', 'targetedTeacher', 'primaryClasses', 'secondaryClasses', 'primarySubjects', 'secondarySubjects', 'allSubjects', 'allRoles', 'allClasses', 'months', 'successed', 'invalidInputs', 'errors', 'targetTeacherLastName', 'targetTeacherFirstName', 'targetTeacherClasseFMT', 'targetTeacherBirthFMT'
        ])




	}
	
</script>