(function ($) {
    "use strict";

    // Scroll Top Hide Show
    var varWindow = $(window);
    varWindow.on('scroll', function () {
        if ($(this).scrollTop() > 250) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });

    //Scroll To Top Animate

})(window.jQuery);

function got_to_top() {
    $('html, body').animate({
        scrollTop: 0
    }, 200);
};


function slider_reboot() {
    $('.owl-carousel').off().owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        nav: false,
        items: 1,
    })
}

var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

window.s_alert = (icon = "success", title = "success") => {
    return Toast.fire({
        icon,
        title
    })
};

window.c_alert = async (icon = "question", title = "Are you sure?", text = '') => {
    let confirm = await Swal.fire({
        title,
        text,
        icon,
        showCancelButton: true,
        confirmButtonText: 'Yes, do it!',
        confirmButtonColor: 'rgba(0,0,0,0)',
        cancelButtonColor: 'rgba(0,0,0,0)',
        customClass: {
            confirmButton: 'btn btn-outline-success',
            cancelButton: 'btn btn-outline-danger'
        },
    })
    if (confirm.isConfirmed) {
        return true;
    } else if (confirm.isDismissed) {
        return false
    }
};

var top_product_page = 1;
async function load_top_products(page = 1) {
    var home_top_products = document.getElementById('home_top_products');
    var top_product_load_btn = document.querySelector('.top_product_load_btn');

    if (home_top_products) {
        top_product_load_btn.disabled = true;
        await fetch(`/api/v1/top-products?page=${page}`)
            .then(res => res.json())
            .then(res => home_top_products.innerHTML += res.data);
        top_product_page = page + 1;
        top_product_load_btn.disabled = false;
    }
}

async function load_category_product() {
    let category_products_paginations = document.getElementById('category_products_paginations');
    let category_product_list = document.getElementById('category_product_list');
    let url = new URL(location.href);
    if (!url.searchParams.get('page')) {
        url.searchParams.set('page', 1);
    }
    await fetch(`/api/v1` + url.pathname + "?" + url.searchParams.toString())
        .then(res => res.json())
        .then(res => {
            category_products_paginations.innerHTML = res.links;
            category_product_list.innerHTML = res.products;
            init_pagination_active();
        });
}

async function load_category_product_brands(category_id) {
    let brand_list = document.getElementById('brand_list');
    let url = new URL(location.href);
    await fetch(`/api/v1/category-products/${category_id}/brands?` + url.searchParams.toString())
        .then(res => res.json())
        .then(res => {
            brand_list.innerHTML = res.data;
        });
}

function init_pagination_active() {
    [...document.querySelectorAll('#category_products_paginations a')].forEach((el) => {
        el.onclick = function (e) {
            e.preventDefault();
            var url = new URL(e.target.href);
            window.history.pushState({ path: url.href }, '', url.href);
            load_category_product();
            window.scrollTo(0, category_product_list.offsetTop - 120)
        }
    })
}


async function search_prodcut() {
    let key = event?.target.value;
    let search_result = document.getElementById('search_result');

    search_result.innerHTML = "";
    if (key) {
        await fetch(`/api/v1/search-products`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({key})
        })
            .then(res => res.text())
            .then(res => {
                search_result.innerHTML = res;
            });
    }
}
