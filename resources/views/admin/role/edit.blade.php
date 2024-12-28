@include('admin.layout.header')

<aside class="main-sidebar">
    @include('admin.layout.sidebar')
</aside>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit ROLE</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Role</li>

        </ol>
    </section>
    @include('admin.layout.alert')
    <section class="content">
        <div class="row">
            <section class="col-lg-10 connectedSortable">
                <div class="box box-info">
                    <form action="{{ route('admin.roles.update', ['role' => $role->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Use PUT method override -->

                        <div class="box-body">
                            <div class="form-group col-6 err_name">
                                <label>Role Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Role Name" value="{{$role->name}}">
                                <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
                            </div>

                            <div class="form-group col-6">
                                <label>Permissions</label><br>

                                @foreach($permissions['allPermissionsLists'] as $permission)
                                    @if (in_array($permission->id, $permissions['rolePermissions']))
                                    <input type="checkbox" name="permissions[]" value="{{$permission->id}}" checked>
                                    <lable>{{$permission->name}}</lable>
                                    @else
                                    <input type="checkbox" name="permissions[]" value="{{$permission->id}}">
                                    <lable>{{$permission->name}}</lable>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            <input type="submit" class="btn btn-primary" value="Add ROLE"/>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </section>
</div>

@include('admin.layout.footer')

<!-- page script -->
<script type="text/javascript">
$(function () {
    $("#example1").dataTable();
    $('#example2').dataTable({
    "bPaginate": true,
    "bLengthChange": false,
    "bFilter": false,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false
    });
    });
</script>
