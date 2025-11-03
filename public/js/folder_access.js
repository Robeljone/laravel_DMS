$(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.folder-label').forEach(label => {
        label.addEventListener('click', function (e) {
            console.log("Sample");
            // Prevent checkbox click from toggling unintentionally
            // if (e.target.tagName.toLowerCase() === 'input') return;

            const subfolder = this.parentElement.querySelector('ul.subfolders');
            const icon = this.querySelector('.toggle-icon');

            if (subfolder) {
                const isVisible = subfolder.style.display === 'block';
                subfolder.style.display = isVisible ? 'none' : 'block';
                icon.textContent = isVisible ? '+' : '−';
            }
        });
    });
});
});