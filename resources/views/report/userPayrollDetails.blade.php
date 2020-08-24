@extends('vendor.backpack.base.layout')
@section('before_styles')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2') }}/select2.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datepicker') }}/datepicker3.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables2') }}/datatables.min.css">
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
                    <div class="col-md-offset-3 col-sm-offset-1 col-sm-offset-4">
                        <form role="form" class="form-inline" action="{{url('admin/report/detail')}}" method="post">
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
                                <input type="text" class="form-control date" id="from_date" name="from_date" value="{{isset($from_date)?$from_date:''}}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">
                                    To:
                                </label>
                                <input type="text" class="form-control date" id="to_date" name="to_date" value="{{isset($to_date)?$to_date:''}}" required>
                            </div>

                            <div class="form-group ">
                                <label for="exampleInputPassword12">
                                    User:
                                </label>

                                    {!! Form::select("user_id", $users, $selected_id, ['class'=>'form-control select2',"id"=>"user"]) !!}



                            </div>


                            <button class="btn btn-success" name="search"  value="search">Search</button><span>
				            <button class="btn btn-default" name="print" value="print">Print</button></span>
                            <button class="btn btn-default" name="email" value="email">Send Email</button>
                            <button class="btn btn-default" name="email" value="email" data-toggle="modal" data-target="#myModal" onclick="return false"><span class="fa fa-book" ></span> Email List</button>
                            <!--
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" class="minimal flat-red" checked>
                                    Monthly Salary
                                </label>

                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" class="minimal flat-red" >
                                    Wage
                                </label>

                            </div>-->
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
                    <h3 class="box-title">Result {{isset($currency)?'(Currency='.$currency.')':''}}</h3>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
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
                                                Shift In
                                            </th>
                                            <th>
                                                Clocked in
                                            </th>
                                            <th>
                                                Shift out
                                            </th>
                                            <th>
                                                Clocked out
                                            </th>
                                            <th>
                                                Late(mins)
                                            </th>
											<th>
                                                Total Shift(mins)
                                            </th>
                                            <th>
                                                Paid Rate
                                            </th>
                                            <th>
                                                deduction Amount
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($reports as $date=>$report)
                                        @foreach($report['shifts'] as $shift)
                                            <tr>
                                                <td>{{$date}}</td>
                                                <td>{{$report["day"]}}</td>
                                                <td><b>{{$shift['start_time']}}</b></td>
                                                <td>{{$shift["clock_in_time"]}}</td>
                                                <td><b>{{$shift['end_time']}}</b></td>
                                                <td>{{$shift["clock_out_time"]}}</td>
                                                <td>{{$shift['late']}}</td>
												                        <td>{{$shift['total_shift_min']}}</td>
                                                <td>{{$rate_per_min=$report["total_min"]==0?$day_rate:(round($day_rate/$report["total_min"],4))}}</td>

                                                <td>{{$shift["clock_in_time"]==0?number_format($deduction_amount=($rate_per_min*$shift['late'])+($rate_per_min*$shift['total_shift_min']), 2, '.', ','):number_format($deduction_amount=$rate_per_min*$shift['late'], 2, '.', ',')}}</td>

                                            </tr>
                                            <?php $total_late_min+=$shift['late']; ?>
                                            <?php $total_deduction_amount+=$deduction_amount; ?>


                                        @endforeach


                                        <?php $total_working_days+=$report["working_day"]; ?>
                                        <?php $total_worked_days+=$report["worked_day"]; ?>
                                        @endforeach
                                        <tr>
                                            <td><b>T.Working Days</b></td>
                                            <td><b>{{$total_working_days}}</b></td>
                                            <td><b>T.Worked Days</b></td>
                                            <td><b>{{$total_worked_days}}</b></td>
                                            <td><b>T.Absent Days</b></td>
                                            <td><b>{{$total_working_days - $total_worked_days }}</b></td>
                                            <td><b>T.Late:</b></td>
                                            <td>{{$total_late_min}}</td>
                                            <td><b>T.Deduction:</b></td>
                                            <td>{{number_format($total_deduction_amount, 2, '.', ',')}}</td>

                                        </tr>

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
    <script src="{{asset('vendor/adminlte/plugins/datatables2')}}/datatables.min.js"></script>

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
            $("#datatable").DataTable({
              "pageLength": 50,
                dom: 'Bfrtip',
                responsive: true,
                colReorder: true,
                buttons: [

                    {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0,1,2,3,4,5,6,7,8,9 ]
                    },
                    title: $("#user option:selected").text()+" " + $("#from_date").val()+ " to " + $("#to_date").val()

                },
                 'csv','colvis'


                ]
            } );

            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });

            $( ".select2" ).select2({});
            $('.date').datepicker({
                format: "yyyy-mm-dd"
            });
            //$("#datatable").DataTable();
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
