<!DOCTYPE html>
<html lang="en">

@include('layout.head')

<body>

    @include('layout.header')


    <!-- Destination Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Destination</h6>
                <h1>Explore Top Destination</h1>
            </div>
            <div class="row">
                @foreach($places as $place)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="destination-item position-relative overflow-hidden mb-2">
                        <img class="img-fluid" src="{{url(''.$place->image)}}" alt="">
                        <a class="destination-overlay text-white text-decoration-none" href="">
                            <h5 class="text-white">{{$place->name}}</h5>
                            <span>{{count($place->hotel)}} Hotels</span>
                            <span>{{count($place->taxi)}} Taxi Service</span>
                            <span>{{count($place->traking)}} Traking Area</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Destination Start -->


    @include('layout.footer')
</body>

</html>
