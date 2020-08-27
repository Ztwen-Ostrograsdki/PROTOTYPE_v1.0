<template>
	<div class="w-100 m-0 p-0">
		<transition name="fade">
			<div class="position-absolute" style="right: 2px; top: 2px; width: 15%; background-image: url(/media/img/art-2578353_1920.jpg) !important; z-index: 300" v-if="userSettings">
				<user-main></user-main>
			</div>
		</transition>
		<transition name="fade">
			<div style="z-index: 20">
				<h5 class="cursive mx-1 text-center border-bottom py-2">Bienvenue au Complexe Scolaire LA PRUNELLE</h5>
				<div class="w-100 px-2 mx-auto d-flex justify-content-between">
					<div class="mr-2">
						<span class="fa fa-chevron-left" @click="prevPage()"></span>
						<span class="fa fa-chevron-left" @click="prevPage()"></span>
					</div>
					<div>
						<span class="fa fa-circle-o" :class="getSlide(0, 10)"></span>
						<span class="fa fa-circle-o" :class="getSlide(10, 20)"></span>
						<span class="fa fa-circle-o" :class="getSlide(20, 34)"></span>
					</div>
					<div class="ml-2">
						<span class="fa fa-chevron-right" @click="nextPage()"></span>
						<span class="fa fa-chevron-right" @click="nextPage()"></span>
					</div>
				</div>
				<div>
					<p>
						<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum eaque minus alias, voluptatem at, ullam tempora perspiciatis? Maxime numquam distinctio molestias. Ipsa blanditiis aliquam omnis, cupiditate sit, ratione totam quisquam.</span>
					</p>
				</div>
				<transition name="justefade" appear>
				<div class="m-1 w-100 opacity-tag" v-if="next == 0">
					<div class="w-100 row mx-auto">
						<div class="col-3">
							<img :src="'/media/prunelle/img' + start + '.jpg'" alt="" width="100%" class="border">
						</div>
						<div class="col-3">
							<img :src="'/media/prunelle/img' + getNext(1) + '.jpg'" alt="" width="100%" class="border">
						</div>
						<div class="col-3">
							<img :src="'/media/prunelle/img' + getNext(2) + '.jpg'" alt="" width="100%" class="border">
						</div>
						<div class="col-3">
							<img :src="'/media/prunelle/img' + getNext(3) + '.jpg'" alt="" width="100%" class="border">
						</div>
					</div>
					<div class="w-100 row mx-auto mt-1">
						<div class="col-3">
							<img :src="'/media/prunelle/img' + getNext(4) + '.jpg'" alt="" width="100%" class="border">
						</div>
						<div class="col-3">
							<img :src="'/media/prunelle/img' + getNext(5) + '.jpg'" alt="" width="100%" class="border">
						</div>
						<div class="col-3">
							<img :src="'/media/prunelle/img' + getNext(6) + '.jpg'" alt="" width="100%" class="border">
						</div>
						<div class="col-3">
							<img :src="'/media/prunelle/img' + getNext(7) + '.jpg'" alt="" width="100%" class="border">
						</div>
					</div>
				</div>
				</transition>
				<transition name="justefade" appear>
					<div class="m-1 w-100 opacity-tag" v-if="next > 0">
						<h5>je suis la page suivante {{ next }}</h5>
					</div>
				</transition>
				<div class="w-25 mx-auto d-flex justify-content-between" v-if="next == 0">
					<div class="mr-2">
						<span class="fa fa-chevron-left" @click="reduce()"></span>
						<span class="fa fa-chevron-left" @click="reduce()"></span>
					</div>
					<div>
						<span class="fa fa-circle-o" :class="getSlide(0, 10)"></span>
						<span class="fa fa-circle-o" :class="getSlide(10, 20)"></span>
						<span class="fa fa-circle-o" :class="getSlide(20, 34)"></span>
					</div>
					<div class="ml-2">
						<span class="fa fa-chevron-right" @click="increase()"></span>
						<span class="fa fa-chevron-right" @click="increase()"></span>
					</div>
				</div>
			</div>
		</transition>
	</div>
</template>


<script>
	import { mapState } from 'vuex'
	export default{

		data(){
			return {
				start: 1,
				next: 0,
			}
		},

		methods: {
			increase(){
				this.start + 8 < 34 ? this.start = this.start + 8 : this.start = 1
			},

			reduce(){
				this.start - 8 > 0 ? this.start = this.start - 8 : this.start = 33
			},
			nextPage(){
				this.next + 1 < 4 ? this.next = this.next + 1 : this.next = 4
			},
			prevPage(){
				this.next - 1 >= 0 ? this.next = this.next - 1 : this.next = 0
			},
			getNext(index){
				if(this.start + index < 34){
					return this.start + index
				}
				else{
					return 1
				}
			},
			getSlide(min, max){
				return (this.start < max && this.start > min) ? 'text-primary' : ''
			}

		},

		created(){
			axios.post('/admin/director/master/getCurrentUser&auth')
			.then(response => {
				if (response.data) {
					this.$store.dispatch('getCounter')
            		this.$store.dispatch('getTOOLS')
				}
				
			}) 
            
            
        },
		computed: mapState([
            'user', 'admin', 'errors', 'userSettings', 'logout', 'users', 'loginNotif'
        ])

	}
</script>

<style>
	.opacity-tag img{
		opacity: 0.8;
	}
	.opacity-tag div div img:hover{
		opacity: 1;
	}
</style>