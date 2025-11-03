$(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $("#rolefrm").submit(function (event) {
        event.preventDefault();
        var form = document.getElementById("rolefrm");
        var formData = new FormData(form);
        $.ajaxSetup({
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Csrf-Token", csrfToken);
            },
        });
        $.ajax({
            url: "/newRole",
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
                window.location.reload();
            },
            error: function (response) {
            const erroralert = document.getElementById('failalert');
            erroralert.classList.remove('hidden');
            const headingElement = document.getElementById('error');
            headingElement.textContent = response?.responseJSON?.error;
            setTimeout(function() {
                erroralert.classList.add('hidden');
            }, 3000);
            },
        });
    });
});
