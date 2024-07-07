<template>
    <div class="container">
        <div class="card list_card">
            <div class="card-header no_print">
                <h4>Details</h4>
                <div class="btns">
                    <a href="" @click.prevent="$router.push({ name: 'EmailOrder', params:{id: $route.params.id} })"  class="btn rounded-pill btn-outline-success me-2">

                        <i class="fa fa-envelope me-5px"></i>
                        <span >
                            Email invoice
                        </span>
                    </a>

                    <a href="" @click.prevent="call_store(`print_${store_prefix}_details`, null)"  class="btn rounded-pill btn-outline-success me-2">

                        <i class="fa fa-print me-5px"></i>
                        <span >
                            Print
                        </span>
                    </a>

                    <a href="" @click.prevent="call_store(`set_${store_prefix}`,null), $router.push({ name: 'AllOrder' })"  class="btn rounded-pill btn-outline-warning" >
                        <i class="fa fa-arrow-left me-5px"></i>
                        <span >
                            Back
                        </span>
                    </a>


                </div>
            </div>
            <div class="card-body pb-5" v-if="this[`get_${store_prefix}`]" id="print_section">
                <div class="row justify-content-center">
                    <form class="status_change_form" action="javascript:void(0)" @submit.prevent="call_store(`set_${store_prefix}_status_update`, null)">
                        <div class="col-lg-12">
                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    <h5 class="mb-3">From:</h5>
                                    <h3 class="text-dark mb-1">{{ get_company_info.company_name }}</h3>
                                    <!-- <div>{{ get_company_info.address[0].building }}, </div> -->
                                    <!-- <div>{{ get_company_info.address[0].shop }}, </div> -->
                                    <div>{{ get_company_info.address[0].area }}, {{ get_company_info.address[0].division }}</div>
                                    <div>Email: {{ get_company_info.email }}</div>
                                    <div>Phone: {{ get_company_info.mobile_no[0] }}</div>
                                </div>
                                <div class="col-sm-6 text-end" v-if="this[`get_${store_prefix}`]">
                                    <h5 class="mb-3">To:</h5>
                                    <h3 class="text-dark mb-1">
                                        {{ this[`get_${store_prefix}`].order_address?.first_name }}
                                        {{ this[`get_${store_prefix}`].order_address?.last_name }}
                                    </h3>
                                    <!-- <div>
                                        <div v-html="full_address"></div>
                                    </div> -->
                                    <div>
                                        {{ this[`get_${store_prefix}`].order_address?.address }}
                                    </div>
                                    <div>Email: {{ this[`get_${store_prefix}`].order_address?.email }}</div>
                                    <div>Phone: {{ this[`get_${store_prefix}`].order_address?.mobile_number }}</div>
                                </div>
                            </div>
                            <div class="table-responsive-sm" v-if="this[`get_${store_prefix}`]">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th>Item</th>
                                            <th class="center">Variant</th>
                                            <th class="right">Price</th>
                                            <th class="center">Qty</th>
                                            <th class="right text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <span v-if="this[`get_${store_prefix}`]">
                                            {{ this[`get_${store_prefix}`].order_details }}
                                        </span> -->

                                        <tr v-for="(order_detail, index) in this[`get_${store_prefix}`].order_details" :key="index" class="single_row_table">

                                            <td class="center">{{ index+1 }}</td>
                                            <td class="left strong">
                                                <img style="height: 50px;margin-bottom: 10px;" :src="`${order_detail.product.related_images[0].image_link}`" alt="">
                                                {{ order_detail.product.product_name }}
                                            </td>
                                            <td class="center text-uppercase">{{ order_detail?.variant?.title }}</td>
                                            <td class="right">{{ order_detail.product_price }}</td>
                                            <td class="center">{{ order_detail.qty }}</td>
                                            <td class="right text-end">{{ order_detail.product_price * order_detail.qty }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-end" colspan="5">
                                                Subtotal:
                                            </td>
                                            <td class="text-end">
                                                <span class="printable_span">{{ this[`get_${store_prefix}`].sub_total }}</span>
                                                <input type="text" name="subtotal" class="form-control no_print" :value="+this[`get_${store_prefix}`].sub_total">
                                                <!-- {{ +this[`get_${store_prefix}`].sub_total + +this[`get_${store_prefix}`].delivery_cost }} -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-end" colspan="5">
                                                Delivery Charge:
                                            </td>
                                            <td class="text-end">
                                                <span class="printable_span">{{ this[`get_${store_prefix}`].delivery_cost }}</span>
                                                <input type="text" name="delivery_cost" class="form-control no_print" :value="this[`get_${store_prefix}`].delivery_cost">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-end" colspan="5">
                                                Discount:
                                            </td>
                                            <td class="text-end">
                                                <span class="printable_span">{{ this[`get_${store_prefix}`].coupon_discount }}</span>
                                                <input type="text" name="total_discount" class="form-control no_print" :value="this[`get_${store_prefix}`].total_discount">
                                                <!-- {{ this[`get_${store_prefix}`].total_discount }} -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-end" colspan="5">
                                                Total Price:
                                            </td>
                                            <td class="text-end">
                                                <span class="printable_span">{{ this[`get_${store_prefix}`].total_price }}</span>
                                                <input type="text" name="total_price" class="form-control no_print" :value="this[`get_${store_prefix}`].total_price">
                                                <!-- {{ this[`get_${store_prefix}`].total_price }} -->
                                            </td>
                                        </tr>
                                        <!-- <button class="btn btn-primary">Update</button> -->
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="seo_section full_width mt-5 pt-5 no_print">
                            <hr>
                            <!-- <div v-if="this[`get_${store_prefix}`]">
                                <h5>Courrier info</h5>
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>consignment id</th>
                                            <td style="width: 2px;padding: 0px 10px;">:</td>
                                            <td>{{ order?.stead_fast?.consignment_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>invoice</th>
                                            <td >:</td>
                                            <td>{{ order?.stead_fast?.invoice }}</td>
                                        </tr>
                                        <tr>
                                            <th>recipient address</th>
                                            <td >:</td>
                                            <td>{{ order?.stead_fast?.recipient_address }}</td>
                                        </tr>
                                        <tr>
                                            <th>recipient name</th>
                                            <td >:</td>
                                            <td>{{ order?.stead_fast?.recipient_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>recipient phone</th>
                                            <td >:</td>
                                            <td>{{ order?.stead_fast?.recipient_phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>status</th>
                                            <td >:</td>
                                            <td>{{ order?.stead_fast?.status }}</td>
                                        </tr>
                                        <tr>
                                            <th>tracking code</th>
                                            <td >:</td>
                                            <td>{{ order?.stead_fast?.tracking_code }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> -->
                            <div class="heading mb-4">
                                <h4 class="d-flex justify-content-center">Order action</h4>
                                <h6 class="d-flex justify-content-center">change order status.</h6>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-4 mx-auto">

                                        <div class="mb-2">
                                            <label for="order_status_change" class="form-label">Change Status</label>

                                            <select :value="this[`get_${store_prefix}`].order_status" id="order_status_change" v-model="this[`get_${store_prefix}`].order_status" class="form-select" name="order_status">
                                                <option value="Pending">Pending</option>
                                                <option value="Accepted">Accepted</option>
                                                <option value="Processing">Processing</option>
                                                <option value="Delivered">Delivered</option>
                                                <option value="Canceled">Canceled</option>
                                            </select>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-primary">Update</button>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- <div class="card-footer text-center">
            </div> -->
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex'
import PermissionButton from '../components/PermissionButton.vue'
/** store and route prefix for export object use */
import PageSetup from './PageSetup';
const {route_prefix, store_prefix} = PageSetup;

export default {
    components: { PermissionButton },
    data: function(){
        return {
            /** store prefix for JSX */
            store_prefix,
            route_prefix,
        }
    },
    created: function () {
        this[`fetch_${store_prefix}`]({id: this.$route.params.id, select_all:1})

        // setTimeout(() => {
        //     document.querySelector("section").style.background = "transparent"
        //     // if(this[`get_${store_prefix}`].description.includes("bg-white")) {
        //     //     document.querySelector("section").style.background-color = "transparent";
        //     // }
        // }, 1000);

    },
    methods: {
        ...mapActions([
            `fetch_${store_prefix}`,
            `set_${store_prefix}_status_update`,
            `print_${store_prefix}_details`,
            `email_${store_prefix}_invoice`
        ]),
        ...mapMutations([
            `set_${store_prefix}`
        ]),
        call_store: function(name, params=null){
            // import action before using call store() function
            this[name](params)
        },
    },
    computed: {
        ...mapGetters(
            [
                `get_${store_prefix}`,
                'get_company_info'
            ]
        ),
        ...mapGetters(
            {
                order: `get_${store_prefix}`,
            }
        ),

        // full_address: function(){
        //     return this[`get_${store_prefix}`].order_address?.city.replaceAll(',','<br>');
        // }
    }
}
</script>
