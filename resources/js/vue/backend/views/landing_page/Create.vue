<template>
    <div class="container">
        <div class="card list_card">
            <div class="card-header">
                <h4>Create</h4>
                <div class="btns">
                    <router-link :to="{ name: `All${route_prefix}` }" class="btn rounded-pill btn-outline-warning" >
                        <i class="fa fa-arrow-left me-5px"></i>
                        Back
                    </router-link>
                </div>
            </div>
            <form @submit.prevent="call_store(`store_${store_prefix}`,$event.target)" autocomplete="false" class="landing_create_form">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="admin_form form_1">
                                <div class=" form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`Name`"
                                        :name="`name`"
                                    />
                                </div>

                                <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`Title`"
                                        :name="`title`"
                                    />
                                </div>

                                <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`sub title`"
                                        :name="`sub_title`"
                                    />
                                </div>

                                <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`middle text`"
                                        :name="`middle_title`"
                                        :type="`text`"
                                    />
                                </div>

                                <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`Main Button text`"
                                        :name="`first_btn_text`"
                                        :type="`text`"
                                    />
                                </div>

                                <div class=" form-group d-grid align-content-start gap-1 mb-2 " >
                                    <div>
                                        <label class="mb-2 text-capitalize">
                                            Select Product
                                        </label>
                                        <ProductManagementModal/>
                                    </div>
                                </div>

                                <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`Delivery cost`"
                                        :name="`delivery_cost`"
                                        :type="`number`"
                                    />
                                </div>

                                <div class="seo_section full_width mt-5">
                                    <div class="heading mb-4">
                                        <h4 class="d-flex justify-content-center">Colors</h4>
                                    </div>
                                    <hr>
                                    <div class="admin_form form_1 col_2 mt-3">
                                        <div class="form-group d-grid align-content-start gap-1 mb-2 ">
                                            <input-field
                                                :label="`Primary colors`"
                                                :name="`primary_color`"
                                                :type="`color`"
                                            />
                                        </div>

                                        <div class="form-group d-grid align-content-start gap-1 mb-2 ">
                                            <input-field
                                                :label="`secondary colors`"
                                                :name="`secondary_color`"
                                                :type="`color`"
                                            />
                                        </div>

                                        <div class="form-group d-grid align-content-start gap-1 mb-2 ">
                                            <input-field
                                                :label="`First Button color`"
                                                :name="`first_btn_color`"
                                                :type="`color`"
                                            />
                                        </div>

                                        <div class="form-group d-grid align-content-start gap-1 mb-2 ">
                                            <input-field
                                                :label="`Seond Button color`"
                                                :name="`second_btn_color`"
                                                :type="`color`"
                                            />
                                        </div>
                                    </div>
                                </div>


                                <div class="full_width mb-2 mt-2 row">
                                    <div class="heading mb-4">
                                        <h4 class="d-flex justify-content-center">Image and video</h4>
                                    </div>
                                    <hr>
                                    <div class="col-lg-6" >
                                        <input-field
                                            :label="`Image 1`"
                                            :name="`image1`"
                                            :type="`file`"
                                            :accept="`image/*`"
                                            :multiple="false"
                                            :preview="true"
                                        />
                                    </div>
                                    <div class="col-lg-6" >
                                        <input-field
                                            :label="`Image 2`"
                                            :name="`image2`"
                                            :type="`file`"
                                            :accept="`image/*`"
                                            :multiple="false"
                                            :preview="true"
                                        />
                                    </div>
                                    <div class="form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                        <label for="meta_description">Video Link</label>
                                        <textarea class="form-control" id="video_link" name="video_link"></textarea>
                                    </div>
                                </div>

                                <div class="seo_section full_width mt-2">

                                    <div class="heading mb-2">
                                        <h4 class="d-flex justify-content-center">FAQ section</h4>
                                    </div>
                                    <hr>
                                    <div class="admin_form form_1 col_2 mt-3">
                                        <div class="form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                            <label for="meta_description">FAQ Title</label>
                                            <textarea class="form-control" id="faq_title" name="faq_title"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="mb-3" data-repeater-list="group-a">
                                            <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item="">
                                                <label class="form-label" for="collapsible-address"><h5>Create Faq</h5></label>
                                                <div class="d-flex border rounded position-relative pe-0 mt-2" v-for="(input,index) in faqs" :key="index">
                                                    <div class="row w-100 pt-1 pl-3">
                                                        <div class="col-md-5 col-12 mb-md-0 mb-3">
                                                            <p class="mb-2 repeater-title">Question Title</p>
                                                            <input type="text" v-model="input.title" class="form-control invoice-item-price mb-3" placeholder="model" />
                                                        </div>
                                                        <div class="col-md-5 col-12 mb-md-0 mb-3">
                                                            <p class="mb-2 repeater-title">Question Answer</p>
                                                                <input type="text" v-model="input.description" class="form-control invoice-item-price mb-3" placeholder="inspiration 3000" />
                                                            <div></div>
                                                        </div>
                                                        <div class="col-md-2 col-6">
                                                            <p class="mb-2 repeater-title">Action</p>
                                                            <button type="button" @click="addFaq(index)" class="btn btn-primary waves-effect waves-light" data-repeater-create=""><i class="fa fa-plus"></i></button>
                                                            <button v-if="faqs.length>1" type="button" @click="removeFaq(index)" class="btn btn-danger waves-effect waves-light" data-repeater-create=""><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-outline-info" >
                        <i class="fa fa-upload"></i>
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex'
import InputField from '../components/InputField.vue'
import ProductManagementModal from '../product/components/ManagementModal.vue';
/** store and route prefix for export object use */
import PageSetup from './PageSetup';
const {route_prefix, store_prefix} = PageSetup;
import Editor from '@tinymce/tinymce-vue'

export default {
    components: { InputField, ProductManagementModal, Editor },
    data: function(){
        return {
            /** store prefix for JSX */
            store_prefix,
            route_prefix,
            slug: '',
            description_value: '',
            specification_value: '',
            short_description_value: '',
            faqs: [
                {
                    title: "",
                    description: ""
                }
            ],
        }
    },
    created: function () {
        this.set_clear_selected_categorys(false);
        this.fetch_all_variant_json();
    },
    watch: {
        description_value: function(v){
            this[`set_${store_prefix}_description`](v);
        },
        specification_value: function(v){
            this[`set_${store_prefix}_specification`](v);
        },
        short_description_value: function(v){
            this[`set_${store_prefix}_short_description`](v);
        },
    },
    methods: {
        ...mapActions([
            `store_${store_prefix}`,
            `generateSlug`,
            `fetch_all_variant_json`,
        ]),
        ...mapMutations([
            `set_clear_selected_categorys`,
            `set_${store_prefix}_description`,
            `set_${store_prefix}_specification`,
            `set_${store_prefix}_short_description`,
        ]),
        call_store: function(name, params=null){
            params = {
                faqs: this.faqs
            };
            this[name](params)
        },
        addFaq() {
            this.faqs.push({
                title: "",
                description: "",
            })
        },
        removeFaq(index) {
            this.faqs.splice(index, 1)
        },
        onchage_handler: async function({value}){
            this.slug = await this[`generateSlug`](value);
            // console.log(value, this.slug);
        },
        initCKEditor: function(){
            let that = this;

            setTimeout(async function() {
                let description = window.editor = await CKEDITOR.ClassicEditor
                    .create( document.querySelector( '#description' ), window.ck_editor_config)
                    .catch( error => {
                        console.error( error );
                    } );

                let specification = await CKEDITOR.ClassicEditor
                    .create( document.querySelector( '#specification' ), window.ck_editor_config )
                    .catch( error => {
                        console.error( error );
                    } );

                description.model.document.on('change', function(){
                    that[`set_${store_prefix}_description`](description.data.get());
                });
                specification.model.document.on('change', function(){
                    that[`set_${store_prefix}_specification`](specification.data.get());
                });
            }, 300);
        }
    },
    computed: {
        ...mapGetters([
            'get_all_variant_json'
        ])
    }
};
</script>

<style>
</style>
