<template>
    <div>
        <h4 class="mb-3">Basic Information</h4>
        <div class="s_setting">
            <label for="">Header Logo (120 × 42 px)</label>
            <div class="input_field">
                <setting-input :type="`file`" :name="`header_logo`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">Footer Logo</label>
            <div class="input_field">
                <setting-input :type="`file`" :name="`footer_logo`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">Fab icon</label>
            <div class="input_field">
                <setting-input :type="`file`" :name="`fabicon`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">Beaking news</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`breaking_news`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">Footer short description</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`footer_short_description`"/>
            </div>
        </div>
    </div>
</template>

<script>
import SettingInput from './SettingInput.vue';
export default {
    components: { SettingInput },
    created: function(){
        console.log(this.$store);
    },

}
</script>

<style>

</style>
