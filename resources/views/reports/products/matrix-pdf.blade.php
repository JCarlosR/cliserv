<!DOCTYPE html>
<html lang="es">
<head>
    <title>Matriz de horas pico - Click Stream</title>
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
    <div class="container">
        <div class="row teal lighten-2 white-text">
            <h4 class="center-align" id="title">Matriz de horas pico</h4>
        </div>
        <div class="row black-text">
            <table>
                <thead>
                <tr>
                    <th>Hora</th>
                    <th>Dom</th>
                    <th>Lun</th>
                    <th>Mar</th>
                    <th>Mié</th>
                    <th>Jue</th>
                    <th>Vie</th>
                    <th>Sáb</th>
                </tr>
                </thead>
                <tbody>
                @for ($h=0; $h<24; ++$h)
                    <tr>
                        <td>{{ $h . ' - ' . ($h+1) }}</td>
                        @for ($d=0; $d<7; ++$d)
                            <td>{{ $matrix[$d][$h]['q'] }} ({{ number_format($matrix[$d][$h]['p'], 2, '.', '') }})</td>
                        @endfor

                    </tr>
                @endfor
                </tbody>
            </table>
        </div>

    </div>
</main>

</body>
</html>
