@include('admin.layout.header')

<!-- Left side column. contains the logo and sidebar -->
     <aside class="main-sidebar">
       <!-- sidebar: style can be found in sidebar.less -->
       @include('admin.layout.sidebar')
       <!-- /.sidebar -->
     </aside>

     <!-- Content Wrapper. Contains page content -->
     <div class="content-wrapper">
       <!-- Content Header (Page header) -->
       <section class="content-header">
         <h1>
           Dashboard
           <small>Control panel</small>
         </h1>
         <ol class="breadcrumb">
           <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
           <li class="active">Dashboard</li>
         </ol>
       </section>

       <!-- Main content -->
       <section class="content">

         <div class="row">
           <div class="col-lg-12 col-xs-12">
             <!-- small box -->
             <div class="small-box bg-aqua">
               <div class="inner">
                 <h4>Local Tourism</h4>
               </div>

             </div>
           </div>

         </div>
         <!-- Main row -->
         <div class="row">

           <!-- right col (We are only adding the ID to make the widgets sortable)-->
           <section class="col-lg-12 connectedSortable">



           </section><!-- right col -->
         </div><!-- /.row (main row) -->
       </section><!-- /.content -->
     </div><!-- /.content-wrapper -->
       @include('admin.layout.footer')
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
   <script src="{{url('public/admin/dist/js/pages/dashboard.js')}}" type="text/javascript"></script>
     <!-- daterangepicker -->
 <script src="plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
   <!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
