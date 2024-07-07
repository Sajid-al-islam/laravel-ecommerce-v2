<template>
    <div class="conatiner">
        <div class="card list_card">
            <div class="card-header">
                <h4>
                    All
                </h4>
                <!-- <div class="search">
                    <form action="#">
                        <input @keyup="call_store(`set_${store_prefix}_search_key`,$event.target.value)" class="form-control border border-info" placeholder="search..." type="search">
                    </form>
                </div> -->
                <div class="btns d-flex gap-2 align-items-center">
                    <permission-button
                        :permission="'can_create'"
                        :to="{name: `Offer`}"
                        :classList="'btn rounded-pill btn-outline-info'">
                        <i class="fa fa-pencil me-5px"></i>
                        Create
                    </permission-button>
                </div>
            </div>
            <div class="table-responsive card-body text-nowrap">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <table-th :sort="false" :tkey="'id'" :title="'ID'" :ariaLable="'id'"/>
                            <table-th :sort="false" :tkey="'product_id'" :title="'product'" />
                            <table-th :sort="false" :tkey="'discount_percent'" :title="'Discount Percent'" />
                            <table-th :sort="false" :tkey="'discount_amount'" :title="'Discount Amount'" />
                            <table-th :sort="false" :tkey="'discount_last_date'" :title="'Last Date'" />
                            <th aria-label="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr v-for="item in offers.data" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>
                                {{ item.product?.product_name }}
                            </td>
                            <td>
                                {{ item.discount_percent }}
                            </td>
                            <td>
                                {{ item.discount_amount }}
                            </td>
                            <td>
                                {{ item.discount_last_date }}
                            </td>
                            <td>
                                <ul class="d-flex gap-1 p-0" style="list-style-type:none">
                                    <li>
                                        <a class="btn btn-sm btn-outline-danger" href="javascript:void(0);" @click.prevent="remove(item.id)"><i class="fa-solid fa-trash-can me-1"></i> Delete</a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer py-1 border-top-0">
                <div class="d-inline-block">
                    <pagination :data="offers" :limit="20" :size="'small'" :show-disabled="true" :align="'left'"
                        @pagination-change-page="get_offer">
                        <span slot="prev-nav"><i class="fa fa-angle-left"></i> Previous</span>
                        <span slot="next-nav">Next <i class="fa fa-angle-right"></i></span>
                    </pagination>
                </div>
                <div class="show-limit d-inline-block">
                    <span>Total:</span>
                    <span>{{ offers.total }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex';
import PermissionButton from '../components/PermissionButton.vue';
import TableTh from './components/TableTh.vue';

/** store and route prefix for export object use */
import PageSetup from './PageSetup';
const {route_prefix, store_prefix} = PageSetup;

export default {
    components: { PermissionButton, TableTh },
    data: function(){
        return {
            store_prefix,
            route_prefix,
            offers: {}
        }
    },
    created: function(){
        this.get_offer();
    },
    methods: {
        get_offer: function(){
            axios.get('/product/all-offers')
            .then((response) => {
                // window.s_alert('success', response.data.message);
                // this.mssg = response.data.message
                this.offers = response.data;
            })
            .catch((e) => {
                console.log(e);
            });
        },
        remove: async function (id) {
            let cconfirm = await window.s_confirm("Permenently delete");
            if (cconfirm) {
                await axios
                    .post(`/product/offers/destroy`, { id })
                    .then(({ data }) => {
                        this.get_offer();
                        window.s_alert(
                            `Offer has been Permenently delted`
                        );
                    });
            }
        },

    },
    computed: {

    }
}
</script>

<style>

</style>

PermissionButton
