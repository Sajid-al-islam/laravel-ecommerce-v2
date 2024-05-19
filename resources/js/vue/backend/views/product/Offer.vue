<template>
    <div class="container">
        <div class="card list_card">
            <div class="card-header">
                <h4>Set Offer</h4>
                <div class="btns">
                    <router-link :to="{ name: `All${route_prefix}` }" class="btn rounded-pill btn-outline-warning" >
                        <i class="fa fa-arrow-left me-5px"></i>
                        Back
                    </router-link>
                </div>
            </div>
            <form @submit.prevent="set_offer" autocomplete="false" class="product_stock_create_form">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="admin_form form_1">
                                <div class=" form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                    <div>
                                        <label class="mb-2 text-capitalize">
                                            Select product
                                        </label>
                                        <ProductStockManagementModal :qty="1"/>
                                    </div>
                                </div>
                                <template v-if="product.length">
                                    <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                        <label for="">
                                            Product Price
                                            <div>
                                                {{ product[0]?.sales_price }}
                                            </div>
                                        </label>
                                    </div>

                                    <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                        <label for="">
                                            Discount Percent
                                            <div>
                                                <input type="number" @keyup="set_flat_amount" v-model="discount_percent" class="form-control" name="discount_percent">
                                            </div>
                                        </label>
                                    </div>

                                    <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                        <label for="">
                                            Flat Amount
                                            <div>
                                                <input v-model="flat_amount" @keyup="set_discount" type="number" class="form-control" name="discount_amount">
                                            </div>
                                        </label>
                                    </div>

                                    <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                        <input-field
                                            :label="`Discount Last Date`"
                                            :name="`discount_last_date`"
                                            :type="`date`"
                                        />
                                    </div>
                                </template>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-outline-info" >
                        <i class="fa fa-upload"></i>
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import InputField from '../components/InputField.vue'
/** store and route prefix for export object use */
import PageSetup from './PageSetup';
import ProductStockManagementModal from "../product/components/ManagementModal.vue"
import SupplierManagementModal from "../Supplier/components/ManagementModal.vue"
const {route_prefix, store_prefix} = PageSetup;

export default {
    components: { InputField, ProductStockManagementModal, SupplierManagementModal },
    data: function(){
        return {
            /** store prefix for JSX */
            store_prefix,
            route_prefix,
            discount_percent: 0,
            flat_amount: 0,
        }
    },
    created: function () {
    },
    methods: {
        ...mapActions([
            `store_${store_prefix}`,
        ]),
        call_store: function(name, params=null){
            this[name](params)
        },
        set_discount: function(){
            this.discount_percent = Math.ceil(100 * this.flat_amount / this.product[0].sales_price);
        },
        set_flat_amount: function(){
            // this.flat_amount = this.product[0].sales_price - Math.ceil(this.product[0].sales_price * this.discount_percent / 100);
            this.flat_amount = Math.ceil(this.product[0].sales_price * this.discount_percent / 100);
        },
        set_offer: function(){
            let data = new FormData(event.target);
            data.append('product_id',this.product[0].id);
            data.append('main_price',this.product[0].sales_price);
            axios.post('/product/set-offer',data)
                .then(res=>{
                    // console.log(res.data);
                    window.s_alert('offer created');

                })
        }
    },

    computed: {
        // mapping the getters
        ...mapGetters([
            'get_customer_phone_no',
        ]),
        ...mapGetters({
            product: 'get_product_selected',
        })

    },
};
</script>

