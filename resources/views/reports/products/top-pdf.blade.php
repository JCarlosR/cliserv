<!DOCTYPE html>
<html lang="es">
<head>
    <title>Top de productos - Click Stream</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        <?php
            include public_path().'/css/materialize.min.css';
        ?>
    </style>
</head>
<body>

<main>
    <div class="row teal lighten-2 white-text">
        <h4 class="center-align" id="title">Top de productos</h4>
    </div>
    <div class="container">
        <div class="row">
            <table border="2" cellspacing="2" cellpadding="2">
                <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($pairs as $product)
                <tr>
                    <td>{{ $product['product'] }}</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td>{{ $product['percent'] }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>

</body>
</html>