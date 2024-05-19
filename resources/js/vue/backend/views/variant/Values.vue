<template>
    <div class="container">
        <div class="setting_management" v-if="get_all_variant_json.length">
            <div class="navs">
                <ul>
                    <li v-for="(variant, index) in get_all_variant_json" :key="variant.id"> 
                        <a href="#/" @click.prevent="set_value(index)" :class="{active: index==0, set_nav:1,}">
                            <i class="far fa-circle"></i> 
                            <div>
                                {{ variant.title }}
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="setting_body custom_scroll">
                <div class="s_setting">
                    <ol v-if="values.length">
                        <li v-for="(value,index) in values" :key="value.id" class="mb-2 d-flex gap-2">
                            <div style="width: 260px;" class="d-flex gap-2 align-items-center">
                                <input type="checkbox" 
                                    :checked="value.default_checked"
                                    @change="variant_update_default_checked(value.id)"
                                    class="form-check-input">
                                <input type="text" 
                                    :value="value.title" 
                                    @change="variant_update_title(value.id)"
                                    :name="`title`"
                                    class="form-control" >
                            </div>
                            
                            <button @click="delete_value({id:value.id,variant:value.product_variant_id,index })" class="btn btn-sm btn-outline-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                            <button @click="add_new(value.product_variant_id)" class="btn btn-sm btn-outline-info" v-if="index == values.length-1">
                                <i class="fa fa-plus"></i>
                            </button>
                        </li>
                    </ol>
                    <ul v-else>
                        <li>
                            <div>
                                No value in variant, create new
                            </div>
                            <button @click="add_new(selected_variant.id)" class="btn btn-sm btn-outline-info">
                                <i class="fa fa-plus"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import InputField from '../components/InputField.vue'
/** store and route prefix for export object use */
import PageSetup from './PageSetup';
const {route_prefix, store_prefix} = PageSetup;

export default {
    components: { InputField },
    data: function(){
        return {
            /** store prefix for JSX */
            store_prefix,
            route_prefix,

            values: [],
            selected_variant: {},
            selected_variant_index: 0,
        }
    },
    created: async function () {
        await this.fetch_all_variant_json();
        if(this.get_all_variant_json.length){
            this.set_value(0);
        }
    },
    watch: {
        get_all_variant_json: {
            handler: function(v){
                let index = this.selected_variant.id?this.selected_variant_index: 0;
                this.values = v[index].values;
            },
        }
    },
    methods: {
        ...mapActions([`store_${store_prefix}`]),
        ...mapActions([
            `fetch_all_variant_json`,
            `variant_update_title`,
            `variant_update_default_checked`,
            `variant_add_new`,
            `variant_delete_value`,
        ]),
        call_store: function(name, params=null){
            this[name](params)
        },
        set_value: function(variant_index){
            this.selected_variant_index = variant_index
            this.selected_variant = this.get_all_variant_json[variant_index];
            this.values = this.selected_variant.values;

            if(event.type == 'click'){
                [...document.querySelectorAll('.navs .set_nav')].forEach(e=>e.classList.remove('active'));
                event.currentTarget.classList.add('active');
            }
        },
        add_new: async function(product_variant_id){
            let that = this;
            let data = await that.variant_add_new(product_variant_id);
            // that.values.push({...data});
        },
        delete_value: async function({id, variant, index}){
            let that = this;
            await that.variant_delete_value({id, variant});
        }
    },
    computed: {
        ...mapGetters([
            'get_all_variant_json'
        ])
    }
};
</script>

<style>
</style>
