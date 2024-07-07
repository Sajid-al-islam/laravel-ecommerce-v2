import Layout from '../../views/coupon/Layout'
import AllCoupon from '../../views/coupon/All'
import CreateCoupon from '../../views/coupon/Create'
import EditCoupon from '../../views/coupon/Edit'
import DetailsCoupon from '../../views/coupon/Details'
import ImportCoupon from '../../views/coupon/Import'

export default {
    path: 'coupon',
    component: Layout,
    props: {
        role_permissions: ['super_admin','admin'],
        layout_title: 'Coupon Management',
    },
    children: [{
            path: '',
            name: 'AllCoupon',
            component: AllCoupon,
        },
        {
            path: 'import',
            name: 'ImportCoupon',
            component: ImportCoupon,
        },
        {
            path: 'create',
            name: 'CreateCoupon',
            component: CreateCoupon,
        },
        {
            path: 'edit/:id',
            name: 'EditCoupon',
            component: EditCoupon,
        },
        {
            path: 'details/:id',
            name: 'DetailsCoupon',
            component: DetailsCoupon,
        },
    ],

};
