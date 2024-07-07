<template>
    <div class="container">
        <div class="card list_card">
            <div class="card-header">
                <h4>Create</h4>
                <div class="btns">
                    <router-link :to="{ name: `All${route_prefix}` }" class="btn rounded-pill btn-outline-warning" >
                        <i class="fa fa-arrow-left me-5px"></i>
                        Back
                    </router-link>
                </div>
            </div>
            <form @submit.prevent="call_store(`store_${store_prefix}`,$event.target)" autocomplete="false" class="create_form">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="admin_form form_1">
                                <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                    <input-field
                                        :label="`Coupon code`"
                                        :name="`code`"
                                    />
                                </div>

                                <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                    <label class="text-capitalize d-block">
                                        <span class="mb-2 d-block">
                                            Coupon Type
                                        </span>
                                        <select class="form-select" name="type" id="type">
                                            <option selected value="fixed">fixed</option>
                                            <option value="percent">percent</option>
                                        </select>
                                    </label>
                                </div>

                                <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                    <input-field
                                        :label="`Coupon Amount`"
                                        :name="`value`"
                                        :type="`number`"
                                    />
                                </div>

                                <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                    <input-field
                                        :label="`Start Date`"
                                        :name="`start_date`"
                                        :type="`date`"
                                    />
                                </div>

                                <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                    <input-field
                                        :label="`End Date`"
                                        :name="`end_date`"
                                        :type="`date`"
                                    />
                                </div>

                                <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                    <input-field
                                        :label="`Usage Limit`"
                                        :name="`usage_limit`"
                                        :type="`number`"
                                    />
                                </div>


                                <div class=" form-group d-grid align-content-start gap-1 mb-2">
                                    <input-field
                                        :label="`Coupon Used`"
                                        :name="`used`"
                                        :type="`number`"
                                        :value="0"
                                    />
                                </div>


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
const {route_prefix, store_prefix} = PageSetup;

export default {
    components: { InputField },
    data: function(){
        return {
            /** store prefix for JSX */
            store_prefix,
            route_prefix
        }
    },
    created: function () {},
    methods: {

        ...mapActions([
            `store_${store_prefix}`,
            `add_customer_phone_no`,
            `remove_customer_phone_no`
        ]),
        call_store: function(name, params=null){
            this[name](params)
        },
    },

    computed: {
        // mapping the getters
        ...mapGetters([
            'get_customer_phone_no',
        ]),

    },
};
</script>

<style scoped>
.invoice_email {
    margin-right: 10px !important;
}
.add_btn_email {
    margin-right: 10px !important;
}
</style>
