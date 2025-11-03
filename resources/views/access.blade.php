@include("./includes/header")
@include('./includes/sidebar')
<div class="p-4 sm:ml-64">
<div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
</br>
<div id="failalert" class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 hidden" role="alert">
  <span class="font-medium">Error!</span><h2 id="error"></h2>
</div>
<div id="okalert" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 hidden" role="alert">
  <span class="font-medium">Success !</span><h2 id="success">Record saved</h2>
</div>
<div style="overflow-x: auto;">
<div class="p-6">
  <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-white">Access Management</h2>
  <div class="overflow-x-auto rounded-lg shadow">
    <table class="min-w-full border-collapse bg-white dark:bg-dark rounded-lg overflow-hidden dark:text-white">
      <thead class="text-black">
        <tr>
          <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Role</th>
          @foreach($permission as $header)
            <th class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">
              {{ $header->name }}
            </th>
          @endforeach
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @foreach($roles as $role)
          <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
            <td class="px-6 py-3 font-medium text-gray-700">{{ $role->name }}</td>
            @foreach($permission as $perm)
              <td class="px-4 py-2 text-center">
                <input 
                  type="checkbox" 
                  class="permission-checkbox w-4 h-4 accent-indigo-600 cursor-pointer"
                  data-role="{{ $role->id }}" 
                  data-permission="{{ $perm->id }}"
                  @if(in_array($perm->id, $matrix_role[$role->id])) checked @endif
                >
              </td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
</div>
</div>
</div>
</div>
@include('./includes/footer')