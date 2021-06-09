<template>
	<div class="container-profil m-0 p-0">
		<div class="justify-content-center w-100 m-0 p-0">
			<transition name="fade" appear>
				<teacher-profil-main></teacher-profil-main>
			</transition>
		</div>
		<div class="w-100 p-1">
			
		</div>
		<div class="mt-5 w-100" id="teacher-profil">
			<div class="d-flex justify-content-around w-100">
				<div class="d-flex justify-content-between" style="width:30% ;">
					<transition name="fade" appear>
						<teacher-perso-data></teacher-perso-data>
					</transition>
				</div>
				<div class="d-flex justify-content-between" style="width: 30%;">
					<transition name="fade" appear>
						<profil-teacher-classes-box></profil-teacher-classes-box>
					</transition>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: [],

		data(){
			return {
				classe : '',
				visible : true,
			}
		},

		methods: {
			
		}
	}

</script>
<style>
	.fade-enter-active, .fade-leave-active{
		transition: opacity 2s, transform 1s;
	}

	.fade-enter, .fade-leave-active{
		opacity: 0;
		transform: translateY(-30px); 
	}

	.scale-enter-active, .scale-leave-active{
		transition: opacity 2s, transform 2s;
	}

	.scale-enter, .scale-leave-active{
		opacity: 0;
		transform: scale(0.7);
	}
	.fadelow-enter-active, .fadelow-leave-active{
        transition: opacity 7s, transform 2s;
    }

    .fadelow-enter, .fadelow-leave-active{
        opacity: 0;
        -webkit-transform: scale(0.1);
        -ms-transform: scale(0.1);
        -o-transform: scale(0.1);
        transform: scale(0.1);
    }
    .bodyfade-enter-active, .bodyfade-leave-active{
        transition: opacity 7s, transform 2s;
    }

    .bodyfade-enter, .bodyfade-leave-active{
        opacity: 0;
        -webkit-transform: translateY(20px);
        -ms-transform: translateY(20px);
        -o-transform: translateY(20px);
        transform: translateY(20px);
    }
</style>
