function conexiones(){
    var path = "random.php";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        
        if(xhttp.readyState == 4 && xhttp.status == 200){
            document.getElementById("gente").innerHTML=xhttp.responseText;
        }
    }    
    
    xhttp.open("GET", path, true);
    xhttp.send();
}


$(document).ready(function() {
    $('#logoff').on('click', function() {
        $.post('log-off.php', {}, function(response) {
            window.location=index.php;
        });
    });

    setInterval(conexiones, 3000);
});
