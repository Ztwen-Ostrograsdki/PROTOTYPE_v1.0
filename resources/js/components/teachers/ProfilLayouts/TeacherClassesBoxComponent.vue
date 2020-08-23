<template>
	<div class="onetable teacher-classes  " style="width: 100%;">
		<div class="onetable teacher-classes" style="width: 100%;">
        <h5>
            Les classes tenues
            <div  class="d-inline m-0 p-0 float-right" v-if="targetedTeacherClasses.length > 0">
                <span :title="'Retirer toutes les classes de la gestion du prof ' + targetedTeacher.name " class="float-right fa" @click="disjoinedClasses(targetedTeacher, null)">
                    <img src="/media/icons/recycleall.png" alt="recyclage" width="25" class="float-right">
                </span>
            </div>
        </h5>
        <div class="m-0 p-0" v-if="targetedTeacherClasses.length > 0">
            <div class="border w-100 p-1 bg-linear-official-180">
                <div class="d-flex mb-1 border-bottom" v-for="(classe, k) in targetedTeacherClassesFMT">
                    <div class="border-right p-1 text-center" style="width: 40%;">
                        <span>
                        	<router-link class="text-white-50 text-decoration-none" :to="{name: 'classesProfil', params: {id: k}}">
                            {{ classe.name }}<sup>{{ classe.sup }}</sup> {{classe.idc}}
                            </router-link>
                        </span>
                        <div class="d-inline float-right ml-3" title="Retirer cette classe de la gestion de ce prof">
                            <div class="d-inline m-0 p-0">
                                <span @click="disjoinedClasses(targetedTeacher, k)">
                                    <span class="fa fa-remove text-danger"></span>
                                </span>
                            </div>
                        </div>
                        <div class="float-right" title="Empêcher le prof d'avoir la possiblité de modifier les notes de cette classe" >
                            <div class="d-inline m-0 p-0" >
                                <span >
                                    <span class="fa fa-lock text-warning"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center" style="width: 55%;">
                        <h6 class="m-0 p-0">Lundi 10h - 12h</h6>
                        <h6 class="m-0 p-0">Mercredi 10h - 12h</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-0 p-2 font-italic bg-linear-official-180 border border-white" v-if="targetedTeacherClasses.length <= 0">
        	<h5 class="text-white-50" style="font-size: 9px">Le prof <span class="text-secondary">{{ targetedTeacher.name }}</span> n'a encore aucune salle</h5>
        </div>
        <div class="m-0 p-0 d-flex flex-column">
        	<div class="m-0 p-0" @click="editClasses(targetedTeacher)">
                <span href="#" data-toggle="modal" data-target="#editTeacherClassesModal" class="btn btn-news mt-1 p-1 float-right">Mettre à jour</span>
            </div>
            <div class="m-1 h5-title p-1 text-white text-success border rounded shadow" v-if="classeDetachAlert.status">
            	{{classeDetachAlert.msg}} <span class="fa fa-close float-right mt-1" @click="closeAlert()"></span>
            </div>
        </div>
        </div>
	</div>
</template>

<script>
	import { mapState } from 'vuex'
	export default{
		data() {
            return {
				preEdited: {},
				            
            }   
        },

		


		methods: {

			editClasses(teacher){ 
                this.$store.commit('RESET_EDITED_TEACHER')
                this.$store.commit('RESET_INVALID_INPUTS')
                this.$store.dispatch('getATeacherData', teacher)
                this.$store.commit('RESET_EDITED_TEACHER_CLASSES1_CONFIRM')

                $('#editTeacherClassesModal .div-confirm-classe-prim').hide('fade')
                $('#editTeacherClassesModal .div-success').hide('slide', 'up')
                $('#editTeacherClassesModal .div-success h4').text('')
                $('#editTeacherClassesModal').animate({
                    top: '20px'
                })
                
                $('#editTeacherClassesModal form').show('slide', {direction: 'up'}, 1, function(){
                    $('#editTeacherClassesModal form').animate({
                        opacity: '0'
                    }, function(){
                        $('#editTeacherClassesModal form').animate({
                            opacity: '1'
                        }, 800)
                        $('#editTeacherClassesModal .buttons-div').show('fade')
                    })
                })
                
            },

            disjoinedClasses(teacher, classeID = null){
            	let route = this.$route

            	if(classeID !== null){
            		let classe = {id: parseInt(classeID, 10)}
            		this.$store.dispatch('disjoinedClasses', {teacher, classe, route})
            	}
            	else{
            		let classe = {id: "fresh"}
            		this.$store.dispatch('disjoinedClasses', {teacher, classe, route})
            	}
            	
            },

            closeAlert(){
            	this.$store.commit('RESET_ALERT_CLASSE_DETACH', {status: false, msg: ''})
            }
			
            
		},
		computed: mapState([
           'editedTeacher', 'errors', 'targetedTeacher', 'targetedTeacherClassesFMT', 'targetedTeacherClasses', 'classeDetachAlert'
        ])

	}
</script>