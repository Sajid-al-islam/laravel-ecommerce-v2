<template>
    <div class="container">
        <div class="card list_card">
            <div class="card-header">
                <h4>Edit</h4>
                <div class="btns">
                    <a href="" @click.prevent="call_store(`set_${store_prefix}`,null), $router.push({ name: `All${route_prefix}` })"  class="btn rounded-pill btn-outline-warning" >
                        <i class="fa fa-arrow-left me-5px"></i>
                        <span >
                            Back
                        </span>
                    </a>
                </div>
            </div>
            <form @submit.prevent="call_store(`update_${store_prefix}`,$event.target)" autocomplete="false" class="update_form">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="admin_form form_1" v-if="this[`get_${store_prefix}`]">
                                <div class=" form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`Code`"
                                        :name="`code`"
                                        :value="this[`get_${store_prefix}`]['code']"
                                    />
                                </div>

                                <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                    <label class="text-capitalize d-block">
                                        <span class="mb-2 d-block">
                                            Coupon Type
                                        </span>
                                        <select :value="this[`get_${store_prefix}`]['type']" class="form-select" name="type" id="type">
                                            <option selected value="fixed">fixed</option>
                                            <option value="percent">percent</option>
                                        </select>
                                    </label>
                                </div>

                                <div class=" form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`Coupon Amount`"
                                        :name="`value`"
                                        :type="`number`"
                                        :value="this[`get_${store_prefix}`]['value']"
                                    />
                                </div>

                                <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                    <input-field
                                        :label="`Start Date`"
                                        :name="`start_date`"
                                        :type="`date`"
                                        :value="this[`get_${store_prefix}`]['start_date']"
                                    />
                                </div>

                                <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                    <input-field
                                        :label="`End Date`"
                                        :name="`end_date`"
                                        :type="`date`"
                                        :value="this[`get_${store_prefix}`]['end_date']"
                                    />
                                </div>

                                <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                    <input-field
                                        :label="`Usage Limit`"
                                        :name="`usage_limit`"
                                        :type="`number`"
                                        :value="this[`get_${store_prefix}`]['usage_limit']"
                                    />
                                </div>


                                <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                    <input-field
                                        :label="`Coupon Used`"
                                        :name="`used`"
                                        :type="`number`"
                                        :value="this[`get_${store_prefix}`]['used']"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-outline-info" >
                        <i class="fa fa-upload"></i>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex'
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
        }
    },
    created: function () {
        this[`fetch_${store_prefix}`]({id: this.$route.params.id});
    },
    methods: {
        ...mapActions([
            `update_${store_prefix}`,
            `fetch_${store_prefix}`,
            `add_customer_phone_no`,
            `remove_customer_phone_no`
        ]),
        ...mapMutations([
            `set_${store_prefix}`,
        ]),
        call_store: function(name, params=null){
            this[name](params)
        },
    },
    computed: {
        ...mapGetters([
            `get_${store_prefix}`,
            'get_customer_phone_no'
        ])
    }
};
</script>

<style>
</style>
