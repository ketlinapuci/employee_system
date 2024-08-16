<ul>
    @foreach ($children as $child)
        <li>
            {{ $child->name }}
            @if ($child->children->isNotEmpty())
                @include('admin.department.tree', ['children' => $child->children])
            @endif
        </li>
    @endforeach
</ul>
