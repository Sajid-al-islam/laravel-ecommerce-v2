<template>
    <div>
        <h3 class="mb-2 d-flex justify-content-between">
            <span>
                {{ layout_title }}
            </span>

            <!-- <span>( courier balance: {{ balance }} ৳)</span> -->
        </h3>
        <router-view v-if="is_role_permitted"></router-view>
        <div v-else class="text-center">
            <h4 class="text-warning">sorry you have no permission</h4>
            <router-link class="btn btn-outline-warning mt-3" :to="{name:'Dashboard'}">Go Back</router-link>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
/** store and route prefix for export object use */
import PageSetup from './PageSetup';
const {layout_title} = PageSetup;
export default {
    props: ['role_permissions'],
    created: function(){
        // console.log(this.role_permissions);

        axios.get(`https://portal.steadfast.com.bd/api/v1/get_balance`,{
            headers: {
                "Api-Key": "at8f3p06nfiqizwdcisimpjjxoncwljo",
                "Secret-Key" : "txgfd00ut5pikkbi4lgpnta5",
            }
        }).then(res=>{
            this.balance = res.data.current_balance;
        })

    },
    data: function(){
        return {
            layout_title,
            balance: 0,
        }
    },
    computed: {
        ...mapGetters(['get_auth_roles']),
        is_role_permitted: function(){
            for (let i=0; i<this.role_permissions?.length; i++) {
                let item = this.role_permissions[i];
                if(this.get_auth_roles.includes(item)){
                    return true;
                }
            }
            return false;
        }
    }

};
</script>

<style></style>
