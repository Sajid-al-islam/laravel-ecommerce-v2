let selected_size = null;



async function addToCart(product_id, qty = 1, show_toast = true) {
    if (!selected_size && location.pathname !== "/cart") {
        window.s_alert("warning", "no size is selected");
        return 0;
    }
    await fetch("/add_to_cart", {
        method: "POST",
        headers: {
            "content-type": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify({
            id: product_id,
            qty: qty,
            size: selected_size,
        })
    }).then(async res => {
        selected_size = null;
        let response = {}
        response.status = res.status
        response.data = await res.json();
        return response;
    }).then(res => {
        if (res.status === 200) {
            let product = res.data.cart.find(i => i.product.id == product_id);
            if (product) {
                $(`#${product_id}_cart_total`).html(product.price * product.qty);
            }
            $(".header_cart_count").html(res.data.cart_count);
            $("#cart_total").html(res.data.cart_total_formated);

            if (show_toast) {
                window.s_alert("success", res.data.message);
            }

            if(fb_add_to_cart && typeof fb_add_to_cart == 'function'){
                fb_add_to_cart();
            }
        }
    })
}

function removeCart(product_id) {
    confirm("remove item") &&
        fetch("/remove_cart", {
            method: "POST",
            headers: {
                "content-type": "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                id: product_id
            })
        }).then(async res => {
            let response = {}
            response.status = res.status
            response.data = await res.json();
            return response;
        }).then(res => {
            if (res.status === 200) {
                selected_size = null;
                $(`#${product_id}_row`).remove();
                $(".header_cart_count").html(res.data.cart_count);
                $("#cart_total").html(res.data.cart_total_formated);
                window.s_alert("success", res.data.message);
            }
        })
}

async function buy_now(product_id, qty) {
    // if (!selected_size) {
    //     window.s_alert("warning", "no size is selected");
    //     return 0;
    // }
    await addToCart(product_id, qty, false);
    location.href = "/checkout";
}

function convertDigitsToBengali(number) {
    const englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

    return number.toString().split('').map(function(digit) {
        const index = englishDigits.indexOf(digit);
        return index !== -1 ? bengaliDigits[index] : digit;
    }).join('');
}


function select_size(size) {
    let size_obj = JSON.parse(size);
    $(".product_size ul li").removeClass('active');
    $(event.target).addClass('active');
    selected_size = size_obj.product_variant_value_id;
    let html = `${convertDigitsToBengali(size_obj.variant_price)} ৳`
    $(`#variant_price_set`).html(html);
}

function up_qty(type = "inc", product_id = "") {
    let el = "";
    let qty = 1;

    if (type == "inc") {
        el = event.currentTarget.previousElementSibling;
        qty = +el.value + 1;
    } else {
        el = event.currentTarget.nextElementSibling;
        qty = +el.value - 1;
    }

    if (qty >= 1) {
        el.value = qty;
        addToCart(product_id, qty);
    }
}

function quick_view_add_to_cart(product_id) {
    Livewire.emit('viewProduct', product);
}

async function checkout(event) {
    event.preventDefault();

    // if (!confirm('complete order')) {
    //     return 0;
    // }

    let formData = new FormData(event.target);
    // let city = ``;
    // city += 'division: '+window.divisions.find(i=>i.id == $('#divisions').val()).name;
    // city += ', district: '+window.districts.find(i=>i.id == $('#districts').val()).name;
    // city += ', upazila: '+window.upazilas.find(i=>i.id == $('#upazilas').val()).name;
    // city += ', union: '+window.unions.find(i=>i.id == $('#unions').val()).name;
    // if($('#police_stations').val()){
    //     city += ', police station: ' + $('#police_stations').val();
    // }
    // city += ', area: ' + ($('input[name="address"]').val() || '');
    // formData.append('city', city);
    formData.append('shipping_method', $("input[name='shipping_method']:checked").val());

    await fetch("/checkout", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: formData
    }).then(async res => {
        let response = {}
        response.status = res.status
        response.data = await res.json();
        return response;
    }).then(res => {
        if (res.status === 422) {
            error_response(res.data)
        }
        if (res.status === 200) {
            if(fb_purchase && typeof fb_purchase == 'function'){
                fb_purchase();
            }
            location.href = "/order-complete/" + res.data.order.id;
        }
    })
}

async function updateCart(product_id, delivery_cost=0) {
    // await fetch(`/update-cart-html/${product_id}`, {
    //     method: "GET",
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    // }).then(async res => {
    //     let response = {}
    //     response.status = res.status
    //     response.data = await res.json();
    //     return response;
    // }).then(res => {
    //     if (res.status === 422) {
    //         error_response(res.data)
    //     }
    //     if (res.status === 200) {
    //         $('#cart_section').html(res.data);
    //     }
    // })
    $('#landing_page_product_id').val(product_id);
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: `/update-cart-html`,
        type: 'POST',
        dataType: 'json',
        data: {
            // Add any data you need to send here
            _token: csrfToken,  // Add CSRF token for security
            product_id: product_id,  // Example data
            delivery_cost: delivery_cost
        },
        success: function(data) {
            console.log('success', data);
            $('#cart_section').html(data.result);
        }
    });
}

function change_bkash() {
    $('#bkash_section').removeClass('d-none');
    $('#bank_section').addClass('d-none');
    $('#bkash_number').attr('required');
    $('#bkash_trx_id').attr('required');
}

function change_bank_transfer() {
    $('#bkash_section').addClass('d-none');
    $('#bank_section').removeClass('d-none');
    $('#bank_ac_no').attr('required');
    $('#bank_trx_no').attr('required');
}

function change_cod() {
    $('#bkash_section').addClass('d-none');
    $('#bank_section').addClass('d-none');
}

window.divisions = [];
window.districts = [];
window.upazilas = [];
window.unions = [];
window.police_stations = [];
window.checkout_info = {};

async function load_data(type) {
    var res = await fetch(`/jsons/${type}.json`)
    var data = await res.json();
    if(Array.isArray(data)){
        data = data?.map(i => ({ ...i, text: i.name }))
    }
    window[type] = data;
}

function set_checkout_info() {
    let info = localStorage.getItem('checkout_info');
    if(!info){
        info = {};
    }else{
        info = JSON.parse(info);
    }
    if(event && event.target){
        info[event.target.name] = event.target.value;
        localStorage.setItem('checkout_info', JSON.stringify(info));
    }
}
function load_checkout_info(){
    let info = localStorage.getItem('checkout_info');
    if(info){
        window.checkout_info = info = JSON.parse(info);
        for (const key in info) {
            if (Object.hasOwnProperty.call(info, key)) {
                const element = info[key];
                let el = document.querySelector(`[name="${key}"]`);
                if(el){
                    el.value = element;
                }
            }
        }
    }
}

async function init_division() {
    await load_data('divisions');
    await load_data('districts');
    await load_data('upazilas');
    await load_data('unions');
    await load_data('police_stations');
    await load_checkout_info();
    setTimeout(() => {
        get_divisions();
    }, 200);
}

async function get_divisions() {
    var data = window.divisions;
    $('#divisions').select2({
        data,
    })
        .val([6]).trigger('change')
        .on('select2:select', function (e) {
            let value = e.target.value;
            get_districts(value);
            if (value != 6) {
                $('#home_delivery').prop('checked', false);
                $('#outside_dhaka').prop('checked', true);
                $('#outside_dhaka').trigger('change');
            } else {
                $('#outside_dhaka').prop('checked', false);
                $('#home_delivery').prop('checked', true);
                $('#home_delivery').trigger('change');
            }

        });
    get_districts();
}

async function get_districts(divistion = 6) {
    var data = window.districts.filter(i => i.division_id == divistion);
    data = data.map(i => ({ ...i, text: i.name }));

    $('#districts').html('').select2().select2("destroy");
    $('#districts').select2({
        data,
    })
        .val([data[7]?.id || data[0].id]).trigger('change')
        .on('select2:select', function (e) {
            let value = e.target.value;
            // console.log(value);
            // get_upazilas(value);
            get_police_stations(data.find(i=>i.id==value)?.name || '');

            if (value != 47) {
                $('#home_delivery').prop('checked', false);
                $('#outside_dhaka').prop('checked', true);
                $('#outside_dhaka').trigger('change');
            } else {
                $('#outside_dhaka').prop('checked', false);
                $('#home_delivery').prop('checked', true);
                $('#home_delivery').trigger('change');
            }
        });
    // get_upazilas(data[7]?.id || data[0].id);
    get_police_stations(data[7]?.name || data[0].name);
}

async function get_police_stations(district_name) {
    var data = [];
    for (const key in window.police_stations) {
        if (Object.hasOwnProperty.call(window.police_stations, key)) {
            const stations = window.police_stations[key];
            if(key.includes(district_name)){
                data = stations
            }
        }
    }
    data = data.map(i => ({ id: i, text: i }));
    if(data.length == 0){
        data[0] = {id: "Enter police station name", text: "Enter police station name"}
    }

    $('#police_stations').html('').select2().select2("destroy");
    $('#police_stations').select2({
        data,
        tags: true,
    })
        .val([data[0]?.id]).trigger('change')
        .on('select2:select', function (e) {
            let value = e.target.value;
            console.log(value);
        });
}

async function get_upazilas(district = 1) {
    var data = window.upazilas.filter(i => i.district_id == district);
    data = data.map(i => ({ ...i, text: i.bn_name }))

    $('#upazilas').html('').select2().select2("destroy");
    $('#upazilas').select2({
        data,
    })
        .val([data[0].id]).trigger('change')
        .on('select2:select', function (e) {
            let value = e.target.value;
            get_unions(value);
        });
    get_unions(data[0].id)
}

async function get_unions(upazila = 1) {
    var data = window.unions.filter(i => i.upazilla_id == upazila);
    data = data.map(i => ({ ...i, text: i.bn_name }))

    $('#unions').html('').select2().select2("destroy");
    $('#unions').select2({
        data,
    })
        .val([data[0].id]).trigger('change')
        .on('select2:select', function (e) {
            let value = e.target.value;
        });
}

var finalEnlishToBanglaNumber={'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};

String.prototype.getDigitBanglaFromEnglish = function() {
    var retStr = this;
    for (var x in finalEnlishToBanglaNumber) {
         retStr = retStr.replace(new RegExp(x, 'g'), finalEnlishToBanglaNumber[x]);
    }
    return retStr;
};
