@extends('printLayout')
@section('content')

    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> Premier Bank.

                    <small class="pull-right">{{date("d/m/Y")}}</small>
                </h2>
                <h4 class="text-center">
                     Attendance Report for <b>{{$date}}</b>.
                </h4>

            </div>
            <!-- /.col -->
        </div>




    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            @if(isset($daily_reports))
                <table class="table no-margin table-stripped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Shift IN</th>
                        <th>In</th>
                        <th>Late(min)</th>
                        <th>Out</th>
                        


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
                                <td class="{{$shift['late']>0?'danger':''}}" >{{$shift["clock_in_time"]}}</td>
                                <td>{{$shift['late']}}</td>
                                <td>{{$shift["clock_out_time"]}}</td>
                                




                            </tr>

                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    </section>


@stop
