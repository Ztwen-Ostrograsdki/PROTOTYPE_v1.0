<template>
	<div>
		<router-view></router-view>
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