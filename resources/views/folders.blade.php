<ul>
    <li class="folder">{{ $item['name'] }}
        <ul>
            @foreach ($item['files'] as $file)
                <li class="file">{{ $file['name'] }} ({{ $file['extension'] }})</li>
            @endforeach

            @foreach ($item['folders'] as $subfolder)
                @include('folders', ['item' => $subfolder])
            @endforeach
        </ul>
    </li>
</ul>
