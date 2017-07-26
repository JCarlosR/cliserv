<!DOCTYPE html>
<html lang="es">
<head>
    <title>Matriz de horas pico - Click Stream</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
    <style>
    main { padding-left: 0; }
    </style>
</head>
<body>

<main>
    <div class="row teal lighten-2 white-text">
        <h4 class="center-align" id="title">Top de productos</h4>
    </div>
    <div class="container">

        <div class="row">
            <table border="0" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th class="no">#</th>
                    <th class="desc">DESCRIPTION</th>
                    <th class="unit">UNIT PRICE</th>
                    <th class="total">TOTAL</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="no">{{ $data['quantity'] }}</td>
                    <td class="desc">{{ $data['description'] }}</td>
                    <td class="unit">{{ $data['price'] }}</td>
                    <td class="total">{{ $data['total'] }} </td>
                </tr>

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td >TOTAL</td>
                    <td>$6,500.00</td>
                </tr>
                </tfoot>
            </table>
        </div>

    </div>
</main>

</body>
</html>
