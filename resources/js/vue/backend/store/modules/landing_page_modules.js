import axios from "axios";
import StoreModule from "./schema/StoreModule";

let test_module = new StoreModule('landing_page','landing-page','LandingPage');
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

    [`store_${store_prefix}`]: function({state, getters, commit}, event){
        const {form_values, form_inputs, form_data} = window.get_form_data(`.landing_create_form`);
        // console.log(form_data, form_inputs, form_values);
        console.log(getters);
        const {get_product_selected: product} = getters;
        let faqs = JSON.stringify(event.faqs);
        product.forEach((i)=> {
            form_data.append('product_ids[]',i.id);
        });
        // form_data.append('product_id',product[0].id);
        form_data.append('faqs',faqs);

        axios.post(`/${api_prefix}/store`,form_data)
            .then(res=>{
                if(res.data.type == 'warning') {
                    window.s_alert(res.data.message, `warning`);
                }else {
                    window.s_alert(`new ${store_prefix} has been created`);
                    $(`${store_prefix}_create_form input`).val('');
                    commit(`set_clear_selected_products`,false);
                    management_router.push({name:`All${route_prefix}`})
                }
            })
            .catch(error=>{
                console.log(error);
            })

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
