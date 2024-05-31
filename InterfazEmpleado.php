<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Empleado - Veterinaria El Tucán</title>
    <link rel="stylesheet" href="Style.css">
    <script>
        function validarFormularios(event) {
            var form = event.target;
            var inputs = form.querySelectorAll('input[required]');
            var valido = true;

            inputs.forEach(function(input) {
                if (input.value.trim() === "") {
                    valido = false;
                }
            });

            if (!valido) {
                alert("Por favor, complete todos los campos.");
                event.preventDefault();
            } else {
                var mensajeId = form.dataset.mensajeId;
                document.getElementById(mensajeId).innerText = "Formulario enviado con éxito.";
                event.preventDefault(); // Prevenir el envío inmediato del formulario
                setTimeout(function() {
                    form.submit(); // Enviar el formulario después de un breve retraso
                }, 1000);
            }
        }
    </script>
</head>
<body>
    <div id="sidebar">
        <div id="logo">
            <h1><a href="#">Veterinaria El Tucán</a></h1>
            <p>A la vanguardia con tus mascotas.</p>
        </div>
        <div id="widgets">
            <div id="widgets-top"></div>
            <ul>
                <li>
                    <h2>Acciones</h2>
                    <ul>
                        <li><a href="#">Registrar Medicamentos Vendidos</a></li>
                        <li><a href="#">Registrar Citas Atendidas</a></li>
                        <li><a href="#">Agendar Nueva Cita</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div id="page">
        <div id="search">
            <form method="get" action="#">
            </form>
        </div>
        <div id="content">
            <h1 class="pagetitle">Veterinaria "El Tucán"</h1>
            <div class="post">
                <div class="ct">
                    <div class="l">
                        <div class="r"></div>
                    </div>
                </div>
                <h2 class="title">Registrar Medicamentos Vendidos</h2>
                <div class="entry">
                    <form action="#" method="post" onsubmit="validarFormularios(event)" data-mensaje-id="mensajeMedicamentos">
                        <div class="form-group">
                            <label for="nombreMedicamento">Nombre del Medicamento:</label>
                            <input type="text" id="nombreMedicamento" name="nombreMedicamento" required>
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" id="cantidad" name="cantidad" min="1" required>
                        </div>
                        <input type="submit" value="Registrar Venta">
                        <p id="mensajeMedicamentos" class="mensaje"></p>
                    </form>
                </div>
                <div class="cb">
                    <div class="l">
                        <div class="r"></div>
                    </div>
                </div>
                <h2 class="title">Historial de Citas Atendidas</h2>
                <div class="entry">
                    <table>
                        <thead>
                            <tr>
                                <th>ID de Cita</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Cliente</th>
                                <th>Mascota</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2024-05-15</td>
                                <td>10:00</td>
                                <td>María Rodríguez</td>
                                <td>Luna</td>
                            </tr>
                            <!-- Se pueden agregar más filas según las citas atendidas -->
                        </tbody>
                    </table>
                </div>
                <div class="cb">
                    <div class="l">
                        <div class="r"></div>
                    </div>
                </div>
                <h2 class="title">Agendar Nueva Cita</h2>
                <div class="entry">
                    <form action="#" method="post" onsubmit="validarFormularios(event)" data-mensaje-id="mensajeCitas">
                        <div class="form-group">
                            <label for="fecha">Fecha:</label>
                            <input type="date" id="fecha" name="fecha" required>
                        </div>
                        <div class="form-group">
                            <label for="hora">Hora:</label>
                            <input type="time" id="hora" name="hora" required>
                        </div>
                        <div class="form-group">
                            <label for="cliente">Cliente:</label>
                            <input type="text" id="cliente" name="cliente" required>
                        </div>
                        <div class="form-group">
                            <label for="mascota">Mascota:</label>
                            <input type="text" id="mascota" name="mascota" required>
                        </div>
                        <input type="submit" value="Agendar Cita">
                        <p id="mensajeCitas" class="mensaje"></p>
                    </form>
                </div>
                <div class="footer">© 2024 Veterinaria El Tucán. Todos los derechos reservados.</div>
            </div>
        </div>
    </div>
</body>
</html>
