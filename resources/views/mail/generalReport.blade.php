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
        <tr >

            <td colspan="8">
                <img src="<?php echo $message->embed(public_path() . '/img/Attendance_mail_header.png'); ?>" alt="Creating Email Magic" width="100%" height="230" style="display: block;" />
                <!--<img src="{{asset('img/Attendance_mail_header.png')}}" alt="Creating Email Magic" width="100%" height="230" style="display: block;" />-->
            </td>

        </tr>
        <tr>
            <th>
                Name
            </th>
            <th >
                Working Days
            </th>
            <th >
                Worked Days
            </th>
            <th >
                Working Shifts
            </th>
            <th >
                Worked Shifts
            </th>
            <th >
                Late(mins)
            </th>
            <th >
                Advances
            </th>

            <th>
                deduction Amount
            </th>

        </tr>
        </thead>
        <tbody>
        @foreach($reports as $id=>$report)
            @if($type=="all")
                <tr >
                    <td >
                        {{$report['name']}}
                    </td>

                    <td >
                        {{$report['working_days']}}
                    </td>
                    <td >
                        {{$report['worked_days']}}
                    </td>
                    <td >
                        {{$report['all_shifts']}}
                    </td>
                    <td >
                        {{$report['worked_shifts']}}
                    </td>
                    <td >
                        {{$report['late']}}
                    </td>
                    <td >
                        {{$report['advance']}}
                    </td>
                    <td >
                        {{number_format($report['deduction_amount']).' /'.$report['currency']}}
                    </td>
                </tr>
            @elseif($type=="late")
                @if($report['late']>0)
                    <tr >
                        <td >
                            {{$report['name']}}
                        </td>

                        <td >
                            {{$report['working_days']}}
                        </td>
                        <td >
                            {{$report['worked_days']}}
                        </td>
                        <td >
                            {{$report['all_shifts']}}
                        </td>
                        <td >
                            {{$report['worked_shifts']}}
                        </td>
                        <td >
                            {{$report['late']}}
                        </td>
                        <td >
                            {{$report['advance']}}
                        </td>
                        <td >
                            {{number_format($report['deduction_amount']).' /'.$report['currency']}}
                        </td>
                    </tr>
                @endif
            @elseif($type=="absent")
                @if($report['all_shifts']-$report['worked_shifts']>0)
                    <tr >
                        <td >
                            {{$report['name']}}
                        </td>

                        <td >
                            {{$report['working_days']}}
                        </td>
                        <td >
                            {{$report['worked_days']}}
                        </td>
                        <td >
                            {{$report['all_shifts']}}
                        </td>
                        <td >
                            {{$report['worked_shifts']}}
                        </td>
                        <td >
                            {{$report['late']}}
                        </td>
                        <td >
                            {{$report['advance']}}
                        </td>
                        <td >
                            {{number_format($report['deduction_amount']).' /'.$report['currency']}}
                        </td>
                    </tr>
                @endif
            @endif

        @endforeach


        </tbody>
    </table>
    </div>

    <footer >
        <p >© Vitek {{date("Y")}}</p>
    </footer>




