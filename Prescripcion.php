<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anotaciones y Prescripciones - Veterinaria El Tucán</title>
    <link rel="stylesheet" href="style.css">
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
          <li><a href="AltaEmpleado.php" class="menu-item">Alta de Empleado</a></li>
          <li><a href="AltaMedicamento.php" class="menu-item">Alta de Medicamento</a></li>
          <li><a href="Prescripcion.php" class="menu-item">Anotaciones y Prescripciones</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
<!-- end sidebar -->

<!-- start page -->
<div id="page">
  <div id="content">
    <h1 class="pagetitle">Veterinaria "El Tucán"</h1>
    <div class="post">
      <div class="entry">
        <h2 class="title">Anotaciones y Prescripciones para el Canino Atendido</h2>
        <form action="#" method="post">
            <h3>Anotaciones</h3>
            <div class="form-group">
                <label for="nombreCaninoAnotaciones"><h3>Nombre del Canino:</h3></label>
                <input type="text" id="nombreCaninoAnotaciones" name="nombreCaninoAnotaciones" required>
            </div>
            <div class="form-group">
                <label for="anotaciones"><h3>Anotaciones:</h3></label>
                <textarea id="anotaciones" name="anotaciones" required></textarea>
            </div>
            
            <h3>Prescripciones</h3>
            <div class="form-group">
                <label for="nombreCaninoPrescripciones"><h3>Nombre del Canino:</h3></label>
                <input type="text" id="nombreCaninoPrescripciones" name="nombreCaninoPrescripciones" required>
            </div>
            <div class="form-group">
                <label for="medicamento"><h3>Medicamento:</h3></label>
                <input type="text" id="medicamento" name="medicamento" required>
            </div>
            <div class="form-group">
                <label for="dosis"><h3>Dosis:</h3></label>
                <input type="text" id="dosis" name="dosis" required>
            </div>
            <input type="submit" value="Guardar Información">
        </form>
        <div class="footer">© 2024 Veterinaria El Tucán. Todos los derechos reservados.</div>
      </div>
    </div>
  </div>
  <!-- end content -->
</div>
<!-- end page -->
</body>
</html>
