@include('admin.layout.header')

<aside class="main-sidebar">
    @include('admin.layout.sidebar')
</aside>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Add New ROLE</h1>
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
                    <form action="{{route('admin.roles.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="box-body">
                            <div class="form-group col-6 err_name">
                                <label>Role Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Role Name">
                                <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
                            </div>

                            <div class="form-group col-6">
                                <label>Permissions</label><br>

                                @foreach($permissions['allPermissionsLists'] as $permission)
                                <input type="checkbox" name="permissions[]" value="{{$permission->id}}">
                                <lable>{{$permission->name}}</lable>
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
