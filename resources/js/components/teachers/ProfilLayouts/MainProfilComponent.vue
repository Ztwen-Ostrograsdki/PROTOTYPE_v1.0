<template>
	<div class="d-flex justify-content-around w-100 m-0 p-0">
		<transition name="depperscale" appear>
			<div class="profil-img p-2">
				<div class="text-center" id="profil-photo">
					<div class="d-flex justify-content-between">
						<h3 class="">{{ targetedTeacher.name }}</h3>
					</div>
					<span class="photo fa fa-user-secret text-primary text-shadow" style="font-size: 6rem"></span>
				</div>
			</div>
		</transition>
		<div class="profil-school d-none d-lg-inline-block">
			<h3>COMPLEXE SCOLAIRE LA PRUNELLE</h3>
			<h3 align="center" class="position-relative" style="top: 10px; font-size: 4rem">
				{{ targetedTeacher.level !== 'primary' ? targetedTeacherSubject : 'Maître' }}
			</h3>
		</div>
		<div class="profil-admin d-lg-inline-block d-sm-flex d-md-flex justify-content-sm-around justify-content-md-around">
			
		</div>
	</div>
</template>

<script>
import { mapState } from 'vuex'
	export default{
		props: [],


		computed: mapState([
           'editedTeacher', 'errors', 'targetedTeacher', 'targetedTeacherSubject'
        ])

	}
</script>

<style>
	.depperscale-enter-active, .depperscale-leave-active{
		transition: opacity 5s, transform 3s;
	}

	.depperscale-enter, .depperscale-leave-active{
		opacity: 0;
		transform: scale(0.1);
	}
</style>