<template>
    <div>
        <h4 class="mb-3">Contact Information</h4>
        <div class="s_setting">
            <label for="">Address</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`address`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">Phone numbers</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`phone_number_1`" class="mb-2" />
                <setting-input :type="`text`" :name="`phone_number_2`" class="mb-2"/>
                <setting-input :type="`text`" :name="`phone_number_3`"/>
            </div>
        </div>
        <div class="s_setting">
            <label for="">Service numbers</label>
            <div class="input_field">
                <label for="" class="mb-1">Desktop</label> <br>
                <setting-input :type="`text`" :name="`phone_number_desktop`" class="mb-2" />

                <label for="" class="mb-1">Laptop</label> <br>
                <setting-input :type="`text`" :name="`phone_number_laptop`" class="mb-2" />

                <label for="" class="mb-1">Service</label> <br>
                <setting-input :type="`text`" :name="`phone_number_service`" class="mb-2" />

                <label for="" class="mb-1">Accessories</label> <br>
                <setting-input :type="`text`" :name="`phone_number_accessories`" class="mb-2" />

                <label for="" class="mb-1">Helpline</label> <br>
                <setting-input :type="`text`" :name="`phone_number_helpline`" class="mb-2" />

                <label for="" class="mb-1">RMA</label> <br>
                <setting-input :type="`text`" :name="`phone_number_rma`" />
            </div>
        </div>
        <div class="s_setting">
            <label for="">Email</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`email_1`" class="mb-2" />
                <setting-input :type="`text`" :name="`email_2`" class="mb-2" />
                <setting-input :type="`text`" :name="`email_3`" />
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

