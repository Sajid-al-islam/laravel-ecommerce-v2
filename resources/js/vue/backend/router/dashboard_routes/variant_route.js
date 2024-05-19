import Layout from '../../views/variant/Layout'
import AllVariant from '../../views/variant/All'
import CreateVariant from '../../views/variant/Create'
import EditVariant from '../../views/variant/Edit'
import DetailsVariant from '../../views/variant/Details'
import ImportVariant from '../../views/variant/Import'
import Values from '../../views/variant/Values'

export default {
    path: 'variant',
    component: Layout,
    props: {
        role_permissions: ['super_admin','admin'],
        layout_title: 'Variant Management',
    },
    children: [{
            path: '',
            name: 'AllVariant',
            component: AllVariant ,
        },
        {
            path: 'import',
            name: 'ImportVariant',
            component: ImportVariant ,
        },
        {
            path: 'create',
            name: 'CreateVariant',
            component: CreateVariant ,
        },
        {
            path: 'values',
            name: 'VariantValues',
            component: Values ,
        },
        {
            path: 'edit/:id',
            name: 'EditVariant',
            component: EditVariant ,
        },
        {
            path: 'details/:id',
            name: 'DetailsVariant',
            component: DetailsVariant ,
        },
    ],

};