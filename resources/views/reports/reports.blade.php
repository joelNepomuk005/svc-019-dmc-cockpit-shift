<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <style>

        @page {
            /* size: A4; */
            margin-top: 2cm;
            margin-bottom: 1cm;
            margin-left: 2cm;
            margin-right: 2cm;
        }

        body {
            position: relative;
        }

        #overlay {
            position: absolute;
            top: -20mm;
            left: -20mm;
            height: 230mm;
            width: 314mm;
            background-color: red;
            z-index: -1;
        }

        #content {
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #000000;
        }

        h1, h2, h3, h4, h5, h6 {
            margin: 0 0 2mm 0;
            padding: 0;
        }

        h1 {
        }

        h2 {
            font-size: 16pt;
            font-weight: lighter;
            text-transform: none;
            color: #000000;
        }

        h3 {
            font-size: 16pt;
            font-weight: lighter;
            text-transform: none;
            color: #000000;
        }

        h4 {
            font-size: 16pt;
            text-transform: uppercase;
            color: #000000;
        }

        h5 {
            font-size: 16pt;
            text-transform: uppercase;
            color: #000000;
        }

        table {
            width: 100%;
            margin: 0;
            padding: 0;
            font-size: 8pt;
            font-weight: lighter;
            text-transform: none;
            color: #000000;
        }

        table thead tr th {
            padding: 4px 0 4px 0;
            border-top: 1px solid #cccccc;
            border-bottom: 2px solid #cccccc;
        }

        table thead tr th {
            font-size: 8pt;
            text-transform: none;
            font-weight: bold;
            text-align: left;
            color: #000000;
        }

        table tbody tr td {
            padding: 4px 0 4px 0;
            border-bottom: 1px solid #cccccc;
            font-size: 8pt;
            font-weight: normal;
            text-transform: none;
            color: #000000;
        }

        table tbody tr:last-child td:nth-child(odd),
        table tbody tr:last-child td:nth-child(even) {
        }

        #cover {
        }

        #cover h1 {
            font-size: 24pt;
            font-weight: lighter;
            text-transform: none;
            color: #ffffff;
        }

        .page {
            position: fixed;
            bottom: 0;
            overflow: visible;
            width: 100%;
        }

        .page .page-number:after {
            content: counter(page);
        }

        .page .page-number, .page .page-title {
            font-size: 8pt;
            font-weight: lighter;
            text-transform: none;
            color: #000000;
        }

        .page .page-title {
            display: inline-block;
            text-align: left;
            width: 45%;
        }

        .page .page-number {
            display: inline-block;
            text-align: right;
            width: 45%;
        }
    </style>
</head>
<body>

<div class="page">
    <div>
        <span class="page-title">{{$meta['title']}} vom {{$meta['date']}} / {{$meta['author']}}</span>
        <span class="page-number">Seite </span>
    </div>
</div>

<div id="page-body">

    <div id="overlay"></div>

    <div id="content">

        <div id="cover" style="page-break-after: always;">
            <header style="margin: 80px 0 0 0;">
                <h1>
                    {{$meta['title']}}<br>
                    <small>{{$meta['date']}} {{$meta['author']}}</small>
                </h1>
            </header>
            <!--<img src="storage/xxx/logo.png" style="position: absolute; right: 20px; top: 20px; width: 100px;">-->
        </div>

        @include ('reports.reports.measures_current_year')


    </div>
</div>

</body>
</html>
