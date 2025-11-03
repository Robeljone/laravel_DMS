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
 document.getElementById("signout").onclick = function () {
        location.href = "logout";
    };
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
<script>
document.addEventListener('DOMContentLoaded',async function () {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    const tree = document.getElementById('folder-tree');
    const user_id = document.getElementById('user_id');
    const selectedFolders = [];

    if (!tree) return;

    let assigned_folders = [];

    try {
        const url = `/getFolders/${user_id.value}`;
        const response = await fetch(url); // your API endpoint
        if (!response.ok) throw new Error('Failed to fetch');
        assigned_folders = await response.json(); // assuming it returns an array of IDs, e.g., [1,3]
    } catch (err) {
        console.error("Error fetching assigned folders:", err);
    }

    tree.querySelectorAll('.folder-checkbox').forEach(cb => {
        const id = parseInt(cb.dataset.id);
        if (assigned_folders.includes(id)) {
            cb.checked = true;           
            selectedFolders.push(id);    
        }
    });

    // 🔹 Function to count subfolders for each parent
    const updateFolderCounts = () => {
        const folders = tree.querySelectorAll('li');
        folders.forEach(li => {
            const nameSpan = li.querySelector('.folder-name');
            if (!nameSpan) return;

            const subfolders = li.querySelectorAll(':scope > ul.subfolders > li');
            const countSpan = li.querySelector('.folder-count');

            if (subfolders.length > 0) {
                if (countSpan) {
                    countSpan.textContent = `(${subfolders.length})`;
                } else {
                    const newCount = document.createElement('span');
                    newCount.classList.add('folder-count');
                    newCount.style.color = '#888';
                    newCount.style.marginLeft = '6px';
                    newCount.textContent = `(${subfolders.length})`;
                    nameSpan.after(newCount);
                }
            } else if (countSpan) {
                countSpan.remove();
            }
        });
    };

    // Run count once when loaded
    updateFolderCounts();

    // 1️⃣ Toggle expand/collapse

    tree.addEventListener('click', function (e) {
        const icon = e.target.closest('.toggle-icon'); // check if the click is on the icon
        if (!icon) return; // ignore clicks elsewhere

        const li = icon.closest('li');
        if (!li) return;

        const sub = li.querySelector(':scope > ul.subfolders');
        if (!sub) return;

        const isHidden = sub.classList.toggle('hidden');
        icon.textContent = isHidden ? '+' : '−';
    });
    // 2️⃣ Checkbox hierarchy logic
    tree.addEventListener('change', function (e) {
        const checkbox = e.target;
        if (!checkbox.classList.contains('folder-checkbox')) return;

        const li = checkbox.closest('li');

        // Toggle all children
        const toggleChildren = (parentLi, checked) => {
            const childCheckboxes = parentLi.querySelectorAll('ul.subfolders .folder-checkbox');
            childCheckboxes.forEach(cb => cb.checked = checked);
        };
        toggleChildren(li, checkbox.checked);

        // Update parent checkboxes
        const updateParents = (childLi) => {
            const parentUl = childLi.parentElement.closest('ul.subfolders');
            if (!parentUl) return;

            const parentLi = parentUl.closest('li');
            if (!parentLi) return;

            const parentCheckbox = parentLi.querySelector(':scope > .folder-label > .folder-checkbox');
            if (!parentCheckbox) return;

            const anyChildChecked = Array.from(parentUl.querySelectorAll('> li > .folder-label > .folder-checkbox')).some(cb => cb.checked);
            parentCheckbox.checked = anyChildChecked;

            updateParents(parentLi);
        };
        updateParents(li);

        // Update selectedFolders array
        const allChecked = tree.querySelectorAll('.folder-checkbox:checked');
        selectedFolders.length = 0;
        allChecked.forEach(cb => selectedFolders.push(cb.dataset.id));
        console.log(selectedFolders);
    });

     $("#update").submit(function (event) {
        event.preventDefault();
        var form = document.getElementById("update");
        var formData = new FormData(form);
        formData.append('selectedFolders', JSON.stringify(selectedFolders));
        $.ajaxSetup({
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Csrf-Token", csrfToken);
            },
        });
        $.ajax({
            url: "/folderAccess",
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
</script>
<script src="{{ asset('js/folder.js') }}"></script>
<script src="{{ asset('js/users.js') }}"></script>
<script src="{{ asset('js/roles.js') }}"></script>
<script src="{{ asset('js/permission.js') }}"></script>
<script src="{{ asset('js/access.js') }}"></script>
</body>
</html>