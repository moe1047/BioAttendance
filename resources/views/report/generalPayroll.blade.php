@extends('vendor.backpack.base.layout')
@section('before_styles')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2') }}/select2.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datepicker') }}/datepicker3.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables') }}/dataTables.bootstrap.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/') }}/iCheck/all.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/') }}/daterangepicker/daterangepicker.css">
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-offset-2 col-sm-offset-1 col-sm-offset-4">
                        <form role="form" class="form-inline" action="{{url('admin/report/general')}}" method="post">
                            {{ csrf_field() }}
                            <!--<div class="form-group">
                                <label>Date and time range:</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="reservationtime" name="daterange" required>
                                </div>

                            </div>
                            <input type="hidden"  id="from_date" name="from_date">
                            <input type="hidden"  id="to_date" name="to_date">-->
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    From:
                                </label>
                                <input type="text" class="form-control date" id="exampleInputEmail1" name="from_date" value="{{isset($from_date)?$from_date:''}}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">
                                    To:
                                </label>
                                <input type="text" class="form-control date" id="exampleInputPassword1" name="to_date" value="{{isset($to_date)?$to_date:''}}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">
                                    Type:
                                </label>
                                {!! Form::select("type",  array('all' => 'All','late' => 'Late', 'absent' => 'Absents'), isset($type)?$type:null, ['class'=>'form-control select2']) !!}
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">
                                    Department:
                                </label>

                                {!! Form::select("departments", $departments,  isset($departments)?$departments:null, ['class'=>'form-control select2']) !!}
                            </div>
                            <button class="btn btn-success" name="search"  value="search">Search</button><span>
				            <button class="btn btn-default" name="print" value="print">Print</button></span>
                            <button class="btn btn-default" name="email" value="email">Send Email</button>
                            <button class="btn btn-default" name="email" value="email" data-toggle="modal" data-target="#myModal" onclick="return false"><span class="fa fa-book" ></span> Email List</button>


                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Email List</h4>
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


                        </form><br>
                    </div>


                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Result</h3>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
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
                                                Absent Days
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
                                                    {{$report['working_days'] - $report['worked_days']}}
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
                                                    {{number_format($report['salary'] - number_format($report['deduction_amount'],0),2)}}
                                                </td>
                                                <td>
                                                    <a href="{{url('admin/report/payslip?name='.$report['name'].'&id='.$id.'&from='.$from_date.'&to='.$to_date.
                                                    '&total_worked_days='.$report['worked_days'].'&late='.$report['late'].'&deduction_amount='.$report['deduction_amount']
                                                    .'&working_days='.$report['working_days'].'&worked_days='.$report['worked_days'].'&advance='.$report['advance'].
                                                    '&accumulated_rate='.$report['accumulated_rate'].'&absent_shifts='.$report['absent_shifts'])}}"
                                                       class="btn btn-success btn-sm">Payslip</a>
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
                                                        <td>
                                                            <a href="{{url('admin/report/payslip?name='.$report['name'].'&id='.$id.'&from='.$from_date.'&to='.$to_date.
                                                    '&total_worked_days='.$report['worked_days'].'&late='.$report['late'].'&deduction_amount='.$report['deduction_amount']
                                                    .'&working_days='.$report['working_days'].'&worked_days='.$report['worked_days'].'&advance='.$report['advance'].
                                                    '&accumulated_rate='.$report['accumulated_rate'].'&absent_shifts='.$report['absent_shifts'])}}"
                                                               class="btn btn-success btn-sm">Payslip</a>
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
                                                        <td>
                                                            <a href="{{url('admin/report/payslip?name='.$report['name'].'&id='.$id.'&from='.$from_date.'&to='.$to_date.
                                                    '&total_worked_days='.$report['worked_days'].'&late='.$report['late'].'&deduction_amount='.$report['deduction_amount']
                                                    .'&working_days='.$report['working_days'].'&worked_days='.$report['worked_days'].'&advance='.$report['advance'].
                                                    '&accumulated_rate='.$report['accumulated_rate'].'&absent_shifts='.$report['absent_shifts'])}}"
                                                               class="btn btn-success btn-sm">Payslip</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach


                                        </tbody>
                                    </table>
                                    @endif


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
    <!-- iCheck 1.0.1 -->
    <script src="{{asset('vendor/adminlte/plugins/')}}/iCheck/icheck.min.js"></script>

    <!-- date-range-picker -->
    <script src="{{asset('vendor/adminlte/plugins/')}}/daterangepicker/moment.min.js"></script>
    <script src="{{asset('vendor/adminlte/plugins/')}}/daterangepicker/daterangepicker.js"></script>



    <script type="text/javascript">
        var deleteShift=function ($id){
            if(confirm("are you sure you want to delete this shift?")==true){
                $.ajax({
                    url: '/admin/shift/'+$id,
                    type: 'DELETE',
                    success: function(result) {
                        // Show an alert with the result
                        new PNotify({
                            title: "Item Deleted",
                            text: result,
                            type: "success"
                        });
                        location.reload();
                    }

                })
            }
        }
        $( document ).ready(function() {
            //iCheck for checkbox and radio inputs

            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });

            $( ".select2" ).select2({});
            $('.date').datepicker({
                format: "yyyy-mm-dd"
            });
            $("#datatable").DataTable();
            $("body").addClass('sidebar-collapse');

            $('input[name="daterange"]').daterangepicker(
                    {
                        locale: {
                            format: 'YYYY-MM-DD'
                        },
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                        startDate: moment().subtract(29, 'days'),
                        endDate: moment()
                    },
                    function (start, end) {
                        $('#from_date').val(start.format('YYYY-MM-DD'));
                        $('#to_date').val(end.format('YYYY-MM-DD'));
                        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    }
            );
            $('input[name="daterange"]').val('');
            //$('input[name="daterange"]').val('YYYY-MM-DD');
        });

    </script>

@stop
