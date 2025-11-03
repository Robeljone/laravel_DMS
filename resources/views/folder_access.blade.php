@include("./includes/header")
@include('./includes/sidebar')
<div class="p-4 sm:ml-64 overflow-x-auto dark:text-white">
<div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
</br>
<div id="failalert" class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 hidden" role="alert">
  <span class="font-medium">Error!</span><h2 id="error"></h2>
</div>
<div id="okalert" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 hidden" role="alert">
  <span class="font-medium">Success !</span><h2 id="success">Record saved</h2>
</div>
<h2>📁 Folder Access Control</h2>
</br>
<div >
      <ul id="folder-tree"> 
          @foreach($folders as $folder)
              @include('partial_node', ['folder' => $folder])
          @endforeach
      </ul>
</div>
</div>
</br>
<form id="update">
@csrf
<input type="hidden" name="user_id" id="user_id" value="{{$user_id}}"/>
<button type="submit"  class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
Update
</button>
</form>
</div>
@include('./includes/footer')