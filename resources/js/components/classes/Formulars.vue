<template>
	<div class="w-100 p-0 m-0">
		<registred></registred>
		<confirm-registration></confirm-registration>
		<success-connected></success-connected>
            
	</div>
</template>

<script>

	import { mapState } from 'vuex'
	export default {

		computed: mapState([
           'errors', 'pupilsArray'
        ])
	}
</script>