<template>
	<div class="w-100 p-1 mx-auto">
		<div class="w-100 mx-auto d-flex justify-content-center">
			<table class="table-table table-striped w-100">
				<transition name="justefade" appear>
                    <thead>
                        <th class=" mark-name">Matières</th>
                        <th class=" coef-tag">Coef</th>
                        <th class="">Interrogations (EPE)</th>
                        <th class="">Devoirs</th>
                        <th>Moyenne</th>
                    </thead>
                </transition>
               	<transition name="fadelow" appear>
                    <tbody class="w-100 marks-td">
                    	<tr class="td border-bottom border-white">
                    		<td class=" bg-linear-official-180">x</td>
                    		<td class=" bg-linear-official-180">x</td>
                    		<td class="text-center ">
                    			<table class="text-center w-100 text-white-50">
	                    			<tbody class="w-100">
	                    				<tr class="text-center w-100">
	                    					<td class="text-center ">Int 1</td>
	                    					<td class="text-center ">Int 2</td>
	                    					<td class="text-center ">Int 3</td>
	                    					<td class="text-center ">Int 4</td>
	                    					<td class="text-center ">Int 5</td>
	                    					<td class="text-primary">Moy Int</td>
	                    				</tr>
	                    			</tbody>
	                    		</table>
                    		</td>
                    		<td class="text-center ">
                    			<table class="text-center w-100 text-primary">
	                    			<tbody class="w-100">
	                    				<tr class="w-100 td">
	                    					<td class="text-center ">Dev 1</td>
	                    					<td>Dev 2</td>
	                    				</tr>
	                    			</tbody>
	                    		</table>
                    		</td>
                    		<td class="bg-linear-official-180">
                    			<table class="text-center w-100">
	                    			<tbody class="w-100">
	                    				<tr class="w-100 td">
	                    					<td class="text-center  text-warning">Moy Coef</td>
	                    					<td class="text-success">Moy</td>
	                    				</tr>
	                    			</tbody>
	                    		</table>
                    		</td>
                    	</tr>
                    	<tr :title="targetPupilMarks !== null && targetPupilMarks[subject.id] && targetPupilMarks[subject.id]['modality'] !== null ? ' Le prof a choisir les ' + targetPupilMarks[subject.id]['modality'] + ' meilleures notes ' : 'Le prof envisage prendre toutes les notes certainement' "  class="td border-bottom border-white" v-for="subject in editedPupilSubjects">
                    		<td class="d-flex justify-content-between pl-2 w-100">
                    			<a class="w-75" href="#">
                    				<span class="float-left">{{ subject.name }}</span>
                    			</a>
                    			<span class="fa fa-edit mr-3 text-white-50 mt-2" style="font-size: 9px" :title="'Editer les notes en ' + subject.name + ' de ' + editedPupil.name " data-toggle="modal" data-target="#editPupilMarks" @click="editedPupilClasseAndSubjectMarks(subject, editedPupil)"></span>
                    		</td>
                    		<td class="text-center">{{ editedPupilCoefTables[subject.id] }}</td>
                    		<td class="text-center">
                    			<table class="text-center w-100 text-white-50">
	                    			<tbody class="w-100">
	                    				<tr class="text-center w-100 td" v-if="targetPupilMarks !== null">
	                    					<td :class="'text-center ' + getMarkStatus(subject, 0)">{{ getSujectMarks(subject, 'epe', 0)}}</td>
	                    					<td :class="'text-center ' + getMarkStatus(subject, 1)">{{ getSujectMarks(subject, 'epe', 1)}}</td>
	                    					<td :class="'text-center ' + getMarkStatus(subject, 2)">{{ getSujectMarks(subject, 'epe', 2)}}</td>
	                    					<td :class="'text-center ' + getMarkStatus(subject, 3)">{{ getSujectMarks(subject, 'epe', 3)}}</td>
	                    					<td :class="'text-center ' + getMarkStatus(subject, 4)">{{ getSujectMarks(subject, 'epe', 4)}}</td>
	                    					<td class="text-primary">{{ getEPPAverage(subject) }}</td>
	                    				</tr>
	                    				<tr class="text-center w-100 td" v-if="targetPupilMarks == null">
	                    					<td class="text-center">-</td>
	                    					<td class="text-center">-</td>
	                    					<td class="text-center">-</td>
	                    					<td class="text-center">-</td>
	                    					<td class="text-center">-</td>
	                    					<td class="text-primary">-</td>
	                    				</tr>
	                    			</tbody>
	                    		</table>
                    		</td>
                    		<td class="text-center ">
                    			<table class="text-center w-100 text-primary">
	                    			<tbody class="w-100">
	                    				<tr class="w-100 td dev-marks" v-if="targetPupilMarks !== null">
	                    					<td class="text-center">{{ getSujectMarks(subject, 'devoirs', 0)}}</td>
	                    					<td>{{ getSujectMarks(subject, 'devoirs', 1)}}</td>
	                    				</tr>
	                    				<tr class="w-100 td" v-if="targetPupilMarks == null">
	                    					<td class="text-center">-</td>
	                    					<td>-</td>
	                    				</tr>
	                    			</tbody>
	                    		</table>
                    		</td>
                    		<td class="text-center av">
                    			<table class="text-center w-100">
	                    			<tbody class="w-100">
	                    				<tr class="w-100"  v-if="targetPupilMarks !== null">
	                    					<td class="text-center text-warning">{{getAverage(subject) !== '-' ? parseFloat(getAverage(subject) * editedPupilCoefTables[subject.id]).toFixed(2) : '-'}}</td>
	                    					<td class="text-success text-center">{{getAverage(subject)}}</td>
	                    				</tr>
	                    				<tr class="w-100"  v-if="targetPupilMarks == null">
	                    					<td class="text-center text-warning">-</td>
	                    					<td class="text-success">-</td>
	                    				</tr>
	                    			</tbody>
	                    		</table>
                    		</td>
                    	</tr>
                    </tbody>
                </transition>
			</table>
		</div>
		
		<div class="d-flex flex-column w-100 m-0 p-0 my-2">
			<div class="d-flex w-100 m-0 p-0 my-2 justify-content-around text-white-50 trimestre">
				<div class="bg-linear-official-50" style="width: 33%;">
					<trimestre :trimestreName="'Trimestre 1'" :border="'border-success'"></trimestre>
				</div>
				<div class="bg-linear-official-50" style="width: 33%;">
					<trimestre :trimestreName="'Trimestre 2'" :border="'border-primary'"></trimestre>
				</div>
				<div class="bg-linear-official-50" style="width: 33%;">
					<trimestre :trimestreName="'Trimestre 3'" :border="'border-warning'"></trimestre>
				</div>
			</div>
			<div class="mx-auto mt-1 row w-100">
				<div class="border border-white mx-auto box-color-blue col-10 py-2">
					<trimestre-general></trimestre-general>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import { mapState } from 'vuex'
	import averageComputor from '../../../../helpers/helpers.js'

	export default{
		data() {
            return {

            }   
        },
        created(){
        	
        },

		methods: {
			getSujectMarks(subject, type, id, marks = this.targetPupilMarks){
				if(marks[subject.id] !== undefined){
					if(marks[subject.id][type][id] !== undefined){
						return marks[subject.id][type][id].value >= 10 ? marks[subject.id][type][id].value : '0' + marks[subject.id][type][id].value
						
					}
					
					return '-'
				}
				else{
					return "-"
				}
				
			},
			editedPupilClasseAndSubjectMarks(subject){
				this.$store.commit('RESET_TARGETED_PUPIL_SUBJECT_MARKS', subject)
				this.$store.commit('RESET_TARGETED_PUPIL_SUBJECT', subject.id)
				$('#editPupilMarks .div-success').hide('slide', 'up')
                $('#editPupilMarks .div-success h4').text('')
                $('#editPupilMarks').animate({
                    top: '1px'
                })
                
                $('#editPupilMarks form').show('slide', {direction: 'up'}, 1, function(){
                    $('#editPupilMarks form').animate({
                        opacity: '0'
                    }, function(){
                        $('#editPupilMarks form').animate({
                            opacity: '1'
                        }, 800)
                        $('#editPupilMarks .buttons-div').show('fade')
                    })
                })
			},

			getEPPAverage(subject, marks = this.targetPupilMarks, modality = 5){
				let type = "epe"
				let all = []
				let selectedMarks = []
				let som = 0
				let avg = 0
				if (marks !== null && marks[subject.id] && marks[subject.id]['modality'] !== null) {
					modality = marks[subject.id]['modality']
				}
				if(marks[subject.id] !== undefined){
					for (var i = 0; i < marks[subject.id][type].length; i++) {
						if(marks[subject.id][type][i] !== undefined && marks[subject.id][type][i] !== 0 && marks[subject.id][type][i] !== '0' && marks[subject.id][type][i] !== null){
							all.push(marks[subject.id][type][i].value)
						}
					}
					all = this.getBestMarks(all, modality)
					for (var i = 0; i < all.length; i++) {
						som += all[i]
					}
					if(som !== 0){
						avg = parseFloat(som / all.length).toFixed(2)
						return avg
					}
					else{
						return "-"
					}
					avg = parseFloat(som / all.length).toFixed(2)
					return avg
				}
				else{
					return "-"
				}
			},

			getAverage(subject, marks = this.targetPupilMarks){
				let modality = 5
				if (marks !== null && marks[subject.id] && marks[subject.id]['modality'] !== null) {
					modality = marks[subject.id]['modality']
				}
				return averageComputor(subject, marks, modality)
				
			}, 
			getBestMarks(marks = [], modality = 5)
			{
				let bestMarks = []
				if (marks.length < modality) {
					bestMarks = marks
				}
				else{
					while (bestMarks.length < modality) {
						for (var i = 0; i < marks.length; i++) {
							if(marks[i] == Math.max(...marks)){
								bestMarks.push(marks[i])
								marks.splice(i, 1)
							}
							
						}
					}
				}
				return bestMarks
			},
			getMarkStatus(subject, markIndex)
			{
				let marksTab = this.targetPupilMarks
				let marks = []
				let modality = 5
				let mark = Number(this.getSujectMarks(subject, 'epe', markIndex, marksTab))
				let text = ''

				if (marksTab !== null && marksTab[subject.id] && marksTab[subject.id]['modality'] !== null) {
					modality = marksTab[subject.id]['modality']
				}


				if(marksTab[subject.id] !== undefined){
					
						for (var i = 0; i < marksTab[subject.id]['epe'].length; i++) {
							marks.push(marksTab[subject.id]['epe'][i].value)
						}
					
				}

				let bestMarks = this.getBestMarks(marks, modality)
				
				if (marks !== []) {
					if (marks.length < modality) {
						text = 'text-success'
					}
					
				}
				
				if (bestMarks.indexOf(mark) == -1) {
					text = 'text-warning'
				}
				else if (bestMarks.indexOf(mark) !== -1) {
					text = 'text-success'
				}
				if (mark == '-' || isNaN(mark)) {
					text = ''
				}

				return text
			}
		},

		computed: mapState([
          	'targetPupilLastName', 'targetPupilFirstName', 'targetPupilClasseFMT', 'targetPupilBirthFMT', 'editedPupilSubjects', 'editedPupil', 'targetPupilMarks', 'editedPupilSubjectMarks', 'editedPupilCoefTables', 'targetedClasseSubjectsCoef', 'targetedClasseSubject', 'subjectWithModalities'
        ])

	}
</script>

<style>
	.marks-td tr table tr td{
		width: 15%;
	}

	.dev-marks td{
		width: 50% !important;
	}
	.marks-td tr table tr td.coef{
		width: 10% !important;
	}

	.av tr td{
		width: 50% !important;
	}

	.mark-name{
		width: 25% !important;
	}
	.coef-tag{
		width: 4% !important;
	}

	.trimestre h5{
		font-size: 10px;
		margin: 0px;
		padding: 2;
	}

	.td td, th{
		border-left: solid thin white;
		border-right: solid thin white;
		border-collapse: collapse;
	}
</style>