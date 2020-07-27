@extends('vendor.backpack.base.layout')
@section('before_styles')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2') }}/select2.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datepicker') }}/datepicker3.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables') }}/dataTables.bootstrap.css">
@stop
@section('content')

    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Shifts List</h3>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">

                        <!-- /.box-header -->
                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-striped dataTable" id="datatable">
                                <thead>
                                <th>Shift</th>
                                <th>Sat</th>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thur</th>
                                <th>Fri</th>
                                <th></th>


                                </thead>
                                <tbody>

                                @foreach($shifts as $shift)
                                    <tr>
                                        <td class="success">{{$shift->name}}</td>
                                        <td>
                                            @foreach($shift->shiftTimetables()->where('day', "sat")->get() as $shiftTimetable)
                                            @if($shiftTimetable->timetable!=null)
                                              <b>({{$shiftTimetable->timetable->name}}) </b>{{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($shift->shiftTimetables()->where('day', "sun")->get() as $shiftTimetable)
                                            @if($shiftTimetable->timetable!=null)
                                              <b>({{$shiftTimetable->timetable->name}}) </b>{{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($shift->shiftTimetables()->where('day', "mon")->get() as $shiftTimetable)
                                            @if($shiftTimetable->timetable!=null)
                                              <b>({{$shiftTimetable->timetable->name}}) </b>{{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($shift->shiftTimetables()->where('day', "tue")->get() as $shiftTimetable)
                                            @if($shiftTimetable->timetable!=null)
                                              <b>({{$shiftTimetable->timetable->name}}) </b>{{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($shift->shiftTimetables()->where('day', "wed")->get() as $shiftTimetable)
                                            @if($shiftTimetable->timetable!=null)
                                              <b>({{$shiftTimetable->timetable->name}}) </b>{{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($shift->shiftTimetables()->where('day', "thu")->get() as $shiftTimetable)
                                            @if($shiftTimetable->timetable!=null)
                                              <b>({{$shiftTimetable->timetable->name}}) </b>{{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($shift->shiftTimetables()->where('day', "fri")->get() as $shiftTimetable)
                                            @if($shiftTimetable->timetable!=null)
                                              <b>({{$shiftTimetable->timetable->name}}) </b>{{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="{{url("admin/shift/$shift->id/edit")}}">Edit</a></li>
                                                    <li><a href="#" onclick="deleteShift({{$shift->id}})">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody></table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
            </div>
        </div>
    </div>

@stop
@section('after_scripts')
    <script src="{{asset('vendor/adminlte/plugins/datatables')}}/jquery.dataTables.min.js"></script>
    <script src="{{asset('vendor/adminlte/plugins/datatables')}}/dataTables.bootstrap.min.js"></script>

    <script src="{{asset('vendor/adminlte/plugins/select2')}}/select2.full.js"></script>
    <script src="{{asset('vendor/adminlte/plugins/datepicker')}}/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        var deleteShift=function ($id){
            if(confirm("are you sure you want to delete this shift?")==true){
                $.ajax({
                    url: '{{url('admin/shift')}}'+'/'+$id,
                    type: 'DELETE',
                    success: function(result) {
                        // Show an alert with the result

                        location.reload();
                        new PNotify({
                            title: "Shift is Deleted",
                            text: result,
                            type: "success"
                        });
                    }

                })
            }
            }
        $( document ).ready(function() {

                $( ".select2" ).select2({});
                $('.date').datepicker({
                    ///format: "dd-mm-yyyy"
                });
                $("#datatable").DataTable();
                $("body").addClass('sidebar-collapse');




        });

    </script>

@stop
