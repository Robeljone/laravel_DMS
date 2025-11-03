$(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $("#loginfrm").submit(function (event) {
        event.preventDefault();
        var form = document.getElementById("loginfrm");
        var formData = new FormData(form);
        $.ajaxSetup({
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Csrf-Token", csrfToken);
            },
        });
        $.ajax({
            url: "/login",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
            const okalert = document.getElementById('okalert');
            okalert.classList.remove('hidden');
            setTimeout(function() {
            okalert.classList.add('hidden');
            }, 3000);
            window.location.href='dashboard';
            },
            error: function (response) {
            console.log(response);
            const erroralert = document.getElementById('failalert');
            erroralert.classList.remove('hidden');
            setTimeout(function() {
                erroralert.classList.add('hidden');
            }, 3000);
            },
        });
    });
});
