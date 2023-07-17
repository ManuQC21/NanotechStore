<?php
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
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WEBSTORE NANOTECHNOLOGY</title>
    <link rel="stylesheet" href="style.css">
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
        </section>
        <section class="table__body">
            <table id="myTable">
                <thead class="text-centrar">
                    <tr>
                        <th class="font-weight-bold"></th>
                        <th onclick="sortTables(1)" class="font-weight-bold">Producto</th>
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
                    $sql = "SELECT * FROM NANOTECHNOLOGY ORDER BY Producto ASC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Generar las filas de la tabla con los datos
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            // Agregar botones a la izquierda de la fila
                            echo '<td>';
                            echo '<button class="VerProducto" onclick="VerProducto(\'' . $row['Codigo'] . '\')">Ver Producto</button>';
                            echo '</td>';
                            // Resto de las columnas de la tabla
                            echo '<td class="image-cell">' . $row['Producto'] . '<br><img src="data:image/jpeg;base64,' . base64_encode($row['Foto']) . '" alt="Foto"></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8">No hay datos disponibles</td></tr>';
                    }

                    // Cerrar la conexión a la base de datos
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
        </main>

        <script>
            function VerProducto(Codigo) {
                window.location.href = "Productos.php?Codigo=" + Codigo;
            }
        </script>
    <script>
        function searchData(event) {
            var searchText = event.target.value.toLowerCase();
            var table = document.getElementById("myTable");
            var rows = table.rows;

            for (var i = 1; i < rows.length; i++) {
            var product = rows[i].cells[1].innerText.toLowerCase();
            var imageCell = rows[i].cells[1];

            if (product.includes(searchText)) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
            }
        }
    </script>
    <script>
        function sortTables(columnIndex) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("myTable");
        switching = true;
        dir = "asc";

        while (switching) {
            switching = false;
            rows = table.rows;

            for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[columnIndex].textContent;
            y = rows[i + 1].getElementsByTagName("TD")[columnIndex].textContent;

            if (dir == "asc") {
                if (x.toLowerCase() > y.toLowerCase()) {
                shouldSwitch = true;
                break;
                }
            } else if (dir == "desc") {
                if (x.toLowerCase() < y.toLowerCase()) {
                shouldSwitch = true;
                break;
                }
            }
            }

            if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
            } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
            }
        }
        }
</script>

</body>
</html>
