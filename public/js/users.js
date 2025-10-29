$(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $("#userfrm").submit(function (event) {
        event.preventDefault();
        var form = document.getElementById("userfrm");
        var formData = new FormData(form);
        $.ajaxSetup({
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Csrf-Token", csrfToken);
            },
        });
        $.ajax({
            url: "/newUser",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                alert("Form Created");
                window.location.reload();
            },
            error: function (xhr, status, error) {
                alert("Your form was not sent successfully.");
            },
        });
    });
});
