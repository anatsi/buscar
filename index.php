<!DOCTYPE html>
<!--
#######################################################
#         TSI - Employment Directory. Version 1       #
#                                                     #
# Author: Vicente Catala                              #
# Date: 06/11/2017                                    #
#                                                     #
#######################################################
-->
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Directorio empleados</title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <script>
      $(document).ready(function(){
          var consulta;
          //hacemos focus al campo de busqueda
          $("#busqueda").focus();
          //comprobamos si se pulsa una tecla
          $("#busqueda").keyup(function(e){
            //obtenemos el texto introducido en el campo de bÃºsqueda
            consulta = $("#busqueda").val();
             //hace la bÃºsqueda
               $.ajax({
                   type: "POST",
                   url: "buscar.php",
                   data: "b="+consulta,
                   dataType: "html",
                   beforeSend: function(){
                        //imagen de carga
                       $("#resultado").html("<p align='center'><img src='ajax-loader.gif' /></p>");
                   },
                   error: function(){
                       alert("Error en peticion");
                   },
                  success: function(data){
                    $("#resultado").empty();
                    $("#resultado").append(data);
                  }
              });
          });
      });

  </script>
  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans'>
      <link rel="stylesheet" href="css/tabla.css">
</head>

<body>
  <h1>DIRECTORIO EMPLEADOS</h1><br>
    Buscar: <input type="text" id="busqueda"/><br /><br />
    <div id="resultado">

<?php
  //MySQLi
  require_once 'servicio.php';
  require_once 'cliente.php';
  $servicio= new Servicio();
  $cliente= new Cliente();

  $finalizados= $servicio->listaFinalizados();

    echo "
      <table id='tablamod'>
      <thead id='theadmod'>
        <tr id='trmod'>
          <th scope='col' id='thmod'>ACTIVIDAD</th>
          <th scope='col' id='thmod'>MODELOS</th>
          <th scope='col' id='thmod'>CLIENTE</th>
          <th scope='col' id='thmod'>RESPONSABLE</th>
        </tr>
      </thead><tbody id='tbodymod'>

      "; foreach ($finalizados as $servicio) {
        $clientes=$cliente->ClienteId($servicio['id_cliente']);
         echo "
            <tr id='trmod'>
              <td data-label='NOMBRE' id='tdmod'>".$servicio['descripcion']."</td>
              <td data-label='CORREO' id='tdmod'>".$servicio['modelos']."</td>
              <td data-label='MOVIL' id='tdmod'>".$clientes['nombre']."</td>
              <td data-label='TLF FIJO' id='tdmod'>".$servicio['responsable']."</td>
            </tr>

      ";} echo "</tbody></table></div></body></html>";

?>
