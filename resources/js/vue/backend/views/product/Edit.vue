<template>
    <div class="container">
        <div class="card list_card">
            <div class="card-header">
                <h4>Edit</h4>
                <div class="btns">
                    <a href="" @click.prevent="call_store(`set_${store_prefix}`,null), $router.push({ name: `All${route_prefix}` })"  class="btn rounded-pill btn-outline-warning" >
                        <i class="fa fa-arrow-left me-5px"></i>
                        <span >
                            Back
                        </span>
                    </a>
                </div>
            </div>
            <form @submit.prevent="call_store(`update_${store_prefix}`,$event.target)" autocomplete="false" class="update_form">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="admin_form form_1" v-if="this[`get_${store_prefix}`]">
                                <div class="full_width form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`Name`"
                                        :name="`product_name`"
                                        :value="this[`get_${store_prefix}`]['product_name']"
                                    />
                                </div>
                                <div class="form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`search keywords`"
                                        :name="`search_keywords`"
                                        :value="this[`get_${store_prefix}`]['search_keywords']"
                                    />
                                </div>

                                <div class=" form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`Price`"
                                        :name="`sales_price`"
                                        :value="this[`get_${store_prefix}`]['sales_price']"
                                    />
                                </div>

                                <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                    <input-field
                                        :label="`low stock`"
                                        :name="`low_stock`"
                                        :value="this[`get_${store_prefix}`]['low_stock']"
                                        :type="`number`"
                                    />
                                </div>

                                <div class="form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                    <h4>Update stock</h4>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                                <input-field
                                                    :label="`Present stock`"
                                                    :name="``"
                                                    :value="this[`get_${store_prefix}`]['stock']"
                                                    :type="`number`"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                                <input-field
                                                    :label="`New stock`"
                                                    :name="`updated_stock`"
                                                    :value="0"
                                                    :type="`number`"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                                <label for="">Stock info</label>
                                                <select class="form-select" name="stock_log_type" id="">
                                                    <option selected value="sell">sold out</option>
                                                    <option value="purchase">purchase</option>
                                                </select>
                                            </div>
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

                                <div class="full_width form-group d-grid align-content-start gap-1 mb-2 " >
                                    <div>
                                        <label class="mb-2 text-capitalize">
                                            Previous Category
                                        </label>
                                        <!-- <CategoryManagementModal/> -->
                                        <nested-category-modal></nested-category-modal>
                                    </div>
                                    <label class="text-capitalize">
                                        Select Cateogry
                                    </label>
                                    <select class="form-select" name="category_id" id="category_id">
                                        <option value="">Select category</option>
                                        <option v-for="(cagtegory, index) in get_category_all_json" :key="index" :value="cagtegory.id">{{ cagtegory.name }}</option>
                                    </select>
                                </div>


                                <div class=" form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                    <div>
                                        <label class="mb-2 text-capitalize">
                                            Select Variants
                                        </label>

                                        <div class="variants">
                                            <div class="variant_list" v-for="variant in get_all_variant_json" :key="variant.id">
                                                <div class="value_title">
                                                    {{ variant.title }}
                                                </div>
                                                <div class="values_selections">
                                                    <label :for="`variant_${variant.id}_${variant_value.id}`" v-for="variant_value in variant.values" :key="variant_value.id">
                                                        <input type="checkbox"
                                                            :name="`variants[${variant.id}][${variant_value.id}][variant_id]`"
                                                            :value="`${variant_value.id}`"
                                                            :checked="check_has_variant(variant.id, variant_value.id)"
                                                            class="form-check-input"
                                                            :id="`variant_${variant.id}_${variant_value.id}`">
                                                        <span class="variant_value">
                                                            {{ variant_value.title }}
                                                        </span>
                                                        <input type="text" :value="set_variant_pricing(variant.id, variant_value.id)" :name="`variants[${variant.id}][${variant_value.id}][variant_price]`"
                                                            class="form-control" placeholder="variant price">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
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
                                    <div>
                                        <editor
                                            v-model="specification_value"
                                            api-key="d1wxddm2y8oc8aelf9yljfgq4553ntkqd0slwsh4tzyw05cg"
                                            :init="{height: 200}"
                                        />
                                    </div>
                                    <!-- <div id="specification"></div> -->
                                    <!-- <textarea class="form-control" id="specification" name="specification" :value="this[`get_${store_prefix}`]['description']"></textarea> -->
                                </div>
                                <div class="form-group d-grid align-content-start full_width gap-1 mb-2 " >
                                    <label for="description">Description</label>
                                    <div>
                                        <editor
                                            v-model="description_value"
                                            api-key="d1wxddm2y8oc8aelf9yljfgq4553ntkqd0slwsh4tzyw05cg"
                                            :init="{height: 200}"
                                        />
                                    </div>
                                    <!-- <div id="description"></div> -->
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
                                                :value="this[`get_${store_prefix}`]['page_title']"
                                            />
                                        </div>

                                        <div class="form-group d-grid align-content-start gap-1 mb-2 " >
                                            <input-field
                                                :label="`product url`"
                                                :name="`product_url`"
                                                :value="this[`get_${store_prefix}`]['product_url']"
                                            />
                                        </div>

                                        <div class="form-group full_width d-grid align-content-start gap-1 mb-2 " >
                                            <label for="meta_description">Meta Description</label>
                                            <textarea class="form-control" :value="this[`get_${store_prefix}`]['meta_description']" id="meta_description" name="meta_description"></textarea>
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
                        update
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
    components: { InputField, NestedCategoryModal, BrandManagementModal, Editor },
    data: function(){
        return {
            /** store prefix for JSX */
            store_prefix,
            route_prefix,
            description_value: '',
            specification_value: '',
            short_description_value: '',
        }
    },
    created: async function () {
        this.set_clear_selected_categorys(false);
        this.set_clear_selected_brands(false);
        await this.fetch_all_variant_json();
        this.fetch_category_all_json();
        await this[`fetch_${store_prefix}`]({id: this.$route.params.id});
    },
    watch: {
        [`get_${store_prefix}`]: {
            handler: function(v){
                this.check_selected_categories();
                this.description_value = v.description;
                this.specification_value = v.specification;
                this.short_description_value = v.short_description;
            },
            deep: true,
        },
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
            `update_${store_prefix}`,
            `fetch_${store_prefix}`,
            `fetch_all_variant_json`,
            `fetch_category_all_json`,
        ]),
        ...mapMutations([
            `set_clear_selected_categorys`,
            `set_clear_selected_brands`,
            `set_${store_prefix}`,
            `set_${store_prefix}_description`,
            `set_${store_prefix}_specification`,
            `set_${store_prefix}_short_description`,
        ]),
        call_store: function(name, params=null){
            this[name](params)
        },
        set_variant_pricing: function(variant_id, variant_value_id) {
            let variant_price = 0
            this.product.variants.forEach(v=> {
                if(v.product_variant_id == variant_id && v.product_variant_value_id == variant_value_id){
                    variant_price = v.variant_price;
                }else{
                    variant_price = 0;
                }
            })
            return variant_price;
        },
        check_has_variant: function(variant_id, variant_value_id){
            let check = this.product.variants.find(v=> {
                if(v.product_variant_id == variant_id && v.product_variant_value_id == variant_value_id){
                    return v;
                }else{
                    return false;
                }
            })
            return check ? 1 : 0;
        },
        check_selected_categories: function(){
            setTimeout(() => {
                for (let index = 0; index < this.selected_cats.length; index++) {
                    const i = this.selected_cats[index];
                    let el = document.querySelector(`input[data-id="${i.id}"]`);
                    if(el){
                        el.checked = true;
                        (function check_parent(el){
                            if(el.parentNode){
                                if(el.parentNode.classList?.contains('list')){
                                    el.parentNode.classList.add('d-block');
                                }
                                check_parent(el.parentNode)
                            }
                        })(el)
                    }
                }
            }, 500);
        }
    },
    computed: {
        ...mapGetters({
            get_category_all_json: `get_category_all_json`,
            selected_cats: `get_category_selected`,
            [`get_${store_prefix}`]: `get_${store_prefix}`,
            product: `get_${store_prefix}`,
            'get_all_variant_json': 'get_all_variant_json',
        })
    }
};
</script>

<style>
</style>
