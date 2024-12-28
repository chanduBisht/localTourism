@include('admin.layout.header')

<aside class="main-sidebar">
    @include('admin.layout.sidebar')
</aside>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Add New Service</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Service</li>

        </ol>
    </section>
    @include('admin.layout.alert')
    <section class="content">
        <div class="row">
            <section class="col-lg-10 connectedSortable">
                <div class="box box-info">
                    <form action="{{route('admin.service.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="box-body">

                            <div class="form-group col-6 err_name">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" value="{{old('name')}}">
                            </div>

                            <div class="form-group col-6 err_name">
                                <label>Description</label>
                                <input type="text" name="description" class="form-control" placeholder="Description" value="{{old('description')}}">
                            </div>

                            <div class="form-group col-6 err_name">
                                <label>Icon</label>
                                <input type="file" name="image" class="form-control">
                                <span class="text-xs text-red-500 mt-2 errmsg_name" ></span>
                            </div>

                        </div>
                        <div class="box-footer clearfix">
                            <input type="submit" class="btn btn-primary" value="Add Service"/>
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
