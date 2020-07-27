<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        {{ isset($title) ? $title.' :: '.config('backpack.base.project_name').' Admin' : config('backpack.base.project_name').' Admin' }}
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body onload="window.print();">
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> Star, Co.

                    <small class="pull-right">{{date("Y/m/d")}}</small>
                </h2>
                <h4 class="text-center">
                    Payment Slip.
                </h4>
                <h6 class="text-center">
                    (FROM:{{$from}} TO:{{$to}})
                </h6>
            </div>
            <!-- /.col -->
        </div>




        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-bordered">

                    <tbody>
                    <tr>
                        <td><b>Name:</b></td>
                        <td >{{ucfirst($name)}}</td>
                        <td><b>Phone No.</b></td>
                        <td >{{$phone}}</td>



                    </tr>

                    <tr>
                        <td><b>Salary / Wage:</b></td>
                        <td>{{number_format($salary)}}</td>
                        <td><b>Currency:</b></td>
                        <td>{{ucfirst($currency)}}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">

                    <table class="table table-bordered">
                        <caption>Payment</caption>
                        <tr>
                            <th style="width:50%">Accumulated Payment:</th>
                            <td>{{number_format($accumulated_amount)}}</td>
                        </tr>
                        <tr>
                            <th>Bonuses</th>
                            <td>0</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>{{number_format($accumulated_amount)}}</td>
                        </tr>
                    </table>

            </div>
            <!-- /.col -->
            <div class="col-xs-6">

                <table class="table table-bordered">
                    <caption>Deductions</caption>
                    <tr>
                        <th style="width:50%">Late:</th>
                        <td colspan="2">{{$late}}/Min</td>
                    </tr>
                    <tr>
                        <th>Absents / Shifts</th>
                        <td>{{$absent_days}} /Days</td>
                        <td>{{$absent_shifts}} /Shifts</td>
                    </tr>
                    <tr>
                        <th>Advances</th>
                        <td colspan="2">{{number_format($advance)}} /{{ucfirst($currency)}}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td colspan="2">{{number_format($deduction_amount+$advance)}}</td>
                    </tr>
                </table>
            </div>
            <hr>
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <tr>
                        <th style="width:50%">Gross Pay:</th>
                        <td>{{number_format(($accumulated_amount-$deduction_amount)-$advance)}} /{{ucfirst($currency)}}</td>
                    </tr>
                </table>
                <div>
                            <h5>Manager:_______________________ &nbsp&nbsp&nbsp&nbsp&nbsp     Cashier:_______________________</h5><h5 class="text-right"></h5>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                </h2>
                <h4 class="text-center">
                    Payment Slip.
                </h4>
                <h6 class="text-center">
                    (FROM:{{$from}} TO:{{$to}})
                </h6>
            </div>
            <!-- /.col -->
        </div>




        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-bordered">

                    <tbody>
                    <tr>
                        <td><b>Name:</b></td>
                        <td >{{ucfirst($name)}}</td>
                        <td><b>Phone No.</b></td>
                        <td >{{$phone}}</td>



                    </tr>

                    <tr>
                        <td><b>Salary / Wage:</b></td>
                        <td>{{number_format($salary)}}</td>
                        <td><b>Currency:</b></td>
                        <td>{{ucfirst($currency)}}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">

                <table class="table table-bordered">
                    <caption>Payment</caption>
                    <tr>
                        <th style="width:50%">Basic:</th>
                        <td>{{number_format($accumulated_amount)}}</td>
                    </tr>
                    <tr>
                        <th>Bonuses</th>
                        <td>0</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td>{{number_format($accumulated_amount)}}</td>
                    </tr>
                </table>

            </div>
            <!-- /.col -->
            <div class="col-xs-6">

                <table class="table table-bordered">
                    <caption>Deductions</caption>
                    <tr>
                        <th style="width:50%">Late:</th>
                        <td colspan="2">{{$late}}/Min</td>
                    </tr>
                    <tr>
                        <th>Absents / Shifts</th>
                        <td>{{$absent_days}} /Days</td>
                        <td>{{$absent_shifts}} /Shifts</td>
                    </tr>
                    <tr>
                        <th>Advances</th>
                        <td colspan="2">{{number_format($advance)}} /{{ucfirst($currency)}}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td colspan="2">{{number_format($deduction_amount+$advance)}}</td>
                    </tr>
                </table>
            </div>
            <hr>
            <div class="col-xs-12">
                <table class="table table-bordered">
                    <tr>
                        <th style="width:50%">Gross Pay:</th>
                        <td>{{number_format(($accumulated_amount-$deduction_amount)-$advance)}} /{{ucfirst($currency)}}</td>
                    </tr>
                </table>
                <div>
                    <h5>Manager:_______________________ &nbsp&nbsp&nbsp&nbsp&nbsp     Cashier:_______________________</h5><h5 class="text-right"></h5>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
    </section>





    <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
