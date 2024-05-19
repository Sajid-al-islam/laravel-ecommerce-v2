import axios from "axios";
import StoreModule from "./schema/StoreModule";

let test_module = new StoreModule('variant','product-variant','Variant');
const {store_prefix, api_prefix, route_prefix} = test_module;

// state list
const state = {
    ...test_module.states(),
    all_variant_json: [],
};

// get state
const getters = {
    ...test_module.getters(),
    get_all_variant_json: (state)=>state.all_variant_json,
};

// actions

const actions = {
    ...test_module.actions(),

    fetch_all_variant_json: async ({commit,dispatch,getters,rootGetters,rootState,state}) => {
        let data = await axios.get(`/product-variant/all-json`);
        state.all_variant_json = data.data;
    },

    variant_update_title: async ({commit,dispatch,getters,rootGetters,rootState,state},id) => {
        let form = document.createElement('form');
        let form_data = new FormData(form);
        if(event){
            let target = event.target.cloneNode(true);
            form.appendChild(target);
            form_data = new FormData(form);
            form_data.append('title',target.value);
            form_data.append('id',id);
        }
        let data = await axios.post(`/product-variant/update-title`,form_data);
        await dispatch('fetch_all_variant_json')
        window.s_alert(`value updated.`);
        // console.log(data);
    },

    variant_update_default_checked: async ({commit,dispatch,getters,rootGetters,rootState,state},id) => {
        let data = await axios.post(`/product-variant/update-default-checked`,{id});
        await dispatch('fetch_all_variant_json')
        window.s_alert(`value updated.`);
        // console.log(data);
    },

    variant_delete_value: async ({commit,dispatch,getters,rootGetters,rootState,state},{id,variant}) => {
        let confirm = await window.s_confirm("Remove value");
        if(confirm){
            await axios.post(`/product-variant/delete-value`,{id});
            await dispatch('fetch_all_variant_json')
            window.s_alert(`value deleted.`);
        }
    },

    variant_add_new: async ({commit,dispatch,getters,rootGetters,rootState,state},product_variant_id) => {
        let data = await axios.post(`/product-variant/add-new`,{product_variant_id});
        await dispatch('fetch_all_variant_json')
        // window.s_alert(`value inserted.`);
        // console.log(data.data);
        // return data.data;
    },
}

// mutators
// console.log(test_module.mutations());
const mutations = {
    ...test_module.mutations(),

};


export default {
    state,
    getters,
    actions,
    mutations,
};
