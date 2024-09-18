<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        html {
            margin: 0
        }
        .bg-image {
            background-image: url("data:image/png;base64,{{$bg_image}}");
            width: 210mm;
            height: 297mm;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .title {
            text-align: center;
            color: #4d7241;
            font-size: 70px;
            margin-top: 95px;
            margin-bottom: 95px;
        }
        .child {
            display: table;
            margin: 0 50px 15px 50px;
            border-bottom: 3px solid #4d7241;
        }
        .left-div {
            display: table-cell;
            vertical-align: bottom;
            width: 347px;
            word-wrap: break-word;
            text-align: start;
            padding-left: 10px;
        }
        .right-div {
            display: table-cell;
            vertical-align: bottom;
            width: 347px;
            word-wrap: break-word;
            text-align: right;
            padding-right: 10px;
        }
        .row-text {
            font-size: 20px;
        }
        .owner {
            background-color: #4d7241;
            color: white;
        }
    </style>
</head>
<body>
<div class="bg-image">
    <div>
        <div class="title">
            <span>Certificate</span>
        </div>
    </div>
    <div>
        <div class="child">
            <div class="left-div">
                <span class="row-text">@lang($trans_prefix.'.seedling')</span>
            </div>
            <div class="right-div">
                <span class="row-text">{{$seedling}}</span>
            </div>
        </div>
        <div class="child">
            <div class="left-div">
                <span class="row-text">@lang($trans_prefix.'.tree_coordinates')</span>
            </div>
            <div class="right-div">
                <span class="row-text">{{$lat}}</span>
                <br>
                <span class="row-text">{{$lng}}</span>
            </div>
        </div>
        <div class="child owner">
            <div class="left-div">
                <span class="row-text">@lang($trans_prefix.'.certificate_holder')</span>
            </div>
            <div class="right-div">
                <span class="row-text">{{$firstName.' '.$lastName}}</span>
            </div>
        </div>
        <div class="child">
            <div class="left-div">
                <span class="row-text">@lang($trans_prefix.'.field_number')</span>
            </div>
            <div class="right-div">
                <span class="row-text">{{$field_number}}</span>
            </div>
        </div>
        <div class="child">
            <div class="left-div">
                <span class="row-text">@lang($trans_prefix.'.year_landing_season')</span>
            </div>
            <div class="right-div">
                <span class="row-text">{{$planting_date}}</span>
            </div>
        </div>
        <div class="child">
            <div class="left-div">
                <span class="row-text">@lang($trans_prefix.'.cost')</span>
            </div>
            <div class="right-div">
                <span class="row-text">{{number_format($initial_price / 100, 2) . " $" }}</span>
            </div>
        </div>
        <div class="child">
            <div class="left-div">
                <span class="row-text">@lang($trans_prefix.'.location')</span>
            </div>
            <div class="right-div">
                <span class="row-text">{{$location}}</span>
            </div>
        </div>
        <div class="child">
            <div class="left-div">
                <span class="row-text">@lang($trans_prefix.'.generation_date')</span>
            </div>
            <div class="right-div">
                <span class="row-text">{{$certificates_inst_data}}</span>
            </div>
        </div>
        <div class="child">
            <div class="left-div">
                <span class="row-text">@lang($trans_prefix.'.status')</span>
            </div>
            <div class="right-div">
                <span class="row-text">{{$status}}</span>
            </div>
        </div>
        <div class="child">
            <div class="left-div">
                <span class="row-text">@lang($trans_prefix.'.id')</span>
            </div>
            <div class="right-div">
                <span class="row-text">{{$uuid}}</span>
            </div>
        </div>
    </div>
</div>
</body>
</html>
