// state list
const state = {
    company_info: {
        'company_name': "Premium Fruit Shop",
        'address': [
            {
                "building": "",
                "lane": "",
                "shop": "",
                "area": "Mirpur 11",
                "division": "Dhaka",
            }
        ],
        'mobile_no': [
            '01568-095982'
        ],
        'email': 'fazlulah8@gmail.com'
    },
};

// get state
const getters = {
    get_company_info: state => state.company_info,
};

// actions

const actions = {

}

// mutators
const mutations = {

};


export default {
    state,
    getters,
    actions,
    mutations,
};
