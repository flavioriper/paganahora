function uploadImage(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            uploadAjax(e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function uploadAjax(base64) {
    let url = window.location.origin + "/upload";
    let token = document.head.querySelector('meta[name="csrf-token"]');
    let settings = {
        "url": url,
        "method": "POST",
        "timeout": 0,
        "headers": {
            "X-CSRF-TOKEN": token.content,
            "Content-Type": "application/json"
        },
        "data": JSON.stringify({
            "file": base64,
        }),
    };

    $.ajax(settings).done(function (response) {
        window.location.reload();
    });
}