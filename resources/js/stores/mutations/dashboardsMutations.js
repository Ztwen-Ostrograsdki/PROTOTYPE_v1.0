const dashboards_mutations = {

    GET_HORAIRES: (state, data) =>{
        state.horaires = data
    },

    RESET_NEW_HORAIRE: (state) =>{
        state.newHoraire = {
            start: 7,
            end: state.newHoraire.start + 1,
            classe_id: null,
            subject_id: null,
            level: 'secondary',
            year: (new Date).getFullYear(),
        }
    },
    
    SET_NEW_HORAIRE: (state, data) =>{
        state.newHoraire = data
    }
}

export default dashboards_mutations