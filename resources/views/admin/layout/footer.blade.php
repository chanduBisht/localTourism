<footer class="main-footer">
    <div class="pull-right hidden-xs">

    </div>
    <strong>By <a href="http://sonyinfocom.com" target="_blank">Sonyinfocom</a>.</strong> All rights reserved.
  </footer>
</div><!-- ./wrapper -->


<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Bootstrap 3.3.2 JS -->
<script src="{{url('public/admin/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

 <!-- DATA TABES SCRIPT -->
{{-- <script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script> --}}
{{-- <script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script> --}}
<!-- Morris.js charts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
{{-- <script src="plugins/morris/morris.min.js" type="text/javascript"></script> --}}
 <!-- bootstrap color picker -->
{{-- <script src="plugins/colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script> --}}
<!-- Sparkline -->

{{-- <script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script> --}}
<!-- jvectormap -->
{{-- <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script> --}}
{{-- <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script> --}}
<!-- jQuery Knob Chart -->
{{-- <script src="plugins/knob/jquery.knob.js" type="text/javascript"></script> --}}



<!-- Bootstrap WYSIHTML5 -->
{{-- <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script> --}}
<!-- iCheck -->
{{-- <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script> --}}
<!-- Slimscroll -->
{{-- <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script> --}}
<!-- FastClick -->
{{-- <script src='plugins/fastclick/fastclick.min.js'></script> --}}
<!-- AdminLTE App -->
<script src="{{url('public/admin/dist/js/app.min.js')}}" type="text/javascript"></script>



<!-- AdminLTE for demo purposes -->
<script src="{{url('public/admin/dist/js/demo.js')}}" type="text/javascript"></script>

<!-- My ajax -->
<script src="{{url('public/admin/script/script.js')}}" type="text/javascript"></script>
<script src="{{url('public/admin/script/ajax.js')}}" type="text/javascript"></script>

{{-- yajra datatable --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

{{-- Swal --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script type="text/javascript">
    $('#summernote').summernote({
        placeholder: 'Show your writing creativity here...',
        tabsize: 2,
        height: 300,
        callbacks: {
            onImageUpload: function (files) {
                const editor = $(this); // Capture the current editor instance
                for (let i = 0; i < files.length; i++) {
                    uploadImage(files[i], editor); // Pass the correct editor instance
                }
            },
            onImageUploadError: function () {
                console.log('error');
            },
            onMediaDelete: function (target) {
                deleteImage(target[0].src);
            }
        }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    const uploadImage = (file, editor) => {
        let form = new FormData();
        form.append('image', file);

        $.ajax({
            method: 'POST',
            url: "{{ route('admin.blog.image.upload') }}",
            contentType: false,
            cache: false,
            processData: false,
            data: form,
            beforeSend: () => {
                console.log('Uploading image...');
            },
            success: function (result) {
                console.log('Upload successful:', result);
                // Insert the image into the editor
                editor.summernote('insertImage', result.url, function ($image) {
                    // Optionally manipulate the inserted image
                    $image.attr('alt', 'Uploaded Image');
                });
            },
            error: function (error) {
                console.error('Image upload error:', error);
            }
        });
    };


    const deleteImage = (url) => {
        let form = new FormData();
        form.append('url', url);

        $.ajax({
            method: 'POST',
            url: "{{ route('admin.blog.image.delete') }}",
            contentType: false,
            cache: false,
            processData: false,
            data: form,
            beforeSend: () => {
                // console.log('beforeSend');
            },
            success: function(result) {
                toast.info(result.msg)
            },
            error: function(error) {
                console.log("error", error);
            }
        });
    }

</script>

</body>
</html>
