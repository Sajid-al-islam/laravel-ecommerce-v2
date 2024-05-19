<template>
    <div>
        <h4 class="mb-3">Side Banners</h4>
        <div class="s_setting">
            <label for="">Left Top (350 x 262px)</label>
            <div class="input_field">
                <setting-input :type="`file`" :name="`side_banner_left_top`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">Left Bottom (350 x 262px)</label>
            <div class="input_field">
                <setting-input :type="`file`" :name="`side_banner_left_bottom`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">Right Top (350 x 262px)</label>
            <div class="input_field">
                <setting-input :type="`file`" :name="`side_banner_right_top`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">Right Bottom (350 x 262px)</label>
            <div class="input_field">
                <setting-input :type="`file`" :name="`side_banner_right_bottom`"/>
            </div>
        </div>
    </div>
</template>

<script>
import SettingInput from './SettingInput.vue'
export default {
    components: { SettingInput },

}
</script>

<style>

</style>
