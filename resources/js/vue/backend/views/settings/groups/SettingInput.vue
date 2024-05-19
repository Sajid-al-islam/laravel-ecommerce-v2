<template>
    <div>
        <div v-if="type === 'file'">
            <input type="file" @change="update_data($event)" accept="image/*" :name="name"> <br>
            <img :src="this.$store.getters.get_settings[name]" width="80px" class=" mt-1 img-thumbnail bg-transparent" alt="">
        </div>
        <div v-if="type === 'text'">
            <textarea :name="name" @change="update_data($event)" :value="this.$store.getters.get_settings[name]" class="form-control"></textarea>
        </div>
        <div v-if="type === 'color'" class="d-flex gap-2">
            <div :style="`height: 38px; width: 38px;background-color: ${this.$store.getters.get_settings[name]}; border: 3px solid white;`"></div>
            <input :name="name" type="text" @change="update_data($event)" class="form-control mb-1" :value="this.$store.getters.get_settings[name]"/>
        </div>
    </div>
</template>

<script>
export default {
    props: ['name','type'],
    methods: {
        update_data: function(event){
            this.$store.dispatch('update_setting',{event})
        }
    }
}
</script>

<style>

</style>
