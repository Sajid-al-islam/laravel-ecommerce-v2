import Layout from '../../views/landing_page/Layout'
import AllLandingPage from '../../views/landing_page/All'
import CreateLandingPage from '../../views/landing_page/Create'
import EditLandingPage from '../../views/landing_page/Edit'
import DetailsLandingPage from '../../views/landing_page/Details'
import ImportLandingPage from '../../views/landing_page/Import'

export default {
    path: 'landing_page',
    component: Layout,
    props: {
        role_permissions: ['super_admin','admin'],
        layout_title: 'Landing Page Management',
    },
    children: [{
            path: '',
            name: 'AllLandingPage',
            component: AllLandingPage ,
        },
        {
            path: 'import',
            name: 'ImportLandingPage',
            component: ImportLandingPage ,
        },
        {
            path: 'create',
            name: 'CreateLandingPage',
            component: CreateLandingPage ,
        },
        {
            path: 'edit/:id',
            name: 'EditLandingPage',
            component: EditLandingPage ,
        },
        {
            path: 'details/:id',
            name: 'DetailsLandingPage',
            component: DetailsLandingPage ,
        },
    ],

};
