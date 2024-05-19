import settingLayout from '../../views/settings/Layout'
import settingProfile from '../../views/settings/Profile'
import settingPassword from '../../views/settings/Password'

import settingGroupLayout from '../../views/settings/groups/Layout'
import BasicInformation from '../../views/settings/groups/BasicInformation.vue'
import ContactInformation from '../../views/settings/groups/ContactInformation.vue'
import SideBanner from '../../views/settings/groups/SideBanner.vue'
import WebsiteColors from '../../views/settings/groups/WebsiteColors.vue'
import AboutUs from '../../views/settings/groups/AboutUs.vue'
import SeoInformation from '../../views/settings/groups/SeoInformation.vue'
import Policy from '../../views/settings/groups/Policy.vue'
import PaymentAccount from '../../views/settings/groups/PaymentAccount.vue'
import DeliveryCost from '../../views/settings/groups/DeliveryCost.vue'
import DiscountOnTotal from '../../views/settings/groups/DiscountOnTotal.vue'

const kebabize = str => {
    return str.split('').map((letter, idx) => {
      return letter.toUpperCase() === letter
       ? `${idx !== 0 ? '-' : ''}${letter.toLowerCase()}`
       : letter;
    }).join('');
}
export default {
    path: 'setting',
    component: settingLayout,
    children: [{
            path: '',
            name: 'settingProfile',
            component: settingProfile,
        },
        {
            path: 'password',
            name: 'settingPassword',
            component: settingPassword,
        },
        {
            path: '',
            component: settingGroupLayout,
            children: [
                {
                    path: kebabize("BasicInformation"),
                    name: "BasicInformation",
                    component: BasicInformation,
                },
                {
                    path: kebabize("ContactInformation"),
                    name: "ContactInformation",
                    component: ContactInformation,
                },
                {
                    path: kebabize("SideBanner"),
                    name: "SideBanner",
                    component: SideBanner,
                },
                {
                    path: kebabize("WebsiteColors"),
                    name: "WebsiteColors",
                    component: WebsiteColors,
                },
                {
                    path: kebabize("AboutUs"),
                    name: "AboutUs",
                    component: AboutUs,
                },
                {
                    path: kebabize("SeoInformation"),
                    name: "SeoInformation",
                    component: SeoInformation,
                },
                {
                    path: kebabize("Policy"),
                    name: "Policy",
                    component: Policy,
                },
                {
                    path: kebabize("PaymentAccount"),
                    name: "PaymentAccount",
                    component: PaymentAccount,
                },
                {
                    path: kebabize("DeliveryCost"),
                    name: "DeliveryCost",
                    component: DeliveryCost,
                },
                {
                    path: kebabize("DiscountOnTotal"),
                    name: "DiscountOnTotal",
                    component: DiscountOnTotal,
                },
            ]
        },
        // {
        //     path: 'details/:id',
        //     name: 'chapterDetails',
        //     component: chapterDetails,
        // },
    ],
};
