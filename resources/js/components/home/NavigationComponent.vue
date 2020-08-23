<template>
	<div>
		<header class="maskor-sup">
            <div class="position-absolute d-none d-lg-inline text-left mt-2" style="top: 10px; left: 0%; width: 28%;">
                <a class="link-float" href="#" id="link-home-school-name">
                    <span class="fa fa-school mr-2" style="font-size: 30px"></span>
                    <span class="mr-2 d-none d-lg-inline text-black-50 small">CS LA PRUNELLE</span>
                </a>
            </div>
            <div class="d-none w-100 d-lg-flex justify-content-center mx-auto position-absolute" style="top: 35px; z-index: 30">
                <ul class="d-flex justify-content-center mt-2" id="nav-menu">
                    <li><a href="#"><span class="mkv-d"></span>Home</a></li>
                    <li><a href="#"><span class="mkv-d"></span>Menu</a>
                        <ul class="row">
                            <li class="col-12"><a href="#" class="documents">Documents</a></li>
                            <li lass="col-12"><a href="#" class="messages w-auto">Messages</a></li>
                            <li lass="col-12"><a href="#" class="signout">Sign Out</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><span class="mkv-d"></span>Forum</a></li>
                    <li><a href="#"><span class="mkv-d"></span>Espace Parents</a></li>
                    <li v-if="noUser || !admin"><a href="#"><span class="mkv-d"></span>Contacts</a></li>
                    <li v-if="user !== {} && admin"><a href="/admin/director/master"><span class="mkv-d"></span>Admin</a></li>
                </ul> 
            </div>
        <nav class="navbar d-lg-none shadow-sm navbar-home py-3">
            <div class="w-50" id="modal-home-nav-btn" style="cursor: pointer;">
                <span class="">
                    <img src="" alt="" width="30">
                    <i class="fa fa-chevron-down" style="font-size: 25px; font-weight: small; position: relative; top: 5px; display: none"></i>
                </span>
                <span class="text-dark text-shadow d-md-inline d-none">CS LA PRUNELLE</span>
                <span class="text-muted d-sm-inline d-md-none">CS LA PRUNELLE</span>
            </div>
        </nav>
            <div class="position-absolute justify-content-center d-none d-lg-flex" style="top: 10px; right: 20px; width: 15%;">
                <div class="text-center m-0 p-0" style="min-width:45%;">
                    <div class="py-2 w-100 d-inline-block fa m-0 text-white" @click="userSettingsShow()">
                        <span class=" d-none d-lg-inline text-white-600 small py-1">{{ user.name }}</span>
                    </div>
                    <span class="fas fa-user-secret pointer" style="font-size: 20px; cursor: pointer" v-if="admin"></span>
                    <img class="img-profile rounded-circle" src="/media/profil.png" alt="administration" width="25" v-if="!admin && !noUser">
                </div>
            </div>
            <div class="row position-absolute admins-link mt-2 d-lg-none" style="top: -10px; width: 25%; right: 30px">
           
                <div class="col-12 text-center mb-2 px-0">
                    <a class="nav-link w-100 home-link-profil-sm link-float px-1" href="#">
                        <span class="fa fa-user-secret m-0 p-0" style="font-size: 20px"></span>
                        <img class="img-profile rounded-circle" src="/media/profil.png" alt="administration" width="25">
                        <span class="d-block text-white-600 small text-center w-100">{{ user.name }}</span>

                    </a>
                </div>
            </div>
            <div class="login-profil profil-modal position-relative border bg-linear-official border-white" style="width: 200px; display: none; top: 100px; z-index: 100;">
                <div class="w-100 border" style="">
                    <a class="w-100 link-float d-inline-block border m-0 py-1" href="#">
                        <img class="img-profile rounded-circle" src="/media/profil.png" alt="administration" width="25">
                        <span class="mr-2 d-none d-lg-inline text-dark float-right">{{ user.name }}</span>
                    </a>
                      <!-- Dropdown - User Information -->
                </div> 
            </div>
                <div class="position-absolute register-home-links border  d-none d-lg-flex justify-content-between text-center mt-2" style="top: 10px; right: 3%; width: 15%; border-radius: 10px" v-if="noUser">
                    <a href="#" class="py-1 link-float" data-toggle="modal" data-target="#loginModal" @click="getUsers()">Login</a>
                        <a href="#" id="register-link-home" class="register-link py-1 link-float">Register</a>
                </div>
                <div class="position-absolute row register-home-links d-lg-none text-center mt-2" style="top:10px; right: 50px; width: auto; border-radius: 10px">
                    <div class="container-lg d-inline m-0 p-0 mr-3" v-if="!noUser">
                        <a href="#" class="py-1 col-5 link-float">Login</a>
                        <a href="#" id="register-link-home-sm" class="register-link-sm link-float py-1 col-6">Register</a>
                    </div>
                </div>
        </header>
	</div>
</template>

<script>
	import { mapState } from 'vuex'
	export default{
        data(){
            return{
                
            }
        },


		methods: {

			userSettingsShow() {
				this.$store.commit('USER_SETTINGS', !this.userSettings)
			},

            getUsers() {
                $('#loginModal .div-success').hide('slide', 'up')
                $('#loginModal .div-success h4').text('')
                $('#loginModal form').show('fade')
                $('#loginModal .buttons-div').show('fade')

                this.$store.dispatch('getUsers')
            }
		},
        
		computed: mapState([
            'user', 'admin', 'errors', 'userSettings', 'noUser'
        ])

	}
</script>