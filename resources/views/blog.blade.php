<!DOCTYPE html>
<html lang="en">

@include('layout.head')

<body>

    @include('layout.header')


      <!-- Blog Start -->
      <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Our Blog</h6>
                <h1>Latest From Our Blog</h1>
            </div>
            <div class="row pb-3">
                @foreach ($blogs as $blog)
                <div class="col-lg-4 col-md-6 mb-4 pb-2">
                    <div class="blog-item">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{url(''.$blog->image)}}" alt="">
                            <div class="blog-date">
                                <h6 class="font-weight-bold mb-n1">{{$blog->created_at->format('d')}}</h6>
                                <small class="text-white text-uppercase">{{$blog->created_at->format('M')}}</small>
                            </div>
                        </div>
                        <div class="bg-white p-4">
                            <div class="d-flex mb-2">
                                <a class="text-primary text-uppercase text-decoration-none" href="{{route('blog-detail',['blog' => $blog->id])}}">Admin</a>
                                <span class="text-primary px-2">|</span>
                                <a class="text-primary text-uppercase text-decoration-none" href="{{route('blog-detail',['blog' => $blog->id])}}">{{$blog->title}}</a>
                            </div>
                            <a class="h5 m-0 text-decoration-none" href="{{route('blog-detail',['blog' => $blog->id])}}">{{$blog->short_description}}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Blog End -->


    @include('layout.footer')
</body>

</html>
