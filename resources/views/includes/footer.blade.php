<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script>
 if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    const dataTable = new simpleDatatables.DataTable("#search-table", {
        searchable: true,
        sortable: false,
        paging: true,
        perPage: 5,
        perPageSelect: [5, 10, 15, 20, 25],
    });
 }
  if (document.getElementById("user-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    const dataTable = new simpleDatatables.DataTable("#user-table", {
        searchable: true,
        sortable: false,
        paging: true,
        perPage: 5,
        perPageSelect: [5, 10, 15, 20, 25],
    });
 }
</script>
<script>
  document.getElementById('searchInput').addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase();
    document.querySelectorAll('.folder-item, .file-item').forEach(item => {
      const name = item.querySelector('p').innerText.toLowerCase();
      item.style.display = name.includes(term) ? '' : 'none';
    });
  });
</script>
<script>
 var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
 var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

 // Change the icons inside the button based on previous settings
 if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    themeToggleLightIcon.classList.remove('hidden');
 } else {
    themeToggleDarkIcon.classList.remove('hidden');
 }

 var themeToggleBtn = document.getElementById('theme-toggle');

 themeToggleBtn.addEventListener('click', function() 
 {

    // toggle icons inside button`
    themeToggleDarkIcon.classList.toggle('hidden');
    themeToggleLightIcon.classList.toggle('hidden');

    // if set via local storage previously
    if (localStorage.getItem('color-theme')) 
    {
        if (localStorage.getItem('color-theme') === 'light') 
        {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }

    // if NOT set via local storage previously
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('light');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }
    
 });
</script>    
<script src="{{ asset('js/folder.js') }}"></script>
<script src="{{ asset('js/users.js') }}"></script>
</body>
</html>