@extends('printLayout')
@section('content')

    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i>{{env("COMPANY_NAME", "Company Name")}}.

                    <small class="pull-right">{{date("Y/m/d")}}</small>
                </h2>
                <h4 class="text-center">
                    Detail User Attendance.
                </h4>
                <h4 class="text-center">
                     {{$user_full_name}}
                </h4>
                <h6 class="text-center">
                    (FROM:{{$from_date}} TO:{{$to_date}}) - (Currency={{$currency}})
                </h6>
            </div>
            <!-- /.col -->
        </div>




        <div class="row">
            <div class="col-xs-12">
                <div class="">
                    <!-- /.box-header -->
                    <div class="">
                        <?php $deduction_amount=0;$total_deduction_amount=0;$total_late_min=0;$total_working_days=0;$total_worked_days=0;$total_absent_days=0;
                        ?>

                        @if(isset($reports))
                            <table class="table table-bordered " id="datatable">
                                <thead>
                                <tr>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Day
                                    </th>
                                    <th>
                                        Shift
                                    </th>
                                    <th>
                                        Clocked IN
                                    </th>
                                    <th>
                                        Late(mins)
                                    </th>
                                    <th>
                                        Paid Rate
                                    </th>
                                    <th>
                                        deduction Amount
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reports as $date=>$report)

                                    <tr>
                                        <td rowspan="{{count($report['shifts'])+1}}">{{$date}}</td>
                                        <td rowspan="{{count($report['shifts'])+1}}">{{$report["day"]}}</td>
                                    </tr>
                                    @foreach($report['shifts'] as $shift)
                                        <tr>
                                            <td>{{$shift['start_time']}}</td>
                                            <td>{{$shift["clock_in_time"]}}</td>
                                            <td>{{$shift['late']}}</td>
                                            <td>{{$rate_per_min=$report["total_min"]==0?$day_rate:(round($day_rate/$report["total_min"],4))}}</td>

                                            <td>{{$shift["clock_in_time"]==0?number_format($deduction_amount=($rate_per_min*$shift['late'])+($rate_per_min*$shift['total_shift_min']), 2, '.', ','):number_format($deduction_amount=$rate_per_min*$shift['late'], 2, '.', ',')}}</td>
                                            @if ($shift['present'] == 1)
                                                <td class="success">Present</td>
                                            @elseif ($shift['present'] == 0)
                                                <td class="danger">Absent</td>
                                            @else
                                                <td>Not Set</td>
                                            @endif

                                        </tr>
                                        <?php $total_deduction_amount+=$deduction_amount; ?>
										<?php $total_late_min+=$shift['late']; ?>
                                    @endforeach
                                    <?php $total_working_days+=$report["working_day"]; ?>
                                    <?php $total_worked_days+=$report["worked_day"]; ?>
                                @endforeach

                                </tbody>
                                <tr>
                                    <td><b>T.Working Days</b></td>
                                    <td><b>{{$total_working_days}}</b></td>
                                    <td><b>T.Worked Days</b></td>
                                    <td><b>{{$total_worked_days}}</b></td>
                                    <td><b>T.Absent Days</b></td>
                                    <td><b>{{$total_working_days - $total_worked_days }}</b></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>

                                  <td><b>T.Late:</b></td>
                                  <td>{{$total_late_min}}</td>
                                  <td><b>T.Deduction:</b></td>
                                  <td>{{number_format($total_deduction_amount, 2, '.', ',')}}</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>


                                </tr>
                            </table>
                        @endif


                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>

    </section>


@stop
