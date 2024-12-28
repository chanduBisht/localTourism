@include('admin.layout.header')

<aside class="main-sidebar">
    @include('admin.layout.sidebar')
</aside>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Add New Hotel</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Hotel</li>

        </ol>
    </section>
    @include('admin.layout.alert')
    <section class="content">
        <div class="row">
            <section class="col-lg-10 connectedSortable">
                <div class="box box-info">
                    <form action="{{route('admin.hotels.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="box-body">
                            <div class="form-group col-6 err_name">
                                <label>Location List</label>
                                <select  class="form-control" name="place_id">
                                    <option value="">Select Location</option>
                                    @foreach ($places as $place)
                                    <option value="{{$place->id}}" {{old('place_id') == $place->id ? 'selected' : ''}}>{{$place->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6 err_name">
                                <label>Hotel Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Place Name" value="{{old('name')}}">
                            </div>

                            <div class="form-group col-6 err_name">
                                <label>Hotel Multiple Images</label>
                                <input type="file" name="image[]" class="form-control" multiple>
                                <span class="text-xs text-red-500 mt-2 errmsg_name" ></span>
                            </div>

                            <div class="form-group col-6 err_name">
                                <label>Hotel Description</label>
                                <textarea type="text" name="description" class="form-control" placeholder="Enter Description">{{old('description')}}</textarea>
                            </div>


                            <div class="form-group col-6 err_name">
                                <label>Hotel Facility</label>
                                <div id="facilityContainer">
                                    <div class="input-group mb-2">
                                        <input type="text" name="facility[]" class="form-control" placeholder="Facility">
                                        <button type="button" class="btn btn-danger btn-sm removeFacility d-none">Delete</button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-sm addFacility">Add+</button>
                            </div>

                            <script>
                                $(document).ready(function () {
                                    // Add Facility Input Field
                                    $('.addFacility').click(function () {
                                        $('#facilityContainer').append(`
                                            <div class="input-group mb-2">
                                                <input type="text" name="facility[]" class="form-control" placeholder="Facility">
                                                <button type="button" class="btn btn-danger btn-sm removeFacility">Delete</button>
                                            </div>
                                        `);
                                    });

                                    // Remove Facility Input Field
                                    $('#facilityContainer').on('click', '.removeFacility', function () {
                                        $(this).closest('.input-group').remove();
                                    });
                                });
                            </script>

                            <div class="form-group col-6 err_name">
                                <label>Hotel Location</label>
                                <input type="text" name="location" class="form-control" placeholder="Location" value="{{old('location')}}">
                            </div>

                            <div class="form-group col-6 err_name">
                                <label>Check In</label>
                                <input type="text" name="check_in" class="form-control" placeholder="Check In Time" value="{{old('check_in')}}">
                            </div>

                            <div class="form-group col-6 err_name">
                                <label>Check Out</label>
                                <input type="text" name="check_out" class="form-control" placeholder="Check Out Time" value="{{old('check_out')}}">
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            <input type="submit" class="btn btn-primary" value="Add Hotel"/>
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
