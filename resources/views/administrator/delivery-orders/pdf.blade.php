<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Delivery Order {{ $delivery_id }}</title>
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            /* width: 21cm; */
            width: 100%;
            /* height: 29.7cm; */
            height: 100%;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 13px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        .payment-advice {
            padding: 18px 0;
            margin-bottom: 30px;
            border-top: 2px dashed;
            position: relative;
        }

        .payment-advice::before {
            background: url(scissors.png);
            content: "";
            width: 32px;
            height: 32px;
            position: absolute;
            top: -17px;
            left: 2px;
        }

        #logo {
            text-align: center;
            margin-bottom: 30px;
        }

        #logo img {
            width: 450px;
        }

        h1 {
            color: #0070c0;
            font-size: 2.3em;
            font-weight: 600;
            text-align: right;
            margin: 0 0 10px 0;
        }

        #project {
            float: right;
            width: 40%;
        }

        #indate {
            float: right;
            text-align: end;
        }

        #project span {
            color: #000;
            text-align: right;
            width: 80px;
            display: inline-block;
            font-size: 13px;
            font-weight: 400;
        }

        #company {
            float: left;
            text-align: left;
            width: 60%;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        /* table tr:nth-child(2n-1) td {
      background: #F5F5F5;
    } */

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 5px;
            color: #000000;
            border: 1px solid #111;
            white-space: nowrap;
            font-weight: 600;
            font-size: 14px;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            /* padding: 20px; */
            padding: 10px 5px;
            text-align: right;
            border: 1px solid #111;
            vertical-align: top;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            /* font-size: 1.2em; */
        }

        table td.grand {
            border-top: 1px solid #5D6975;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        #notices {
            height: 300px;
        }

        footer {
            color: #111;
            width: 100%;
            height: 30px;
            position: relative;
            bottom: 0;
            /* border-top: 1px solid #C1CED9; */
            padding: 8px 0;
            text-align: left;
            font-size: 11px;
        }

        /* .main-row{
        height: 350px;
        overflow: hidden;
        white-space: nowrap;
    } */
        .desc-td {
            position: relative;
        }

        .noteDiv {
            color: #ff0000;
            text-align: center;
            margin-top: 200px;
        }

    </style>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="{{ public_path('assets/images/logo/login-logo.png') }}" width="30%">
        </div>

        <div id="company" class="clearfix">
            <div style="margin-bottom: 6px;">{{ $company->company }} UEN: {{ $company->uen_no }}</div>
            <div style="margin-bottom: 6px;">{{ $company->address_line_1 }} {{ $company->address_line_2 }}</div>
            <div style="margin-bottom: 6px;">
                TEL: {{ $company->phone }} HP: +88009090
            </div>
            <div style="margin-bottom: 6px;">
                EMAIL: {{ $company->email }}
            </div>

            <div style="margin-top: 25px;">
                BILL TO: {{ $merchant->name }}
            </div>
        </div>
        <div id="project">
            <h1>DELIVERY ORDER</h1>
            <div id="indate">
                <div style="margin-bottom: 12px;">
                    <div style="margin-bottom: 3px;"><b>DELIVERY ORDER :</b> <span>{{ $delivery_id }}</span></div>
                </div>
                <div style="margin-bottom: 12px;">
                    <div style="margin-bottom: 3px;"><b>Date :</b>
                        <span>{{ \Carbon\Carbon::parse($task->completion_time)->format('M d Y') }}</span>
                    </div>
                </div>
                <div style="margin-bottom: 12px;">
                    <div style="margin-bottom: 3px;"></div>
                </div>

            </div>

        </div>
    </header>
    <main>
        <table style="border: 1px solid #111;">
            <thead>
                <tr>
                    <th class="desc" style="text-align: left;">DATE</th>
                    <th class="desc" style="text-align: left;">DESCRIPTION</th>
                    <th style="text-align: center;width: 100px;">VEHICLE NO.</th>
                    <th style="text-align: center;width: 100px;">JOB NO.</th>
                    <th style="text-align: center;width: 100px;">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="date" style="text-align: left;width: 90px;">{{ $task->created_at->format('d-m-Y') }}
                    </td>
                    <td class="desc">
                        <div style="margin-bottom: 4px;">{{ $task->address }}</div>
                        <div style="margin-bottom: 4px;">{{ $task->location }}</div>
                        <div style="margin-bottom: 4px;">{{ $task->service?->name }}</div>
                        <div class="noteDiv">Note: Please be requested to
                            pay the current invoice amount within
                            30 days upon receipt</div>
                    </td>
                    <td class="unit" style="text-align: center;">{{ $task->registration_no }}</td>
                    <td class="qty" style="text-align: center;">
                        {{ isset($task->ticket_no) ? $task->ticket_no : $delivery_id }}</td>
                    <td class="total" style="text-align: center;">$ {{ $task->towing_fee }}</td>
                </tr>
                <tr>
                    <td style="border: none;position: relative;">
                        <div style="position: absolute;width: 230px;text-align: left;">
                            <div style="margin-bottom: 6px;">
                                PAYNOW to: {{ $company->uen_no }}
                            </div>
                            <div style="margin-bottom: 6px;">
                                Remit to: KAOLIN LOGISTIC PTE LTD
                            </div>
                            <div style="margin-bottom: 6px;">
                                Bank: OCBC
                            </div>
                            <div style="margin-bottom: 6px;">
                                Bank Code: 7339 Branch Code: 712
                            </div>
                            <div style="margin-bottom: 6px;">
                                Account No.: 712452515001 (SGD)
                            </div>
                        </div>
                    </td>
                    <td colspan="3" style="border-bottom: none;border: none;border-right: 1px solid #111;">Amount:
                    </td>
                    <td class="total" style="border-bottom: none;border: none;">$ {{ $task->towing_fee }}</td>
                </tr>
                <tr>
                    <td colspan="4" style="border-bottom: none;border: none;border-right: 1px solid #111;">GST@ 9%
                    </td>
                    <td class="total" style="border-bottom: none;border: none;">
                        {{ round($task->towing_fee * 0.09, 2) }}</td>
                </tr>
                <tr style="line-height: 28px;">
                    <td colspan="4" class="grand total"
                        style="border-bottom: none;border: none;border-right: 1px solid #111;font-weight: 700;
    color: #000;vertical-align: bottom;position: relative;
    top: 8px;">
                        Net Payable</td>
                    <td class="grand total"
                        style="border-bottom: none;border: none;font-weight: 700;
    color: #000;vertical-align: bottom;position: relative;
    top: 8px;">
                        {{ round($task->towing_fee * 0.09 + $task->towing_fee, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <table style="border: 1px solid #111; margin-top:20px;">
            <tbody>

                    @php $chunks = $task->photos->chunk(3); @endphp
                    @foreach ($chunks as $chunk)
                    <tr>
                    @foreach ($chunk as $photo)
                        <td style="text-align: center;width: 33%;"><img style="width: 200px;"
                                src="{{ asset('storage/uploads/task-photos/' . $task->id . '/' . $photo->photo) }}"
                                alt=""></td>

                    @endforeach

                </tr>
                    @endforeach


                @isset($task->signature)
                    <tr>
                        <td style="text-align: left;" colspan="3">
                            <img src="{{ $task->signature }}" width="200px" height="200px" style="border:1px solid #777"
                                class="downloadable" />
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </main>
    </body>

    </html>
