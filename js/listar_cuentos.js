function reporte(username,id_cuento) {
    $.ajax({
            type: 'post',
            url: 'ajax_reporte.php',
            data: {"username":username,"id_cuento":id_cuento}, 
            success:  function (response) {
                        //console.log(response);
                        var data = JSON.parse(response);
                        //console.log(cuentos);
                        //var datos=response[0][0];
                        //console.log(response[0][0]);
                        var ticks = [100,90,80,70, 60, 50, 40, 30, 20, 10];
                        var ctx = document.getElementById("myChart");
                        //Chart.defaults.global.legend.display = false;

                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ["inferencia", "monitoreo","structura"],
                                datasets: [{
                                    label: "% de preguntas correctas",
                                    data: data,
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255,99,132,1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                             
                              responsive: false,
                                scales: {
                                    yAxes: [{
        ticks: {
          autoSkip: false,
          min: ticks[ticks.length - 1],
          max: ticks[0]
        },
        afterBuildTicks: function(scale) {
          scale.ticks = ticks;
          return;
        },
        beforeUpdate: function(oScale) {
          return;
        }
      }]
                                }
                            }
                        });

 
                        
                        
                        
                },
             error: function(result) {
                     $("feed").html("error al  Cargar los cuentos");


                }
          });
 }
function end(id_cuento,id_numeracion,username) {
    //alert("end");
 $.ajax({
            type: 'post',
            url: 'ajax_final.php',
            data: {"id_cuento":id_cuento,"id_numeracion":id_numeracion,"username":username}, 
             success:  function (response) {
                        //console.log(response);
                        var respuesta = JSON.parse(response);
                        console.log(respuesta);
                        if (respuesta!=true) 
                            {
                                
                        
                            window.location = 'cuento.html?id='+id_cuento+'&num='+respuesta;
                         

                            }
                            else    
                            {
                      
                         document.getElementById('cuento').innerHTML = "<div class='panel-heading'><h3>Cuento finalizado!!</h3></div>"+
                         "<div class='panel-body'>"+
                           "¡Muy bieeeeeen! <br>Has terminado de leer un cuento. Espero que te haya gustado mucho."
                            +" Ahora puedes continuar leyendo los cuentos que te faltan, o incluso " 
                            +"puedes volver a leer este mismo un par de veces más. Felicidades"
                            +" y a seguir leyendo."+"<br>"+
                        "</div>";
                        document.getElementById('boton').innerHTML =
                          "<a  class='btn btn-default' href='main.html'>continuar</a>";

                            }
                        
                        
                        
                },
             error: function(result) {
                     $("cuento").html("error al  Cargar los cuentos");


                }
          });}

function feedback(id_feedback) {
    $.ajax({
            type: 'post',
            url: 'ajax_feedback.php',
            data: {"id_feedback":id_feedback}, 
             success:  function (response) {
                        //console.log(response);
                        var feedback = JSON.parse(response);
                        //console.log(cuentos);
                        //var datos=response[0][0];
                        //console.log(response[0][0]);
                         document.getElementById('feed').innerHTML = "<div class='panel-heading'><h3>Consejos</h3></div>"+
                         "<div class='panel-body'>"+
                            feedback+"<br>"+
                        "</div>";

 
                        
                        
                        
                },
             error: function(result) {
                     $("#mensaje").html("error al  Cargar los cuentos");


                }
          });
 }
function lista_cuentos(user) {
	var username=user;
   //alert("hola");
      $.ajax({
            type: 'post',
            url: 'ajax_pool_cuentos.php',
            data: {"username":username}, 
             success:  function (response) {
             	        //console.log(response);
             	       var cuentos = JSON.parse(response);
             	       //console.log(cuentos);
             	        //var datos=response[0][0];
             	        //console.log(response[0][0]);
                        if (cuentos==-1) 
                            {

                            window.location = "index.html";

                            }
                         else{   
             	        for(i=0;i<cuentos.length;i++)
             	        {
             	        
						document.getElementById('cuento').innerHTML += "<div class='col-lg-4 col-sm-4 text-center'>"+
						 "<a href='cuento.html?id="+cuentos[i][0]+"&num="+cuentos[i][3]+"'>"+

                        "<button class='btn btn-default'><img class='img-circle img-responsive img-center' src='data:image/png;base64,"+cuentos[i][2]+"' alt=''></button></a>"+
						 "<h3>"+cuentos[i][1]+"</h3>"+
						 "</div>";

 
						}

                    }
						
                        
                },
             error: function(result) {
                    document.getElementById('cuento').innerHTML="error al  Cargar los cuentos";


                }
          });
 }


function cuento(id_cuento,id_numeracion) {
    var id_cuento=id_cuento;
    var id_numeracion=id_numeracion;
    //alert(id_cuento);
      $.ajax({
            type: 'post',
            url: 'ajax_cuento.php',
            data: {"id_cuento":id_cuento,"id_numeracion":id_numeracion},
             success:  function (response) {
                        //console.log(response);
                        var cuentos = JSON.parse(response);
                        //console.log(cuentos);
                        //var datos=response[0][0];
                        //console.log(response[0][0]);
                      
                        
                        document.getElementById('cuento').innerHTML += "<div class='panel-heading'><h3></h3></div>"+
                         "<div class='panel-body'>"+
                            cuentos[0]+"</div>";

 
                        
                        
                },
             error: function(result) {
                     $("#mensaje").html("error ");


                }
          });
 }
 
 
function pregunta(id_cuento,num) {
    var id_cuento=id_cuento;
    var id_num=num;
    //alert(id_num);
     $.ajax({
            type: 'post',
            url: 'ajax_pregunta.php',
            data: {"id_cuento":id_cuento,"id_num":id_num},
            success:  function (response) {
                        console.log(response);
                        var cuentos = JSON.parse(response);
                        //console.log(cuentos);
                        if (cuentos==-1) {
                           
                            window.location = 'error404.html';

                        }
                        else{
                        //var datos=response[0][0];
                        //console.log(response[0][0]);
                        var id_pregunta=cuentos['id_pregunta'];
                        var btn_izq= btoa(cuentos['btn_izq']);
                        var btn_der=btoa(cuentos['btn_der']);
                        var resp_correct=btoa(cuentos['respuesta_correcta']);
                        
                        document.getElementById('cuento').innerHTML += "<div class='panel-heading'><h3>Pregunta</h3></div>"+
                         "<div class='panel-body'>"+
                            cuentos['pregunta_texto']+"<br>"+
                                                    "</div>";

                          document.getElementById('boton1').innerHTML =
                          "<a  class='btn btn-default' href='respuesta.php?id="+id_pregunta+
                          "&resp_user="+btn_izq+"&resp="+resp_correct+"'>"+cuentos['btn_izq']+
                          "</a>";
                          document.getElementById('boton2').innerHTML =
                          "<a  class='btn btn-default' href='respuesta.php?id="+id_pregunta+
                          "&resp_user="+btn_der+"&resp="+resp_correct+"'>"+cuentos['btn_der']+
                          "</a>";


                         }

                        
                },
             error: function(result) {
                     $("#mensaje").html("error ");


                }
          });


    //alert("pseudo_alg");
    //pseudo random
    //var vector=pseudo_random(1,1,1);
    //alert(vector);



     
 }

