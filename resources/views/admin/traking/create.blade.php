@include('admin.layout.header')

<aside class="main-sidebar">
    @include('admin.layout.sidebar')
</aside>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Add New Traking Area</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Traking Area</li>

        </ol>
    </section>
    @include('admin.layout.alert')
    <section class="content">
        <div class="row">
            <section class="col-lg-10 connectedSortable">
                <div class="box box-info">
                    <form action="{{route('admin.traking.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="box-body">
                            <div class="form-group col-6 err_name">
                                <label>Place List</label>
                                <select  class="form-control" name="place_id">
                                    <option value="">Select Place</option>
                                    @foreach ($places as $place)
                                    <option value="{{$place->id}}" {{old('place_id') == $place->id ? 'selected' : ''}}>{{$place->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6 err_name">
                                <label>Track Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Traking Area" value="{{old('name')}}">
                            </div>

                            <div class="form-group col-6 err_name">
                                <label>Track Km</label>
                                <input type="text" name="track_km" class="form-control" placeholder="Track Km" value="{{old('track_km')}}">
                            </div>

                            <div class="form-group col-6 err_name">
                                <label>Track Multiple Images</label>
                                <input type="file" name="image[]" class="form-control" multiple>
                                <span class="text-xs text-red-500 mt-2 errmsg_name" ></span>
                            </div>

                            <div class="form-group col-6 err_name">
                                <label for="room-price">Price per Person (in INR)</label>
                                <input type="number" class="form-control"  id="track-price" name="track_price" value="{{old('track_price')}}" placeholder="e.g., 100" required>
                            </div>

                            <div class="form-group col-6 err_name">
                                <label for="room-price">Tracking Start Time</label>
                                <input type="text" class="form-control"  id="track-start-time" name="track_start_time" value="{{old('track_start_time')}}" placeholder="10 AM" required>
                            </div>

                            <div class="form-group col-6 err_name">
                                <label for="room-price">Tracking Total Days</label>
                                <input type="number" class="form-control"  id="track-days" name="track_days" value="{{old('track_days')}}" placeholder="1" required>
                            </div>

                            <div class="form-group col-6 err_name">
                                <label for="room-availability">Availability</label>
                                <select id="room-availability" name="track_availability" class="form-control"  required>
                                  <option value="available" {{old('track_availability') == 'available' ? 'selected' : ''}}>Available</option>
                                  <option value="unavailable" {{old('track_availability') == 'unavailable' ? 'selected' : ''}}>Unavailable</option>
                                </select>
                            </div>

                            <div class="form-group col-6 err_name">
                                <label for="room-description">Description</label>
                                <textarea id="car-description" class="form-control" name="track_description" rows="5" placeholder="Provide a detailed description of the room">{{old('track_description')}}</textarea>
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            <input type="submit" class="btn btn-primary" value="Add Traking Area"/>
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
