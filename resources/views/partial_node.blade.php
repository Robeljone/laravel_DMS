<li>
    <div class="grid grid-cols-2 gap-0">
    <div class=""><span class="toggle-icon">+</span></div>
    <div>
    <label class="folder-label">
        <input type="checkbox" class="folder-checkbox" data-id="{{ $folder->id }}">
        <span class="folder-name">{{ $folder->name }}</span>
    </label>
    </div>
</div>
    @if($folder->childrenRecursive->count())
        <ul class="subfolders hidden">
            @foreach($folder->childrenRecursive as $child)
                @include('partial_node', ['folder' => $child])
            @endforeach
        </ul>
    @endif
</li>
