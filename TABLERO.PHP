<!DOCTYPE html>
<html>
<head>
<style>
    /* Estilos para la tabla y las celdas */
    table, td {
        border: 1px solid black;
        border-collapse: collapse;
        width: 30px; /* Ancho de las celdas */
        height: 30px; /* Alto de las celdas */
        text-align: center;
        font-weight: bold;
    }

    /* Estilos para las clases de barcos */
    .fragata {
        background-color: red; /* Color de fondo para representar las fragatas */
    }

    .submarino {
        background-color: blue; /* Color de fondo para representar los submarinos */
    }

    .destructor {
        background-color: green; /* Color de fondo para representar los destructores */
    }

    .portaaviones {
        background-color: black; /* Color de fondo para representar los portaaviones */
        color: white; /* Color del texto para que sea legible en el fondo negro */
    }

</style>
</head>
<body>
    <h2>Batalla Naval</h2>

    <table>
        <?php
        $N = 7; // Tamaño del tablero
        $letras = range('A', 'Z'); // Array con las letras del abecedario

        // Función para verificar si una celda está ocupada por un barco
        function esBarco($fila, $columna, $barcos) {
            foreach ($barcos as $barco) {
                if (in_array([$fila, $columna], $barco)) {
                    return true;
                }
            }
            return false;
        }

        // Función para generar una partida de Batalla Naval
        function generarPartida() {
            global $N;
            $barcos = array();
            
            // Coloca el portaaviones (4 posiciones)
            do {
                $fila = rand(1, $N);
                $columna = rand(1, $N - 3);
            } while (esBarco($fila, $columna, $barcos));
            $barcos[] = [[$fila, $columna], [$fila, $columna + 1], [$fila, $columna + 2], [$fila, $columna + 3]];
            
            // Coloca los destructores (3 posiciones cada uno)
            for ($i = 0; $i < 2; $i++) {
                do {
                    $fila = rand(1, $N);
                    $columna = rand(1, $N - 2);
                } while (esBarco($fila, $columna, $barcos) || esBarco($fila, $columna + 1, $barcos) || esBarco($fila, $columna + 2, $barcos));
                $barcos[] = [[$fila, $columna], [$fila, $columna + 1], [$fila, $columna + 2]];
            }

            // Coloca los submarinos (2 posiciones cada uno)
            for ($i = 0; $i < 3; $i++) {
                do {
                    $fila = rand(1, $N);
                    $columna = rand(1, $N - 1);
                } while (esBarco($fila, $columna, $barcos) || esBarco($fila, $columna + 1, $barcos));
                $barcos[] = [[$fila, $columna], [$fila, $columna + 1]];
            }

            // Coloca las fragatas (1 posición cada una)
            for ($i = 0; $i < 4; $i++) {
                do {
                    $fila = rand(1, $N);
                    $columna = rand(1, $N);
                } while (esBarco($fila, $columna, $barcos));
                $barcos[] = [[$fila, $columna]];
            }

            return $barcos;
        }

        $barcos = generarPartida();

        // Crear el tablero con los barcos y colores
        for ($fila = 0; $fila <= $N; $fila++) {
            echo '<tr>';
            for ($columna = 0; $columna <= $N; $columna++) {
                if ($fila == 0 && $columna == 0) {
                    echo '<td></td>'; // Celda vacía en la esquina superior izquierda
                } elseif ($fila == 0) {
                    echo '<td>' . $columna . '</td>'; // Mostrar números en la primera fila
                } elseif ($columna == 0) {
                    echo '<td >' . $letras[$fila-1] . '</td>'; // Mostrar letras en la primera columna de manera vertical
                } elseif (esBarco($fila, $columna, $barcos)) {
                    // Determina el tipo de barco y asigna la clase CSS correspondiente
                    $tipoBarco = determinarTipoBarco($fila, $columna, $barcos);
                    echo '<td class="' . $tipoBarco . '">X</td>';
                } else {
                    echo '<td></td>';
                }
            }
            echo '</tr>';
        }

        // Función para determinar el tipo de barco en una posición dada
        function determinarTipoBarco($fila, $columna, $barcos) {
            foreach ($barcos as $barco) {
                if (in_array([$fila, $columna], $barco)) {
                    $longitud = count($barco);
                    if ($longitud == 1) {
                        return 'fragata';
                    } elseif ($longitud == 2) {
                        return 'submarino';
                    } elseif ($longitud == 3) {
                        return 'destructor';
                    } elseif ($longitud == 4) {
                        return 'portaaviones';
                    }
                }
            }
            return ''; // Si no se encuentra un barco en la posición
        }
        ?>
    </table>
</body>
</html>
