<template>
    <div>
        <h4 class="mb-3">Payment Accounts</h4>
        <div class="s_setting">
            <label for="">Bkash Number 1</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`bkash_number1`" class="" />
            </div>
        </div>
        <div class="s_setting">
            <label for="">Bkash Number 2</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`bkash_number2`" class="" />
            </div>
        </div>
        <div class="s_setting">
            <label for="">Bkash Number 3</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`bkash_number3`" class="" />
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

