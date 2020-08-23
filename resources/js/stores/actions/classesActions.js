const classes_actions = {
	getClassesData: (store) => {
		axios.get('/admin/director/classesm/DATA&for&classes')
             .then(response => {
             	store.commit('GET_CLASSES_DATA', response.data)
        })
	},
    getAClasseData: (store, id) => {
        axios.get('/admin/director/classesm/get&classe&data&credentials/id=' + id)
            .then(response => {
                store.commit('GET_A_CLASSE_DATA', response.data)
            })
            .catch(e => {
               store.commit('ALERT_MAKER', "L'opération a échoué: Echec de connexion au serveur! Veuillez réessayer!")
            })
    },

}

export default classes_actions
