<template>
	<div class="100" v-if="user !== {}">
		<div class="w-100 border userMain">
            <a class="w-100 my-1 hover link-float" href="#" style="border-radius: 30px;">
                <i class="fas fa-user fa-sm fa-fw mr-2"></i>
              Profile <span class="fa fa-circle text-success float-right mt-2" style="font-size: 10px"></span>
            </a>
            <a class="w-100 my-1 hover link-float" href="/admin/director/master" style="border-radius: 30px;" v-if="admin">
                <i class="fas fa-cogs fa-sm fa-fw mr-2"></i>
              Administation
            </a>
                <a class="w-100 my-1 hover link-float" id="adminBecomeTeacherLink" href="#" style="border-radius: 30px;"  v-if="admin">
                    <i class="fas fa-user fa-sm fa-fw mr-2"></i>
                  Enseigner
                </a>
            <a class="w-100 my-1 hover link-float" id="makeUserLink" href="#" style="border-radius: 30px;"  v-if="admin">
                <i class="fas fa-registered fa-sm fa-fw mr-2"></i>
              Créer un utilisateur
            </a>
            <a class="w-100 py-1 hover link-float" href="#">
                 <i class="fas fa-list fa-sm fa-fw mr-2"></i>
              Activity Log
            </a>
            <a class="w-100 py-1 pb-2 hover border-top link-float" href="#" @click="disconnect()">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
              Logout
            </a>
            
        </div>
	</div>
</template>

<script>
	import { mapState } from 'vuex'
	export default{

		created(){
            
            
        },

        methods: {
        	disconnect(){
        		this.$store.dispatch('logout')
        	}
        },
		computed: mapState([
            'user', 'admin', 'errors', 'userSettings'
        ])

	}
</script>

<style>
	.userMain a{
		padding-top: 2px;
		padding-bottom: 2px;
	}
	.userMain a:hover{
		background-color: cyan;
		color: black;
	}
</style>