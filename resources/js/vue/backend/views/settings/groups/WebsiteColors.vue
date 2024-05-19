<template>
    <div>
        <h4 class="mb-3">Website colors</h4>
        <div class="s_setting">
            <label for="">header background color</label>
            <div class="input_field">
                <setting-input :type="`color`" :name="`header_background_color`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">header text color</label>
            <div class="input_field">
                <setting-input :type="`color`" :name="`header_text_color`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">nav background color</label>
            <div class="input_field">
                <setting-input :type="`color`" :name="`nav_background_color`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">nav text color</label>
            <div class="input_field">
                <setting-input :type="`color`" :name="`nav_text_color`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">dropdown background color</label>
            <div class="input_field">
                <setting-input :type="`color`" :name="`dropdown_background_color`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">dropdown heading color</label>
            <div class="input_field">
                <setting-input :type="`color`" :name="`dropdown_heading_color`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">dropdown text color</label>
            <div class="input_field">
                <setting-input :type="`color`" :name="`dropdown_text_color`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">website brand color</label>
            <div class="input_field">
                <setting-input :type="`color`" :name="`website_brand_color`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">website text color</label>
            <div class="input_field">
                <setting-input :type="`color`" :name="`website_text_color`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">website text hover color</label>
            <div class="input_field">
                <setting-input :type="`color`" :name="`website_text_hover_color`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">website hover background color</label>
            <div class="input_field">
                <setting-input :type="`color`" :name="`website_hover_background_color`"/>
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
