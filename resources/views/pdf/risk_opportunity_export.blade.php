<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risk Opportunity & Register Report</title>
    <style>
        body {
            font-size: 10px;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            background-color: #56dbc5;
            padding: 10px;
            page-break-after: avoid;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7px;
            page-break-inside: auto;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 4px;
            text-align: left;
            word-wrap: break-word; /* Allow text to wrap if it's too long */
        }
        th {
            background-color: #a6f119;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        /* Align specific columns to the top */
        .align-top {
            vertical-align: top;
        }
        .align-bottom {
            vertical-align: bottom;
        }
        .align-left {
            text-align: left;
        }
        .align-center {
            text-align: center;
        }
        .separator {
            border: none;
            border-top: 1px solid black;
            margin: 0;
            padding: 0;
        }
        /* Adjust column widths */
        .col-int-ext {
            width: 30px;
            text-align: center;
        }
        .col-tindakan {
            width: 150px;
            text-align: left;
        }
        .col-risiko {
            width: 80px;
        }
        .col-target-pic {
            width: 60px;
        }
        .col-pihak {
            width: 150px;
            text-align: left;
        }
        .col-pihakk {
            width: 150px;
            text-align: center;
        }
        /* Allow for flexible column width */
        .col-flexible {
            width: auto; /* This will allow the column to adjust width based on content */
            min-width: 100px; /* Optional: Set a minimum width for flexibility */
        }
    </style>
</head>
<body>
    <h2>Report Risk & Opportunity Register<br>PT. Tata Metal Lestari</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Issue</th>
                <th class="col-int-ext">Int/Ext</th>
                <th class="col-pihakk">Pihak Yang Berkepentingan</th>
                <th class="col-risiko">Risiko</th>
                <th class="col-risiko">Peluang</th>
                <th>Tingkatan</th>
                <th class="col-risiko">Tindakan Lanjut</th>
                <th class="col-target-pic">Target<br>PIC</th>
                <th>Tanggal Penyelesaian</th>
                <th>Status</th>
                <th>Actual Risk</th>
                <th>Before</th>
                <th>After</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($formattedData as $index => $data)
            <tr>
                <td class="align-top">{{ $index + 1 }}</td>
                <td class="align-top">{{ $data['issue'] }}</td>
                <td class="col-int-ext align-top">{{ $data['inex'] }}</td>
                <td class="align-top">{{ $data['pihak'] }}</td>
                <td class="col-risiko align-top">{{ $data['risiko'] }}</td>
                <td class="align-bottom">{{ $data['peluang'] }}</td>
                <td class="align-top">{{ $data['tingkatan'] }}</td>
                <td class="col-tindakan align-top">
                    @foreach ($data['tindak_lanjut'] as $index => $tindak_lanjut)
                        {{ $index + 1 }}. {{ $tindak_lanjut }}<br>
                        @if (!$loop->last)
                            <hr class="separator">
                        @endif
                    @endforeach
                </td>
                <td class="col-target-pic align-top">
                    @foreach ($data['targetpic'] as $index => $targetpic)
                        {{ $index + 1 }}. {{ $targetpic }}<br>
                        @if (!$loop->last)
                            <hr class="separator">
                        @endif
                    @endforeach
                </td>
                <td class="align-top">
                    @foreach ($data['tgl_penyelesaian'] as $index => $tgl_penyelesaian)
                        {{ $index + 1 }}. {{ $tgl_penyelesaian }}<br>
                        @if (!$loop->last)
                            <hr class="separator">
                        @endif
                    @endforeach
                </td>
                <td class="align-top">{{ $data['status'] }}</td>
                <td class="align-top">{{ $data['risk'] }}</td>
                <td class="align-top">{{ $data['before'] }}</td>
                <td class="align-top">{{ $data['after'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
