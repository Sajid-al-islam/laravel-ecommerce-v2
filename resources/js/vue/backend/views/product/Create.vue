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
            <form @submit.prevent="call_store(`store_${store_prefix}`,$event.target)" autocomplete="false" class="create_form">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="admin_form form_1">
                                <div class=" form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`Name`"
                                        :name="`product_name`"
                                        :keyup="onchage_handler"
                                    />
                                </div>

                                <div class="form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`search keywords`"
                                        :name="`search_keywords`"
                                        :value="slug"
                                        :keyup="onchage_handler"
                                    />
                                </div>

                                <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`cost`"
                                        :name="`cost`"
                                    />
                                </div>

                                <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`price`"
                                        :name="`sales_price`"
                                    />
                                </div>

                                <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`stock`"
                                        :name="`stock`"
                                        :type="`number`"
                                        :value="5"
                                    />
                                </div>

                                <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`low stock`"
                                        :name="`low_stock`"
                                        :type="`number`"
                                        :value="1"
                                    />
                                </div>

                                <div class=" form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                    <div>
                                        <label class="mb-2 text-capitalize">
                                            Select Variants
                                        </label>

                                        <div class="variants">
                                            <template v-for="variant in get_all_variant_json">
                                                <div v-if="variant.values.length" class="variant_list" :key="variant.id">
                                                    <div class="value_title">
                                                        {{ variant.title }}
                                                    </div>
                                                    <div class="values_selections">
                                                        <label :for="`variant_${variant.id}_${variant_value.id}`" v-for="variant_value in variant.values" :key="variant_value.id">
                                                            <input type="checkbox"
                                                                :name="`variants[${variant.id}][${variant_value.id}][variant_id]`"
                                                                :value="`${variant_value.id}`"
                                                                :checked="variant_value.default_checked"
                                                                class="form-check-input"
                                                                :id="`variant_${variant.id}_${variant_value.id}`">
                                                            <span class="variant_value">
                                                                {{ variant_value.title }}
                                                            </span>
                                                            <input type="text" :name="`variants[${variant.id}][${variant_value.id}][variant_price]`"
                                                                class="form-control" placeholder="variant price">
                                                        </label>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <div class=" form-group d-grid align-content-start gap-1 mb-2 " >
                                    <div>
                                        <label class="mb-2 text-capitalize">
                                            Select Brand
                                        </label>
                                        <BrandManagementModal :select_qty="1"/>
                                    </div>
                                </div>

                                <div class=" form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                    <div>
                                        <label class="mb-2 text-capitalize">
                                            Select Cateogry
                                        </label>
                                        <!-- <CategoryManagementModal/> -->
                                        <nested-category-modal></nested-category-modal>
                                    </div>
                                </div>

                                <div class="form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                    <h5 class="text-capitalize">
                                        Product status
                                    </h5>
                                    <label for="call_for_price">
                                        <input type="checkbox" value="1" class="form-check-input" id="call_for_price">
                                        &nbsp; &nbsp; Call for price
                                    </label>
                                    <label for="is_upcomming">
                                        <input type="checkbox" value="1" class="form-check-input" id="is_upcomming">
                                        &nbsp; &nbsp; Upcomming
                                    </label>
                                    <label for="is_tba">
                                        <input type="checkbox" value="1" class="form-check-input" id="is_tba">
                                        &nbsp; &nbsp; TBA
                                    </label>
                                    <label for="is_pre_order">
                                        <input type="checkbox" value="1" class="form-check-input" id="is_pre_order">
                                        &nbsp; &nbsp; Pre order
                                    </label>
                                    <label for="is_in_stock">
                                        <input checked type="checkbox" value="1" class="form-check-input" id="is_in_stock">
                                        &nbsp; &nbsp; In stock available
                                    </label>
                                    <br>
                                </div>


                                <div class="full_width mb-2 row">

                                    <div class="col-lg-3" >
                                        <input-field
                                            :label="`Thumb Image`"
                                            :name="`image1`"
                                            :type="`file`"
                                            :accept="`image/*`"
                                            :multiple="false"
                                            :preview="true"
                                        />
                                    </div>
                                    <div class="col-lg-3" >
                                        <input-field
                                            :label="`Related Image 1`"
                                            :name="`image2`"
                                            :type="`file`"
                                            :accept="`image/*`"
                                            :multiple="false"
                                            :preview="true"
                                        />
                                    </div>
                                    <div class="col-lg-3" >
                                        <input-field
                                            :label="`Related Image 2`"
                                            :name="`image3`"
                                            :type="`file`"
                                            :accept="`image/*`"
                                            :multiple="false"
                                            :preview="true"
                                        />
                                    </div>
                                    <div class="col-lg-3" >
                                        <input-field
                                            :label="`Related Image 3`"
                                            :name="`image4`"
                                            :type="`file`"
                                            :accept="`image/*`"
                                            :multiple="false"
                                            :preview="true"
                                        />
                                    </div>
                                    <div class="col-lg-3" >
                                        <input-field
                                            :label="`Related Image 4`"
                                            :name="`image5`"
                                            :type="`file`"
                                            :accept="`image/*`"
                                            :multiple="false"
                                            :preview="true"
                                        />
                                    </div>
                                    <div class="col-lg-3" >
                                        <input-field
                                            :label="`Related Image 5`"
                                            :name="`image6`"
                                            :type="`file`"
                                            :accept="`image/*`"
                                            :multiple="false"
                                            :preview="true"
                                        />
                                    </div>
                                </div>

                                <div class="form-group d-grid align-content-start full_width gap-1 mb-2 " >
                                    <label for="short_description">Short Description</label>
                                    <editor
                                        v-model="short_description_value"
                                        api-key="d1wxddm2y8oc8aelf9yljfgq4553ntkqd0slwsh4tzyw05cg"
                                        :init="{height: 200}"
                                    />
                                </div>

                                <div class="form-group d-grid align-content-start full_width gap-1 mb-2 " >
                                    <label for="specification">Specification</label>
                                    <editor
                                        v-model="specification_value"
                                        api-key="d1wxddm2y8oc8aelf9yljfgq4553ntkqd0slwsh4tzyw05cg"
                                        :init="{height: 200}"
                                    />
                                    <!-- <textarea class="form-control" id="specification" name="specification" :value="this[`get_${store_prefix}`]['description']"></textarea> -->
                                </div>

                                <div class="form-group d-grid align-content-start full_width gap-1 mb-2 " >
                                    <label for="description">Description</label>
                                    <div id="description">
                                        <editor
                                            v-model="description_value"
                                            api-key="d1wxddm2y8oc8aelf9yljfgq4553ntkqd0slwsh4tzyw05cg"
                                            :init="{height: 200}"
                                        />
                                    </div>
                                    <!-- <textarea class="form-control" id="description" name="description" :value="this[`get_${store_prefix}`]['description']"></textarea> -->
                                </div>

                                <div class="seo_section full_width mt-5">

                                    <div class="heading mb-4">
                                        <h4 class="d-flex justify-content-center">Seo section</h4>
                                        <h6 class="d-flex justify-content-center">Boost traffic to your online business.</h6>
                                    </div>
                                    <hr>
                                    <div class="admin_form form_1 col_2 mt-3">
                                        <div class="form-group d-grid align-content-start gap-1 mb-2 ">
                                            <input-field
                                                :label="`Page Title`"
                                                :name="`page_title`"
                                                :value="slug"
                                            />
                                        </div>

                                        <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                            <input-field
                                                :label="`product url`"
                                                :name="`product_url`"
                                                :value="slug"
                                            />
                                        </div>

                                        <div class="form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                            <label for="meta_description">Meta Description</label>
                                            <textarea class="form-control" id="meta_description" :value="slug" name="meta_description"></textarea>
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
import NestedCategoryModal from '../category/components/NestedCategoryModal.vue';
import BrandManagementModal from '../brand/components/ManagementModal.vue';
/** store and route prefix for export object use */
import PageSetup from './PageSetup';
const {route_prefix, store_prefix} = PageSetup;
import Editor from '@tinymce/tinymce-vue'

export default {
    components: { InputField, BrandManagementModal, NestedCategoryModal, Editor },
    data: function(){
        return {
            /** store prefix for JSX */
            store_prefix,
            route_prefix,
            slug: '',
            description_value: '',
            specification_value: '',
            short_description_value: '',
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
            this[name](params)
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
