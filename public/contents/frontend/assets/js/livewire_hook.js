// document.addEventListener("DOMContentLoaded", () => {
//     Livewire.hook("component.initialized", component => {
//         // console.log('component.initialized');
//     });
//     Livewire.hook("element.initialized", (el, component) => {
//         // console.log('element.initialized');
//     });
//     Livewire.hook("element.updating", (fromEl, toEl, component) => {
//         // console.log('element.updating');
//         if (window.dom_load_navigating) {
//             // console.log('element.updated');
//             let old_el = component.el.firstElementChild.id;
//             old_el = document.getElementById(old_el);
//             let parent = old_el.parentNode;
//             let updated_el = component.el.innerHTML;

//             // old_el.remove();

//             // document.getElementById(old_el).parentNode.innerHTML =
//             //     component.el.innerHTML;
//             // console.log(old_el, component.el.innerHTML, component);
//             console.log(old_el);
//             console.log(parent.innerHTML);
//             console.log(updated_el);
//         }
//     });
//     Livewire.hook("element.updated", (el, component) => {

//     });
//     Livewire.hook("element.removed", (el, component) => { });
//     Livewire.hook("message.sent", (message, component) => { });
//     Livewire.hook("message.failed", (message, component) => { });
//     Livewire.hook('message.received', (message, component) => {
//         find_event_status(message);
//         let access_token = message.response.serverMemo.data?.access_token;
//         if (access_token) {
//             window.localStorage.setItem('token', access_token);
//             window.location.href = "/admin";
//         }
//     })
//     Livewire.hook("message.processed", (message, component) => { });
//     Livewire.on("cartAdded", () => {
//         document.querySelector(".modal-backdrop")?.classList.add("d-none");
//         window.s_alert("success", "Product Added to cart successfully.");
//     });
//     Livewire.on("test", () => {
//         window.s_alert("success", "test");
//     });
//     Livewire.on("cartRemoved", () => {
//         window.s_alert("success", "Product Removed from cart.");
//     });
//     Livewire.on("cartUpdated", () => {
//         window.s_alert("success", "Cart Updated.");
//     });
// });
function showModal(product) {
    Livewire.emit("viewProduct", product);

    setTimeout(() => {
        document.querySelector("body").classList.add("modal-open");
        document.querySelector("body").style.overflow = "hidden";
        document.querySelector("body").style.paddingRight = "17px";
        document.querySelector("#action-QuickViewModal").classList.add("show");
        document
            .querySelector("#action-QuickViewModal")
            .classList.add("d-block");
        document.querySelector(".modal-backdrop").classList.remove("d-none");
        // document.querySelector('#closeModalbutton').addEventListener('click', closeModal);
    }, 500);
}

function showQuickView(product) {
    fetch("/product_quickview/" + product, {
        method: "get"
    })
        .then(res => {
            return res.text();
        })
        .then(res => {
            document.getElementById("quick_view_product_modal").innerHTML = res;
        });
}

window.dom_load_count = 1;
window.dom_load_navigating = false;
window.slider_started = false;
window.banner_started = false;


document.addEventListener("turbolinks:load", function (event) {
    if (window.dom_load_count > 1 && !window.dom_load_navigating) {
        // window.location.reload();
        console.log("reload", window.dom_load_count);
    }

    let path_name = location.pathname;
    if (path_name == '/') {
        load_top_products(1);
        slider_reboot();
    }
    if (path_name.includes('category')) {
        var category_id = path_name.split('/')[2];
        load_category_product(category_id);
        load_category_product_brands(category_id);
    }

    window.dom_load_count++;

});

var find_event_status = message => {
    // console.log(message);
    let data = message.response.serverMemo.data;
    let status = message.response.serverMemo.data?.status_message;
    console.log(data.message);
    if(data.message === 'cart_added') {
        window.s_alert("success", "Product added to cart.");
    }
    if (status === "cartRemoved") {
        update_cart_count_html(data.cart_amount);
    }
};


