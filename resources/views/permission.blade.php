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
<form class="max-w-ls mx-auto" id="perfrm">
   @csrf
  <div class="mb-5">
    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prmission</label>
    <input type="text" name="name" autocomplete="off" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light" placeholder="Role Name" required />
  </div>
  <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
</form>
</br>
<div style="overflow-x: auto;">
<table id="user-table" class="dark:text-white">
    <thead>
        <tr>
            <th>
                <span class="flex items-center">
                    SN
                </span>
            </th>
            <th>
                <span class="flex items-center">
                  Name
                </span>
            </th>
            <th>
               <span class="flex items-center">
                    Guard
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Action
                </span>
            </th>
        </tr>
    </thead>
    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
       @foreach($perm as $role)
        <tr>
            <td>{{$loop->index+1}}</td>
            <td>{{$role->name}}</td>
            <td>{{$role->guard_name}}</td>
            <td>Buttons</td>
        </tr>
      @endforeach
    </tbody>
</table>
</div>
   </div>
</div>
@include('./includes/footer')