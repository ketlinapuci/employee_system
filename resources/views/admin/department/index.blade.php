@extends('layouts.admin')

@section('title', 'Depratments')

@section('content')
    <div class="container-fluid px-4">
        <h3 class="mt-4">DEPARTMENTS</h3>
        <!-- Tree view for departments -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                All Departments
                <a href="{{url('admin/department/create')}}" class="float-end btn btn-sm btn-success">Add New</a>
            </div>
            <div class="card-body">
                <ul id="department-tree">
                    @foreach ($departments as $department)
                        <li style="margin-bottom: 10px;">
                            <div class="d-flex justify-content-between align-items-center" data-id="{{ $department->id }}">
                                <div>{{ $department->name }}</div>
                                <div>
                                    <a href="{{ url('admin/department/' . $department->id . '/edit') }}" class="btn btn-info btn-sm">Update</a>
                                    <a onclick="return confirm('Are you sure to delete this data?')" href="{{ url('admin/department/' . $department->id . '/delete') }}" class="btn btn-danger btn-sm">Delete</a>
                                </div>
                            </div>
                            @if ($department->children->isNotEmpty())
                                <ul style="padding-left: 20px;">
                                    @foreach ($department->children as $child)
                                        <li style="margin-bottom: 10px;">
                                            <div class="d-flex justify-content-between align-items-center" data-id="{{ $child->id }}">
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
                            @endif
                        </li>
                    @endforeach
                </ul>
                <div id="departmentEmployees">
                </div>
                <table id="datatableEmployee" class="table table-bordered">
                </table>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#department-tree div').on('click', function () {
    var departmentId = $(this).data('id');
    $.ajax({
        url: '/admin/department/' + departmentId + '/employees',
        type: 'GET',
        success: function (response) {

            $('#departmentEmployees').empty();

            // Add new department header
            var newRow = '<div>Employee for department: </div>';
            $('#departmentEmployees').append(newRow);


            // Clear the table before adding new content
            $('#datatableEmployee').empty();

            var thead = '<thead>' +
                            '<tr>' +
                                '<th>#</th>' +
                                '<th>Department</th>' +
                                '<th>Name</th>' +
                                '<th>Photo</th>' +
                                '<th>Address</th>' +
                                '<th>Email</th>' +
                                '<th><button id="clearTable" class="btn-close" title="Clear"></button></th>' +
                            '</tr>' +
                        '</thead>';
            $('#datatableEmployee').append(thead);

            var tbody = $('<tbody></tbody>');

            // Append employee rows to the tbody
            $.each(response, function (index, employee) {
                var row = '<tr>' +
                            '<td>' + employee.id + '</td>' +
                            '<td>' + employee.department_id + '</td>' +
                            '<td>' + employee.name + '</td>' +
                            '<td><img src="/images/' + employee.photo + '" width="80" /></td>' +
                            '<td>' + employee.address + '</td>' +
                            '<td>' + employee.email + '</td>' +
                            '</td>' +
                            '</tr>';
                tbody.append(row);
            });

            // Append the tbody to the table
            $('#datatableEmployee').append(tbody);

            // Clear the table
            $('#clearTable').on('click', function () {
                $('#datatableEmployee').empty();
                $('#departmentEmployees').empty();

            });
        },
        error: function (xhr, status, error) {
            console.error('Error fetching employees:', error);
        }
    });
});

</script>

@endsection
