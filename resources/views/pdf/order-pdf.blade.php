<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Order #{{$order->order_number}}
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        @font-face {
            font-family: "OpenSans";
            src: {{ asset('fonts/OpenSans-Regular.ttf') }};
            font-weight: normal;
        }
        @font-face {
            font-family: "OpenSans";
            src: {{ asset('fonts/OpenSans-Bold.ttf') }};
            font-weight: bold;
        }
        @page{
            margin: 60px 30px 30px;
            padding: 0;
        }
        html {
            box-sizing: border-box;
            -ms-overflow-style: scrollbar;
        }

        *,
        *::before,
        *::after {
            font-family: "OpenSans", sans-serif;
            font-size: 0.96em;
            box-sizing: inherit;
        }
        .img-responsive{
            display: block;
            max-width: 100%;
            height: auto;
        }
        .container {
            width: calc(100% - 30px);
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        .row {
            width: 100%;
            margin-right: -15px;
            margin-left: -15px;
        }
        .container:before, .container:after, .row:before, .row:after {
            display: table;
            content: ' ';
        }
        .row:after{
            clear: both;
        }
        .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col-20{
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }
        .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col-20{
            float: left;
        }
        .col-12 {
            width: 100%;
        }
        .col-11 {
            width: 91.66666667%;
        }
        .col-10 {
            width: 83.33333333%;
        }
        .col-9 {
            width: 75%;
        }
        .col-8 {
            width: 66.66666667%;
        }
        .col-7 {
            width: 58.33333333%;
        }
        .col-6 {
            width: 50%;
        }
        .col-5 {
            width: 41.66666667%;
        }
        .col-4 {
            width: 33.33333333%;
        }
        .col-3 {
            width: 25%;
        }
        .col-2 {
            width: 16.66666667%;
        }
        .col-1 {
            width: 8.33333333%;
        }
        .text-center{
            text-align: center;
        }
        .col-20{
            width: 16%;
        }

        h2{
            font-size: 18px;
            margin-bottom: 5px;
        }
        .pd-10{
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .pd-15{
            padding-top: 15px;
            padding-bottom: 15px;
        }
        .pd-20{
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .mb-10{
            margin-bottom: 10px;
        }
        .mt-20{
            margin-top: 20px;
        }
        .mt-30{
            margin-top: 30px;
        }
        .mt-100{
            margin-top: 100px;
        }
        .page-break{
            page-break-after: always;
        }
        .list{
            list-style-type: none;
        }
        .list li{
            margin: 40px 0;
            position: relative;
        }
        .list li:before{
            counter-increment: section;
            content: counter(section) '.';
            position: absolute;
            display: block;
            left: -25px;
        }

        table{
            border-collapse: collapse;
            width: 100%;
        }
        th,td{
            padding: 5px;
        }
        thead{
            background-color: #dddddd;
        }
        .nowrap{
            white-space: nowrap;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }
        .text-right{
            text-align: right;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-6">
            <h2>
                Order #{{$order->order_number}}<br>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <h3>Distributor</h3>
            Unknown Co.<br>
            Address 00<br>
            000 00, City<br>
            Country<br>
            <br>
            Business ID: 00000000<br>
            Tax ID: 0000000000<br>
            Distributor is excluded from VAT<br>
        </div>
        <div class="col-6">
            <h3>Customer</h3>
            {{$order->customer_name}}<br>
            {{$order->customer_address}}<br>
            <br>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-6">
            Order Issued On: {{$order->created_at}}
        </div>
        <div class="col-6">
            Order Payment Due Date: {{$order->due_date}}
        </div>
    </div>

    <div class="row">
        <div class="col-6">Is Order Paid?: {{$order->payment_date ? "Yes" : "No"}}</div>
        <div class="col-6">@if($order->payment_date)Order Payment Date: {{$order->payment_date}}@endif</div>
    </div>

    <div class="row mt-20">
        <div class="col-12">

            <table>
                <thead>
                <tr>
                    <th class="text-center">Item Name</th>
                    <th class="text-center">Count</th>
                    <th class="text-center">Cost (excl. VAT)</th>
                    <th class="text-center">VAT %</th>
                    <th class="text-center">Cost (incl. VAT)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->order_items as $item)
                <tr>
                    <td class="text-center">{{$item->name}}</td>
                    <td class="text-center">{{$item->count}} @if($item->count > 1) pcs @else pc @endif</td>
                    <td class="text-center">{{$item->cost}} €</td>
                    <td class="text-center">{{$item->vat * 100}}%</td>
                    <td class="text-center">{{$item->cost_with_vat}} €</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="row">
        <div class="col-5" style="float: right;">
            <h2>
                <span>Total (incl. VAT)</span>
                <span style="float: right; margin-right: -30px;">{{number_format($order->total_cost_with_vat, 2)}} €</span>
            </h2>
        </div>
    </div>

    <div class="row mt-100">
        <div class="col-12 text-right">
            <!-- <img src="{{-- asset('signature.png') --}}" alt="signature" width="44"> -->

            ..................................................
        </div>
    </div>
</div>
</body>
</html>
