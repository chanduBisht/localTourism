@include('admin.layout.header')

<aside class="main-sidebar">
    @include('admin.layout.sidebar')
</aside>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Update Blog</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Blog</li>

        </ol>
    </section>
    @include('admin.layout.alert')
    <section class="content">
        <div class="row">
            <section class="col-lg-10 connectedSortable">
                <div class="box box-info">
                    <form action="{{route('admin.blog.update', ['blog' => $blog->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                        <div class="box-body">

                            <div class="form-group col-6 err_name">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Title" value="{{$blog->title}}">
                            </div>

                            <div class="form-group col-6 err_name">
                                <label>Short Description</label>
                                <input type="text" name="short_description" class="form-control" placeholder="Short Description" value="{{$blog->short_description}}">
                            </div>

                            <div class="form-group col-6 err_name">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control">
                                <span class="text-xs text-red-500 mt-2 errmsg_name" ></span>
                            </div>

                            <div class="form-group">
                                <label for="detail_content">Detail Content</label>
                                <textarea class="form-control" name="detail_content" id="summernote" placeholder="Write post here..." class="w-full border border-gray-400 p-1 bg-white rounded focus:outline-none">{{$blog->detail_content}}</textarea>
                            </div>

                        </div>
                        <div class="box-footer clearfix">
                            <input type="submit" class="btn btn-primary" value="Update Guide"/>
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
