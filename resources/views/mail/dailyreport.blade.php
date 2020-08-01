<style>
    footer {
        padding: 12px;
        padding-bottom: 8px;
        position: relative;
        height: 40px;
        width: 100%;
        background-color: #BDBDBD;
    }

    p.copyright {
        margin-top: 5px;
        position: absolute;
        width: 100%;
        color: #ffffff;
        line-height: 40px;
        font-size: 1.1em;
        text-align: center;
        bottom:0;
    }
</style>
<style>
    th, td {
        border-bottom: 1px solid #ddd;
    }
    tr:hover {background-color: #f5f5f5}
    tr:nth-child(even) {background-color: #f2f2f2}
</style>
<div style="overflow-x:auto;">
    <table  id="datatable" align="center"  >

        <thead>
        <tr>

            <td colspan="8">
                <img src="<?php echo $message->embed(public_path() . '/img/Attendance_mail_header.png'); ?>" alt="Creating Email Magic" width="100%" height="230" style="display: block;" />
                <!--<img src="{{asset('img/Attendance_mail_header.png')}}" alt="Creating Email Magic" width="100%" height="230" style="display: block;" />-->
            </td>

        </tr>
        <tr>
            <th>Name</th>
            <th>Department</th>
            <th>Shift IN</th>
            <th>In</th>
            <th>Late(min)</th>
            <th>Shift OUT</th>
            <th>Out</th>
            <th>EarlyOut-Mins</th>
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
                    <td><b>{{$shift['start_time']}}</b></td>
                    <td bgcolor="{{$shift['late']>0?'red':''}}"  >{{$shift["clock_in_time"]}}</td>
                    <td>{{$shift['late']}}</td>
                    <td class="info"><b>{{$shift['end_time']}}</b></td>
                    <td>{{$shift["clock_out_time"]}}</td>
                    <td bgcolor="{{$shift['early']>0?'red':''}}" >{{$shift['early']}}</td>




                </tr>

            @endforeach
        @endforeach


        </tbody>
    </table>
</div>

<footer >
    <p >© Vitek {{date("Y")}}</p>
</footer>




