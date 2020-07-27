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
                    Employee Schedule.
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
                        @foreach($users as $user)
                            <tr>

                                <td>
                                    <b>{{$user->NAME}}</b>
                                </td>
                                @if(count($user->OneUserShift))
                                    <td>
                                        @foreach($user->defaultAcYearShift->first()->shift->shiftTimetables()->where('day', "sat")->get() as $shiftTimetable)
                                            {{$shiftTimetable->timetable->start_time}}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($user->defaultAcYearShift->first()->shift->shiftTimetables()->where('day', "sun")->get() as $shiftTimetable)
                                            {{$shiftTimetable->timetable->start_time}} <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($user->defaultAcYearShift->first()->shift->shiftTimetables()->where('day', "mon")->get() as $shiftTimetable)
                                            {{$shiftTimetable->timetable->start_time}} <br>
                                        @endforeach

                                    </td>
                                    <td>
                                        @foreach($user->defaultAcYearShift->first()->shift->shiftTimetables()->where('day', "tue")->get() as $shiftTimetable)
                                            {{$shiftTimetable->timetable->start_time}} <br>
                                        @endforeach

                                    </td>
                                    <td>
                                        @foreach($user->defaultAcYearShift->first()->shift->shiftTimetables()->where('day', "wed")->get() as $shiftTimetable)
                                            {{$shiftTimetable->timetable->start_time}}<br>
                                        @endforeach

                                    </td>
                                    <td>
                                        @foreach($user->defaultAcYearShift->first()->shift->shiftTimetables()->where('day', "thu")->get() as $shiftTimetable)
                                            {{$shiftTimetable->timetable->start_time}} <br>
                                        @endforeach

                                    </td>
                                    <td>
                                        @foreach($user->defaultAcYearShift->first()->shift->shiftTimetables()->where('day', "fri")->get() as $shiftTimetable)
                                            {{$shiftTimetable->timetable->start_time}} <br>
                                        @endforeach

                                    </td>
                                @else
                                    <td>-

                                    </td>
                                    <td>-

                                    </td>
                                    <td>-

                                    </td>
                                    <td>-

                                    </td>
                                    <td>-

                                    </td>
                                    <td>-

                                    </td>
                                    <td>-

                                    </td>

                                @endif



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
