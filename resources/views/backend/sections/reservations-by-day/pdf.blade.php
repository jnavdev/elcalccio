<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Document</title>
        <style>
            html * {
                font-size: 9px !important;
                color: #000 !important;
                font-family: 'Trebuchet MS', sans-serif;
            }

            table, td, th {
                text-align: center;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                padding: 8px;
            }

            .table-border {
                border: 2px solid #000;
            }

            .column-left {
                float: left;
                width: 65%;
                padding: 10px;
            }

            .column-right {
                float: left;
                width: 30%;
                padding: 10px;
            }

            .row:after {
                content: "";
                display: table;
                clear: both;
            }
        </style>
    </head>

    <body>
        <h4 style="text-align: center;">CAJA DIARIA FECHA: {{ $date->format('d-m-Y') }}</h4>
        <h4 style="text-align: center;">{{ $stadium->name }}</h4>

        <div class="row" style="margin-top: 40px;">
            <div class="column-left">
                <table>
                    <tr>
                        <th colspan="3"></th>
                        <th colspan="3" class="table-border">PAGO</th>
                        <th colspan="2" class="table-border">Prestamo</th>
                    </tr>
                    <tr>
                        <th class="table-border">HORA</th>
                        <th class="table-border">{{ $stadium->name }}</th>
                        <th class="table-border">Valor Hora</th>
                        <th class="table-border">Efectivo</th>
                        <th class="table-border">Transferencia</th>
                        <th class="table-border">RedCompra</th>
                        <th class="table-border">Balon</th>
                        <th class="table-border">Petos</th>
                    </tr>
                    {!! $html !!}
                    <tr>
                        <th colspan="2" class="table-border">TOTAL</th>
                        <th colspan="1"></th>
                        <th colspan="1" class="table-border"></th>
                        <th colspan="1" class="table-border"></th>
                        <th colspan="1" class="table-border"></th>
                        <th colspan="1" style="border: none;"></th>
                        <th colspan="1" style="border: none;"></th>
                    </tr>
                </table>
            </div>

            <div class="column-right">
                <table>
                    <tr>
                        <th colspan="2" class="table-border">Efectivo</th>
                    </tr>
                    <tr>
                        <td class="table-border" style="width: 50%;">$ 20.000</td>
                        <td class="table-border" style="width: 50%;"></td>
                    </tr>
                    <tr>
                        <td class="table-border">$ 10.000</td>
                        <td class="table-border"></td>
                    </tr>
                    <tr>
                        <td class="table-border">$ 5.000</td>
                        <td class="table-border"></td>
                    </tr>
                    <tr>
                        <td class="table-border">$ 2.000</td>
                        <td class="table-border"></td>
                    </tr>
                    <tr>
                        <td class="table-border">$ 1.000</td>
                        <td class="table-border"></td>
                    </tr>
                    <tr>
                        <td class="table-border">$ 500</td>
                        <td class="table-border"></td>
                    </tr>
                    <tr>
                        <td class="table-border">$ 100</td>
                        <td class="table-border"></td>
                    </tr>
                    <tr>
                        <td class="table-border">$ 50</td>
                        <td class="table-border"></td>
                    </tr>
                    <tr>
                        <td class="table-border">$ 10</td>
                        <td class="table-border"></td>
                    </tr>
                    <tr>
                        <td class="table-border">Total Efectivo</td>
                        <td class="table-border"></td>
                    </tr>
                    <tr>
                        <td class="table-border">Total RedCompra</td>
                        <td class="table-border"></td>
                    </tr>
                    <tr>
                        <td class="table-border">Total Transferencias</td>
                        <td class="table-border"></td>
                    </tr>
                    <tr>
                        <td class="table-border">Total</td>
                        <td class="table-border"></td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
