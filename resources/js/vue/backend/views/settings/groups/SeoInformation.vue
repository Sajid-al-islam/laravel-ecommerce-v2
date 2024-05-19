<template>
    <div>
        <h4 class="mb-3">SEO Information</h4>
        <div class="s_setting">
            <label for="">Author</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`author`" class="" />
            </div>
        </div>
        <div class="s_setting">
            <label for="">Site Title</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`seo_title`" class="" />
            </div>
        </div>
        <div class="s_setting">
            <label for="">Site Description</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`seo_description`" class="" />
            </div>
        </div>
        <div class="s_setting">
            <label for="">SEO Default Image</label>
            <div class="input_field">
                <setting-input :type="`file`" :name="`seo_image`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">Website Classification</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`seo_classification`" class="" />
            </div>
        </div>
        <div class="s_setting">
            <label for="">Hot Line Number</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`seo_hot_line`" class="" />
            </div>
        </div>
        <div class="s_setting">
            <label for="">SEO Key Words</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`seo_keywords`" class="" />
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

