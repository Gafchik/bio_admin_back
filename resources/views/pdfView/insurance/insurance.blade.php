<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .container {
            width: 90%;
            margin: 0 auto;
        }

        h1, h2, h3 {
            text-align: center;
        }

        .section {
            margin-bottom: 10px;
        }

        .section p {
            text-indent: 10px;
        }

        .list-item {
            display: flex;
            align-items: flex-start; /* Прижать текст и изображения к верху */
            gap: 10px; /* Промежуток между текстом и изображениями */
        }

        .list-item .images {
            display: flex;
            gap: 10px; /* Промежуток между изображениями */
        }

    </style>
</head>
<body>
<div class="container">
    <h1>@lang($trans_prefix.'.title')</h1>
    <div class="section">
        <h2>@lang($trans_prefix.'.location')</h2>
        <p>@lang($trans_prefix.'.city')</p>
        <p>«{{ $tree['inst_date'] }}»</p>
    </div>

    <div class="section">
        <h2>@lang($trans_prefix.'.mini_title.1')</h2>
        <p>
            <strong>@lang($trans_prefix.'.mini_title.2')</strong>
            @lang($trans_prefix.'.mini_title.3')</p>
        <p><strong>@lang($trans_prefix.'.mini_title.4')</strong> @lang($trans_prefix.'.mini_title.5')</p>
        <p><strong>@lang($trans_prefix.'.mini_title.6')</strong> {{ $user['firstName'] }} {{ $user['lastName'] }} @lang($trans_prefix.'.mini_title.7')</p>
    </div>
    <div class="section">
        <p>@lang($trans_prefix.'.mini_title.8')</p>
    </div>
    <div class="section">
        <h2>@lang($trans_prefix.'.subject_agreement.title')</h2>
        <p>@lang($trans_prefix.'.subject_agreement.1_1')</p>
        <p>@lang($trans_prefix.'.subject_agreement.1_2.1')<br>@lang($trans_prefix.'.subject_agreement.1_2.2')
            <br> {{ $tree['uuid'] }}@lang($trans_prefix.'.subject_agreement.1_2.3') {{ $tree['age'] }}, @lang($trans_prefix.'.subject_agreement.1_2.4')</p>
        <p>@lang($trans_prefix.'.subject_agreement.1_3')</p>
        <ul>
            <li>@lang($trans_prefix.'.subject_agreement.ul.1')</li>
            <li>@lang($trans_prefix.'.subject_agreement.ul.2')</li>
            <li>@lang($trans_prefix.'.subject_agreement.ul.3')</li>
            <li>@lang($trans_prefix.'.subject_agreement.ul.4')</li>
            <li>@lang($trans_prefix.'.subject_agreement.ul.5')</li>
            <li>@lang($trans_prefix.'.subject_agreement.ul.6')</li>
            <li>@lang($trans_prefix.'.subject_agreement.ul.7')</li>
            <li>@lang($trans_prefix.'.subject_agreement.ul.8')</li>
            <li>@lang($trans_prefix.'.subject_agreement.ul.9')</li>
        </ul>
        <p>@lang($trans_prefix.'.subject_agreement.1_4')</p>
        <p>@lang($trans_prefix.'.subject_agreement.text')</p>
    </div>

    <div class="section">
        <h2>@lang($trans_prefix.'.2.2')</h2>
        <p>@lang($trans_prefix.'.2.2_1')</p>
        <p>
            @lang($trans_prefix.'.2.2_1_1.1')
            <strong>@lang($trans_prefix.'.2.2_1_1.2')</strong>
            @lang($trans_prefix.'.2.2_1_1.3')
        </p>
        <p>@lang($trans_prefix.'.2.2_1_2')</p>
        <p>@lang($trans_prefix.'.2.2_1_3')</p>
        <p>@lang($trans_prefix.'.2.2_2_1')</p>
        <p>@lang($trans_prefix.'.2.green_pack')</p>
        <p>@lang($trans_prefix.'.2.premium')</p>
        <p>@lang($trans_prefix.'.2.platinum')</p>
        <p>@lang($trans_prefix.'.2.2_2_2')</p>
        <p>@lang($trans_prefix.'.2.2_3')</p>
        <ul>
            <li>@lang($trans_prefix.'.2.ul.1')</li>
            <li>@lang($trans_prefix.'.2.ul.2')</li>
            <li>@lang($trans_prefix.'.2.ul.3')</li>
            <li>@lang($trans_prefix.'.2.ul.4')</li>
            <li>@lang($trans_prefix.'.2.ul.5')</li>
            <li>@lang($trans_prefix.'.2.ul.6')</li>
        </ul>
        <p>@lang($trans_prefix.'.2.2_4')</p>
    </div>


    <div class="section">
        <h2>@lang($trans_prefix.'.3.title')</h2>
        <p>@lang($trans_prefix.'.3.3_1')</p>
        <p>@lang($trans_prefix.'.3.3_2')</p>
        <p>@lang($trans_prefix.'.3.3_3')</p>
        <p>@lang($trans_prefix.'.3.3_4')</p>
        <p>@lang($trans_prefix.'.3.3_5')</p>
    </div>

    <div class="section">
        <h2>@lang($trans_prefix.'.4.title')</h2>
        <p>@lang($trans_prefix.'.4.4_1')</p>
        <p>@lang($trans_prefix.'.4.4_2')</p>
        <p>@lang($trans_prefix.'.4.4_3')</p>
        <p>@lang($trans_prefix.'.4.4_5')</p>
        <p>@lang($trans_prefix.'.4.4_4')</p>
        <p>@lang($trans_prefix.'.4.4_7.1') {{date('Y', strtotime($tree['inst_date'] . ' +1 year'))}} @lang($trans_prefix.'.4.4_7.2')</p>
    </div>
    <div class="section">
        <h2>@lang($trans_prefix.'.5.title')</h2>
        <p>@lang($trans_prefix.'.5.1_1')</p>
        <ul>
            <li>@lang($trans_prefix.'.5.ul_1.1'): JSC «AGROMINE» </li>
            <li>@lang($trans_prefix.'.5.ul_1.2'): 405278131</li>
            <li>@lang($trans_prefix.'.5.ul_1.3'): 5734000@ukr.net</li>
            <li class="list-item">
                @lang($trans_prefix.'.5.ul_1.4'):
                <span class="images">
                    <img width="80px" height="80px" src="data:image/png;base64,{{$images['signature1']}}"/>
                    <img width="110px" height="110px" src="data:image/png;base64,{{$images['stamp1']}}"/>
                </span>
            </li>
            <li>@lang($trans_prefix.'.5.ul_1.5'): {{ $tree['inst_date']}}</li>
        </ul>
        <p>@lang($trans_prefix.'.5.1_2')</p>
        <ul>
            <li>@lang($trans_prefix.'.5.ul_2.1'): JSC «Plantatori»</li>
            <li>@lang($trans_prefix.'.5.ul_2.2'): 405433017</li>
            <li>@lang($trans_prefix.'.5.ul_2.3'): greenagroge@gmail.com</li>
            <li class="list-item">
                @lang($trans_prefix.'.5.ul_2.4'):
                <span class="images">
                    <img width="80px" height="80px" src="data:image/png;base64,{{$images['signature2']}}"/>
                    <img width="110px" height="110px" src="data:image/png;base64,{{$images['stamp2']}}"/>
                </span>
            </li>
            <li>@lang($trans_prefix.'.5.ul_2.5'): {{ $tree['inst_date']}}</li>
        </ul>
        <p>@lang($trans_prefix.'.5.text')</p>
        <ul>
            <li>@lang($trans_prefix.'.5.ul_3.1'): {{ $user['firstName'] }} {{ $user['lastName'] }}</li>
            <li>@lang($trans_prefix.'.5.ul_3.2'): {{ $user['phone'] }}</li>
            <li>@lang($trans_prefix.'.5.ul_3.3'): {{ $tree['inst_date']}}</li>
        </ul>
        <p>@lang($trans_prefix.'.5.5_3')</p>
    </div>
</div>
</body>
</html>
