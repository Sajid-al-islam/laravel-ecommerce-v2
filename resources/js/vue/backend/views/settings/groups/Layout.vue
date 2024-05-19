<template>
    <div>
        <div class="setting_management">
            <div class="navs">
                <ul>
                    <li>
                        <router-link :to="{name:'BasicInformation'}">
                            <i class="far fa-circle"></i>
                            <div>
                                {{ camelToNormal("BasicInformation") }}
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name:'ContactInformation'}">
                            <i class="far fa-circle"></i>
                            <div>
                                {{ camelToNormal("ContactInformation") }}
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name:'PaymentAccount'}">
                            <i class="far fa-circle"></i>
                            <div>
                                {{ camelToNormal("PaymentAccount") }}
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name:'DeliveryCost'}">
                            <i class="far fa-circle"></i>
                            <div>
                                {{ camelToNormal("DeliveryCost") }}
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name:'SideBanner'}">
                            <i class="far fa-circle"></i>
                            <div>
                                {{ camelToNormal("SideBanner") }}s
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name:'WebsiteColors'}">
                            <i class="far fa-circle"></i>
                            <div>
                                {{ camelToNormal("WebsiteColors") }}
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name:'AboutUs'}">
                            <i class="far fa-circle"></i>
                            <div>
                                {{ camelToNormal("AboutUs") }}
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name:'Policy'}">
                            <i class="far fa-circle"></i>
                            <div>
                                {{ camelToNormal("Policy") }}
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name:'SeoInformation'}">
                            <i class="far fa-circle"></i>
                            <div>
                                {{ camelToNormal("SeoInformation") }}
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{name:'DiscountOnTotal'}">
                            <i class="far fa-circle"></i>
                            <div>
                                {{ camelToNormal("DiscountOnTotal") }}
                            </div>
                        </router-link>
                    </li>
                </ul>
            </div>
            <div class="setting_body custom_scroll">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    created: function(){
        this.$store.dispatch('fetch_setting');
    }
}
</script>

<style>

</style>
