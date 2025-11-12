$(document).ready(function () {
    document.getElementById('searchInput').addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase();
    document.querySelectorAll('.folder-item, .file-item').forEach(item => {
      const name = item.querySelector('p').innerText.toLowerCase();
      item.style.display = name.includes(term) ? '' : 'none';
    });
  });
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $("#folderForm").submit(function (event) {
        event.preventDefault();
        var form = document.getElementById("folderForm");
        var formData = new FormData(form);
        $.ajaxSetup({
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Csrf-Token", csrfToken);
            },
        });
        $.ajax({
            url: "/newFolder",
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
    $("#fileForm").submit(function (event) {
        event.preventDefault();
        var form = document.getElementById("fileForm");
        var formData = new FormData(form);
        $.ajax({
            url: "/newFile",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                alert("Form Created");
                window.location.reload();
            },
            error: function (errors) {
                alert(errors.file);
            },
        });
    });
});
