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
<form class="max-w-ls mx-auto" id="userfrm">
   @csrf
  <div class="mb-5">
    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
    <input type="email" name="email" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light" placeholder="name@flowbite.com" required />
  </div>
  <div class="mb-5">
    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
    <input type="password" name="password" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light" required />
  </div>
  <div class="mb-5">
    <label for="repeat-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Full Name</label>
    <input type="text" name="fname" class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light" required />
  </div>
  <div class="mb-5">
  <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
  <select name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    <option selected>Choose a role</option>
    @foreach($roles as $role)
    <option value="{{$role->name}}">{{$role->name}}</option>
    @endforeach
  </select>
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
                  Email Address
                </span>
            </th>
            <th>
                <span class="flex items-center">
                  Roles
                </span>
            </th>
            <th>
                <span class="flex items-center">
                  Permissions
                </span>
            </th>
            <th>
               <span class="flex items-center">
                    Created_at
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
      @foreach($users as $us)
        <tr>
            <td>{{$loop->index+1}}</td>
            <td>{{$us['name']}}</td>
            <td>{{$us['email']}}</td>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
              @foreach($us['roles'] as $id=>$name)
<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-green-400 border border-green-400">{{$name}}</span>
              @endforeach
            </td>
            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
            <div class="grid grid-cols-3 gap-4">
             @foreach($us['permissions'] as $name)
              <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">
              {{$name}}</span>
             @endforeach
            </div>
            </td>
            <td>{{$us['created_at']}}</td>
            <td>
            <a href="fld_access/{{$us['id']}}">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 8H4m8 3.5v5M9.5 14h5M4 6v13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-5.032a1 1 0 0 1-.768-.36l-1.9-2.28a1 1 0 0 0-.768-.36H5a1 1 0 0 0-1 1Z"/>
</svg>
</a>
            </td>
        </tr>
      @endforeach
    </tbody>
</table>
</div>
   </div>
</div>
@include('./includes/footer')