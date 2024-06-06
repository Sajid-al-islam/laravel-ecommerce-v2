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

    [`fetch_${store_prefix}`]: async function ({ state, commit }, { id }) {
        let url = `/${api_prefix}/${id}`;
        await axios.get(url).then((res) => {
            this.commit(`set_${store_prefix}`, res.data);

            var images=[];
            for (let i = 0; i < 3; i++) {
                let img_name = `image_${i}`;
                let el = res.data[img_name];
                if (el) {
                    images.push(`
                        <img src="/${el}" alt="Image ${i}"/>
                        <span onclick="remove_product_image(event, ${i})" class="text-danger cursor-pointer">remove</span>
                    `);
                }
            }
            setTimeout(() => {
                var file_previews = document.querySelectorAll('.file_preview');
                [...file_previews].forEach((i,index)=>{
                    i.innerHTML = images[index] || ''
                })
            }, 1000);

            res.data.landing_products?.forEach((i) => {
                // console.log(i);
                commit(`set_selected_products`, i.product);
            })

            // commit(`set_selected_brands`, res.data.brand);
        });
    },

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

    [`update_${store_prefix}`]: function({state, getters, commit}, event){
        const {form_values, form_inputs, form_data} = window.get_form_data(`.landing_update_form`);
        // console.log(form_data, form_inputs, form_values);
        console.log(getters);
        const {get_product_selected: product} = getters;
        let faqs = JSON.stringify(event.faqs);
        product.forEach((i)=> {
            form_data.append('product_ids[]',i.id);
        });
        // form_data.append('product_id',product[0].id);
        form_data.append('faqs',faqs);
        form_data.append("id", state[store_prefix].id);

        axios.post(`/${api_prefix}/update`,form_data)
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

    [`soft_delete_${store_prefix}`]: async function (
        { state, getters, dispatch },
        id
    ) {
        let cconfirm = await window.s_confirm("Delete");
        if (cconfirm) {
            await axios
                .post(`/${api_prefix}/destroy`, { id })
                .then(({ data }) => {
                    dispatch(`fetch_${store_prefix}s`);
                    window.s_alert(
                        `${store_prefix} has been deleted`
                    );
                });
        }
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
