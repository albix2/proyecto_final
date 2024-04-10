<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="estilo.css">
    <title>Document</title>
</head>
<body>
    <header>
        <h1 class="fw-bold fs-3">gestor de tareas</h1>
        
    </header> 
    <main class="principal-inicio">
        <section class="formulario">
            <a href="#inicio" class="inicio">inicio de sesion </a>
            <a href="#registro" class="registro">registrar</a>
            <form class="active" id="inicio" action="">
                <p>Nombre: <input type="text" name="nombre" size="40"></p>
  <p>Año de nacimiento: <input type="number" name="nacido" min="1900"></p>
  <p>Sexo:
    <input type="radio" name="hm" value="h"> Hombre
    <input type="radio" name="hm" value="m"> Mujer
  </p>
  <p>
    <input type="submit" value="Enviar">
    <input type="reset" value="Borrar">
  </p>
            </form>
            <form class="des" id="registro" action=" ">
            <p>Nombre: <input type="text" name="nombre" size="40"></p>
            <p>Año de nacimiento: <input type="number" name="nacido" min="1900"></p>
            <p>Sexo:
              <input type="radio" name="hm" value="h"> Hombre
              <input type="radio" name="hm" value="m"> Mujer
            </p>
            <p>
              <input type="submit" value="Enviar">
              <input type="reset" value="Borrar">
            </p></form>
        </section>
        
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>