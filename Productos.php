<?php
// Obtener el valor del código de la URL
if (isset($_GET['Codigo'])) {
    $Codigo = $_GET['Codigo'];

    // Configuración de la conexión a la base de datos
    $host = "bll4fyrjpjgibp4qehcz-mysql.services.clever-cloud.com";
    $database = "bll4fyrjpjgibp4qehcz";
    $user = "ukidlkxw9l6lhgnp";
    $password = "QwcKgbfbGcl9cnfAyVaG";
    // Establecer conexión a la base de datos
    $conn = mysqli_connect($host, $user, $password, $database);

    // Verificar si la conexión se estableció correctamente
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VISUALIZACIÓN DEL PRODUCTO SELECCIONADO</title>
    <link rel="stylesheet" href="estilosproducto.css">
</head>
<body>
        <main class="table">
        <section class="table__header">
        <h1>Pedidos de clientes para NANOTECHNOLOGY</h1>
        <div class="input-group">
            <input type="search" placeholder="Search Data..." oninput="searchData(event)">
            <img src="images/search.png" alt="">
        </div>
        <div class="carrito">
            <label for="elcarrito" class="carrito__btn" title="Agregar al carrito" onclick="toggleCart()"></label>
            <input type="checkbox" id="elcarrito">
            <div class="carrito__options">
                <ul id="carrito-list"></ul>
            </div>
        </div>
        <button class="BotonVolver" onclick="window.location.href = 'NanoWeb.php';">Volver a NanoWeb</button>
    </section>
        <section class="table__body">
        <table id="myTable">
                <thead>
                    <tr>
                        <th>OPC</th>
                        <th onclick="sortTable(0)">Codigo</th>
                        <th>Foto</th>
                        <th onclick="sortTables(2)">Producto</th>
                        <th onclick="sortTable(3)">Medida</th>
                        <th onclick="sortTable(4)">Documento</th>
                        <th onclick="sortTable(5)">Cantidad</th>
                        <th onclick="sortTable(6)">Precio</th>
                        <th onclick="sortTable(7)">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Conexión a la base de datos
                    $host = "bll4fyrjpjgibp4qehcz-mysql.services.clever-cloud.com";
                    $database = "bll4fyrjpjgibp4qehcz";
                    $user = "ukidlkxw9l6lhgnp";
                    $password = "QwcKgbfbGcl9cnfAyVaG";
                    $conn = new mysqli($host, $user, $password, $database);
                    if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                    }

                    // Consulta de los datos de la tabla ordenados por Producto
                    $sql = "SELECT * FROM NANOTECHNOLOGY WHERE Codigo = '$Codigo'";
                    $result = mysqli_query($conn, $sql);

                    // Verifica si la consulta fue exitosa
                    if ($result) {
                        if ($result->num_rows > 0) {
                            // Generar las filas de la tabla con los datos
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                // Agregar botones a la izquierda de la fila
                                echo '<td>';
                                echo '<div id="comprarContainer">';
                                echo '<button class="button-comprar" onclick="showCantidadContainer(this)">Comprar</button>';
                                echo '<div class="cantidad-container" style="display: none;">';
                                echo '<button class="button-cantidad" onclick="decreaseCantidad(this)"> - </button>';
                                echo '<input type="number" class="input-cantidad" value="' . intval($row['Cantidad'] / 2) . '" min="1" max="' . $row['Cantidad'] . '" oninput="validateCantidad(this)">';
                                echo '<button class="button-cantidad" onclick="increaseCantidad(this)"> + </button>';
                                echo '</div>';
                                echo '<button class="button-comprar-ahora" onclick="comprarAhora(this)" style="display: none;">Comprar Ahora</button>';
                                echo '</div>';
                                echo '</td>';

                                // Resto de las columnas de la tabla
                                echo '<td>' . $row['Codigo'] . '</td>';
                                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['Foto']) . '" alt="Foto"></td>';
                                echo '<td>' . $row['Producto'] . '</td>';
                                echo '<td>' . $row['Medida'] . '</td>';
                                echo '<td>' . $row['Documento'] . '</td>';
                                echo '<td>' . $row['Cantidad'] . '</td>';
                                echo '<td>' . $row['Precio'] . '</td>';
                                echo '<td>' . $row['Descripción'] . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="8">No hay datos disponibles</td></tr>';
                        }
                    } else {
                        echo 'Error en la consulta de datos: ' . mysqli_error($conn);
                    }

                    // Cerrar la conexión a la base de datos
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <script>
        function showCantidadContainer(button) {
            var container = button.nextElementSibling;
            container.style.display = "block";
            button.style.display = "none";
            var comprarAhoraButton = container.querySelector(".button-comprar-ahora");
            comprarAhoraButton.style.display = "block";
        }

        function decreaseCantidad(button) {
            var input = button.nextElementSibling.nextElementSibling;
            var currentValue = parseInt(input.value);
            if (currentValue > parseInt(input.min)) {
                input.value = currentValue - 1;
            }
        }

        function increaseCantidad(button) {
            var input = button.previousElementSibling;
            var currentValue = parseInt(input.value);
            if (currentValue < parseInt(input.max)) {
                input.value = currentValue + 1;
            }
        }

        function validateCantidad(input) {
            var currentValue = parseInt(input.value);
            if (currentValue < parseInt(input.min)) {
                input.value = input.min;
            } else if (currentValue > parseInt(input.max)) {
                input.value = input.max;
            }
        }

        function comprarAhora(button) {
            // Lógica para realizar la compra inmediata
            console.log("Compra realizada");
        }
    </script>
</body>
</html>
