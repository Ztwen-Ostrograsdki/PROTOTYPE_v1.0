<template>
	<div class="w-100">
		<div class="w-100" style="min-height: 500px;">
            <table class="table-table table-striped w-100">
                <transition name="fadelow" appear>
                    <thead>
                        <th>No</th>
                        <th>Name</th>
                        <th>Sexe</th>
                        <th>Naissance</th>
                        <th>Inscrit depuis</th>
                        <th v-if="!isProfil">Classe</th>
                        <th v-if="isProfil">Status</th>
                        <th v-if="isProfil">Moyenne</th>
                        <th colspan="1">Actions</th>
                    </thead>
                </transition>
                <transition name="bodyfade" appear>
                    <tbody>
                        <tr v-for="(pupil, k) in thePupils" :key="pupil.id" class="border-bottom border-dark">
                            <td>
                                {{k+1}}
                            </td>
                            <td class="text-left">
                                <router-link :to="{name: 'pupilsProfil', params: {id: pupil.id}}"   class="card-link d-inline-block" >
                                    <span  class="w-100 d-inline-block link-profiler"  @click="setEdited(pupil)">
                                        {{pupil.name}}
                                    </span>
                                </router-link>
                                <a href="#" title="card-link Editer les informations de" class="fa fa-edit text-white-50 float-right" style="font-size: 10px!important; font-weight: 200!important" data-toggle="modal" data-target="#editPupilPersoModal" @click="getEdited(pupil)" @mouseout="closeProfiler()"></a>
                            </td>
                            <td>
                                {{gender(pupil.sexe)}}
                            </td>
                            <td>
                                {{birthday(pupil)}}
                            </td>
                            <td>
                                {{pupil.month + ' ' + pupil.year}}
                            </td>
                            <td v-if="!isProfil">
                            	<router-link class="card-link w-100 d-inline-block" :to="{name: 'classesProfil', params: {id: pupil.classe_id}}">
                                    <span>{{pupilsArray[pupil.id].name}} <sup>{{pupilsArray[pupil.id].sup}}</sup>{{pupilsArray[pupil.id].idc}}</span>
                                </router-link>
                            </td>
                            <td v-if="isProfil">
                            	N
                            </td>
                            <td v-if="isProfil">
                            	15
                            </td>
                            <td v-if="!redList">
                                <span class="d-inline-block w-100">
                                    <button title="Voulez vous supprimer" class="px-1 btn bg-transparent w-100" @click="destroy(pupil)">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                </span>
                            </td>
                            <td v-if="redList">
                                <span class="d-flex justify-content-between w-100">
                                    <button title="Restaurer cet élève" class="btn bg-secondary" style="width: 48%;" @click="restore(pupil)">
                                        <i class="fa fa-recycle text-success"></i>
                                    </button>
                                    <button title="Supprimer définitement cet élève" class="btn bg-info"  style="width: 48%;">
                                        <i class="fa fa-user-times text-danger"></i>
                                    </button>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </transition>
            </table>
        </div>
	</div>
</template>
<script>
	import { mapState } from 'vuex'

	export default{
		props: ['isProfil', 'thePupils', 'redList'],

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
                pupils: []
            }   
        },
        created(){
        	
        },

		methods :{
            gender(sexe){
                return sexe == "male" ? 'M' : 'F'
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
            destroy(pupil){
                this.$store.dispatch('lazyDeletePupils', pupil)                
            },

            closeProfiler(){
                this.profiler = false
                $(()=>{
                    $('.profiler').hide('fade', 500)
                })
            },
            openProfiler(){
                this.profiler = true

                $(()=>{
                    $('.profiler').show('fade', 500)
                })
            },

            getEdited(pupil){
                this.$store.dispatch('getTOOLS')
                this.$store.commit('RESET_INVALID_INPUTS')
                this.$store.dispatch('getAPupilData', pupil)

                
                $('#editPupilPersoModal .div-success').hide('slide', 'up')
                $('#editPupilPersoModal .div-success h4').text('')
                $('#editPupilPersoModal').animate({
                    top: '100'
                })
                
                $('#editPupilPersoModal form').show('slide', {direction: 'up'}, 1, function(){
                    $('#editPupilPersoModal form').animate({
                        opacity: '0'
                    }, function(){
                        $('#editPupilPersoModal form').animate({
                            opacity: '1'
                        }, 800)
                        $('#editPupilPersoModal .buttons-div').show('fade')
                    })
                })
            },

            addNew(){
                this.$store.commit('RESET_NEW_PUPIL')
                this.$store.dispatch('getTOOLS')
                this.$store.commit('RESET_INVALID_INPUTS')
                
                $('#newPupilPersoModal .div-success').hide('slide', 'up')
                $('#newPupilPersoModal .div-success h4').text('')
                $('#newPupilPersoModal form').show('fade', function(){
                    $('#newPupilPersoModal .buttons-div').show('fade')
                })
            },

            setEdited(pupil){
                this.$store.commit('SET_EDITED_PUPIL', pupil)
            },

            resetAlert(){
                this.$store.commit('ALERT_RESET')
            }
        },

        
		computed: mapState([
          	'pupilsArray', 'targetedClasse', 'editedPupil'
        ])

	}
</script>
