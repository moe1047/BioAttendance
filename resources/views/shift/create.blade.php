@extends('vendor.backpack.base.layout')
@section('before_styles')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2') }}/select2.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datepicker') }}/datepicker3.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables') }}/dataTables.bootstrap.css">
@stop
@section('content')
    <div class="col-md-4">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Add Weekly Shift</h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
                {!! Form::open(['url' => 'admin/shift']) !!}
                <!-- FROM - TO -->
                <div class="row">
                    <div class="col-md-1">
                        {!! Form::label('ac_year_id', 'Year:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::select("ac_year_id", $academic_years, $default_year, ['class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>
                </div>
                <hr>

                <div class="form-group ">
                    {!! Form::label('name:', 'Shift Name:', ['class' => '']) !!}
                    {!! Form::text('name', '', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('sat:', 'Sat:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11">
                        {!! Form::select("day[sat][]", $timetables, null, ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('sun:', 'Sun:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11">
                        {!! Form::select("day[sun][]", $timetables, null, ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('mon:', 'Mon:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11">
                        {!! Form::select("day[mon][]", $timetables, null, ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('tue:', 'Tue:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11">
                        {!! Form::select("day[tue][]", $timetables, null, ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('wed:', 'Wed:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11 ">
                        {!! Form::select("day[wed][]", $timetables, null, ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('thu:', 'Thur:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11">
                        {!! Form::select("day[thu][]", $timetables, null, ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('fri:', 'Fri:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11">
                        {!! Form::select("day[fri][]", $timetables, null, ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>

                </div>
                <div class="box-footer">
                    <button class="btn btn-success"><span class="fa fa-save" role="presentation" aria-hidden="true"></span> Save</button>
                    <a href="{{url('admin/shift')}}" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;Cancel</a>

                    <div>



                {!! Form::close() !!}

            </div>
            <!-- /.box-body -->
        </div>
    </div>
            </div>
    </div>
    <div class="col-md-8">
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


                                </thead>
                                <tbody>

                                @foreach($shifts as $shift)
                                    <tr>
                                        <td class="success">{{$shift->name}}</td>
                                        <td>
                                        @foreach($shift->shiftTimetables()->where('day', "sat")->get() as $shiftTimetable)
                                        {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                        @endforeach
                                        </td>
                                        <td>
                                            @foreach($shift->shiftTimetables()->where('day', "sun")->get() as $shiftTimetable)
                                                {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($shift->shiftTimetables()->where('day', "mon")->get() as $shiftTimetable)
                                                {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($shift->shiftTimetables()->where('day', "tue")->get() as $shiftTimetable)
                                                {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($shift->shiftTimetables()->where('day', "wed")->get() as $shiftTimetable)
                                                {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($shift->shiftTimetables()->where('day', "thu")->get() as $shiftTimetable)
                                                {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($shift->shiftTimetables()->where('day', "fri")->get() as $shiftTimetable)
                                                {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                            @endforeach
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
                    $( document ).ready(function() {
                        $( ".select2" ).select2({});
                        $('.date').datepicker({
                            ///format: "dd-mm-yyyy"
                        });
                        $("#datatable").DataTable();

                    });

                </script>

@stop

