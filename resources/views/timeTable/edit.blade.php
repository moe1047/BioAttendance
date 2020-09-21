

@extends('vendor.backpack.base.layout')
@section('before_styles')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2') }}/select2.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datepicker') }}/datepicker3.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables') }}/dataTables.bootstrap.css">
@stop
@section('content')
    <div class="row">
        <div class="col-md-8">


            {!! Form::open(['route' => ['crud.timetable.update', $id], 'method' => 'put']) !!}
                <input name="_method" type="hidden" value="PUT">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit</h3>
                    </div>
                    <div class="box-body row">
                        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        <!-- text input -->
                        <div class="form-group col-md-12">
                            <label>Name</label>

                            <input type="text" name="name" value="{{$name}}" class="form-control">


                        </div>

                        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        <!-- html5 time input -->
                        <div class="form-group col-md-12">
                            <label>Start time</label>
                            <input type="time" name="start_time" value="{{$start_time}}" class="form-control">

                        </div>        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        <!-- html5 time input -->
                        <div class="form-group col-md-12">
                            <label>End time</label>
                            <input type="time" name="end_time" value="{{$end_time}}" class="form-control">


                        </div>        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        <!-- text input -->
                        <div class="form-group col-md-12">
                            <label>Late(min)</label>

                            <input type="text" name="late_min" value="{{$late_min}}" class="form-control">


                        </div>
                        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        <!-- text input -->
                        <div class="form-group col-md-12">
                            <label>Early(min)</label>
                            <input type="text" name="early_min" value="{{$early_min}}" class="form-control">
                        </div>
                        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        <!-- html5 time input -->
                        <div class="form-group col-md-12">
                            <label>Start clock-in time</label>
                            <input type="time" name="start_clockin_time" value="{{$start_clockin_time}}" class="form-control">
                        </div>        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        <!-- html5 time input -->
                        <div class="form-group col-md-12">
                            <label>End clock-in time</label>
                            <input type="time" name="end_clockin_time" value="{{$end_clockin_time}}" class="form-control">
                        </div>        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        <!-- html5 time input -->
                        <div class="form-group col-md-12">
                            <label>Start clock-out time</label>
                            <input type="time" name="start_clockout_time" value="{{$start_clockout_time}}" class="form-control">

                        </div>        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        <!-- html5 time input -->
                        <div class="form-group col-md-12">
                            <label>End clock-out time</label>
                            <input type="time" name="end_clockout_time" value="{{$end_clockout_time}}" class="form-control">

                        </div>
                        
                        <div class="form-group col-xs-12">
                          <input type="hidden" name="must_clock_out" value=0>
                          <input type="checkbox" name="must_clock_out" {{ $must_clock_out ? 'checked="checked"' : '' }}  value=1 class="form-check-input">
                            <label>Must Clock-Out</label>


                        </div>
                        <div class="form-group col-md-12">
                            <input type="hidden" name="id" value="{{$id}}" class="form-control">
                        </div>


                    </div><!-- /.box-body -->

                    <div class="box-footer">

                        <div id="saveActions" class="form-group">


                            <div class="btn-group">

                                <button type="submit" class="btn btn-success">
                                    <span class="fa fa-save" role="presentation" ></span> &nbsp;
                                    <span data-value="save_and_back">Save  </span>
                                </button>



                            </div>

                            <a href="{{url('admin/timetable')}}" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;Cancel</a>
                        </div>
                    </div><!-- /.box-footer-->
                </div><!-- /.box -->
                {!! Form::close() !!}
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
