<template>
    <div class="canvas_backdrop" :class="{active:this[`get_${store_prefix}`]}" @click="$event.target.classList.contains('canvas_backdrop') && call_store(`set_${store_prefix}`,null)">
        <div class="content right" v-if="this[`get_${store_prefix}`]">
            <div class="content_header">
                <div>
                    <h3 class="offcanvas-title">Details</h3>
                    <router-link
                        :to="{name:`Details${route_prefix}`,params:{id:this[`get_${store_prefix}`].id}}"
                        class="btn btn-sm btn-warning">
                        Details
                    </router-link>
                </div>
                <i @click="call_store(`set_${store_prefix}`,null)" class="fa fa-times"></i>
            </div>
            <div class="cotent_body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Id</td>
                            <td>:</td>
                            <td>{{ this[`get_${store_prefix}`].id }}</td>
                        </tr>
                        <tr>
                            <td>Invoice no</td>
                            <td>:</td>
                            <td>{{ this[`get_${store_prefix}`].invoice_id }}</td>
                        </tr>
                        <tr>
                            <td>Order Status</td>
                            <td>:</td>
                            <td>{{ this[`get_${store_prefix}`].order_status }}</td>
                        </tr>
                        <tr>
                            <td>Order Total</td>
                            <td>:</td>
                            <td>{{ this[`get_${store_prefix}`].total_price }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"> <b>Products</b> </td>
                        </tr>
                        <tr v-for="product in this[`get_${store_prefix}`].products" :key="product.id">
                            <td>
                                <span v-if="product.related_images.length">
                                    <img :src="product.related_images[0].image_link" alt="" style="height: 60px;">
                                </span>
                            </td>
                            <td>:</td>
                            <td>{{ product.product_name }}</td>
                        </tr>

                        <tr>
                            <td colspan="3"> <b>Courier Info</b> </td>
                        </tr>
                        <tr v-for="(courier, key) in this[`get_${store_prefix}`].stead_fast" :key="key">
                            <td>{{ key }}</td>
                            <td>:</td>
                            <td>
                                <span :class="{'badge bg-info': key=='status'}">
                                    {{ courier }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>
                                <span v-if="this[`get_${store_prefix}`].status == 1" class="badge bg-label-success me-1">active</span>
                                <span v-if="this[`get_${store_prefix}`].status == 0" class="badge bg-label-success me-1">deactive</span>
                            </td>
                        </tr>

                        <tr>
                            <td>created at</td>
                            <td>:</td>
                            <td>{{ new Date(this[`get_${store_prefix}`].created_at).toLocaleString() }}</td>
                        </tr>
                        <tr>
                            <td>udpated at</td>
                            <td>:</td>
                            <td>{{ new Date(this[`get_${store_prefix}`].updated_at).toLocaleString() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
/** store and route prefix for export object use */
import PageSetup from './PageSetup';
const {route_prefix, store_prefix} = PageSetup;
export default {
    data: function(){
        return {
            /** store prefix for JSX */
            store_prefix,
            route_prefix,
        }
    },
    methods: {
        ...mapMutations([`set_${store_prefix}`]),
        call_store: function(name, params=null){
            this[name](params)
        },
    },
    computed: {
        ...mapGetters([`get_${store_prefix}`])
    }
}
</script>

<style>

</style>
