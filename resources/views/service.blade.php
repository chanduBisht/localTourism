<!DOCTYPE html>
<html lang="en">

@include('layout.head')

<body>

    @include('layout.header')

      <!-- Service Start -->
      <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Services</h6>
                <h1>Local Services</h1>
            </div>
            <div class="row">
                @foreach ($services as $service)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-item bg-white text-center mb-2 py-5 px-4">
                        <img class="mx-auto mb-4" src="{{url(''.$service->image)}}" width="50px" height="50px">
                        <h5 class="mb-2">{{$service->name}}</h5>
                        <p class="m-0">{{$service->description}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Service End -->


    @include('layout.footer')
</body>

</html>
