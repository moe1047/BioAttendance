@extends('printLayout')
@section('content')

    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> {{env("COMPANY_NAME", "Company Name")}}.

                    <small class="pull-right">{{date("Y/m/d")}}</small>
                </h2>
                <h4 class="text-center">
                    Employee Working Hours.
                </h4>

            </div>
            <!-- /.col -->
        </div>




        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">

                <table class="table table-bordered " id="datatable">
                    <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Saturday
                        </th>
                        <th>
                            Sunday
                        </th>
                        <th>
                            Monday
                        </th>
                        <th>
                            Tuesday
                        </th>
                        <th>
                            Wednesday
                        </th>
                        <th>
                            Thursday
                        </th>
                        <th>
                            Friday
                        </th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $report)
                        <tr>

                            <td>
                                <b>{{$report['name']}}</b>
                            </td>
                            <td>
                                {{round($report["sat"]["mins"]/60,2)}}
                            </td>
                            <td>
                                {{round($report["sun"]["mins"]/60,2)}}
                            </td>
                            <td>
                                {{round($report["mon"]["mins"]/60,2)}}
                            </td>
                            <td>
                                {{round($report["tue"]["mins"]/60,2)}}
                            </td>
                            <td>
                                {{round($report["wed"]["mins"]/60,2)}}
                            </td>
                            <td>
                                {{round($report["thu"]["mins"]/60,2)}}
                            </td>
                            <td>
                                {{round($report["fri"]["mins"]/60,2)}}
                            </td>
                            








                        </tr>
                    @endforeach


                    </tbody>
                </table>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>


@stop
