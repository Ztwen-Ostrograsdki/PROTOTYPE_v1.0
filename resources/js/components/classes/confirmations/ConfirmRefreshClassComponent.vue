<template>
    <div class="modal fade" id="confirmRefreshClassModal" tabindex="-1" role="dialog" aria-labelledby="confirmRefreshClassModalLabel" aria-hidden="true" style="top: 100px !important;">
        <div class="modal-dialog text-center border border-white">
            <div class="bg-linear-official-180 modal-content" style="border-style: solid; border-radius: 0;">
                <div class="w-100 mx-auto bg-linear-official-180">
                    <div class="mx-auto w-100 p-1 pb-2" style="">
                        <div class="w-100 p-2 my-1 mx-auto">
                            <h5 class="text-center mx-auto text-warning w-75">Confirmation rafraîchissement de classe</h5>
                            <hr class="m-0 p-0 bg-white mb-2 w-100">
                            <div class="mx-auto w-100" v-if="!refreshClasse.confirm">
                                <p class="w-100 mx-auto text-center">
                                    <h5 class="text-danger cursive">Vous êtes sur le point de rafraîchir la classe de <span class="text-warning"> {{targetedClasse.classeFMT.name}}<sup>{{ targetedClasse.classeFMT.sup }}</sup> {{ targetedClasse.classeFMT.idc }}
                                    </span>
                                    </h5> 
                                    <br>
                                    <span class="">
                                    <i class="cursive">Les apprenants de cette classe seront:</i>
                                    <form class="d-inline-block d-flex flex-column form-group" id="refresh-classe">
                                        <span @click="refreshStatus(false)">
                                            <label for="refresh_classe_false">Envoyés dans la corbeille</label>
                                            <input type="radio" class="custom-radio" name="refresh" id="refresh_classe_false" checked="" value="false">
                                        </span>
                                        <span @click="refreshStatus(true)">
                                            <label for="refresh_classe_true">Définitivement supprimés</label>
                                            <input type="radio" name="refresh" class="custom-radio" id="refresh_classe_true" value="true">
                                        </span>
                                    </form>
                                    </span>
                                </p>
                                <div class="w-100 mx-auto mt-2">
                                    <h5 class="mx-auto w-100 text-center text-white-50">Voulez-vous vraiment rafraîchir cette classe?</h5>
                                    <div class="mx-auto w-100 d-flex justify-content-center">
                                        <button class="btn btn-danger mx-1" data-dismiss="modal" >Avorter la requête</button>
                                        <button class="btn btn-primary mx-1" @click="refresherClasse()">Confirmer la requête</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mx-auto w-100" v-if="refreshClasse.confirm">
                                <p class="w-100 mx-auto text-center">
                                    <br>
                                    <h4 class="">
                                        <span class="fa fa-check-square-o text-success text-center d-block" style="font-size: 15px"></span>
                                        <i class="cursive text-success">L'opération s'est déroulée avec succès</i>
                                    </h4>
                                </p>
                                <div class="w-100 mx-auto mt-2">
                                    <h5 class="mx-auto w-100 text-center text-white-50">La classe de <span class="text-warning"> {{targetedClasse.classeFMT.name}}<sup>{{ targetedClasse.classeFMT.sup }}</sup> {{ targetedClasse.classeFMT.idc }}
                                    </span> a été bien rafraîchie</h5>
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
                refresh: {status: false, confirm: false}
                
            }   
        },
        created(){
            
        },

        methods :{
            refreshStatus(status){
                this.refresh.status = status
            },
            refresherClasse(){
                let status = this.refresh.status
                let classe = this.targetedClasse.classe
                let route = this.$route.name

                this.$store.dispatch('refreshOnPupils', {forced: status, classe: classe, route: route})
                
            },
        },

        computed: mapState([
           'classes' , 'errors', 'targetedClasse', 'refreshClasse'
        ])
    }

    
</script>
<style>
    div#options span:hover{
        transform: scale(1.3);
    }
</style>

