function ReviewFunctions() {
    // $("#login_modal").addClass('d-none');
    $("#website_register").off().hide();
    $("#register_btn_link").off().click(function () {
        $("#website_login").hide();
        $("#website_register").show();
    });

    $("#login_btn_link").off().click(function () {
        $("#website_login").show();
        $("#website_register").hide();
    });

    // login();
    // register();
    // reviewSubmit();
    // $("#login_modal").addClass('d-none');
}

ReviewFunctions();

function login() {
    event.preventDefault();
    let formData = new FormData(event.target);

    fetch("/website_login", {
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
        console.log(res);
        if(res.status === 422) {
            error_response(res.data)
        }
        if(res.status === 401) {
            $("#login_modal").click();
        }
        if(res.status === 200) {
            $("#login_modal_close").click();
            reviewSubmit();
        }
    })
}

function register() {
    event.preventDefault();

    let formData = new FormData(event.target);

    fetch("/website_register", {
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
        console.log(res);
        if(res.status === 422) {
            error_response(res.data)
        }
        if(res.status === 401) {
            $("#login_modal").click();
        }
        if(res.status === 200) {
            $("#login_modal_close").click();
            reviewSubmit();
        }
    })
}

function reviewSubmit() {
    event?.preventDefault();
    let formData = new FormData($("#review-form")[0]);

    fetch("/review-submit", {
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
        if(res.status === 422) {
            error_response(res.data)
        }
        if(res.status === 401) {
            $("#login_modal").click();
        }
        if(res.status === 200) {
            window.s_alert("success", "Review created successfully");
            document.getElementById("review_description").value = "";
        }
    })
}

function remove_review(id) {
    let e = event.currentTarget;
    if(!confirm('remove review')){
        return 0;
    }
    fetch("/review-remove", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Content-Type": "application/json",
        },
        body: JSON.stringify({id}),
    }).then(async res => {
        let response = {}
        response.status = res.status
        response.data = await res.json();
        return response;
    }).then(res => {
        if(res.status === 200) {
            window.s_alert("success", "Review removed successfully");
            e.parentNode.remove();
        }
    })
}

const error_response = ({data})=>{
    console.log(data);
    $('.loader_body').removeClass('active');
    $('form button').prop('disabled',false);
    $('#backend_body .main_content').css({overflowY:'scroll'});
    // whatever you want to do with the error
    // console.log(error.response.data.errors);
    $(`label`).siblings(".text-danger").remove();
    $(`select`).siblings(".text-danger").remove();
    $(`input`).siblings(".text-danger").remove();
    $(`textarea`).siblings(".text-danger").remove();
    $('.form_errors').html('');

    let error_html = ``;

    for (const key in data) {
        if (Object.hasOwnProperty.call(data, key)) {
            const element = data[key];
            if (document.getElementById(`${key}`)) {
                $(`#${key}`)
                    .parent("div")
                    .append(`<div class="text-danger">${element[0]}</div>`);
            } else {
                $(`input[name="${key}"]`)
                    .parent("div")
                    .append(`<div class="text-danger">${element[0]}</div>`);

                $(`select[name="${key}"]`)
                    .parent("div")
                    .append(`<div class="text-danger">${element[0]}</div>`);

                $(`input[name="${key}"]`).trigger("focus");

                $(`textarea[name="${key}"]`)
                    .parent("div")
                    .append(`<div class="text-danger">${element[0]}</div>`);

                $(`textarea[name="${key}"]`).trigger("focus");
            }
            // console.log({
            //     [key]: element,
            // });

            error_html += `
                <div class="alert alert_${key} my-1 mx-2 alert-danger pe-5 inverse alert-dismissible fade show" role="alert">
                    <i class="icon-alert txt-dark rounded-0"></i>
                    <div>${element}</div>
                    <button type="button" class="btn-close txt-light" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
            `;
        }
    }

    $('.form_errors').html(error_html);

    if (typeof data === "string") {
        // console.log("error", data);
    } else {
        // console.log(data);
    }

    window.s_alert('error',"check errors below.")
}

window.render_error = error_response;
