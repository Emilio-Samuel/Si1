function validation(){
    var passw = document.getElementById('pass').value;
    var passw2 = document.getElementById('pass2').value
    var card = document.getElementById('card').value;
    var email = document.getElementById('email').value;
    var url = document.getElementById('email').value;
    var letter = /[a;-z]/;
    var upper  =/[A-Z]/;
    var number = /[0-9]/;

    if(urlExists(url)==true){
        alert("Por favor introduzca un nombre de usuario que aun no halla sido escogido");
        return false;
    }

    if(passw!==passw2)
    {
        alert("Las contraseñas no coinciden");
        return false;
    }

    if(email.indexOf(".")<0){ 
        alert("Un email tiene la estructura *******@******.(com/es)");
        return false;

    }
    if((card.toString().length<16)||(card<0)||(card>9999999999999999)) {
        alert("La tarjeta de credito debe ser una combinacion de 16 numeros.");
        return false;
    }

    if(!letter.test(passw) || !number.test(passw) || !upper.test(passw) || passw.lenght < 8) {
        alert("La contraseña debe contener mayusculas minusculas y numeros y ser mas larga de 8 caracteres.");
        return false;
    }
}


function lifeValidator() {

    var usertemp = document.getElementById("email").value;	
    var path = "usuarios/" + usertemp + "/user.dat";

    if(usertemp == "") {
        $('#disponible').innerHTML="";
    } else {
        console.log(path);

        var xhttp= new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(xhttp.readyState == 4) {
                if(xhttp.status == 200) {
                    document.getElementById("disponible").innerHTML = "E-mail ya escogido. Pruebe con otro.";
                    document.getElementById("disponible").style.color = "red";
                } else {
                    document.getElementById("disponible").innerHTML = "E-mail disponible.";
                    document.getElementById("disponible").style.color = "green";
                }
                console.log(xhttp.status);
            }
        }

        xhttp.open("GET", path,true );
        xhttp.send();
    }
}



function urlExists(url)
{
    var http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    return http.status == 200;
}
