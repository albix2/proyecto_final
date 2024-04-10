<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- css -->
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="../css/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="../css/estilo.css">

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/calendario.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


    
    <title>Document</title>
</head>
<body>
<header>
    <h1 class="fw-bold fs-5">gestor de tareas</h1>
    
</header> 
<main class="principal">
    <section class="enlaces">
        <ul>
            <li>
                <a href="calendario/calendario.php"><i class="bi bi-calendar3"></i>calendario</a>
            </li>
            <li>
                <a href="../tarea/tareas.php"><i class="bi bi-calendar2-event"></i>Tareas</a>
            </li>
            <li>        
                <a href=""><i class="bi bi-people-fill"></i>grupo de trabajo</a>
            </li>
            <li>
                <a href=""><i class="bi bi-kanban"></i>Kamban </a>
            </li>
            <li>
                <a href=""><i class="bi bi-chat-dots"></i>chat</a>
            </li>
            <li>
                <a href=""><i class="bi bi-share"></i>compartir</a>
            </li>
            <li>
                <a href=""><i class="bi bi-person-fill-gear"></i>pefil</a>

            </li>
        </ul>
        
    </section> 
    <section id="contenido" class="principal-calendario">
      
<?php
include('config.php');

  $SqlEventos   = ("SELECT * FROM eventoscalendar");

  $resulEventos = mysqli_query($con, $SqlEventos);

?>
<div class="mt-5"></div>

<div class="container">
  <div class="row">
    <div class="col msjs">
      <?php
        include('msjs.php');
      ?>
    </div>
  </div>

<!-- <div class="row">
  <div class="col-md-12 mb-3">
  <h3 class="text-center" id="title">Como crear un Calendario de Eventos con PHP y MYSQL</h3>
  </div>
</div> -->
</div>



<div id="calendar"></div>


<?php  
include('modalNuevoEvento.php');
  include('modalUpdateEvento.php');
  

?>



<script src ="../js/jquery-3.0.0.min.js"> </script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script type="text/javascript" src="../js/moment.min.js"></script>	
<script type="text/javascript" src="../js/fullcalendar.min.js"></script>
<script src='../locales/es.js'></script>

<script type="text/javascript">
$(document).ready(function() {
    $("#calendar").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay"
        },

        locale: 'es',

        defaultView: "month",
        navLinks: true, 
        editable: true,
        eventLimit: true, 
        selectable: true,
        selectHelper: false,

        // Nuevo Evento
        select: function(start, end){
            $("#exampleModal").modal();
      $("input[name=fecha_inicio]").val(start.format('DD-MM-YYYY HH:mm:ss'));
       
      var valorFechaFin = end.format("DD-MM-YYYY HH:mm:ss");
var F_final = moment(valorFechaFin, "DD-MM-YYYY HH:mm:ss").format('DD-MM-YYYY HH:mm:ss');
      $('input[name=fecha_fin').val(F_final);  
      if (event) {
        $("input[name=evento]").val(event.evento);
        $("input[name=descripcion]").val(event.descripcion);
        $("select[name=id_estado]").val(event.id_estado);
        $("select[name=id_etiqueta]").val(event.id_etiqueta);
    }
        },
        
        events: [
            <?php
            while($dataEvento = mysqli_fetch_array($resulEventos)){ ?>
                {
                _id: '<?php echo $dataEvento['id']; ?>',
                title: '<?php echo $dataEvento['evento']; ?>',
                start: '<?php echo $dataEvento['fecha_inicio']; ?>',
                end:   '<?php echo $dataEvento['fecha_fin']; ?>',
                color: '<?php echo $dataEvento['color_evento']; ?>',
                id_usuario: '<?php echo $dataEvento['id_usuario']; ?>',
                fotografia: '<?php echo $dataEvento['archivos']; ?>',
                descripcion: '<?php echo $dataEvento['descripcion']; ?>',
                id_etiqueta: '<?php echo $dataEvento['id_etiquetas']; ?>',
                id_estado: '<?php echo $dataEvento['id_estado']; ?>'
                },
            <?php } ?>
        ],

        // Eliminar Evento
        eventRender: function(event, element) {
            element
                .find(".fc-content")
                .prepend("<span id='btnCerrar'; class='closeon material-icons'>&#xe5cd;</span>");
            
            // Eliminar evento
            element.find(".closeon").on("click", function() {
                var pregunta = confirm("¿Deseas Borrar este Evento?");   
                if (pregunta) {
                    $("#calendar").fullCalendar("removeEvents", event._id);

                    $.ajax({
                        type: "POST",
                        url: 'deleteEvento.php',
                        data: {id: event._id},
                        success: function(datos) {
                            $(".alert-danger").show();

                            setTimeout(function () {
                                $(".alert-danger").slideUp(500);
                            }, 3000); 
                        }
                    });
                }
            });
        },

        // Moviendo Evento Drag - Drop
        eventDrop: function (event, delta) {
            var idEvento = event._id;
            var start = event.start.format('YYYY-MM-DDTHH:mm:ss');
            var end = event.end.format('YYYY-MM-DDTHH:mm:ss');

            $.ajax({
                url: 'drag_drop_evento.php',
                data: 'start=' + start + '&end=' + end + '&idEvento=' + idEvento,
                type: "POST",
                success: function (response) {
                    // $("#respuesta").html(response);
                }
            });
        },

        // Modificar Evento del Calendario 
        eventClick: function(event) {
  var idEvento = event._id;
  $('input[name=idEvento]').val(idEvento);
  $('input[name=evento]').val(event.title);
  $('input[name=descripcion]').val(event.descripcion);
  $('input[name=archivo_actual]').val(event.fotografia); // Actualiza el campo con la ruta del archivo actual
  $('#archivo_actual_link').attr('href', event.fotografia).text(event.fotografia); // Muestra el enlace al archivo actual
  $('input[name=fecha_inicio]').val(event.start.format('YYYY-MM-DDTHH:mm:ss'));
  $('input[name=fecha_fin]').val(event.end.format('YYYY-MM-DDTHH:mm:ss'));
  $('select[name=id_etiqueta]').val(event.id_etiqueta);
  $('select[name=id_estado]').val(event.id_estado);
  $('select[name=id_usuario]').val(event.id_usuario);
  $("#modalUpdateEvento").modal();
           
        }
    });

    // Oculta mensajes de Notificacion
    setTimeout(function () {
        $(".alert").slideUp(300);
    }, 3000); 
});

</script>

        
    </section> 
</main>
<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
 <!-- <p>hofgla</p>    -->
</body>
</html>