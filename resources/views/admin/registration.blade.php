<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Local Tourism | Log in</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{url('public/admin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{url('public/admin/dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index2.html"><b>Local Tourism</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">New Registration</p>
        <span class="error"></span>
        <form action="{{route('admin.login.insert')}}" name="login_form"  onsubmit="return false;" method="POST" enctype="multipart/form-data">
        @csrf
          <div class="form-group has-feedback err_email">
            <label for="name" class="form-label">Name*</label>
            <input type="text" class="form-control" placeholder="Name" name="name"/>
          </div>
          <div class="form-group has-feedback err_email">
            <label for="email" class="form-label">Email*</label>
            <input type="text" class="form-control" placeholder="Email" name="email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback err_password">
            <label for="password" class="form-label">Password*</label>
            <input type="password" class="form-control" placeholder="Password" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback err_email">
            <label for="address" class="form-label">Address*</label>
            <input type="text" class="form-control" placeholder="Address" name="address"/>
          </div>
          <div class="form-group has-feedback err_email">
            <label for="mobile" class="form-label">Mobile*</label>
            <input type="text" class="form-control" placeholder="Mobile" name="mobile"/>
          </div>
          <div class="form-group has-feedback err_email">
            <label for="image" class="form-label">Image*</label>
            <input type="file" class="form-control" name="image"/>
          </div>
          <div class="form-group has-feedback err_email">
            <label for="image" class="form-label">Role*</label>
            <select class="form-control" name="role_id" id="role_id">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                <option value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group has-feedback err_password">
            <button type="button" id="new_register" class="btn btn-primary btn-block btn-flat">Sign Up</button>
          </div>

        </form>

      <!--  <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div>-->
        <!-- /.social-auth-links -->

        {{-- <a href="#">I forgot my password</a><br> --}}
        <!--<a href="register.html" class="text-center">Register a new membership</a>-->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.3 -->
    <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{url('public/admin/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });

      $('#new_register').on('click', function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var form = document.login_form;
        var formData = new FormData(form);
        var url = '{{ route('admin.register.insert') }}';
        $.ajax({
            type: 'POST',
            url: url,
            processData: false,
            contentType: false,
            dataType: 'json',
            data: formData,
            dataSrc: "",
            beforeSend: function() {

                $('span.alerts').remove();
                $("div#divLoading").addClass('show');
            },
            success: function(data) {
                console.log(data)
                if (data.status == false) {
                    $('.error').html(
                            '<span class="small alerts text-danger text-center text-bold">' + data.error + '</span>');
                }
                if (data.status == true) {
                    window.location.href = data.redirect;
                }
            }
        });
    });
    </script>
  </body>
</html>
