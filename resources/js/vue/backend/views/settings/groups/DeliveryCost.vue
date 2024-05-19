<template>
    <div>
        <h4 class="mb-3">Delivery Costs</h4>
        <div class="s_setting">
            <label for="">Home Delivery</label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`home_delivery_cost`" class="" />
            </div>
        </div>
        <div class="s_setting">
            <label for="">Outside Dhaka </label>
            <div class="input_field">
                <setting-input :type="`text`" :name="`outside_dhaka_cost`" class="" />
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

