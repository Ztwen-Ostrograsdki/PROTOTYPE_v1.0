<template>
    <div class="modal fade" id="confirmDeletingModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeletingModalLabel" aria-hidden="true" style="top: 100px !important;">
        <div class="modal-dialog text-center border border-white">
            <div class="bg-linear-official-180 modal-content" style="border-style: solid; border-radius: 0;">
                <div class="w-100 mx-auto bg-linear-official-180">
                    <div class="mx-auto w-100 p-1 pb-2" style="">
                        <div class="w-100 p-2 my-1 mx-auto">
                            <h5 class="text-center mx-auto text-warning w-75">Confirmation Suppression d'apprenant{{deletingPupil.sexe == 'female' ? 'e' : ''}}</h5>
                            <hr class="m-0 p-0 bg-white mb-2 w-100">
                            <div class="mx-auto w-100" v-if="!deletingPupilConfirmation.confirm">
                                <p class="w-100 mx-auto text-center">
                                    <h5 class="text-danger cursive">Vous êtes sur le point de supprimer l'apprenant{{deletingPupil.sexe == 'female' ? 'e' : ''}} de <span class="text-warning"> {{deletingPupil.name}}
                                    </span>
                                    </h5> 
                                    <br>
                                    <span class="">
                                    <i class="cursive">L'apprenant{{deletingPupil.sexe == 'female' ? 'e' : ''}} <span class="text-warning"> {{deletingPupil.name}}</span> sera</i>
                                    <i class="text-danger cursive" v-if="$route.name == 'pupilsRedList'"> <br>définitivement supprimé{{deletingPupil.sexe == 'female' ? 'e' : ''}} de la base de données</i>
                                    <div v-if="$route.name !== 'pupilsRedList'" class="m-0 p-0">
                                        <form class="d-inline-block d-flex flex-column form-group" id="refresh-classe" >
                                        <span @click="refreshStatus('weak')">
                                            <label for="deleting_pupil_weak">Envoyés dans la corbeille</label>
                                            <input type="radio" class="custom-radio" name="deletePupil" id="deleting_pupil_weak" checked="" value="weak">
                                        </span>
                                        <span @click="refreshStatus('strong')">
                                            <label for="deleting_pupil_strong">Définitivement supprimé{{deletingPupil.sexe == 'female' ? 'e' : ''}}</label>
                                            <input type="radio" name="deletePupil" class="custom-radio" id="deleting_pupil_strong" value="strong">
                                        </span>
                                    </form>
                                    </div>
                                    </span>
                                </p>
                                <div class="w-100 mx-auto mt-2">
                                    <h5 class="mx-auto w-100 text-center text-white-50">Voulez-vous vraiment supprimer cet{{deletingPupil.sexe == 'female' ? 'te' : ''}} apprenant{{deletingPupil.sexe == 'female' ? 'e' : ''}}?</h5>
                                    <div class="mx-auto w-100 d-flex justify-content-center">
                                        <button class="btn btn-danger mx-1" data-dismiss="modal" >Avorter la requête</button>
                                        <button class="btn btn-primary mx-1" @click="deletePupil()">Confirmer la requête</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mx-auto w-100" v-if="deletingPupilConfirmation.confirm">
                                <p class="w-100 mx-auto text-center">
                                    <br>
                                    <h4 class="">
                                        <span class="fa fa-check-square-o text-success text-center d-block" style="font-size: 15px"></span>
                                        <i class="cursive text-success">L'opération s'est déroulée avec succès</i>
                                    </h4>
                                </p>
                                <div class="w-100 mx-auto mt-2">
                                    <h5 class="mx-auto w-100 text-center text-white-50">L'apprenant{{deletingPupil.sexe == 'female' ? 'e' : ''}} <span class="text-warning"> {{deletingPupil.name}}
                                    </span> a été bien supprimé{{deletingPupil.sexe == 'female' ? 'e' : ''}}</h5>
                                    <div class="mx-auto w-100 d-flex justify-content-center">
                                        <button class="btn btn-success mx-1 w-50" data-dismiss="modal" >Terminée</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        data() {
            return {
                deleting: {status: 'weak', confirm: false}
                
            }   
        },
        created(){
            
        },

        methods :{
            refreshStatus(status){
                this.deleting.status = status
            },
            deletePupil(){
                let status = this.deleting.status
                let pupil = this.deletingPupil
                let route = this.$route
                if(this.$route.name == 'pupilsRedList'){
                    status = 'strong'
                }
                

                if(status == 'weak'){
                    if(route.name == 'classesProfil'){
                        this.$store.dispatch('deletePupilOfAClasse', {pupil, route, status})  
                    }
                    else{
                        this.$store.dispatch('lazyDeletePupils', pupil)                
                    }
                }
                else if(status == 'strong'){
                    if(route.name == 'classesProfil'){
                        this.$store.dispatch('deletePupilOfAClasse', {pupil, route, status})  
                    }
                    else if(route.name == 'pupilsListing' || route.name == 'pupilsRedList'){
                        this.$store.dispatch('forceDeletePupils', pupil)                
                    }
                }
                
            },
            destroyer(pupil){
                
               
            },
        },

        computed: mapState([
            'errors', 'deletingPupil', 'deletingPupilConfirmation'
        ])
    }

    
</script>
<style>
    div#options span:hover{
        transform: scale(1.3);
    }
</style>

