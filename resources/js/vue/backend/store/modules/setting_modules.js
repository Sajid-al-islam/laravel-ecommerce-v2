import axios from 'axios';

// state list
const state = {
    settings: {},
}

// get state
const getters = {
    get_settings: state => state.settings,
}

// actions
const actions = {
    fetch_setting: async function ({state, commit}) {
        axios.get('/settings/get')
            .then((res) => {
                commit('set_settings',res.data);
            })
            .catch((err)=>{
                console.log(err);
            })
    },
    update_setting: async function ({state, commit}, {event, single_data}) {
        let form = document.createElement('form');
        let form_data = new FormData(form);
        if(event){
            let target = event.target.cloneNode(true);
            form.appendChild(target);
            form_data = new FormData(form);
            form_data.append('key',target.name);
        }
        if(single_data){
            let input = document.createElement('input');
            input.name = single_data.key;
            input.value = single_data[single_data.key];
            form.appendChild(input);
            form_data = new FormData(form);
            form_data.append('key',input.name);
        }

        axios.post('/settings/update',form_data)
            .then((res) => {
                commit('set_settings',res.data);
                window.s_alert(`${name} setting value updated.`);
            })
            .catch((err)=>{
                console.log(err);
            })
    },

}

// mutators
const mutations = {
    set_settings: function (state, settings) {
        state.settings = settings;
    },
}

export default {
    state,
    getters,
    actions,
    mutations
}
