<div style='font-family:"DejaVu Sans","sans-serif";'>

<table width="100%" cellspacing="0" cellpadding="0" border="0" >
    <tbody>
        <tr>
            <td width="100%" valign="top">
                <p align="center">
                    <strong><em>Акт</em></strong>
                    <strong><em></em></strong>
                </p>
                <p align="center">
                    <strong><em>приемки-передачи Деревьев</em></strong>
                </p>
            </td>
        </tr>
        <tr>
            <td width="100%" valign="top">
                <p>
                    «{{ date('d', strtotime($order['updated_at']))  }}» {{ date('m Y', strtotime($order['updated_at']))  }} г.
                </p>
            </td>
        </tr>
        <tr>
            <td width="100%" valign="top">
                <p>
                    Акционерное общество Агромайн (JSC AGROMINE), именуемое в
                    дальнейшем Продавец, в лице Савина Александра, с одной
                    стороны, и {{ $user['lastName'] }} {{ $user['firstName'] }}, именуемое в
                    дальнейшем Покупатель другой стороны, именуемый в
                    дальнейшем Стороны, подписали настоящий Акт
                    приемки-передачи Деревьев (далее – «Акт») о нижеследующем:
                </p>
            </td>
        </tr>
        <tr>
            <td width="100%" valign="top">
                <p>
                    1. Продавец передает, а Покупатель принимает в
                    собственность оливковые деревья (далее – «Деревья»),
                    произрастающие на территории Грузии, номер поля – согласно
                    Приложения №1, в количестве согласно Приложения №1
                    Деревьев. Точные данные о каждом Дереве, включая год
                    посадки, согласованы сторонами в Приложении №1 к настоящему
                    Акту.
                </p>
                <p>
                    2. Право собственности на Деревья переходит к Покупателю с
                    момента принятия Покупателем настоящего Акта. Принятие Акта
                    Покупателем осуществляется путем совершения конклюдентных
действий на сайте                    <a href="https://biodeposit.ge/">https://biodeposit.ge/</a>
                    , а именно подтверждением Покупателем факта принятия
                    Деревьев.
                </p>
            </td>
        </tr>
        <tr>
            <td width="100%" valign="top">
                <p>
                    3. Настоящий Акт составлен в 2-х экземплярах, по одному
                    экземпляру для каждой из Сторон.
                </p>
            </td>
        </tr>
    </tbody>
</table>
<table width="633" cellspacing="0" cellpadding="0" border="0">
    <tbody>
        <tr>
            <td width="337" valign="top">
                <p>
                    Продавец:
                </p>
                <p>
                    АО Агромайн (JSC AGROMINE)
                </p>
                <p>
                    Регистрационный номер 405278131
                </p>
                <p>
                    Директор
                </p>
                <p>
                    Савин Александр Евгеньевич
                    <br/>
                    <br/>
                </p>
            </td>
            <td width="297" valign="top">
                <p>
                    Покупатель:
                </p>
                <p>
                    {{ $user['lastName'] }}
                </p>
                <p>
                    {{ $user['firstName'] }}
                </p>
                <p>
                    {{ $user['email'] }}
                </p>
                <p>
                    {{ $user['phone'] }}
                </p>
            </td>
        </tr>
    </tbody>
</table>

<p style="page-break-before: always"> </p>

<p align="right">
    Приложение №1
</p>
<p align="right">
    к Акту приемки-передачи Деревьев
</p>
<p align="right">
    «{{ date('d', strtotime($order['updated_at']))  }}» {{ date('m Y', strtotime($order['updated_at'])) }}
</p>
<p>
    Продавец передает, а Покупатель принимает право собственности на следующие
    Деревья:
</p>
<p>
    @php
        function getSeasonByAct(string $date)
        {
            $month = Carbon\Carbon::parse($date)->month;
            switch ($month) {
                case 12:
                case 1:
                case 2:
                    return 'Зима';
                case 3:
                case 4:
                case 5:
                    return 'Весна';
                case 6:
                case 7:
                case 8:
                    return 'Лето';
                case 9:
                case 10:
                case 11:
                    return 'ошибка';
            }
        }
    @endphp
    @foreach($trees as $tree)
<p>
	{{ $loop->iteration }}.
	Товар - {{ $tree['tree_type'] }};
	ID номер - {{ $tree['uuid'] }};
	год посадки - {{ date('Y', strtotime($tree['planting_date']))  }},
	сезон - {{ getSeasonByAct($tree['planting_date'])}};
	цена - {{
        $tree['purchase_price']
            ? number_format($tree['purchase_price'] / 100, 0)
            : number_format($tree['current_price'] / 100, 0)

    }} долларов США;
	локация - {{$tree['location'] }};
	номер поля - {{ $tree['cadastral_number'] }};
	кооператив - {{ $tree['cooperative_name'] }};
	координаты - {{ json_decode($tree['coordinates'],true)['lat'] }}, {{ json_decode($tree['coordinates'],true)['lng'] }}
</p>
    @endforeach

<table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody>
        <tr>
            <td width="50%" valign="top">
                <p>
                    Продавец:
                </p>
            </td>
            <td width="50%" valign="top">
                <p>
                    Покупатель:
                </p>
            </td>
        </tr>
        <tr>
            <td width="50%" valign="top">
                <p>
                    АО Агромайн (JSC AGROMINE)
                </p>
                <p>
                    Регистрационный номер 405278131
                </p>
                <p>
                    Директор
                </p>
                <p>
                    Савин Александр Евгеньевич
                </p>
            </td>
            <td width="50%" valign="top">
                <p>
                    {{ $user['lastName'] }}
                </p>
                <p>
                    {{ $user['firstName'] }}
                </p>
                <p>
                    {{ $user['email'] }}
                </p>
                <p>
                    {{ $user['phone'] }}
                </p>
            </td>
        </tr>
    </tbody>
</table>

</div>
