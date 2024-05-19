<template>
    <div>
        <h4 class="mb-3">About US</h4>
        <div class="s_setting">
            <label for="">Short About</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`short_about`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">Descriptive About</label>
            <div class="input_field">
                <editor
                    v-model="description_value"
                    api-key="d1wxddm2y8oc8aelf9yljfgq4553ntkqd0slwsh4tzyw05cg"
                    :init="{height: 400}"
                />
                <button type="button" @click="update_descriptive_about" class="btn btn-primary mt-2"> Update descriptive about</button>
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
            description_value: '',
        }
    },
    created: function(){
        this.$watch("get_settings",function(){
            this.description_value = this.get_settings['descriptive_about'];
        })
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
