<template>
    <div class="w-100">
        <div class="w-100" style="min-height: 500px;">
            <table class="table-table table-striped w-100">
                <transition name="fadelow" appear>
                    <thead>
                        <th>No</th>
                        <th>Classe</th>
                        <th>Crée depuis</th>
                        <th>Principal</th>
                        <th>Respo 1</th>
                        <th>Respo 2</th>
                        <th colspan="1">Actions</th>
                    </thead>
                </transition>
                <transition name="bodyfade" appear>
                    <tbody>
                        <tr v-for="(classe, k) in theClasses" :key="classe.id" class="border-bottom border-dark">
                            <td>
                                {{k+1}}
                            </td>
                            <td class="px-2 text-left">
                                <router-link :to="{name: 'classesProfil', params: {id: classe.id}}"   class="card-link d-inline-block">
                                    <span  class="w-100 d-inline-block link-profiler">
                                        {{classe.name}}
                                    </span>
                                </router-link>
                                <a href="#" title="Editer le nom de cette classe" class="fa fa-edit text-white-50 float-right" style="font-size: 10px!important; font-weight: 200!important" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(classe, 'name')"></a>
                            </td>
                            <td class="px-2">
                                {{classe.month + ' ' + classe.year}}
                                <a href="#" title="Editer les dates de cette classe" class="fa fa-edit text-white-50 float-right" style="font-size: 10px!important; font-weight: 200!important" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(classe, 'year')"></a>
                            </td>
                            <td class="px-2">
                                <router-link v-if="classe.teacher_id !== null" :to="{name: 'teachersProfil', params: {id: classe.teacher_id}}"   class="card-link d-inline-block">
                                    <span>
                                        {{ getValue(classe.teacher_id)}}
                                    </span>
                                </router-link>
                                <span v-if="classe.teacher_id == null">
                                    {{ getValue(classe.teacher_id)}}
                                </span>
                               <a href="#" title="Editer le prof principal de cette classe" class="fa fa-edit text-white-50 float-right" style="font-size: 10px!important; font-weight: 200!important" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(classe, 'teacher')"></a>
                            </td>
                            <td class="px-2">
                               {{ getValue(classe.respo1) }}
                               <a href="#" title="Editer le premier responsable de cette classe" class="fa fa-edit text-white-50 float-right" style="font-size: 10px!important; font-weight: 200!important" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(classe, 'respo1')"></a>
                            </td>
                            <td class="px-2">
                               {{ getValue(classe.respo2)}}
                               <a href="#" title="Editer le second responsables de cette classe" class="fa fa-edit text-white-50 float-right" style="font-size: 10px!important; font-weight: 200!important" data-toggle="modal" data-target="#editClasseModal" @click="setEdited(classe, 'respo2')"></a>
                            </td>
                            
                            <td v-if="!redList">
                                <span class="d-inline-block w-100">
                                    <button title="Voulez vous supprimer" class="px-1 btn bg-transparent w-100" @click="destroy(classe.id)">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                </span>
                            </td>
                            <td v-if="redList">
                                <span class="d-flex justify-content-between w-100">
                                    <button title="Restaurer cette classe" class="btn bg-secondary" style="width: 48%;" @click="restore(classe)">
                                        <i class="fa fa-recycle text-success"></i>
                                    </button>
                                    <button title="Supprimer définitement cette classe" class="btn bg-info"  style="width: 48%;">
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
    export default { 
        props: ['isProfil', 'theClasses', 'redList', 'deletedClasses'],
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
                return value == null ? '-' : this.teachers[value].name
            },
            gender(sexe){
                return sexe == "male" ? 'M' : 'F'
            },
            filtrer(level){
                this.$store.commit('SHOW_CLASSES_BY_LEVEL', level)
            },

            
            destroy(id){
                this.$store.dispatch('lazyDeleteClasse', {id: id, forced: false})                
            },

            closeProfiler(){
                this.profiler = false
                $(()=>{
                    $('.profiler').hide('fade', 500)
                })
            },
            restore(classe){
                this.$store.dispatch('restoreClasses', classe)
            },
            openProfiler(){
                this.profiler = true

                $(()=>{
                    $('.profiler').show('fade', 500)
                })
            },

            getEdited(classe){
                this.$store.dispatch('getTOOLS')
                this.$store.commit('RESET_INVALID_INPUTS')
                this.$store.dispatch('getAClasseData', classe.id)

                
                $('#editClasseModal .div-success').hide('slide', 'up')
                $('#editClasseModal .div-success h4').text('')
                $('#editClasseModal').animate({
                    top: '100'
                })
                
                $('#editClasseModal form').show('slide', {direction: 'up'}, 1, function(){
                    $('#editClasseModal form').animate({
                        opacity: '0'
                    }, function(){
                        $('#editClasseModal form').animate({
                            opacity: '1'
                        }, 800)
                        $('#editClasseModal .buttons-div').show('fade')
                    })
                })
            },

            addNew(){
                this.$store.commit('RESET_NEW_CLASSE')
                this.$store.dispatch('getTOOLS')
                this.$store.commit('RESET_INVALID_INPUTS')
                
                $('#newClasseModal .div-success').hide('slide', 'up')
                $('#newClasseModal .div-success h4').text('')
                $('#newClasseModal form').show('fade', function(){
                    $('#newClasseModal .buttons-div').show('fade')
                })
            },

            setEdited(classe, tag){
                this.$store.commit('RESET_INVALID_INPUTS')
                
                $('#editClasseModal .div-success').hide('slide', 'up')
                $('#editClasseModal .div-success h4').text('')
                $('#editClasseModal').animate({
                    top: '100'
                })
                
                $('#editClasseModal form').show('slide', {direction: 'up'}, 1, function(){
                    $('#editClasseModal form').animate({
                        opacity: '0'
                    }, function(){
                        $('#editClasseModal form').animate({
                            opacity: '1'
                        }, 800)
                        $('#editClasseModal .buttons-div').show('fade')
                    })
                })

                if(tag == 'teacher'){
                    this.$store.dispatch('getAClasseDataOnTeachers', classe.id)
                }
                
                this.$store.commit('RESET_EDITING_CLASSE', {classe: classe, tag: tag}) 
            },

            resetAlert(){
                this.$store.commit('ALERT_RESET')
            }
        },

        computed: mapState([
           'classesAll', 'tl', 'alertClassesSearch', 'alert', 'message', 'editedClasse', 'classesSecondary', 'classesPrimary', 'primarySubjects', 'secondarySubjects', 'allSubjects', 'months', 'successed', 'invalidInputs', 'errors', 'teachers'
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

