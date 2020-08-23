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
                    	<tr class="td border-bottom border-white" v-for="subject in editedPupilSubjects">
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
	                    					<td class="text-center">{{ getSujectMarks(subject, 'epe', 0)}}</td>
	                    					<td class="text-center">{{ getSujectMarks(subject, 'epe', 1)}}</td>
	                    					<td class="text-center">{{ getSujectMarks(subject, 'epe', 2)}}</td>
	                    					<td class="text-center">{{ getSujectMarks(subject, 'epe', 3)}}</td>
	                    					<td class="text-center">{{ getSujectMarks(subject, 'epe', 4)}}</td>
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
	                    				<tr class="w-100 td" v-if="targetPupilMarks !== null">
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

		methods: {
			getSujectMarks(subject, type, id, marks = this.targetPupilMarks){
				if(marks[subject.id] !== undefined){
					if(marks[subject.id][type][id] !== undefined){
						return marks[subject.id][type][id].value > 10 ? marks[subject.id][type][id].value : '0' + marks[subject.id][type][id].value
						
					}
					
					return '-'
				}
				else{
					return "-"
				}
				
			},
			editedPupilClasseAndSubjectMarks(subject){
				this.$store.commit('RESET_TARGETED_PUPIL_SUBJECT_MARKS', subject)
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

			getEPPAverage(subject, marks = this.targetPupilMarks){
				let type = "epe"
				let all = []
				let som = 0
				let avg = 0
				if(marks[subject.id] !== undefined){
					for (var i = 0; i < marks[subject.id][type].length; i++) {
						if(marks[subject.id][type][i] !== undefined && marks[subject.id][type][i] !== 0 && marks[subject.id][type][i] !== '0' && marks[subject.id][type][i] !== null){
							all.push(marks[subject.id][type][i].value)
						}
					}
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
				return averageComputor(subject, marks)
				
			}
		},

		computed: mapState([
          	'targetPupilLastName', 'targetPupilFirstName', 'targetPupilClasseFMT', 'targetPupilBirthFMT', 'editedPupilSubjects', 'editedPupil', 'targetPupilMarks', 'editedPupilSubjectMarks', 'editedPupilCoefTables'
        ])

	}
</script>

<style>
	.marks-td tr table tr td{
		width: 15%;
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