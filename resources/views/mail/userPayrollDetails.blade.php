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

</style>
<div style="overflow-x:auto;">
    <?php $deduction_amount=0;$total_deduction_amount=0;
    ?>
    <table class="" id="datatable" align="center">
        <thead>
        <tr>
            <td colspan="8">
                <img src="<?php echo $message->embed(public_path() . '/img/Attendance_mail_header.png'); ?>" alt="Creating Email Magic" width="100%" height="230" style="display: block;" />
                <!--<img src="{{asset('img/Attendance_mail_header.png')}}" alt="Creating Email Magic" width="100%" height="230" style="display: block;" />-->
            </td>
        </tr>
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
                deduction Amount({{isset($currency)?$currency:''}})
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

                    <td>{{$shift["clock_in_time"]==0?number_format($deduction_amount=($rate_per_min*$shift['late'])+($rate_per_min*$shift['total_shift_min'])):number_format($deduction_amount=$rate_per_min*$shift['late'])}}</td>

                </tr>
                <?php $total_deduction_amount+=$deduction_amount; ?>
            @endforeach
        @endforeach

        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>TOTAL:</td>
            <td>{{number_format($total_deduction_amount)}}</td>
        </tr>
        </tfoot>
    </table>
</div>

<footer >
    <p >© Vitek {{date("Y")}}</p>
</footer>




