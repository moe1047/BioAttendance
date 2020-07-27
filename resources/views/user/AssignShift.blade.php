@extends('vendor.backpack.base.layout')
@section('before_styles')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2') }}/select2.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datepicker') }}/datepicker3.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables') }}/dataTables.bootstrap.css">
@stop
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Assign Weekly Shift</h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    {!! Form::open(['url' => 'admin/user/assignShift']) !!}
                    <div class="box-body table-responsive ">
                        <table class="table table-bordered table-striped dataTable" id="datatable">
                            <thead>
                            <th>Name</th>
                            <th>Salary</th>
                            <th>Shift</th>
                            <th>Payment</th>
                            <th>Currency</th>

                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->NAME}}</td>
                                    <td><input type="text" class="form-control" name="user[{{$user->USERID}}][salary]" value="{{$user->defaultAcYearShift->first()["salary"]}}"></td>

                                    <td>{!! Form::select("user[$user->USERID][shift]", $shifts, $user->defaultAcYearShift->first()["clicklizeshift_id"], ['class'=>'form-control select2','style'=>"width: 100%"]) !!}</td>
                                    <td>{!! Form::select("user[$user->USERID][payment_type]", ['monthly'=>'Monthly','daily'=>'Daily'], $user->defaultAcYearShift->first()["payment_type"], ['class'=>'form-control select2','style'=>"width: 100%"]) !!}</td>
                                    <td>{!! Form::select("user[$user->USERID][currency]", ['dollar'=>'Dollar','shilling'=>'Shilling'], $user->defaultAcYearShift->first()["currency"], ['class'=>'form-control select2','style'=>"width: 100%"]) !!}</td>


                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>




                    <div class="box-footer">
                        <button class="btn btn-success" ><span class="fa fa-save" role="presentation" aria-hidden="true"></span> Update </button>
                        <p class="help-block">By clicking this, you will only update one page.</p>


                        <div>



                            {!! Form::close() !!}

                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
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

                                    @foreach($all_shifts as $shift)
                                        <tr>
                                            <td class="success">{{$shift->name}}</td>
                                            @if($shift->shiftTimetables()->get()->count())
                                                <td>
                                                  @if($shift->shiftTimetables()->where('day', "sat")->get()->count() > 0)
                                                    @foreach($shift->shiftTimetables()->where('day', "sat")->get() as $shiftTimetable)
                                                        @if($shiftTimetable->timetable!=null)
                                                          {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                                        @endif
                                                    @endforeach
                                                  @endif
                                                </td>
                                                <td>
                                                    @foreach($shift->shiftTimetables()->where('day', "sun")->get() as $shiftTimetable)
                                                      @if($shiftTimetable->timetable!=null)
                                                        {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                                      @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($shift->shiftTimetables()->where('day', "mon")->get() as $shiftTimetable)
                                                      @if($shiftTimetable->timetable!=null)
                                                        {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                                      @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($shift->shiftTimetables()->where('day', "tue")->get() as $shiftTimetable)
                                                      @if($shiftTimetable->timetable!=null)
                                                        {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                                      @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($shift->shiftTimetables()->where('day', "wed")->get() as $shiftTimetable)
                                                      @if($shiftTimetable->timetable!=null)
                                                        {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                                      @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($shift->shiftTimetables()->where('day', "thu")->get() as $shiftTimetable)
                                                      @if($shiftTimetable->timetable!=null)
                                                        {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                                      @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($shift->shiftTimetables()->where('day', "fri")->get() as $shiftTimetable)
                                                      @if($shiftTimetable->timetable!=null)
                                                        {{$shiftTimetable->timetable->start_time}} - {{$shiftTimetable->timetable->end_time}}<br>
                                                      @endif
                                                    @endforeach
                                                </td>

                                            @else
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                            @endif


                                        </tr>
                                    @endforeach
                                    </tbody>
									</table>
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
            $(document).ready(function() {
                var table = $('#datatable').DataTable();

                $('#btnUpdate').click( function() {
                    var data = table.$('input, select').serialize();
                    alert(
                            "The following data would have been submitted to the server: \n\n"+
                            data.substr( 0, 120 )+'...'
                    );
                    console.log(data.substr( 0, 120 )+'...');
                    return false;
                } );
            });
        });
    </script>

@stop
