<template>
	<div class="w-100 m-0 p-0">
		<header class="maskor-sup" v-if="!errors.status">
            <div class="w-100 m-0 p-0 border d-flex justify-content-between bg-linear-official-dark" style="background-color:;">
                <div class="d-lg-inline text-left" style="width: 20%;">
                    <a class="link-float w-100 h-100" href="#" id="open-admin-aside">
                        <span class="fa fa-school mr-2 mt-3" style="font-size: 30px"></span>
                        <span class="mr-2 d-none d-lg-inline text-white small">ADMINISTRATIONS</span>
                    </a>
                </div>
                <div class="ml-3 row" style="width: 60%;">
                    <div class="col-8 h-100">
                        <div class="w-100 d-flex justify-content-start h-100 pt-3" style="">
                            <form action="" class="bg-transparent h-50 d-none" id="form-admin-search" style="">
                                <input type="search" id="input" class="form-control bg-transparent border py-1 text-white d-inline-block" style="border: none; " placeholder="Enter your search...">
                                <button class="border text-white bg-linear-official rounded" style="border: none; width: 25%; padding-top: 6px; padding-bottom: 6px;">Search</button>
                                    <span class="fa fa-close mt-3 float-right" id="search-admin-close" style="cursor: pointer; display: none">
                                    </span>
                            </form>
                            <span class="fa fa-search mt-3 mx-1 position-relative" id="search-admin-link" style="cursor: pointer;">
                            </span>
                        </div>
                    </div>
                    <div class="col-4 d-flex justify-content-end py-3">
                        <div class="w-50 mr-2">
                            <form action="">
                                <select name="currentYear" id="" class="custom-select border-dark bg-transparent text-dark" style="">
                                    <option :value="year" v-for="year in getYears()" :selected="wasSelected(year, (new Date).getFullYear())">{{ year }}</option>
                                </select>
                            </form>
                        </div>
                        <div class="w-auto m-0 p-0 mt-3">
                            <i class="fas fa-bell fa-1x fa-fw"></i>
                            <span class="badge badge-danger badge-counter position-relative" style="right:35%; bottom: 10px; font-size: 5px">3+</span>
                        </div>
                        <div class="mt-3">
                            <i class="fas fa-comments fa-1x text-gray-300"></i>
                        </div>
                        
                    </div>
                </div>
                <div class="justify-content-center admins-link mt-2 d-none d-lg-flex" style="width: 15%;">
                    <div class="text-center" style="min-width:45%;">
                        <span class="nav-link w-100 admin-profil marker link-float" style="cursor: pointer;">
                            <span class="mr-2 d-none d-lg-inline text-white-600 small"> {{ user.name }} </span>
                                <span class="fa fa-user-secret m-0 p-0" style="font-size: 20px" v-if="admin"></span>
                                <img class="img-profile rounded-circle" src="/media/profil.png" alt="administration" width="25" v-if="!admin">
                        </span>
                    </div>
                </div>
            </div>
            <admin-menu></admin-menu>
            <div class="login-profil profil-modal position-absolute border border-white" style="width: 200px; display: none; top: 75px; z-index: 100; background-image: url(/media/img/art-2578353_1920.jpg) !important; background-position: -200px 200px;">
                <div class="w-100 border" style="">
                    <a class="w-100 link-float d-inline-block border m-0 py-1" href="#">
                        <img class="img-profile rounded-circle" src="/media/profil.png" alt="administration" width="25">
                        <span class="mr-2 d-none d-lg-inline text-dark float-right"></span>
                    </a>
                      <!-- Dropdown - User Information -->
                    <div class="w-100 border">
                            <a class="w-100 my-1 hover link-float" href="" style="border-radius: 30px;">
                                <i class="fas fa-user fa-sm fa-fw mr-2"></i>
                              Profile
                            </a>
                            <a class="w-100 my-1 hover link-float" href="" style="border-radius: 30px;">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2"></i>
                              Administation
                            </a>
                                <a class="w-100 my-1 hover link-float" id="adminBecomeTeacherLink" href="#" style="border-radius: 30px;">
                                    <i class="fas fa-user fa-sm fa-fw mr-2"></i>
                                  Enseigner maintenant
                                </a>
                            <a class="w-100 my-1 hover link-float" id="makeUserLink" href="#" style="border-radius: 30px;">
                                <i class="fas fa-registered fa-sm fa-fw mr-2"></i>
                              Créer un utilisateur
                            </a>
                        <a class="w-100 py-1 hover link-float" href="#">
                             <i class="fas fa-list fa-sm fa-fw mr-2"></i>
                          Activity Log
                        </a>
                        <a @click="logout()" class="w-100 py-1 pb-2 hover border-top link-float" href="#">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                          Logout
                        </a>
                    </div>
                </div> 
            </div>
        </header>
        <div v-if="errors.status">
            <div>
                
            </div>
            <error404 v-if="errors.type == '404'"></error404>    
            <error419 v-if="errors.type == '419'"></error419>    
        </div>
        <!-- The formulars -->
        <pupil-perso></pupil-perso>
        <pupil-add></pupil-add>
        <pupil-edit-marks></pupil-edit-marks>
        
        <pupil-delete-confirmation></pupil-delete-confirmation>
        
        <parent-add></parent-add>
        <classe-add></classe-add>
        <classe-edit></classe-edit>
        <classe-refresh></classe-refresh>

        <teacher-perso></teacher-perso>
        <teacher-add></teacher-add>
        <teacher-classes></teacher-classes>

        <pupil-edit-parents></pupil-edit-parents>
        <edit-parents></edit-parents>
        <new-horaire></new-horaire>

	</div>
</template>


<script>
    import { mapState } from 'vuex'
	export default {

        data() {
            return {
                currentYear: (new Date).getFullYear(),
                
                
            }   
        },
        created(){
            this.$store.dispatch('getCounter')
            this.$store.dispatch('getTOOLS')
        },

 
        methods: {
            getYears(){
                let $tab = []

                for (var i = 1995; i <= (new Date).getFullYear(); i++) {
                    $tab.push(i)
                }
                return $tab
            },
            wasSelected(tag, target){
                return tag == target ? 'selected' : ''
            },

            logout(){
                this.$store.dispatch('logout')
            },
        },

        computed: mapState([
            'editedPupil', 'primaryClasses', 'secondaryClasses', 'primarySubjects', 'secondarySubjects', 'allSubjects', 'allRoles', 'allClasses', 'months', 'user', 'admin', 'errors', 'subjects', 'classesBlockeds', 'classesBlockedsAll'
        ])
        
	}


</script>

<style>
    .fade-enter-active, .fade-leave-active{
        transition: opacity 1s, transform 0.4s;
    }

    .fade-enter, .fade-leave-active{
        opacity: 0;
        transform: translateY(-30px); 
    }
    .fadeR-enter-active, .fadeR-leave-active{
        transition: opacity 1s, transform 0.5s;
    }

    .fadeR-enter, .fadeR-leave-active{
        opacity: 0;
        transform: translateX(-30px); 
    }
    .fadelist-enter-active, .fadelist-leave-active{
        transition: opacity 0.5s;
    }

    .fadelist-enter, .fadelist-leave-to{
        opacity: 0;
    }

    .scale-enter-active, .scale-leave-active{
        transition: opacity 0.5s, transform 0.2s;
    }

    .scale-enter, .scale-leave-active{
        opacity: 0;
        transform: scale(0.8);
    }

    .rapidScale-enter-active, .rapidScale-leave-active{
        transition: opacity 0.5s, transform 0.5s;
    }

    .rapidScale-enter, .rapidScale-leave-active{
        opacity: 0;
        transform: scale(0.7);
    }
    .fadelow-enter-active, .fadelow-leave-active{
        transition: opacity 1s, transform 1s;
    }

    .fadelow-enter, .fadelow-leave-active{
        opacity: 0;
        -webkit-transform: scale(0.1);
        -ms-transform: scale(0.1);
        -o-transform: scale(0.1);
        transform: scale(0.1);
    }
    .justefade-enter-active, .justefade-leave-active{
        transition: opacity 0.8s,
    }

    .justefade-enter, .justefade-leave-active{
        opacity: 0;
        
    }
    .bodyfade-enter-active, .bodyfade-leave-active{
        transition: opacity 1s, transform 1s;
    }

    .bodyfade-enter, .bodyfade-leave-active{
        opacity: 0;
        -webkit-transform: translateY(20px);
        -ms-transform: translateY(20px);
        -o-transform: translateY(20px);
        transform: translateY(20px);
    }
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