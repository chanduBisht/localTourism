@include('admin.layout.header')

<aside class="main-sidebar">
    @include('admin.layout.sidebar')
</aside>

<div class="content-wrapper">
    <section class="content-header">
        <h1>View All Hotels</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Hotels</li>
        </ol>
    </section>

    @include('admin.layout.alert')

        <section class="content">
          <div class="row">
            <div class="col-xs-12">

                <div class="box">
                <div class="box-header table-responsive">
                 <!-- <h3 class="box-title">Hover Data Table</h3>-->
                  <form action="action/category1.php?subview=bulk_actions" method="post">
                    <!-- <div class="col-md-4 col-xs-12 form-group">
                        <select name="bulk_action" class="form-control" title="Select Action Type">
                            <option value="">Bulk Actions</option>
                            <option value="delete">Delete Gallery</option>
                            <option value="active">Activate Gallery</option>
                            <option value="block">Block Gallery</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-xs-12 form-group">
                        <input type="submit" class="btn btn-primary " value="Apply Action" />
                    </div>
                    <div class="col-md-4 col-xs-12 form-group">
                        <select name="filter" class="form-control" title="Select course Type">
                            <option value="all">Filter Gallery</option>
                            <option value="active">Active Gallery</option>
                            <option value="block">Blocked Gallery</option>
                        </select>
                    </div> -->
                    <div class="col-md-2 col-xs-12 form-group pull-right">
                        <a href="{{route('admin.hotels.create')}}" class="btn btn-primary" title="Click for Add New course"><i class="fa fa-plus"></i> Add New </a>
                    </div>


                    <!-- /.box-header -->
                    <div class="box-body ">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Place Name</th>
                                <th>Hotel Name</th>
                                <th>Description</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                    </table>
                    </div>
                    </form>
                    <!-- /.box-body -->
              </div>
              </div>
              </div>
              </div>
              </section>

      </div>
</div>

@include('admin.layout.footer')

<!-- page script -->
<script type="text/javascript">
    $(function () {
        var table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.hotels.index') }}",

            "columns": [
                {
                    "data": "place.name",
                },
                {
                    "data": "name",
                },
                {
                    "data": "description",
                },
                {
                    "data": "check_in",
                },
                {
                    "data": "check_out",
                },
                {
                    "data": "action", // Display the dynamic edit button
                    "orderable": false, // Disable ordering on this column
                    "searchable": false // Disable searching on this column
                },
            ],
        });
    });

    $(document).on('click', '#remove', function(){
        var id = $(this).attr('data-id');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
            if(result.value){

                var url = '{{ route('admin.hotels.destroy', ':id') }}';
                url = url.replace(':id', id); // Replace the placeholder with the actual ID
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(data)
                    {
                        if(data.status == false){
                            Swal.fire(data.title,data.message,data.type);
                        }
                        Swal.fire(
                            "Deleted!",
                            "Deleted successfully.",
                            "success"
                        ).then(function() {
                            $('.table').DataTable().ajax.reload();
                        });
                    }
                });

            }
        });
    })
</script>
