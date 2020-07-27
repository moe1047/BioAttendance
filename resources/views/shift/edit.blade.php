@extends('vendor.backpack.base.layout')
@section('before_styles')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2') }}/select2.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datepicker') }}/datepicker3.css">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/pnotify/pnotify.custom.min.css') }}">
@stop
@section('content')
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Weekly Shift</h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
                {!! Form::model($shift, array('route' => array('crud.shift.update', $shift->id),'method'=>'PUT')) !!}
                {!! Form::hidden('id', $shift->id, ['class' => 'form-control']) !!}
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
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('sat:', 'Sat:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11">
                        {!! Form::select("day[sat][]", $timetables,$selected_days['sat'], ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('sun:', 'Sun:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11">
                        {!! Form::select("day[sun][]", $timetables, $selected_days['sun'], ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('mon:', 'Mon:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11">
                        {!! Form::select("day[mon][]", $timetables, $selected_days['mon'], ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('tue:', 'Tue:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11">
                        {!! Form::select("day[tue][]", $timetables, $selected_days['tue'], ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('wed:', 'Wed:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11 ">
                        {!! Form::select("day[wed][]", $timetables, $selected_days['wed'], ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('thu:', 'Thur:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11">
                        {!! Form::select("day[thu][]", $timetables, $selected_days['thu'], ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        {!! Form::label('fri:', 'Fri:', ['class' => '']) !!}
                    </div>
                    <div class="col-md-11">
                        {!! Form::select("day[fri][]", $timetables, $selected_days['fri'], ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                    </div>

                </div>
                <div class="box-footer">
                    <button class="btn btn-success"><span class="fa fa-save" role="presentation" aria-hidden="true"></span> Update</button>
                    <a href="{{url('admin/shift')}}" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;Cancel</a>

                    <div>



                        {!! Form::close() !!}

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>


@stop
@section('after_scripts')
    <script src="{{asset('vendor/backpack/pnotify/pnotify.custom.min.js')}}"></script>

    <script src="{{asset('vendor/adminlte/plugins/select2')}}/select2.full.js"></script>
    <script src="{{asset('vendor/adminlte/plugins/datepicker')}}/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $( ".select2" ).select2({});
            $('.date').datepicker({
                ///format: "dd-mm-yyyy"
            });
            $("#datatable").DataTable();




        })

    </script>

@stop

