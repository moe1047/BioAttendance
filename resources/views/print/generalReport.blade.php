@extends('printLayout')
@section('content')

    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> Premier Bank.

                    <small class="pull-right">{{date("Y/m/d")}}</small>
                </h2>
                <h4 class="text-center">
                    General Attendance Report.<br>
                    {{$department}} Department
                </h4>
                <h6 class="text-center">
                    (FROM:{{$from_date}} TO:{{$to_date}})
                </h6>
            </div>
            <!-- /.col -->
        </div>
        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                @if(isset($reports))
                    <table class="table table-bordered " id="datatable">
                        <thead>
                        <tr>
                            <th>
                                Name
                            </th>
                            <th>
                                Working Days
                            </th>
                            <th>
                                Worked Days
                            </th>
                            <th>
                                Working Shifts
                            </th>
                            <th>
                                Worked Shifts
                            </th>
                            <th>
                                Late(mins)
                            </th>
                            <th>
                                Advances
                            </th>
                            <th>
                                Salary
                            </th>

                            <th>
                                deduction Amount
                            </th>
                            <th>
                                To pay
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reports as $id=>$report)
                            @if($type=="all")
                                <tr>

                                    <td>
                                        {{$report['name']}}
                                    </td>

                                    <td>
                                        {{$report['working_days']}}
                                    </td>
                                    <td>
                                        {{$report['worked_days']}}
                                    </td>
                                    <td>
                                        {{$report['all_shifts']}}
                                    </td>
                                    <td>
                                        {{$report['worked_shifts']}}
                                    </td>
                                    <td>
                                        {{$report['late']}}
                                    </td>
                                    <td>
                                        {{$report['advance']}}
                                    </td>
                                    <td>
                                        {{$report['salary']}}
                                    </td>

                                    <td>
                                        {{number_format($report['deduction_amount'],0) .' /'.$report['currency']}}
                                    </td>
                                    <td>
                                        {{$to_pay=number_format($report['salary'] - $report['deduction_amount'])}}
                                    </td>
                                </tr>
                            @elseif($type=="late")
                                @if($report['late']>0)
                                    <tr>

                                        <td>
                                            {{$report['name']}}
                                        </td>

                                        <td>
                                            {{$report['working_days']}}
                                        </td>
                                        <td>
                                            {{$report['worked_days']}}
                                        </td>
                                        <td>
                                            {{$report['all_shifts']}}
                                        </td>
                                        <td>
                                            {{$report['worked_shifts']}}
                                        </td>
                                        <td>
                                            {{$report['late']}}
                                        </td>
                                        <td>
                                            {{$report['advance']}}
                                        </td>
                                        <td>
                                            {{$report['salary']}}
                                        </td>
                                        <td>
                                            {{number_format($report['deduction_amount'],0) .' /'.$report['currency']}}
                                        </td>
                                        <td>
                                            {{$to_pay=number_format($report['salary'] - $report['deduction_amount'])}}
                                        </td>
                                    </tr>
                                @endif
                            @elseif($type=="absent")
                                @if($report['all_shifts']-$report['worked_shifts']>0)
                                    <tr>

                                        <td>
                                            {{$report['name']}}
                                        </td>

                                        <td>
                                            {{$report['working_days']}}
                                        </td>
                                        <td>
                                            {{$report['worked_days']}}
                                        </td>
                                        <td>
                                            {{$report['all_shifts']}}
                                        </td>
                                        <td>
                                            {{$report['worked_shifts']}}
                                        </td>
                                        <td>
                                            {{$report['late']}}
                                        </td>
                                        <td>
                                            {{$report['advance']}}
                                        </td>
                                        <td>
                                            {{$report['salary']}}
                                        </td>
                                        <td>
                                            {{number_format($report['deduction_amount'],0) .' /'.$report['currency']}}
                                        </td>
                                        <td>
                                            {{$to_pay=number_format($report['salary'] - $report['deduction_amount'])}}
                                        </td>
                                    </tr>
                                @endif
                            @endif

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
