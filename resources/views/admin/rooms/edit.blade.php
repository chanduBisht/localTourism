@include('admin.layout.header')

<aside class="main-sidebar">
    @include('admin.layout.sidebar')
</aside>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Room</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Room</li>

        </ol>
    </section>
    @include('admin.layout.alert')
    <section class="content">
        <div class="row">
            <section class="col-lg-10 connectedSortable">
                <div class="box box-info">
                    <form action="{{route('admin.rooms.update', ['room' => $room->id ])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                        <div class="box-body">
                            <div class="form-group col-6 err_name">
                                <label>Hotel List</label>
                                <select  class="form-control" name="hotel_id">
                                    <option value="">Select Hotel</option>
                                    @foreach ($hotels as $hotel)
                                    <option value="{{$hotel->id}}" {{$room->hotel_id == $hotel->id ? 'selected' : ''}}>{{$hotel->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6 err_name">
                                <label>Room Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Room Name" value="{{$room->name}}">
                            </div>

                            <div class="form-group col-6 err_name">
                                <label>Room Multiple Images</label>
                                <input type="file" name="image[]" class="form-control" multiple>
                                <span class="text-xs text-red-500 mt-2 errmsg_name" ></span>
                            </div>

                            <div class="form-group col-6 err_name">
                                <label for="room-price">Price per Night (in USD)</label>
                                <input type="number" class="form-control"  id="room-price" name="room_price" value="{{$room->room_price}}" placeholder="e.g., 100" required>

                            </div>

                            <div class="form-group col-6 err_name">
                                <label for="room-availability">Availability</label>
                                <select id="room-availability" name="room_availability" class="form-control"  required>
                                  <option value="available" {{$room->room_availability == 'available' ? 'selected' : ''}}>Available</option>
                                  <option value="unavailable"  {{$room->room_availability == 'unavailable' ? 'selected' : ''}}>Unavailable</option>
                                </select>
                            </div>

                            <div class="form-group col-6 err_name">
                                <label for="room-description">Description</label>
                                <textarea id="room-description" class="form-control" name="room_description" rows="5" placeholder="Provide a detailed description of the room">{{$room->room_description}}</textarea>
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            <input type="submit" class="btn btn-primary" value="Update Room"/>
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
