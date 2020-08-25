<template>
	<div class="d-flex justify-content-between w-100 m-0 p-0 px-1">
		<transition name="depperscale" appear>
			<div class="profil-img p-2">
				<div class="text-center" id="profil-photo">
					<div class="d-flex justify-content-between">
						<h3 class="">{{ targetPupil.name }}</h3>
					</div>
					<span class="photo fa fa-user-secret text-primary text-shadow" style="font-size: 6rem"></span>
				</div>
			</div>
		</transition>
		<div class="profil-school d-none d-lg-inline-block" style="position:relative; right:50px;">
			<h3>COMPLEXE SCOLAIRE LA PRUNELLE</h3>
			<h3 align="center" class="position-relative" style="top: 10px; font-size: 4rem">{{targetPupilClasseFMT.name}}<sup>{{ targetPupilClasseFMT.sup }}</sup> {{ targetPupilClasseFMT.idc }}</h3>
		</div>
		<div class="profil-admin d-lg-inline-block d-sm-flex d-md-flex justify-content-sm-around justify-content-md-around float-right">
			<div class="w-100 float-right">
				<div class="text-right w-100" @click="toggleOptions(showOptions)" v-if="!showOptions">
					<span class="fa fa-sliders float-right"></span>
				</div>
				<div class="text-right w-100" @click="toggleOptions(showOptions)" v-if="showOptions">
					<span class="fa fa-chevron-up float-right"></span>
				</div>
				<transition name="scalefade" appear>
				<div class="login-profil  position-absolute border border-white" style="width: 250px; top: 110px; z-index: 100; background-image: url(/media/img/art-2578353_1920.jpg) !important; background-position: -200px 200px;" v-if="showOptions">
	                <div class="w-100 border" style="">
	                    <a class="w-100 link-float d-inline-block border m-0 py-1" href="#">
	                        <i class="fa fa-sliders fa-sm fa-fw mr-2"></i>
	                        <span>Options</span>
	                        <span class="mr-2 d-none d-lg-inline text-dark float-right"></span>
	                    </a>
	                      <!-- Dropdown - User Information -->
	                    <div class="w-100 border">
	                            <a class="w-100 my-1 hover link-float" href="" style="border-radius: 30px;">
	                                <i class="fas fa-cogs fa-sm fa-fw mr-2"></i>
	                              Administation
	                            </a>
	                            <router-link :to="'/admin/director/pupilsm/' + this.$route.params.id + '/marks/index/trimestre/1'" class="w-100 my-1 hover link-float" style="border-radius: 30px;">
	                            	<i class="fa fa-file-text fa-sm fa-fw mr-2"></i>
	                              Les notes
            					</router-link>
            					<router-link :to="'/admin/director/pupilsm/' + this.$route.params.id + '/bulletin&trimestrielle&eleve/index/trimestre/1'" class="w-100 my-1 hover link-float" style="border-radius: 30px;">
	                            	<i class="fa fa-file-text fa-sm fa-fw mr-2"></i>
	                              	Générer bulletin
            					</router-link>
	                            <a class="w-100 my-1 hover link-float" href="" style="border-radius: 30px;">
	                                <i class="fa fa-line-chart fa-sm fa-fw mr-2"></i>
	                              Scolarité
	                            </a>
	                            <a class="w-100 my-1 hover link-float" href="" style="border-radius: 30px;">
	                                <i class="fa fa-address-card fa-sm fa-fw mr-2"></i>
	                              Les parents
	                            </a>
	                        <a class="w-100 py-1 hover link-float" href="#">
	                             <i class="fas fa-list fa-sm fa-fw mr-2"></i>
	                          Activity Log
	                        </a>
	                        <a class="w-100 py-1 pb-2 hover border-top link-float" href="">
	                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
	                          Renvoyer cet apprenant
	                        </a>
	                        <form action=""  style="display: none;">
	                        </form>
	                    </div>
	                </div> 
	            </div>
	            </transition>
			</div>
		</div>
	</div>
</template>

<script>
import { mapState } from 'vuex'
	export default{
		props: [],

		data() {
			return{
				showOptions: false,
			}
		},

		methods: {
			toggleOptions(){
				return this.showOptions = !this.showOptions
			}
		},


		computed: mapState([
           'editedPupil', 'errors', 'targetPupil', 'targetPupilLastName', 'targetPupilFirstName', 'targetPupilClasseFMT', 'targetPupilBirthFMT'
        ])

	}
</script>

<style>
	.depperscale-enter-active, .depperscale-leave-active{
		transition: opacity 1s, transform 1s;
	}

	.depperscale-enter, .depperscale-leave-active{
		opacity: 0;
		transform: scale(0.1);
	}

	.scalefade-enter-active, .scalefade-leave-active{
		transition: opacity 1s, transform 1s;
	}

	.scalefade-enter, .scalefade-leave-active{
		opacity: 0;
		transform: scale(0.1);
	}
</style>