<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Total de Faltas Justificas e Injustificadas</title>
    <style>
        /*! CSS Used from: http://pdflaravel:8000/dist/css/adminlte.min.css */
        *, ::after, ::before {
            box-sizing: border-box;
        }

        .cor-fraca {
            color: rgba(121, 121, 121, 0.85)
        }

        .d-block {
            display: block !important
        }

        .font-size-14 {
            font-size: 14px;
            font-style: normal;
            float: left;
            margin-top: -12px;
            display: block;
            letter-spacing: 0px
        }

        .spacing-7 {
            letter-spacing: 7px;
        }

        .spacing-8 {
            letter-spacing: 8px
        }

        .spacing-10 {
            letter-spacing: 10px
        }

        body {
            margin: 0;
            font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }

        h1 {
            margin-top: 0;
            margin-bottom: .5rem;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
            text-align: -webkit-match-parent;
        }

        h1 {
            margin-bottom: .5rem;
            font-family: inherit;
            font-weight: 500;
            line-height: 1.2;
            color: inherit;
        }

        h1 {
            font-size: 2.5rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            background-color: transparent;
        }

        .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .tableNoPadding td, .table th {
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table-sm td, .table-sm th {
            padding: .3rem;
        }


        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, .05);
        }

        .table-hover tbody tr:hover {
            color: #212529;
            background-color: rgba(0, 0, 0, .075);
        }

        .card-body {
            -webkit-flex: 1 1 auto;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1.25rem;
        }

        .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        @media (prefers-reduced-motion: reduce) {
            .badge {
                transition: none;
            }
        }

        .badge:empty {
            display: none;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .p-0 {
            padding: 0 !important;
        }

        @media print {
            *, ::after, ::before {
                text-shadow: none !important;
                box-shadow: none !important;
            }

            thead {
                display: table-header-group;
            }

            img, tr {
                page-break-inside: avoid;
            }

            body {
                min-width: 992px !important;
            }

            .badge {
                border: 1px solid #000;
            }

            .table {
                border-collapse: collapse !important;
            }

            .table td, .table th {
                background-color: #fff !important;
            }
        }

        body {
            min-height: 100%;
        }

        .card-body::after {
            display: block;
            clear: both;
            content: "";
        }

        .card-body > .table {
            margin-bottom: 0;
        }

        .card-body > .table > thead > tr > th {
            border-top-width: 0;
        }

        .table:not(.table-dark) {
            color: inherit;
        }

        .card-body.p-0 .table tbody > tr > td:first-of-type, .card-body.p-0 .table thead > tr > th:first-of-type {
            padding-left: 1.5rem;
        }

        .card-body.p-0 .table tbody > tr > td:last-of-type, .card-body.p-0 .table thead > tr > th:last-of-type {
            padding-right: 1.5rem;
        }

        .elevation-2 {
            box-shadow: 0 3px 6px rgba(0, 0, 0, .16), 0 3px 6px rgba(0, 0, 0, .23) !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .bg-warning {
            color: #1f2d3d !important;
        }

        .bg-cyan {
            background-color: #17a2b8 !important;
        }

        .bg-cyan {
            color: #fff !important;
        }

        .text-left {
            text-align: left !important
        }

        .text-right {
            text-align: right !important
        }

        .text-danger {
            color: #ff3737 !important;
        }

        .text-center {
            text-align: center !important
        }

        .text-lowercase {
            text-transform: lowercase !important
        }

        .text-uppercase {
            text-transform: uppercase !important
        }

        .text-capitalize {
            text-transform: capitalize !important
        }

        .font-weight-light {
            font-weight: 300 !important
        }

        .font-weight-normal {
            font-weight: 400 !important
        }

        .font-weight-bold {
            font-weight: 700 !important
        }

        .font-italic {
            font-style: italic !important
        }

        .text-white {
            color: #fff !important
        }

        .text-primary {
            color: #007bff !important
        }

        .text-muted {
            color: rgba(10, 14, 20, 0.52);
        }

        .text-gray-600 {
            color: #696a6c
        }

        .table-border-top-none {
            border: 1px solid #c5c5c5 !important;
            border-top: none !important;
            width: 15px;
            font-size: 10px;
            text-align: center;
            font-weight: normal;
        }
        .table-border-all {
            border: 1px solid #c5c5c5 !important;
            width: 15px;
            font-size: 10px;
            text-align: center;
            border-radius: 5px!important;
        }

        .table-border-x-none {
            border: 1px solid #c5c5c5 !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            width: 15px;
            text-align: center;

        }


    </style>
</head>
<body style="padding: 20px">
<div>


    {{-- Cabeçalho --}}
    <table class=""
           style="border: none; padding: 1px!important; font-size: 12px; width: 100%">
        <thead>
        <tr style="padding-right: 0">
            <td style="width: 60%; text-align: left; padding-left: 10px; padding-right: 0">
                <img src="{{ config('saude.logo64Php') }}" style="width: 200px!important;" alt="">
            </td>

            <td style="width: 30%; text-align: right; border-left: 2px solid rgba(192,191,191,0.83)">
                <div>
                    <table>
                        <tbody style="text-transform:  uppercase;  ">
                        <tr style="letter-spacing: 2px; color: #969595">
                            <td style=" width: 50%; text-align: left;  padding-left: 10px; font-size: 18px ">Apólice
                                Plano Seguro
                            </td>
                        </tr>
                        <tr style="font-size: 20px; color: #696a6c; font-weight: bold;">
                            <td style=" width: 50%; text-align: left;  padding-left: 10px">Plano De Saúde</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        </thead>
    </table>
    <br>
    <br>
    {{-- Barramento de informação --}}
    <table
            style="border: 2px solid #ccc; border-right: none;
                                border-left: none; padding: 1px!important; font-size: 9px; width: 100%">
        <tbody style="border: none!important; text-transform: uppercase">
        <tr class="text-gray-600">
            <th style=" width: 100%; text-align: left;  padding-left: 30px; padding-top: 5px; padding-bottom: 5px">
                Área de informações gerais da apólice plano de saúde metecare
            </th>
        </tr>
        </tbody>
    </table>

    @include('apolice.plano::header-plano')
    {{-- Fim Cabeçalho --}}


    <br>
    {{-- Informação --}}
    {{--@if(!is_null($obs))--}}
    <table class=""
           style="border:none;  padding: 1px!important; font-size: 12px;width: 100%; margin-bottom: 0px">
        <thead>
        <tr>
            <th style="width: 100%; text-align: left; padding-left: 10px">Informação Clínica/Sintomas/Observação
            </th>

        </tr>
        </thead>
    </table>
    <div class="card-body p-0">
        <table class=""
               style="border: none; padding: 1px!important; font-size: 12px; width: 100%">
            <tbody>
            <tr>
                <td style=" width: 100%; text-align: left;  padding-left: 20px ; padding-top: 20px">Outras informações
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <br>
    <div style="page-break-inside: avoid!important;">
        <div class="card-body p-0">
            <table class=""
                   style="border: none; padding: 1px!important; font-size: 12px; width: 100%">
                <tbody style="font-size: 11px">
                <tr>
                    <th style=" width: 40%; text-align: left;  padding-left: 20px ; padding-top: 2px;">Assinatura
                        Responsável pela Emissão da Guia
                    </th>
                    <td style=" width: 20%; text-align: left;  padding-left: 20px ; padding-top: 2px"></td>
                    <th style=" width: 40%; text-align: left;  padding-left: 20px ; padding-top: 2px">Assinatura do
                        Beneficiário ou Responsável
                    </th>
                </tr>
                <tr>
                    <td style=" width: 40%; text-align: left;  padding-left: 20px ; padding-top: 2px">{{ date('d/m/Y His') }}
                        / {{ auth()->user()->name }}</td>
                    <td style=" width: 20%; text-align: left;  padding-left: 20px ; padding-top: 2px"></td>
                    <td style=" width: 40%; text-align: left;  padding-left: 20px ; padding-top: 2px">{{ date('d/m/Y His') }}
                    {{--                        / {{$beneFix['nome'] }}</td>--}}
                </tr>
                </tbody>
            </table>
        </div>
        <br>
        <br>
        {{--  @endif--}}
        {{-- SAÚDE + ( HA20 SAÚDE+ - GESTAO DE SERVIÇOS DE SAUDE LDA)  --}}
        <div style="background-color: #c0bfbf;">
            <table class="" style="border:none;  padding: 1px!important;
            font-size: 10px;width: 100%; margin-bottom: 0px">
                <thead>
                <tr>
                    <td style="width: 100%; text-align: left; padding-left: 10px">APPS SAÚDE ( HA20 SAÚDE - GESTAO DE
                        SERVIÇOS
                        DE SAUDE LDA)
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%; text-align: left; padding-left: 10px; padding-top: 4px">OBSERVAÇÃO:</td>
                </tr>
                </thead>
            </table>
            <div class="card-body p-0 mt-2">
                <table class="" style="border: none; padding: 1px!important; font-size: 10px; width: 100%">
                    <tbody>
                    <tr>
                        <td style="width: 2%!important; text-align: right">-</td>
                        <td style=" width: 98%; text-align: left;  padding-left: 5px;padding-right: 5px">
                            ESTA AUTORIZAÇÃO DEVE SER ANEXADA A FACTURA JUNTAMENTE COM CÓPIA FRENTE/VERSO DE DOCUMENTO
                            DE
                            IDENTIFICAÇÃO COM FOTO.
                        </td>
                    </tr>
                    </tbody>
                </table>

                {{-- Ultima informação --}}
                <table class=""
                       style="border: none; padding: 1px!important; font-size: 10px; width: 100%; margin-top: 20px">
                    <tbody>

                    <tr style="margin-top: 20px">
                        <td style=" width: 100%; text-align: left;  padding-left: 10px; font-size: 10px!important;">
                            Esta Guia é válida apenas para a data de emissão.
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<br>
</body>
</html>
