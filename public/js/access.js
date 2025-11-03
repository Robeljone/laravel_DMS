$(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
     const $tableWrapper = $('.overflow-x-auto');
    
    // Add loader HTML dynamically
    const loader = $('<div id="table-loader" class="absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center rounded-lg hidden z-50">\
        <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>\
    </div>');
    $tableWrapper.css('position', 'relative').append(loader);
    $('.permission-checkbox').on('change', function() {
        
        const roleId = $(this).data('role');
        const permissionId = $(this).data('permission');
        const checked = $(this).is(':checked');

        $tableWrapper.addClass('pointer-events-none opacity-50');
        $('#table-loader').removeClass('hidden');

        $.ajax({
            url: "/updateAccess",
            method: "POST",
            data: {
                _token: csrfToken,
                role_id: roleId,
                permission_id: permissionId,
                checked: checked
            },
            success: function(response) {
            const okalert = document.getElementById('okalert');
            okalert.classList.remove('hidden');
            setTimeout(function() {
            okalert.classList.add('hidden');
            $tableWrapper.removeClass('pointer-events-none opacity-50');
            $('#table-loader').addClass('hidden');
            }, 1000);
            },
            error: function(xhr) {
            const erroralert = document.getElementById('failalert');
            erroralert.classList.remove('hidden');
            const headingElement = document.getElementById('error');
            headingElement.textContent = response?.responseJSON?.error;
            setTimeout(function() {
                erroralert.classList.add('hidden');
                $tableWrapper.removeClass('pointer-events-none opacity-50');
                $('#table-loader').addClass('hidden');
            }, 1000);
            }
        });
    });
});