<template>
    <div class="d-flex flex-column justify-content-around py-1 w-100 border float-right mx-0 bg-linear-official-180 px-3" >
        <transition name="scale" appear>
        <div class="d-flex justify-content-around py-1 w-100">
            <div>
                <span class="fa fa-chevron-up"></span>
            </div>
        </div>
        </transition>
        <div class="w-100">
            <div class="w-100 my-1 m-0 p-1">
                <div class="w-100 row m-0 p-0 pl-lg-4">
                    <div class="col-3 row pr-2 p-0 mt-1 mb-0">
                        
                    </div>
                    <div class="offset-7 col-2 mb-0" v-if="!alert">
                        <span class="btn btn-primary m-0 px-3 float-right mt-1" title="Ajouter un nouveau parent..." data-toggle="modal" data-target="#newParentModal" @click="addNew()">
                            <i class="fa fa-user-plus"></i>
                        </span>
                    </div>
                </div>
                <hr class="m-0 mt-1" style="background-color: white">
            </div>
            <div class="pupils">
                <div class="container bg-transparent w-100 py-1">
                    <div class="d-flex w-100 my-1 justify-content-start">

                    </div>
                    
                    <div class="w-100" style="min-height: 500px;">
                        <table class="table-table table-striped w-100">
                            <transition name="fadelow" appear>
                                <thead>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Sexe</th>
                                    <th>Profession</th>
                                    <th>Localité</th>
                                    <th>Contacts</th>
                                    <th>E-mail</th>
                                    <th>Parentés</th>
                                    <th colspan="1">Actions</th>
                                </thead>
                            </transition>
                            <transition name="bodyfade" appear>
                                <tbody>
                                    <tr v-for="(parent, k) in parents" :key="parent.parent.id" class="border-bottom border-dark" :class="show && index == k ? 'text-success' : ''">
                                        <td>
                                            {{k+1}}
                                        </td>
                                        <td class="text-left px-2">
                                            <router-link :to="{name: 'teachersProfil', params: {id: 1}}"   class="card-link d-inline-block" >
                                                <span  class="w-100 d-inline-block link-profiler"  @click="setEditedParent(parent.parent)">
                                                    {{parent.parent.name}}
                                                </span>
                                            </router-link>
                                            <a href="#" :title="'Editer les informations de ' + parent.name " class="fa fa-edit text-white-50 float-right" style="font-size: 10px!important; font-weight: 200!important" data-toggle="modal" data-target="#editParentModal" @click="setEditedParent(parent.parent)"></a>
                                        </td>
                                        <td>
                                            {{gender(parent.parent.sexe)}}
                                        </td>
                                        <td>
                                            {{parent.parent.works}}
                                        </td>
                                        <td>
                                            {{parent.parent.residence !== null ? parent.parent.residence : '-'}}
                                        </td>
                                        <td>
                                            {{parent.parent.contact}}
                                        </td>
                                        <td>
                                            {{parent.parent.email}}
                                        </td>
                                        <td class="" @click="displayIndex(k)">
                                            <span>
                                                <span>{{parent.pupils.length + ' apprenant(s)'}}</span>
                                            </span>
                                            <transition name="justefade" appear>
                                                <table style="padding: 5px !important; z-index: 3000" class=" text-dark position-absolute border border-warning w-auto bg-primary table-list-official" v-if="show && index == k">
                                                    <li style="" class="list-unstyled border border-bottom px-3 py-2" v-for="pupil in parent.pupils">
                                                        <span class="">{{pupil.child.name}}</span>
                                                    </li>
                                                </table>
                                            </transition>
                                        </td>

                                        <td>
                                            <span class="d-inline-block w-100">
                                                <button :title="'Voulez-vous envoyez ' + parent.name + ' dans la corbeille? '" class="px-1 btn bg-transparent w-100" @click="destroy(parent.parent)">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </transition>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
    import { mapState } from 'vuex'
    export default { 
        props : [],
        editedTeacher: {}, 

        data() {
            return {
                selfMonths : [
                    "Janvier",
                    "Février",
                    "Mars",
                    "Avril",
                    "Mai",
                    "Juin",
                    "Juillet",
                    "Août",
                    "Septembre",
                    "Octobre",
                    "Novembre",
                    "Décembre"

                ],
                show: false,
                index: 0,
                target: '',
            }   
        },
        created(){
            this.$store.dispatch('getParentsData')
        },

        methods :{
            gender(sexe){
                return sexe == "male" ? 'M' : 'F'
            },
            filtrer(level){
                this.$store.commit('SHOW_TEACHERS_BY_LEVEL', level)
            },

            birthday(user)
            {
                let date = user.birth
                let parts = (date.split("-")).reverse()
                let day = parts[0]
                let m = (this.selfMonths[parts[1] - 1]).length > 5 ? (this.selfMonths[parts[1] - 1]).substring(0, 3) : this.selfMonths[parts[1] - 1]
                let year = parts[2]

                return day + " " + m + " " + year
            },
            destroy(teacher){
                // this.$store.dispatch('lazyDeleteTeachers', teacher)                
            },
            displayIndex(index){
                this.index = index
                this.show = !this.show
            },
            setEditedParent(parent){
                this.$store.commit('RESET_EDITED_PARENT', parent)
            },
            addNew(){
                this.$store.commit('RESET_NEW_PARENT')
                this.$store.commit('RESET_INVALID_INPUTS')
                $('#newParentModal .div-success').hide('size', function(){
                    $('#newParentModal .div-success h4').text('')
                    $('#newParentModal form').show('fade', function(){
                        $('#newParentModal .buttons-div').show('size', 50)
                        $('#newParentModal').animate({
                            top: '50'
                        }, () => {})
                    })
                })
            }
           
        },

        computed: mapState([
            'alert', 'message', 'parents'
        ])
    }

</script>
<style>
    .table-list-official li:nth-of-type(odd) {
        background-color: rgba(150, 200, 150, 0.7);
    }
</style>

