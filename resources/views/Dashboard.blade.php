@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">{{ trans('backpack::base.dashboard') }}</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <div class="col-md-12">
                <h3 class="box-title">Daily Attendance
                    @if($holiday)
                        <span class="label label-primary">{{$holiday->name}}</span></h3>
                    @endif
                <hr>
            </div>
            <div class="col-md-12">
                <form role="form" class="form-inline" action="{{url('admin/report/dailyReport')}}" method="get">
                    {{ csrf_field() }}
                    
                    <button name="print" class="btn btn-success btn-sm" value="print">Print</button>
                    <button name="email" class="btn btn-success btn-sm" value="email">Send</button>
                    <button class="btn btn-default btn-sm" name="email" value="email" data-toggle="modal" data-target="#myModal" onclick="return false"><span class="fa fa-book" ></span> Email List</button>
                    <div class="col-md-6">
                        {!! Form::label('date', 'Date', ['class' => '']) !!}
                        {!! Form::date('date',\Carbon\Carbon::now(),['class'=>'form-control']) !!}
                        {!! Form::label('departments', 'Department', ['class' => '']) !!}
                        {!! Form::select("departments", $departments,  isset($departments)?$departments:null, ['class'=>'form-control select2']) !!}
                        <button name="search" class="btn btn-primary btn-sm" value="search">Search</button>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h3 class="modal-title" id="myModalLabel">Email List</h3>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {!! Form::label('fri:', 'You can select multiple emails below:', ['class' => '']) !!}
                                            {!! Form::select("emails[]", $emails, null, ['multiple'=>'1','class'=>'form-control select2','style'=>"width: 100%"]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>



            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table no-margin table-stripped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Shift IN</th>
                        <th>In</th>
                        <th>Late(min)</th>
                        <th>Out</th>
                        <th>Total (min)</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($daily_reports as $daily_report)
                        <tr>
                            <td rowspan="{{count($daily_report["date"]["$date"]['shifts'])+2}}">{{$daily_report["name"]}}</td>
                        </tr>
                        <tr>
                            <td rowspan="{{count($daily_report["date"]["$date"]['shifts'])+2}}">{{$daily_report["department"]}}</td>
                        </tr>
                        @foreach($daily_report["date"]["$date"]['shifts'] as $shift)
                            <tr>
                                <td class="info"><b>{{$shift['start_time']}}</b></td>
                                <td class="{{$shift['late']>0 || Carbon\Carbon::parse($time)->gt($shift['start_time']) ?'danger':''}}" >{{$shift["clock_in_time"]}}</td>
                                <td>{{$shift['late']}}</td>
                                <td>{{$shift["clock_out_time"]}}</td>
                                <td>{{$shift['total_shift_min']}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->

        <!-- /.box-footer -->
    </div>
@endsection
