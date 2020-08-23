<template>
	<div class="bg-linear-official-180 p-2 px-3 border border-white">
        <listing-classe></listing-classe>
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
            this.$store.dispatch('getAClasseData', this.$route.params.id)
        },
        

        computed: mapState([
            'allClasses', 'successed', 'invalidInputs', 'errors', 'targetedClasse'
        ])




	}
	
</script>