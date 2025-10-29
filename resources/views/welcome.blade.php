@extends('app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <h1 class="text-2xl font-semibold mb-4 sm:mb-0">📁 Document Manager</h1>
    <input 
      id="searchInput"
      type="text" 
      placeholder="Search files or folders..." 
      class="border rounded-lg px-4 py-2 w-full sm:w-1/3 focus:outline-none focus:ring focus:border-blue-300"
    />
  </div>

  {{-- Breadcrumb --}}
  @if ($breadcrumb ?? false)
    <div class="text-sm text-gray-600 mb-4">
      <a href="{{ route('index') }}" class="text-blue-500 hover:underline">Home</a>
      @foreach ($breadcrumb as $crumb)
        / <a href="{{ route('show', ['dir' => $crumb['path']]) }}" class="text-blue-500 hover:underline">{{ $crumb['name'] }}</a>
      @endforeach
    </div>
  @endif

  {{-- Folder Section --}}
  <h2 class="text-lg font-semibold mb-2">Folders</h2>
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-8">
    @forelse ($directories as $directory)
      <a href="{{ route('show', ['dir' => $directory['path']]) }}" 
         class="folder-item bg-white rounded-xl shadow hover:shadow-md p-4 flex flex-col items-center justify-center transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-yellow-500 mb-2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75v-6a2.25 2.25 0 012.25-2.25h5.25l2.25 2.25h7.5A2.25 2.25 0 0121.75 9v3.75M2.25 12.75h19.5M2.25 12.75v6a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25v-6" />
        </svg>
        <p class="text-center text-sm font-medium text-gray-800 truncate w-full">{{ $directory['name'] }}</p>
      </a>
    @empty
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-yellow-500 mb-2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75v-6a2.25 2.25 0 012.25-2.25h5.25l2.25 2.25h7.5A2.25 2.25 0 0121.75 9v3.75M2.25 12.75h19.5M2.25 12.75v6a2.25 2.25 0 002.25 2.25h15a2.25 2.25 0 002.25-2.25v-6" />
        </svg>
      <p class="text-gray-500 text-sm col-span-full text-center">No folders found.</p>
    @endforelse
  </div>

  {{-- File Section --}}
  <h2 class="text-lg font-semibold mb-2">Files</h2>
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
    @forelse ($files as $file)
      <div class="file-item bg-white rounded-xl shadow hover:shadow-md p-4 flex flex-col items-center justify-center transition">
        @php
          $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        @endphp
        @if (in_array($ext, ['jpg', 'png', 'jpeg', 'gif']))
          <img src="{{ asset('storage/' . $file['path']) }}" class="w-16 h-16 object-cover rounded mb-2" alt="">
        @elseif (in_array($ext, ['pdf']))
          <svg class="w-10 h-10 text-red-500 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-6.75a2.25 2.25 0 00-2.25-2.25h-10.5A2.25 2.25 0 004.5 7.5v9a2.25 2.25 0 002.25 2.25h6.75M14.25 19.5l3-3m0 0l3 3m-3-3v6" />
          </svg>
        @else
          <svg class="w-10 h-10 text-gray-500 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7.5V3.75h6V7.5m-6 0h6m-6 0v12.75h6V7.5M9 20.25h6" />
          </svg>
        @endif
        <p class="text-center text-sm text-gray-800 truncate w-full">{{ $file['name'] }}</p>
      </div>
    @empty
      <p class="text-gray-500 text-sm col-span-full text-center">No files found.</p>
    @endforelse
  </div>
</div>

{{-- Search Script --}}
<script>
  document.getElementById('searchInput').addEventListener('input', function(e) {
    const term = e.target.value.toLowerCase();
    document.querySelectorAll('.folder-item, .file-item').forEach(item => {
      const name = item.querySelector('p').innerText.toLowerCase();
      item.style.display = name.includes(term) ? '' : 'none';
    });
  });
</script>
@endsection
