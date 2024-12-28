 <!-- Topbar Start -->
 <div class="container-fluid bg-light pt-3 d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center">
                    <p><i class="fa fa-envelope mr-2"></i>chandusingh751.com</p>
                    <p class="text-body px-3">|</p>
                    <p><i class="fa fa-phone-alt mr-2"></i>+918077013392</p>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-primary px-3" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-primary px-3" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-primary px-3" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-primary px-3" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-primary pl-3" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<div class="container-fluid position-relative nav-bar p-0">
    <div class="container-lg position-relative p-0 px-lg-3" style="z-index: 9;">
        <nav class="navbar navbar-expand-lg bg-light navbar-light shadow-lg py-3 py-lg-0 pl-3 pl-lg-5">
            <a href="" class="navbar-brand">
                <h1 class="m-0 text-primary"><span class="text-dark">LOCAL </span>TOURISM</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                <div class="navbar-nav ml-auto py-0">
                    <a href="{{route('index')}}" class="nav-item nav-link active">Home</a>
                    <a href="{{route('about')}}" class="nav-item nav-link">About</a>
                    <a href="{{route('service')}}" class="nav-item nav-link">Services</a>
                    <a href="{{route('package')}}" class="nav-item nav-link">Tour Packages</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu border-0 rounded-0 m-0">
                            <a href="{{route('blog')}}" class="dropdown-item">Blog Grid</a>
                            <a href="{{route('destination')}}" class="dropdown-item">Destination</a>
                            <a href="{{route('guide')}}" class="dropdown-item">Travel Guides</a>
                        </div>
                    </div>
                    <a href="{{route('contact')}}" class="nav-item nav-link">Contact</a>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->

<!-- Carousel Start -->
<div class="container-fluid p-0">
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="{{url('public/frontend/img/slider/slider3.jpg')}}" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase mb-md-3">Local Traveling</h4>
                        <h1 class="display-3 text-white mb-md-4">Nainital Local Tourism</h1>
                        <a href="" class="btn btn-primary py-md-3 px-md-5 mt-2">Book Now</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item ">
                <img class="w-100" src="{{url('public/frontend/img/slider/slider3.jpg')}}" alt="Image">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px;">
                        <h4 class="text-white text-uppercase mb-md-3">Local Traveling</h4>
                        <h1 class="display-3 text-white mb-md-4">Nainital Local Tourism</h1>
                        <a href="" class="btn btn-primary py-md-3 px-md-5 mt-2">Book Now</a>
                    </div>
                </div>
            </div>

        </div>
        <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-prev-icon mb-n2"></span>
            </div>
        </a>
        <a class="carousel-control-next" href="#header-carousel" data-slide="next">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-next-icon mb-n2"></span>
            </div>
        </a>
    </div>
</div>
<!-- Carousel End -->


<!-- Booking Start -->
<div class="container-fluid booking mt-5 pb-5">
    <div class="container pb-5">
        <div class="bg-light shadow" style="padding: 30px;">
            <div class="row align-items-center" style="min-height: 60px;">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3 mb-md-0">
                                <select class="custom-select px-4" style="height: 47px;">
                                    <option selected>Destination</option>
                                    <option value="1">Destination 1</option>
                                    <option value="2">Destination 1</option>
                                    <option value="3">Destination 1</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3 mb-md-0">
                                <div class="date" id="date1" data-target-input="nearest">
                                    <input type="text" class="form-control p-4 datetimepicker-input" placeholder="Depart Date" data-target="#date1" data-toggle="datetimepicker"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3 mb-md-0">
                                <div class="date" id="date2" data-target-input="nearest">
                                    <input type="text" class="form-control p-4 datetimepicker-input" placeholder="Return Date" data-target="#date2" data-toggle="datetimepicker"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3 mb-md-0">
                                <select class="custom-select px-4" style="height: 47px;">
                                    <option selected>Duration</option>
                                    <option value="1">Duration 1</option>
                                    <option value="2">Duration 1</option>
                                    <option value="3">Duration 1</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-block" type="submit" style="height: 47px; margin-top: -2px;">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Booking End -->
