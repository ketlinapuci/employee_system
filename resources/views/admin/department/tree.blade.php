<ul>
    @foreach ($children as $child)
        <li style="margin-bottom: 10px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ $child->name }}</div>
                <div>
                    <a href="{{ url('admin/department/' . $child->id . '/edit') }}" class="btn btn-info btn-sm" style="margin-top: 5px;">Update</a>
                    <a onclick="return confirm('Are you sure to delete this data?')" href="{{ url('admin/department/' . $child->id . '/delete') }}" class="btn btn-danger btn-sm" style="margin-top: 5px;">Delete</a>
                </div>
            </div>
            @if ($child->children->isNotEmpty())
                @include('admin.department.tree', ['children' => $child->children])
            @endif
        </li>
    @endforeach
</ul>
