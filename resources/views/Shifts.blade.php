@extends('vendor.backpack.base.layout')

@section('content')
    <div class="col-md-6">
        <form method="POST" action="http://attendance.dev:88/admin/timetable" accept-charset="UTF-8" >
            <input name="_token" type="hidden" value="XuAV7kzDcMkig1nHkTXj2q24LzNfY5yNrtxy2QDV">
            <div class="box">

                <div class="box-header with-border">
                    <h3 class="box-title">Add a new  Shift</h3>
                </div>
                <div class="box-body row">
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- text input -->
                    <div class="form-group col-md-12">
                        <label>Name</label>
                        <input type="text" name="name" value="" class="form-control">
                    </div>

                            <!-- load the view from the application if it exists, otherwise load the one in the package -->
                            <!-- html5 time input -->
                    <div class="form-group col-md-12">
                        <label>Saturday</label>
                        <input type="time" name="start_time" value="" class="form-control">


                    </div>        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <div class="form-group col-md-12">
                        <label>Sunday</label>
                        <input type="time" name="start_time" value="" class="form-control">


                    </div>
                    <div class="form-group col-md-12">
                        <label>Monday</label>
                        <input type="time" name="start_time" value="" class="form-control">


                    </div>
                    <div class="form-group col-md-12">
                        <label>Tuesday</label>
                        <select class="select2 form-control">
                            <option>1</option><option>1</option><option>1</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Wednesday</label>
                        <input type="time" name="start_time" value="" class="form-control">

                    </div>
                    <div class="form-group col-md-12">
                        <label>Thursday</label>
                        <input type="time" name="start_time" value="" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Friday</label>
                        <input type="time" name="start_time" value="" class="form-control">
                    </div>


                </div><!-- /.box-body -->
                <div class="box-footer">

                    <div id="saveActions" class="form-group">

                        <input type="hidden" name="save_action" value="save_and_back">

                        <div class="btn-group">

                            <button type="submit" class="btn btn-success">
                                <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                <span data-value="save_and_back">Save and back</span>
                            </button>

                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aira-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Save Dropdown</span>
                            </button>

                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" data-value="save_and_edit">Save and edit this item</a></li>
                                <li><a href="javascript:void(0);" data-value="save_and_new">Save and new item</a></li>
                            </ul>

                        </div>

                        <a href="http://attendance.dev:88/admin/timetable" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;Cancel</a>
                    </div>
                </div><!-- /.box-footer-->

            </div><!-- /.box -->
        </form>
    </div>
    <div class="col-md-6">
        <div class="box-body table-responsive">



            <div id="crudTable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"><div class="dataTables_length" id="crudTable_length"><label><select name="crudTable_length" aria-controls="crudTable" class="form-control input-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> records per page</label></div></div><div class="col-sm-6"><div id="crudTable_filter" class="dataTables_filter"><label>Search: <input type="search" class="form-control input-sm" placeholder="" aria-controls="crudTable"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="crudTable" class="table table-bordered table-striped display dataTable" role="grid" aria-describedby="crudTable_info">
                            <thead>
                            <tr role="row"><th class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 60px;">Name</th><th class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" aria-label="Start_time: activate to sort column ascending" style="width: 100px;">Start_time</th><th class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" aria-label="End_time: activate to sort column ascending" style="width: 91px;">End_time</th><th class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" aria-label="Late_min: activate to sort column ascending" style="width: 90px;">Late_min</th><th class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" aria-label="Early_min: activate to sort column ascending" style="width: 95px;">Early_min</th><th class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" aria-label="Start_clockin_time: activate to sort column ascending" style="width: 169px;">Start_clockin_time</th><th class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" aria-label="End_clockin_time: activate to sort column ascending" style="width: 158px;">End_clockin_time</th><th class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" aria-label="Start_clockout_time: activate to sort column ascending" style="width: 181px;">Start_clockout_time</th><th class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" aria-label="End_clockout_time: activate to sort column ascending" style="width: 170px;">End_clockout_time</th><th class="sorting" tabindex="0" aria-controls="crudTable" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 124px;">Actions</th></tr>
                            </thead>
                            <tbody>




                            <tr data-entry-id="2" role="row" class="odd">



                                <td>Morning</td>
                                <td>8:00 am</td>
                                <td>12:00 pm</td>
                                <td>5</td>
                                <td>5</td>
                                <td>6:00 am</td>
                                <td>9:00 am</td>
                                <td>10:00 am</td>
                                <td>2:00 pm</td>

                                <td>
                                    <!-- Single edit button -->
                                    <a href="http://attendance.dev:88/admin/timetable/2/edit" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Edit</a>

                                    <a href="http://attendance.dev:88/admin/timetable/2" class="btn btn-xs btn-default" data-button-type="delete"><i class="fa fa-trash"></i> Delete</a>
                                </td>

                            </tr><tr data-entry-id="3" role="row" class="even">

                                <td>Afternoon</td>
                                <td>4:00 pm</td>
                                <td>9:00 pm</td>
                                <td>5</td>
                                <td>5</td>
                                <td>2:00 pm</td>
                                <td>5:00 pm</td>
                                <td>8:00 pm</td>
                                <td>11:00 pm</td>

                                <td>
                                    <!-- Single edit button -->
                                    <a href="http://attendance.dev:88/admin/timetable/3/edit" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Edit</a>

                                    <a href="http://attendance.dev:88/admin/timetable/3" class="btn btn-xs btn-default" data-button-type="delete"><i class="fa fa-trash"></i> Delete</a>
                                </td>

                            </tr></tbody>
                            <tfoot>
                            <tr><th rowspan="1" colspan="1">Name</th><th rowspan="1" colspan="1">Start_time</th><th rowspan="1" colspan="1">End_time</th><th rowspan="1" colspan="1">Late_min</th><th rowspan="1" colspan="1">Early_min</th><th rowspan="1" colspan="1">Start_clockin_time</th><th rowspan="1" colspan="1">End_clockin_time</th><th rowspan="1" colspan="1">Start_clockout_time</th><th rowspan="1" colspan="1">End_clockout_time</th><th rowspan="1" colspan="1">Actions</th></tr>
                            </tfoot>
                        </table></div></div><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="crudTable_info" role="status" aria-live="polite">Showing 1 to 2 of 2 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="crudTable_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="crudTable_previous"><a href="#" aria-controls="crudTable" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="crudTable" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button next disabled" id="crudTable_next"><a href="#" aria-controls="crudTable" data-dt-idx="2" tabindex="0">Next</a></li></ul></div></div></div></div>

        </div>
    </div>

@stop
@section('after_scripts')
    <link rel="stylesheet" href="{{asset('vendor/adminlte/plugins/select2/select2.min.css')}}">
    <script src="{{asset('vendor/adminlte/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".select2").select2();
    });
</script>
@stop