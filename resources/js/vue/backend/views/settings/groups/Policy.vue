<template>
    <div>
        <h4 class="mb-3">Policy</h4>
        <div class="s_setting">
            <label for="">Privacy Policy</label>
            <div class="input_field">
                <editor
                    v-model="privacy_policy"
                    api-key="d1wxddm2y8oc8aelf9yljfgq4553ntkqd0slwsh4tzyw05cg"
                    :init="{height: 400}"
                />
            </div>
        </div>
        <div class="s_setting">
            <label for="">Terms &amp; conditions</label>
            <div class="input_field">
                <editor
                    v-model="terms_condition"
                    api-key="d1wxddm2y8oc8aelf9yljfgq4553ntkqd0slwsh4tzyw05cg"
                    :init="{height: 400}"
                />
            </div>
        </div>
        <div class="s_setting">
            <label for="">Refund Policy</label>
            <div class="input_field">
                <editor
                    v-model="refund_policy"
                    api-key="d1wxddm2y8oc8aelf9yljfgq4553ntkqd0slwsh4tzyw05cg"
                    :init="{height: 400}"
                />
            </div>
        </div>
        <div class="s_setting">
            <label for=""></label>
            <div class="input_field">
                <button type="button" @click="update_data" class="btn btn-primary mt-2"> Update </button>
            </div>
        </div>
    </div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue'
import SettingInput from './SettingInput.vue';
import { mapGetters } from 'vuex';
export default {
    components: { SettingInput, Editor},
    data: function(){
        return {
            privacy_policy: '',
            terms_condition: '',
            refund_policy: '',
        }
    },
    created: function(){
        this.$watch("get_settings",function(){
            this.privacy_policy = this.get_settings['privacy_policy'];
            this.terms_condition = this.get_settings['terms_condition'];
            this.refund_policy = this.get_settings['refund_policy'];
        })
    },
    methods: {
        update_data: function(){
            let single_data= {
                key: 'privacy_policy',
                privacy_policy: this.privacy_policy,
            }
            this.$store.dispatch('update_setting',{single_data});

            single_data= {
                key: 'terms_condition',
                terms_condition: this.terms_condition,
            }
            this.$store.dispatch('update_setting',{single_data})

            single_data= {
                key: 'refund_policy',
                refund_policy: this.refund_policy,
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
