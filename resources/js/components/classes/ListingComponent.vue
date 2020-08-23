<template>
    <div class="d-flex flex-column justify-content-around py-1 w-100 border float-right mx-0 bg-linear-official-180 px-3" >
        <transition name="scale" appear>
        <div class="d-flex justify-content-around py-1 w-100">
            <div class="d-flex row justify-content-around" style="width: 100%">
                <div class="border py-2 col-lg-5 col-md-12">
                    <div class="w-100 d-flex justify-content-between">
                        <div class="">
                            <h5 class="h5-title">Le Primaire</h5> 
                        </div>
                        <div class="">
                            <span class="fa fa-close float-right p-1"></span>
                        </div>
                    </div>
                    <hr class="m-0" style="background-color: white">
                    <div class="mt-1 w-100">
                        <div class="w-100 d-flex justify-content-between">
                            <span class="fa fa-university fa-2x" ></span>
                            <span class="fa fa-2x">{{ classesPrimary.length }}</span>
                        </div>
                        <div class="w-100 d-block">
                            <span class="w-100 d-flex justify-content-around">
                                <span class="m-0 p-0">
                                    <i class="text-white-50 h5-title ">Meilleur:</i> <i class="text-white-50 h5-title ">Jean Maillote [18.89] </i>
                                </span>
                                <span class="m-0 p-0">
                                    <i class="text-white-50 h5-title ">Faible:</i> <i class="text-white-50 h5-title ">Origi France [06.88] </i>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 border">
                    <div class="py-2" id="sup-tag" style="display: none; width: 0; opacity: 0">
                        <div class="d-flex justify-content-between tag-container" style="width: 100%">
                            <div style="width: 98.5%">
                                <div class="d-flex justify-content-between">
                                    <div class="">
                                        <h5 class="h5-title">Le Supérieur</h5>
                                    </div>
                                    <div class="">
                                        <span class="fa fa-close float-right p-1"></span>
                                    </div>
                                </div>
                                <hr class="m-0" style="background-color: white">
                                <div class="mt-1 w-100">
                                    <div class="w-100 d-flex justify-content-between">
                                        <span class="fa fa-university fa-2x text-white" ></span>
                                        <span class="fa fa-2x">700</span>
                                    </div>
                                    <div class="w-100 d-block">
                                        <span class="w-100 d-flex justify-content-around">
                                            <span class="m-0 p-0">
                                                <i class="text-white-50 h5-title ">Meilleur:</i> <i class="text-white-50 h5-title ">Jean Maillote [18.89] </i>
                                            </span>
                                            <span class="m-0 p-0">
                                                <i class="text-white-50 h5-title ">Faible:</i> <i class="text-white-50 h5-title ">Origi France [06.88] </i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="py-4 float-right ml-3">
                                <span class="fa fa-chevron-left float-right" id="chevron-sup" style="font-size: 12px;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="py-2" id="sec-tag" style="width: 100%">
                        <div class="d-flex justify-content-between tag-container" style="width: 100%">
                            <div style="width: 98.5%">
                                <div class="d-flex justify-content-between">
                                    <div class="">
                                        <h5 class="h5-title">Le Secondaire</h5>
                                    </div>
                                    <div class="">
                                        <span class="fa fa-close float-right p-1"></span>
                                    </div>
                                </div>
                                <hr class="m-0" style="background-color: white">
                                <div class="mt-1 w-100">
                                    <div class="w-100 d-flex justify-content-between"> 
                                        <span class="fa fa-university fa-2x text-white" ></span>
                                        <span class="fa fa-2x">{{ classesSecondary.length }}</span>
                                    </div>
                                    <div class="w-100 d-block">
                                        <span class="w-100 d-flex justify-content-around">
                                            <span class="m-0 p-0">
                                                <i class="text-white-50 h5-title ">Meilleur:</i> <i class="text-white-50 h5-title ">Jean Maillote [18.89] </i>
                                            </span>
                                            <span class="m-0 p-0">
                                                <i class="text-white-50 h5-title ">Faible:</i> <i class="text-white-50 h5-title ">Origi France [06.88] </i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="py-4 float-right ml-3">
                                <span class="fa fa-chevron-left float-right" id="chevron-sec" style="font-size: 12px;"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                    <div class="float-right d-flex justify-content-around pr-2 mt-4 mb-0 border py-2" v-if="alert">
                        <p class="h5-title m-0 px-2">
                            <span class="mx-2 fa fa-envelope-open"></span>{{ message }}
                        </p>
                        <span class="mx-1 fa fa-close text-danger" @click="resetAlert()"></span>
                    </div>
                    <div class="offset-7 col-2 mb-0" v-if="!alert">
                        <span class="btn btn-primary m-0 px-3 float-right mt-1" title="Ajouter une nouvelle classe..." data-toggle="modal" data-target="#newClassePersoModal" @click="addNew()">
                            <i class="fa fa-plus"></i>
                        </span>
                        
                    </div>
                </div>
                <hr class="m-0 mt-1" style="background-color: white">
            </div>
            <div class="pupils">
                <div class="container bg-transparent w-100 py-1">
                    <div class="d-flex w-100 my-1 justify-content-start">
                        <div class="mx-1 my-0">
                            <span class="fa fa-refresh text-white-50" @click="filtrer('all')" v-if="alertClassesSearch !== 'Toutes les classes'"></span>
                            <button class="btn btn-primary mx-1" @click="filtrer('primary')"> Le Primaire ({{ ' '+ classesPrimary.length +' ' }}) </button>
                            <button class="btn btn-primary" @click="filtrer('secondary')">Le Secondaire ({{ ' '+ classesSecondary.length +' ' }})</button>
                        </div>
                        <h5 class="card-link mt-3 text-white-50 ml-3"> {{ alertClassesSearch }}</h5>
                        <div class="position-absolute profiler" style="top: 150px; left: 10px; display: none">
                            <div class="profil-img">
                                <span class="photo"><img src="/media/hideface.jpg" width="250"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="w-100" style="min-height: 500px;">
                        <table class="table-table table-striped w-100">
                            <transition name="fadelow" appear>
                                <thead>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Crée depuis</th>
                                    <th>Principal</th>
                                    <th>Respo 1</th>
                                    <th>Respo 2</th>
                                    <th colspan="1">Actions</th>
                                </thead>
                            </transition>
                            <transition name="bodyfade" appear>
                                <tbody>
                                    <tr v-for="(classe, k) in classes" :key="classe.id" class="border-bottom border-dark">
                                        <td>
                                            {{k+1}}
                                        </td>
                                        <td class="text-left">
                                            <router-link :to="{name: 'classesProfil', params: {id: classe.id}}"   class="card-link d-inline-block">
                                                <span  class="w-100 d-inline-block link-profiler"  @click="setEdited(classe)">
                                                    {{classe.name}}
                                                </span>
                                            </router-link>
                                            <a href="#" title="card-link Editer les informations de" class="fa fa-edit text-white-50 float-right" style="font-size: 10px!important; font-weight: 200!important" data-toggle="modal" data-target="#editClassePersoModal" @click="getEdited(classe)" @mouseout="closeProfiler()"></a>
                                        </td>
                                        <td>
                                            {{classe.month + ' ' + classe.year}}
                                        </td>
                                        <td>
                                           {{ getValue(classe.teacher_id)}}
                                        </td>
                                        <td>
                                           {{ getValue(classe.respo1) }}
                                        </td>
                                        <td>
                                           {{ getValue(classe.respo2)}}
                                        </td>
                                        
                                        <td>
                                            <span class="d-inline-block w-100">
                                                <button title="Voulez vous supprimer" class="px-1 btn bg-transparent w-100" @click="destroy(classe)">
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
        editedPupil: {}, 

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
                profiler: false
            }   
        },
        created(){
            this.$store.dispatch('getClassesData')
        },

        methods :{
            getValue(value){
                return value == null ? '-' : value
            },
            gender(sexe){
                return sexe == "male" ? 'M' : 'F'
            },
            filtrer(level){
                this.$store.commit('SHOW_CLASSES_BY_LEVEL', level)
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

                
                $('#editClassePersoModal .div-success').hide('slide', 'up')
                $('#editClassePersoModal .div-success h4').text('')
                $('#editClassePersoModal').animate({
                    top: '100'
                })
                
                $('#editClassePersoModal form').show('slide', {direction: 'up'}, 1, function(){
                    $('#editClassePersoModal form').animate({
                        opacity: '0'
                    }, function(){
                        $('#editClassePersoModal form').animate({
                            opacity: '1'
                        }, 800)
                        $('#editClassePersoModal .buttons-div').show('fade')
                    })
                })
            },

            addNew(){
                // this.$store.commit('RESET_NEW_PUPIL')
                // this.$store.dispatch('getTOOLS')
                // this.$store.commit('RESET_INVALID_INPUTS')
                
                $('#newClassePersoModal .div-success').hide('slide', 'up')
                $('#newClassePersoModal .div-success h4').text('')
                $('#newClassePersoModal form').show('fade', function(){
                    $('#newClassePersoModal .buttons-div').show('fade')
                })
            },

            setEdited(pupil){
                
            },

            resetAlert(){
                this.$store.commit('ALERT_RESET')
            }
        },

        computed: mapState([
           'classes', 'classesAll', 'tl', 'alertClassesSearch', 'alert', 'message', 'editedClasse', 'classesSecondary', 'classesPrimary', 'primarySubjects', 'secondarySubjects', 'allSubjects', 'months', 'successed', 'invalidInputs', 'errors'
        ])
    }

    $(function(){

    let sup_tag = $('#sup-tag')
    let sup_ch = $('#chevron-sup')
    let sec_tag = $('#sec-tag')
    let sec_ch = $('#chevron-sec')


    sec_ch.click(function(){

        sec_tag.animate({
            width: '0px',
            opacity: '0'
        })
        sec_tag.hide()
        sup_tag.animate({
            width: '100%',
            opacity: '1'
        },100 , function(){
            sup_tag.show('slide', {direction: 'right'})
        })

    })

    sup_ch.click(function(){

        sup_tag.animate({
            width: '0px',
            opacity: '0'
        })
        sup_tag.hide()
        sec_tag.animate({
            width: '100%',
            opacity: '1'
        },100 , function(){
            sec_tag.show('slide', {direction: 'right'})
        })

    })
})

</script>
<style>
    
</style>

