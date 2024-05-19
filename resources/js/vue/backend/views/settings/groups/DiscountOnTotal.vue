<template>
    <div>
        <h4 class="mb-3">Discount On Total Amount</h4>
        <div class="s_setting">
            <label for="">Discount on greter title</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`discount_on_greater_title`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">Discount on greter than amount</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`discount_on_greater_amount`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">Discount amount</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`discount_on_greater_tk`"/>
            </div>
        </div>
    </div>
</template>

<script>
import SettingInput from './SettingInput.vue';
import { mapGetters } from 'vuex';
export default {
    components: { SettingInput},
    data: function(){
        return {
            description_value: '',
        }
    },
    created: function(){
        
    },
    methods: {
        update_descriptive_about: function(){
            let single_data= {
                key: 'descriptive_about',
                descriptive_about: this.description_value,
            }
            this.$store.dispatch('update_setting',{single_data})
        }
    },
    computed: {
        ...mapGetters(['get_settings']),
    }

}
</script>

<style>

</style>
