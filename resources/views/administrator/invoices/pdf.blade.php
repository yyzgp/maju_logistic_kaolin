<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>{{ $invoice->invoice_no }}</title>
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
      background: url('/assets/images/scissors.png');
      content: "";
      width: 32px;
      height: 32px;
      position: absolute;
      top: -17px;
      left: 2px;
    }

    #logo {
      text-align: right;
      margin-bottom: 30px;
    }

    #logo img {
      width: 300px;
    }

    h1 {
      color: #000;
      font-size: 2.4em;
      font-weight: normal;
      text-align: left;
      margin: 0 0 10px 0;
    }

    #project {
      float: right;
      width: 50%;
    }

    #indate {
      float: left;
      margin-right: 15px;
    }

    #project span {
      color: #000;
      text-align: right;
      width: 120px;
      margin-right: 10px;
      display: inline-block;
      font-size: 13px;
      font-weight: 600;
      line-height: 22px;
    }

    #company {
      float: left;
      text-align: left;
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
      border-bottom: 1px solid #C1CED9;
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
      border-bottom: 1px solid #C1CED9;
      vertical-align: top;
    }

    table td.service,
    table td.desc {
      vertical-align: top;
    }

    table td.unit,
    table td.qty,
    table td.total {
      font-size: 1.2em;
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
    #incompany {
    float: right;
}
  </style>
</head>

<body>
  <header class="clearfix">
    <div id="logo">
      <img src="{{ public_path('assets/images/logo/login-logo.png') }}">
    </div>

    <div id="company" class="clearfix">
      <h1>TAX INVOICE</h1>
      <div style="margin-bottom: 5px;"> {{ $invoice->merchant->name }}</div>
      <div style="margin-bottom: 5px;">{{ $invoice->merchant->billingDetail->address }}<br /> #07-18</div>
      <div style="margin-bottom: 5px;">SINGAPORE 139949</div>
      <div>SGP</div>
    </div>
    <div id="project">
      <div id="indate">
        <div style="margin-bottom: 12px;">
          <div style="margin-bottom: 3px;"><b>Invoice Date</b></div>
          <div>{{ $invoice->created_at->format("d M Y") }}</div>
        </div>
        <div style="margin-bottom: 12px;">
          <div style="margin-bottom: 3px;"><b>Invoice Number</b></div>
          <div>{{ $invoice->invoice_no }}</div>
        </div>
        <div>
          <div><b>KAOLIN LOGISTIC PTE</b></div>
          <div>{{ $company->uen_no }}</div>
        </div>
      </div>
      <div id="incompany">
        <div style="margin-bottom: 5px;">{{ $company->company }}</div>
      <div style="margin-bottom: 5px;">{{ $company->address_line_1 }}</div>
      <div style="margin-bottom: 5px;">{{ $company->address_line_2 }}
      </div>
      <div style="margin-bottom: 5px;">UEN: {{ $company->uen_no }}</div>
      <div>GST Reg No: {{ $company->gst_no }}</div>
      </div>
    </div>
  </header>
  <main>
    <table>
      <thead>
        <tr>
          <th class="desc" style="text-align: left;">Description</th>
          <th style="text-align: right;">Quantity</th>
          <th style="text-align: right;">Unit Price</th>
          <th style="text-align: right;">Amount SGD</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($invoice->items as $item)
        <tr>
          <td class="desc" width="40%">
              <div style="margin-bottom: 4px;">{{ $item->task->created_at->format('d/m/Y') }}</div>
            {{-- <div style="margin-bottom: 4px;">{{ $invoice->invoice_no }}</div> --}}
            <div style="margin-bottom: 4px;">{{ $item->task->registration_number }}</div>
            <div style="margin-bottom: 4px;">{{ $item->task->address }} {{ $item->task->location }}</div>
            <div style="margin-bottom: 4px;">{{ $item->task->service?->name }}</div>
            <div style="margin-bottom: 4px;">{{ $item->task->battery_tyre_size }}</div>
            <div style="margin-bottom: 4px;">{{ $item->task->ticket_no }}</div>
            {{-- <div> {{ $item->task->notes }}</div>
            <div> {{ $item->task->remarks }}</div> --}}
          </td>
          <td class="unit">1.00</td>
          <td class="qty">{{ $item->task->towing_fee }}</td>
          <td class="total">{{ $item->task->towing_fee }}</td>
        </tr>
        @endforeach

        <tr>
          <td colspan="3" style="border-bottom: none;">Subtotal</td>
          <td class="total" style="border-bottom: none;">{{ $invoice->amount }}</td>
        </tr>
        <tr>
          <td colspan="3">TOTAL GST 9%</td>
          <td class="total">{{ round($invoice->amount * (0.9), 2) }}</td>
        </tr>
        <tr>
          <td colspan="3" class="grand total" style="border-bottom: none;font-weight: 700;
    color: #000;">TOTAL SGD</td>
          <td class="grand total" style="border-bottom: none;font-weight: 700;
    color: #000;">{{ round( $invoice->amount + ($invoice->amount * (0.9)), 2) }}</td>
        </tr>
      </tbody>
    </table>
    <div id="notices">
      <div style="font-size: 17px;"><b>Due Date: {{ \Carbon\Carbon::parse($invoice->created_at)->addMonth()->format('M d Y')  }}</b></div>
      <div style="margin-bottom: 12px;">
        <div style="margin-bottom: 4px;">1) TRANSFER / PAYNOW</div>
        <div style="margin-bottom: 4px;">OCBC - 712452515001</div>
        <div style="margin-bottom: 4px;">UEN - 201730867M</div>
      </div>
      <div style="margin-bottom: 12px;">
        <div style="margin-bottom: 4px;">2) BY CHEQUE</div>
        <div style="margin-bottom: 4px;">Please issue to KAOLIN LOGISTIC PTE LTD</div>
      </div>
      <div style="margin-bottom: 12px;">
        <!-- <a href="https://in.xero.com/m/0hHoKt3Lf0m8XmK4djLC2vdrjYLGsm5TDPYFtgMq?utm_source=invoicePdfLink"
          style="color: #0078c8;font-size: 17px;">View and pay online now</a> -->
      </div>
      <!-- <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div> -->
    </div>

  </main>


  <div class="clearfix payment-advice">


    <div id="company" class="clearfix">
      <h1>PAYMENT ADVICE</h1>
      <div style="margin-bottom: 5px;">To: Logistics Pte Ltd</div>
      <div style="margin-bottom: 5px;margin-left: 20px;">61 Woodlands Industrial Park E9,<br> #04-19, E9 Premium</div>
      <div style="margin-bottom: 5px;margin-left: 20px;">Singapore 757047</div>
      <div style="margin-bottom: 5px;margin-left: 20px;">UEN: 201730867M</div>
      <div style="margin-bottom: 5px;margin-left: 20px;">GST Reg No: 201730867M</div>
    </div>
    <div id="project" style="width: auto;">
      <div><span>Customer</span> {{ $invoice->merchant->name }}</div>
      <div><span>Invoice Number</span> {{ $invoice->invoice_no }}</div>
      <div><span>Amount Due</span> {{ round( $invoice->amount + ($invoice->amount * (0.9)), 2) }}</div>
      <div><span>Due Date</span> {{ \Carbon\Carbon::parse($invoice->created_at)->addMonth()->format('M d Y')  }}</div>
      <div><span>Amount Enclosed</span> <span style="border-bottom: 1px solid;width: 200px;"></span></div>
      <div style="text-align: right;
    font-size: 12px;">Enter the amount you are paying above
      </div>
    </div>
  </div>


  <footer>
    Company Registration No: 201730867M. Registered Office: 33 Ubi Avenue 3, #02-53 Vertex, 408868, Singapore.
  </footer>
</body>

</html>
