<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>{{ $ticket->code}} - {{ $ticket->article}}</title>
    <style>

        @page {
            margin: 80px 25px;
        }
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 5px;
            margin-bottom: 5px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            max-width: 900px;
            margin: auto;
            padding: 2px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 14px;
            line-height: 20px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 1px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: center;
        }

        .invoice-box table tr td:nth-child(3) {
            text-align: center;
        }

        .invoice-box table tr td:nth-child(4) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 2px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 14px;
            line-height: 24px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.heading td {
            background: rgba(85, 110, 230, .25) !important;
            border-bottom: 2px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.heading-price td {
            background: #eee;
            /*border-bottom: 2px solid #325288;*/
            font-weight: bold;
            text-align: right;
        }

        .invoice-box table tr.details td {
            padding-bottom: 5px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .invoice-box table tr.total td:nth-child(3) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

    </style>
</head>

<body>
<div class="invoice-box">
    <table>
        <tr class="top">
            <td colspan="4">
                <table>
                    <tr>
                        <td class="title" style="text-align: center; font-size: 14px !important;">
                            <h1>Rapport Complet du Ticket : {{$ticket->code}} </h1>
                        </td>

                    </tr>
                </table>
                <table>
                    <tr>
                        <td class="" style="text-align: center; font-size: 14px !important;">
                            <p>{{$ticket->article}}</p>
                        </td>

                    </tr>
                    <tr class="heading">
                        <td colspan="4">Technicien : {{optional($ticket->technicien)->full_name}}</td>
                    </tr>
                    <tr class="heading">
                        <td colspan="4">La date d'entrée : {{$ticket->created_at->format('d-m-Y')}}</td>

                    </tr>
                    @if($ticket->started_at)
                        <tr class="heading">
                            <td colspan="4">La date de départ de diagnostique
                                : {{$ticket->started_at->format('d-m-Y')}}</td>
                        </tr>
                    @endif
                    @if($ticket->finished_at)
                        <tr class="heading">
                            <td colspan="4">La date de finalisation de diagnostique
                                : {{$ticket->finished_at->format('d-m-Y')}}</td>
                        </tr>
                    @endif
                    @if($ticket->delivery_count)
                        <tr class="heading">
                            <td colspan="4">La date de sortie
                                : {{optional($ticket->delivery)->date_end->format('d-m-Y')}}</td>
                        </tr>
                    @endif
                </table>
                <table>
                    <tr>
                        <td class="" style="text-align: center; font-size: 14px !important;">
                            <p>Figure : 1</p>
                            <img src="{{  $data['firstImage'] }}"
                                 style="width: 70%;"/>
                        </td>

                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
            <td colspan="4">
                <table>
                    <tr>
                        <td class="" style="text-align: center; font-size: 14px !important; color: red">
                            <h5>Rapport de réparation : </h5><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="title" style="font-size: 14px !important;">
                            {!! optional($ticket->reparationReports)->content !!}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="4">
                <table>
                    <tr>
                        <td class="" style="text-align: center; font-size: 14px !important; color: red">
                            <h5>Rapport de diagnostique : </h5><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="title" style="font-size: 14px !important;">
                            {!! optional($ticket->diagnoseReports)->content !!}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <table>
            @foreach($data['allImages'] as $index => $img)
                <tr>
                    <td class="" style="text-align: center;font-size: 14px !important;">
                        <p>Figure : {{$index + 1}}</p>
                        <img src="{{  $img }}"
                             style="width: 70%; "/>
                    </td>

                </tr>
            @endforeach
        </table>


    </table>
</div>

<script type="text/php">

            if (isset($pdf) && $PAGE_COUNT > 1) {
                $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
                $size = 5;
                $font = $fontMetrics->getFont("Verdana");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width);
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size);
            }







</script>
</body>

</html>
