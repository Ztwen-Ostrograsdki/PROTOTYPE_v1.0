require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import store from './stores/store.js'
Vue.use(VueRouter)
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//ERRORS COMPONENTS
let error404 = Vue.component('error404', require('./components/errors/Errors404Component.vue').default)
let error419 = Vue.component('error419', require('./components/errors/Errors419Component.vue').default)


//ADMINS COMPONENTS
let admin_sidebar = Vue.component('admin-sidebar', require('./components/admin/SidebarComponent.vue').default)
let admin_menu = Vue.component('admin-menu', require('./components/admin/AsideMenuComponent.vue').default)
let admin_defaultDashboard = Vue.component('admin-dashboard-default', require('./components/admin/HomeDashboardComponent.vue').default)

//PUPILS COMPONENTS
let pdf = Vue.component('pdf', require('./components/pupils/ExampleComponent.vue').default)
let pupils_home = Vue.component('pupils-home', require('./components/pupils/HomeComponent.vue').default)
let listing_pupils_component = Vue.component('listing-pupils', require('./components/admin/layouts/ListingPupilsComponent.vue').default)
let listing_pupils = Vue.component('listing-component-pupils', require('./components/pupils/ListingComponent.vue').default)
let pupils_redList = Vue.component('pupils-redList', require('./components/pupils/RedListComponent.vue').default)

let pupils_profil = Vue.component('profil-component-pupils', require('./components/pupils/ProfilComponent.vue').default)
let pupils_profil_main = Vue.component('pupil-profil-main', require('./components/pupils/ProfilLayouts/MainProfilComponent.vue').default)
let pupils_perso_data = Vue.component('pupil-perso-data', require('./components/pupils/ProfilLayouts/PersonalBoxComponent.vue').default)
let pupils_parents_data = Vue.component('pupil-parents-data', require('./components/pupils/ProfilLayouts/ParentalBoxComponent.vue').default)
let pupils_marks_data = Vue.component('pupil-marks-data', require('./components/pupils/ProfilLayouts/MarksBoxComponent.vue').default)
let pupils_profil_box = Vue.component('profil-pupil-box', require('./components/pupils/ProfilLayouts/HomeProfilComponent.vue').default)
		//PUPILS MARKS
let pupils_marks_home = Vue.component('marks-home', require('./components/pupils/marks/HomeComponent.vue').default)
let pupils_marks_table = Vue.component('marks-table', require('./components/pupils/marks/layouts/MarksTableComponent.vue').default)
let pupils_marks_trimestre = Vue.component('trimestre', require('./components/pupils/marks/layouts/TrimestreTableComponent.vue').default)
let pupils_marks_general = Vue.component('trimestre-general', require('./components/pupils/marks/layouts/TrimestreGeneralTableComponent.vue').default)
let bulletin = Vue.component('bulletin', require('./components/admin/layouts/BulletinComponent.vue').default)

//CLASSES
let classes_home = Vue.component('classes-home', require('./components/classes/HomeComponent.vue').default)
let listing_classes = Vue.component('listing-component-classes', require('./components/classes/ListingComponent.vue').default)
let classe_marks = Vue.component('classe-marks', require('./components/classes/layouts/MarksComponent.vue').default)
let classe_profil = Vue.component('profil-classe', require('./components/classes/ProfilComponent.vue').default)
let classe_listing = Vue.component('listing-classe', require('./components/classes/layouts/ListingForAClasseComponent.vue').default)
let listing_classes_component = Vue.component('listing-classes', require('./components/admin/layouts/ListingClassesComponent.vue').default)
let confirm_refresh_class = Vue.component('classe-refresh', require('./components/classes/confirmations/ConfirmRefreshClassComponent.vue').default)
let classes_redList = Vue.component('classes-redList', require('./components/classes/RedListComponent.vue').default)


//HOMES
let home = Vue.component('home-public', require('./components/home/HomeComponent.vue').default)
let homeNav = Vue.component('home-nav', require('./components/home/NavigationComponent.vue').default)
let homeFooter = Vue.component('home-footer', require('./components/home/FooterComponent.vue').default)
let userMain = Vue.component('user-main', require('./components/home/UserMainComponent.vue').default)
let home_container = Vue.component('home-container', require('./components/home/HomeContainerComponent.vue').default)

//Connexions
let login = Vue.component('login', require('./components/connexions/LoginComponent.vue').default)

//FORMULARS COMPONENTS

let pupils_add = Vue.component('pupil-add', require('./components/formulars/pupils/AddNewComponent.vue').default)
let pupils_perso_edit = Vue.component('pupil-perso', require('./components/formulars/pupils/EditPersonalComponent.vue').default)
let pupils_edit_marks = Vue.component('pupil-edit-marks', require('./components/formulars/pupils/EditMarkComponent.vue').default)
let pupils_edit_parents = Vue.component('pupil-edit-parents', require('./components/formulars/pupils/EditParentComponent.vue').default)
let pupils_deleting = Vue.component('pupil-delete-confirmation', require('./components/pupils/confirmations/ConfirmDeletingPupilComponent.vue').default)

let teachers_add = Vue.component('teacher-add', require('./components/formulars/teachers/AddNewComponent.vue').default)
let teachers_perso_edit = Vue.component('teacher-perso', require('./components/formulars/teachers/EditPersonalComponent.vue').default)
let teachers_classes_edit = Vue.component('teacher-classes', require('./components/formulars/teachers/EditClassesComponent.vue').default)

let parents_add = Vue.component('parent-add', require('./components/formulars/parents/AddNewComponent.vue').default)
let parents_edit = Vue.component('edit-parents', require('./components/formulars/parents/EditComponent.vue').default)
let classes_add = Vue.component('classe-add', require('./components/formulars/classes/AddNewComponent.vue').default)
let classes_edit = Vue.component('classe-edit', require('./components/formulars/classes/EditComponent.vue').default)


let default_success = Vue.component('default-success', require('./components/success/SuccessComponent.vue').default)
let add_new_horaire = Vue.component('new-horaire', require('./components/formulars/dashboards/NewHoraireComponent.vue').default)


//TEACHERS COMPONENTS
let teachers_home = Vue.component('teachers-home', require('./components/teachers/HomeComponent.vue').default)
let listing_teachers = Vue.component('listing-component-teachers', require('./components/teachers/ListingComponent.vue').default)
let teachers_redList = Vue.component('teachers-redList', require('./components/teachers/RedListComponent.vue').default)

let teachers_profil = Vue.component('profil-component-teachers', require('./components/teachers/ProfilComponent.vue').default)
let teachers_profil_main = Vue.component('teacher-profil-main', require('./components/teachers/ProfilLayouts/MainProfilComponent.vue').default)
let teachers_perso_data = Vue.component('teacher-perso-data', require('./components/teachers/ProfilLayouts/PersonalBoxComponent.vue').default)
let teachers_profil_box = Vue.component('profil-teacher-box', require('./components/teachers/ProfilLayouts/ProfilBoxComponent.vue').default)
let teachers_classes_box = Vue.component('profil-teacher-classes-box', require('./components/teachers/ProfilLayouts/TeacherClassesBoxComponent.vue').default)

//PARENTS
let parents_home = Vue.component('parents-home', require('./components/parents/HomeComponent.vue').default)
let listing_parents = Vue.component('listing-component-parents', require('./components/parents/ListingComponent.vue').default)
let parents_redList = Vue.component('parents-redList', require('./components/parents/RedListComponent.vue').default)

//DASHBOARDS COMPONENENTS
let dashboard_plan = Vue.component('dashboard-plan', require('./components/admin/layouts/dashboards/PlansComponent.vue').default)


const routes = [
	
	{
		path: '/admin/director/master',
		component: admin_defaultDashboard,
		name: 'adminHome'
	},
	{
		path: '/admin/director/master/dashboards/emplois-du-temps',
		component: dashboard_plan,
		name: 'dashboard_plan',
	},

	{
		path: '/admin/director/pupilsm',
		component: pupils_home,
		name: 'pupilsIndex',
		children: [
			{
				path: '/admin/director/pupilsm',
				component: listing_pupils,
				name: 'pupilsListing',
			},
			{
				path: '/admin/director/pupilsm/redList',
				component: pupils_redList,
				name: 'pupilsRedList'

			},
			{
				path: '/admin/director/pupilsm/:id',
				component: pupils_profil,
				name: 'pupilsProfil',
				store
				
			},
			{
				path: '/admin/director/pupilsm/:id/marks/index/trimestre/:trimestre',
				component: pupils_marks_home,
				name: 'pupilsMarks',
				store,
			},
			{
				path: '/admin/director/pupilsm/:id/bulletin&trimestrielle&eleve/index/trimestre/:trimestre',
				component: bulletin,
				name: 'bulletin',
				store,
			},
			{
				path: '/admin/director/docPDF/getApath',
				component: pdf,
				name: 'pdf',
				store

			}
			
		]
	},
	{
		path: '/admin/director/parentsm',
		component: parents_home,
		name: 'parentsIndex',
		children: [
			{
				path: '/admin/director/parentsm',
				component: listing_parents,
				name: 'parentsListing',
			},
		]
	},
	{
		path: '/admin/director/teachersm',
		component: teachers_home,
		name: 'teachersIndex',
		children: [
			{
				path: '/admin/director/teachersm',
				component: listing_teachers,
				name: 'teachersListing',
			},
			{
				path: '/admin/director/teachersm/redList',
				component: teachers_redList,
				name: 'teachersRedList'

			},
			{
				path: '/admin/director/teachersm/:id',
				component: teachers_profil,
				name: 'teachersProfil',
				store

			}
			
		]
	},
	{
		path: '/admin/director/classesm',
		component: classes_home,
		name: 'classesIndex',
		children: [
			{
				path: '/admin/director/classesm',
				component: listing_classes,
				name: 'classesListing',
			},
			{
				path: '/admin/director/classesm/redList',
				component: classes_redList,
				name: 'classesRedList'

			},
			{
				path: '/admin/director/classesm/:id',
				component: classe_profil,
				name: 'classesProfil',
				store
			},
			{
				path: '/admin/director/classesm/:id/marks/index',
				component: classe_marks,
				name: 'classeMarks',
				store
			},
			{
				path: '/admin/director/classesm/:id/marks/index/subject/:s/trimestre/:t',
				component: classe_marks,
				name: 'classeSubjectMarks',
				store
			}
		]
	}
]

const router = new VueRouter({mode: 'history', routes})
new Vue({
	store,
	router: router,
	el: ".app",
	components: {
		admin_sidebar,
		error404,
		error419,
	}
})




window._ = require('lodash');
window.Popper = require('popper.js').default;
try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {}