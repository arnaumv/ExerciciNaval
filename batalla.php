<!DOCTYPE html>
<html>
<head>
<style>
    /* Estilos CSS para las tablas y las celdas */
    table, td {
        border: 1px solid black;
        border-collapse: collapse;
        width: 30px; /* Ancho de las celdas */
        height: 30px; /* Alto de las celdas */
        text-align: center;
        font-weight: bold;
    }

    /* Estilos CSS para las clases de barcos */
    .fragata {background: red; color: white;}
    .submarino {background: blue; color: white;}
    .destructor {background: green; color: white;}
    .portaaviones {background: black; color: white;}
</style>
</head>
<body>
    <h2>Batalla Naval</h2>

    <table>
        <?php
        $N = 7; // Tamaño del tablero
        $barcos = []; // para almacenar información de los barcos

        // Función para verificar si una celda está ocupada por un barco
        function esBarco($fila, $columna, $barcos) {
            foreach ($barcos as $barco) {
                if (in_array([$fila, $columna], $barco)) return true;
            }
            return false;
        }

        // Función para generar un barco en el tablero
        function generarBarco($longitud, &$barcos) {
            global $N;
            do {
                $fila = rand(1, $N);
                $columna = rand(1, $N - $longitud + 1);
            } while (esBarco($fila, $columna, $barcos));

            $barco = [];
            for ($i = 0; $i < $longitud; $i++) {
                $barco[] = [$fila, $columna + $i];
            }

            $barcos[] = $barco;
        }

        generarBarco(4, $barcos); // Generar un portaaviones
        for ($i = 0; $i < 2; $i++) generarBarco(3, $barcos); // Generar destructores
        for ($i = 0; $i < 3; $i++) generarBarco(2, $barcos); // Generar submarinos
        for ($i = 0; $i < 4; $i++) generarBarco(1, $barcos); // Generar fragatas

        // Bucle para crear el tablero HTML
        for ($fila = 0; $fila <= $N; $fila++) {
            echo '<tr>'; // Crear una fila en la tabla HTML
            for ($columna = 0; $columna <= $N; $columna++) {
                if ($fila == 0 && $columna == 0) echo '<td></td>'; // Celda vacía en la esquina superior izquierda
                elseif ($fila == 0) echo '<td>' . $columna . '</td>'; // Números en la primera fila
                elseif ($columna == 0) echo '<td>' . chr($fila + 64) . '</td>'; // Letras en la primera columna
                else {
                    $tipoBarco = ''; // Variable para almacenar el tipo de barco en la celda
                    foreach ($barcos as $barco) {
                        if (in_array([$fila, $columna], $barco)) {
                            $longitud = count($barco);
                            $tipoBarco = ($longitud == 4) ? 'portaaviones' : (($longitud == 3) ? 'destructor' : (($longitud == 2) ? 'submarino' : 'fragata'));
                        }
                    }
                    // Crear celda con la clase de estilo del barco y la letra "X" si está ocupada
                    echo '<td class="' . $tipoBarco . '">' . (($tipoBarco != '') ? 'X' : '') . '</td>';
                }
            }
            echo '</tr>'; // Cerrar la fila de la tabla HTML
        }
        ?>
    </table>
</body>
</html>
