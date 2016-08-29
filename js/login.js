function InvalidMsg(textbox) {
    
    if (textbox.value == '') {
        textbox.setCustomValidity('ingrese nombre de usuario');
    }   
    else {
        textbox.setCustomValidity('');
    }
    return true;
}
function recuperar(email) {
    var email=email;
    //alert(email);

    $.ajax({
        type: 'post',
        url: 'ajax_recuperar_clave.php',
        data: {"email":email},
        success:  function (response) {
                        console.log(response);
                        var mensaje = JSON.parse(response);
                        console.log(mensaje);
                        if (mensaje==-1)
                        {   
                            document.getElementById('message').innerHTML = "<div class='alert alert-danger'>"+
                            "<strong>error!</strong> no se encuentra correo."+
                            "</div>";
                             
                            
                        }
                        else{
                            document.getElementById('message').innerHTML = "<div class='alert alert-success'>"+
                            "<strong>successful!</strong>"+"<br>se ha enviando un correo con el nombre de usuario a : <b>"+mensaje+"</b>"+
                            "</div>";
                            document.getElementById('tutor').value ="";
                            
                            
                        }
                        
 
                        
                        
                },
             error: function(result) {
                     document.getElementById('message').innerHTML = "error ajax";


                }
          });
 }
function validarEmail( email ) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) )
        {

            return false;
        }
        else{
            return true;
        }

} 
 function registrar(username,curso,email) 
{    
     if (username== '') {
         document.getElementById('message').innerHTML = "<div class='alert alert-danger'>"+
                            "<strong>error!</strong> ingrese nombre."+
                            "</div>";
         document.getElementById('username').focus();                    
         return true;
    }   
     
    if (curso== '') {
          document.getElementById('message').innerHTML = "<div class='alert alert-danger'>"+
                            "<strong>error!</strong> seleccione curso."+
                            "</div>";
         document.getElementById('curso').focus();  
         return true;
    }
    if (email== '') {

         document.getElementById('message').innerHTML = "<div class='alert alert-danger'>"+
                            "<strong>error!</strong> ingrese correo."+
                            "</div>";
         document.getElementById('tutor').focus();  
         return true;
    }
    if ( validarEmail(email)==false)
    {
        document.getElementById('message').innerHTML = "<div class='alert alert-danger'>"+
                            "<strong>error!</strong> correo invalido."+
                            "</div>";
         document.getElementById('tutor').focus();
         return true; 
    }
    if (document.getElementById("checkbox2").checked == false)
    {
        document.getElementById('message').innerHTML = "<div class='alert alert-danger'>"+
                            "<strong>error!</strong> debe aceptar el consentimiento."+
                            "</div>";
         document.getElementById('checkbox2').focus();
         return true; 
    }
    
    $.ajax({
            type: 'post',
            url: 'ajax_registro.php',
            data: {"username":username,"edad":curso,"email": email}, 
             success:  function (response) {
                        console.log(response);
                        var mensaje = JSON.parse(response);
                        console.log(mensaje);
                        if (mensaje==-1)
                        {   
                            document.getElementById('message').innerHTML = "<div class='alert alert-danger'>"+
                            "<strong>error!</strong> usuario ya existe."+
                            "</div>";
                             
                            
                        }
                        else{
                            document.getElementById('message').innerHTML = "<div class='alert alert-success'>"+
                            "<strong>successful!</strong>"+"<br> registro exitoso!<b> </b>"+
                            "</div>";
                            window.location = "login.html";
                            
                            
                        }
                        
 
                        
                        
                },
             error: function(result) {
                     document.getElementById('message').innerHTML = "error ajax";


                }
          });


}
  function login(username) 
{   
  if (username== '') {
         document.getElementById('message').innerHTML = " <br> <div class='alert alert-danger'>"+
                            "<strong>error!</strong> ingrese nombre."+
                            "</div>";
         document.getElementById('username').focus();                    
         return true;
    }   
    $.ajax({
            type: 'post',
            url: 'ajax_login.php',
            data: {"username":username}, 
             success:  function (response) {
                        console.log(response);
                        var mensaje = JSON.parse(response);
                        console.log(mensaje);
                        if (mensaje==-1)
                        {   
                            document.getElementById('message').innerHTML = "<br> <div class='alert alert-danger'>"+
                            "<strong>error!</strong> usuario no existe."+
                            "</div>";
                             
                            
                        }
                        else{
                            window.location = "instrucciones.html";
                            
                            
                            
                        }
                        
 
                        
                        
                },
             error: function(result) {
                     document.getElementById('message').innerHTML = "error ajax";


                }
          });


}
