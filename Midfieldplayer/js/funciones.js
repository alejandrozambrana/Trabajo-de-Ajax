/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
  
  //ajax
  
  
  
  //al clickar en añadir, llamo a añadir artista
  $(document).on("click", "#anadir", function () {
    tabla = $(this).data("tabla");
    $.post("filaAnadir.php",{tabla: tabla}, function (data) {
      //Añade a la tabla de datos una nueva fila
      //$("#tabla .table tbody").append(data);
      $("#tabla").after(data);
      //Ocultamos boton de nuevo inmueble
      //Para evitar añadir mas de uno 
      //a la vez
      $("#anadir").hide();
      //datepicker
      $( "#datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd"
      });
    })//get	
  });

  //Boton de cancelar nuevo
  $(document).on("click", "#cancelarNuevo", function () {
    //Elimina la nueva fila creada
    $("#filaAnadir").remove();
    //vuelve a mostrar el botón de nuevo (+)
    $("#anadir").show();
  });
  
  //Boton de guardar nuevo
  $(document).on("click", "#anadirNuevo", function () {
    tabla = $(this).parents("label").data("tabla");
    codigo = $("#codigoId").val();
    nombre = $("#nombreId").val();
    dorsal = $("#dorsalId").val();
    edad = $("#datepicker").val();
    altura = $("#alturaId").val();
    peso = $("#pesoId").val();
    if(tabla != "jugadores" && nombre != "" && codigo != ""){
      campo = $(this).parents("label").data("campo");
      $.post("anadir.php", {
        tabla: tabla,
        codigo: codigo,
        nombre: nombre,
        campo: campo
      }, function () {
        if((tabla == "nacionalidad")){
          $.get("listadonacionalidad.php", function (data) {
            $("#listado").html(data);
          });
        }
        if(tabla == "equipo"){
          $.get("listadoequipos.php", function (data) {
            $("#listado").html(data);
          });
        }
        if(tabla == "posicion"){
          $.get("listadoposiciones.php", function (data) {
            $("#listado").html(data);
          });
        }
        //Vuelve a mostrar el boton de nuevo
        $("#anadir").show();
      })//post	
    }else if(tabla == "jugadores" && nombre != "" && dorsal != "" && edad != "" && altura != "" && peso != ""){
      equipo = $("#equipoId").val();
      nacionalidad = $("#nacionalidadId").val();
      posicion = $("#posicionId").val();
      console.log(edad);
      $.post("anadirJugador.php", {
        tabla: tabla,
        nombre: nombre,
        equipo: equipo,
        dorsal: dorsal,
        edad: edad,
        altura: altura,
        peso: peso,
        nacionalidad: nacionalidad,
        posicion: posicion
      }, function () {
        $.get("listadojugadores.php", function (data) {
          $("#listado").html(data);
        });
        //Vuelve a mostrar el boton de nuevo
        $("#anadir").show();
      });
    }
  });

  //ordenar
  $(document).on("click", ".ordena", function () {

    //obtener el ordenapor
    ordenar = $(this).attr("name");
    direccion = $("#ordenar").val();
    tabla = $(this).parents("tr").data("tabla");
    if(tabla == "nacionalidad"){
      $.ajax({
        url: "../Administrador/listadonacionalidad.php",
        data: {ordenapor: ordenar, direccion: direccion},
        success: rellenar,
        type: "post",
        cache: false
      });
    }
    if(tabla == "equipo"){
      $.ajax({
        url: "../Administrador/listadoequipos.php",
        data: {ordenapor: ordenar, direccion: direccion},
        success: rellenar,
        type: "post",
        cache: false
      });
    }
    if(tabla == "posicion"){
      $.ajax({
        url: "../Administrador/listadoposiciones.php",
        data: {ordenapor: ordenar, direccion: direccion},
        success: rellenar,
        type: "post",
        cache: false
      });
    }
    if(tabla == "jugadores"){
      $.ajax({
        url: "../Administrador/listadojugadores.php",
        data: {ordenapor: ordenar, direccion: direccion},
        success: rellenar,
        type: "post",
        cache: false
      });
    }
  });

  //Se ejecuta en el tiempo de espera del servidor
  function rellenar(data) {

    $("#listado").html(data);
  }

  //VENTANA DIALOGO DE BORRAR
  $(document).on("click", "#borrar", function () {
    codigo = $(this).parents("tr").data("botonborrar");
    tabla = $(this).parents("tr").data("tabla");
    campo = $(this).parents("tr").data("campo");
    $("#dialogoborrar").dialog("open");
  });

  $("#dialogoborrar").dialog({
    autoOpen: false,
    resizable: false,
    modal: true,
    buttons: {
      "Borrar": function () {
        $.get("eliminar.php", {codigo: codigo, tabla: tabla, campo: campo}, function () {
          $("#botonBorrar_" + codigo).fadeOut(1000);
          if(tabla == "nacionalidad"){
            $.get("listadonacionalidad.php", function (data) {
              $("#listado").html(data);
            });
          }
          if(tabla == "equipo"){
            $.get("listadoequipos.php", function (data) {
              $("#listado").html(data);
            });
          }
          if(tabla == "posicion"){
            $.get("listadoposiciones.php", function (data) {
              $("#listado").html(data);
            });
          }
          if(tabla == "jugadores"){
            $.get("listadojugadores.php", function (data) {
              $("#listado").html(data);
            });
          }
        });
        //get			
        //cierra ventana dialogo				
        $(this).dialog("close");
      },
      "Cancelar": function () {
        $(this).dialog("close");
      }
    }//buttons
  });

  //al clickar en añadir, llamo a añadir artista
  $(document).on("click", "#modificar", function () {
    codigo = $(this).parents("tr").data("botonborrar");
    //mete la informacion en el value de los input de dialogo
    $("#dialogomodificar #codigoId").val($(this).parent().siblings("td.codigo").text());
    $("#dialogomodificar #nombreId").val($(this).parent().siblings("td.nombre").text());
    
    //para poner en los option el que tiene
    var equipo = $(this).parent().siblings("td.equipo").attr("name");
    $("#dialogomodificar #equipoId option[value='" + equipo + "']").attr("selected", true);
   
    $("#dialogomodificar #dorsalId").val($(this).parent().siblings("td.dorsal").text());
    $("#dialogomodificar #datepicker").val($(this).parent().siblings("td.edad").text());
    $("#dialogomodificar #alturaId").val($(this).parent().siblings("td.altura").text());
    $("#dialogomodificar #pesoId").val($(this).parent().siblings("td.peso").text());
    
    var nacionalidad = $(this).parent().siblings("td.nacionalidad").attr("name");
    $("#dialogomodificar #nacionalidadId option[value='" + nacionalidad + "']").attr("selected", true);
    
    var posicion = $(this).parent().siblings("td.posicion").attr("name");
    $("#dialogomodificar #posicionId option[value='" + posicion + "']").attr("selected", true);
    tabla = $(this).parents("tr").data("tabla");
    campo = $(this).parents("tr").data("campo");
    segundocampo = $(this).parent().siblings("td.nombre").data("campo");
    //datepicker modificar
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "yy-mm-dd"
    });
    $("#dialogomodificar").dialog("open");
  });

  //VENTANA DIALOGO DE MODIFICAR
  $("#dialogomodificar").dialog({
    autoOpen: false,
    resizable: false,
    modal: true,
    buttons: {
      "Modificar": function () {
        nombre = $("#dialogomodificar #nombreId").val();
        if(tabla != "jugadores" && nombre != ""){
          $.get("modificar.php", {
            codigo: codigo,
            tabla: tabla,
            campo: campo,
            nombre: nombre,
            segundocampo: segundocampo},
                function () {
                  if(tabla == "nacionalidad" && nombre != ""){
                    $.get("listadonacionalidad.php", function (data) {
                      $("#listado").html(data);
                    });
                  }
                  if(tabla == "equipo" && nombre != ""){
                    $.get("listadoequipos.php", function (data) {
                      $("#listado").html(data);
                      console.log(data);
                    });
                  }
                  if(tabla == "posicion" && nombre != ""){
                    $.get("listadoposiciones.php", function (data) {
                      $("#listado").html(data);
                    });
                  }
                });
           if(nombre != ""){
            $(this).dialog("close");
           }
        }else if(tabla == "jugadores"){
          $.get("modificarjugadores.php", {
            codigo: codigo,
            nombre: $("#dialogomodificar #nombreId").val(),
            equipo: $("#dialogomodificar #equipoId").val(),
            dorsal: $("#dialogomodificar #dorsalId").val(),
            edad: $("#dialogomodificar #datepicker").val(),
            altura: $("#dialogomodificar #alturaId").val(),
            peso: $("#dialogomodificar #pesoId").val(),
            nacionalidad: $("#dialogomodificar #nacionalidadId").val(),
            posicion: $("#dialogomodificar #posicionId").val()
            },
                function () {
                  $.get("listadojugadores.php", function (data) {
                    $("#listado").html(data);
                  });
                });
          $(this).dialog("close");
        }
      }
    }//buttons
  });

  //--- PAGINACION -----
  $(document).on("click", ".pagination li a", function () {
    var numpage = $(this).data("page");
    tabla = $(this).data("tabla");
    if(tabla == "nacionalidad"){
      $.get("listadonacionalidad.php", {page: numpage}, function (data) {
        $("#listado").html(data);
      });
    }
    if(tabla == "equipo"){
      $.get("listadoequipos.php", {page: numpage}, function (data) {
        $("#listado").html(data);
      });
    }
    if(tabla == "posicion"){
      $.get("listadoposiciones.php", {page: numpage}, function (data) {
        $("#listado").html(data);
      });
    }
    if(tabla == "jugadores"){
      $.get("listadojugadores.php", {page: numpage}, function (data) {
        $("#listado").html(data);
      });
    }
  });

  //BUSQUEDA AVANZADA
  $(document).on("keypress keyup", "#buscar", function () {
    var valor = $("#buscar").val();
    tabla = $("#buscar").data("tabla");
    if(tabla == "nacionalidad"){
      $.get("listadonacionalidad.php",
            {
              busqueda: valor
            },
            function (data) {
              //vuelve a pintar el listado
              $("#listado").html(data);
      });//get
    }
    if(tabla == "equipo"){
      $.get("listadoequipos.php",
            {
              busqueda: valor
            },
            function (data) {
              //vuelve a pintar el listado
              $("#listado").html(data);
      });//get
    }
    if(tabla == "posicion"){
      $.get("listadoposiciones.php",
            {
              busqueda: valor
            },
            function (data) {
              //vuelve a pintar el listado
              $("#listado").html(data);
      });//get
    }
    if(tabla == "jugadores"){
      $.get("listadojugadores.php",
            {
              busqueda: valor
            },
            function (data) {
              //vuelve a pintar el listado
              $("#listado").html(data);
      });//get
    }
  });
  
  
  

}); 
