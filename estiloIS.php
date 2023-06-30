<style type="text/css">
	
a{
  color: #BBE1FA;
  font-weight: bold;
  font-size: 18px;
}
a:hover{
  cursor: pointer;
  color: white;
}
p{
  color: #2b4a83;
  text-align: center;
}

#contenedor{
    width: 750px;
    height: 550px;
    margin: 50px auto;
    background-color: white;
}

#botonIngresar{
    height: 40px; 
    width: 150px; 
    border: 2px solid;
    border-radius: 25px;
    font-size: 15px;
    background-color: #2b4a83;
    color: white;
    
}

#botonIngresar:hover {
  background: white;
  /*color: #003366 !important;*/
  color: #2b4a83 !important;
  }

#botonVolver,#botonActivar, #botonRegistrar,#botonRecuperar, #botonVerificar{
    height: 40px; 
    width: 150px; 
    border: 2px solid;
    border-radius: 25px;
    font-size: 15px;
    /*background: #003366;*/
    background-color: #2b4a83;
    color: white;
    margin-bottom: 2%;
    /*font-family: 'Georgia', cursive;*/
  }

#botonVolver:hover,#botonActivar:hover, #botonRegistrar:hover,#botonRecuperar:hover, #botonVerificar:hover {
  background: white;
  color: #2b4a83 !important;
}

#imagen{
    height: 25%;
    width: 25%;
    margin-top:3%;
}

#documento::placeholder, #email::placeholder, #email::placeholder, #codigo::placeholder, #clave::placeholder, #confirmacion::placeholder  {
    text-align: center;
    padding-top: 30px;
    font-size: 2vw;
  }
#documento, #email, #email, #codigo, #clave, #confirmacion {
    text-transform:uppercase; 
    border-color: #2874A6; 
    border-radius: 25px; 
    text-align: center; 
    margin: 5px;
  }

 
#titulo{
    color: #003366;
    color: white;
    text-align: center; /*alineacion*/
    font-size: 2vw;  /*tamaño letra*/
    font-weight: 500; /*grosor letra*/
    /*font-family: 'Georgia', cursive;*/
}
  
body{
    background-image: url("imagenes/fondoBarra.png");
    width: 100%;
}

#documento, #clave{
    text-transform:uppercase; 
    border-color: #2874A6; 
    border-radius: 25px; 
    text-align: center; 
    margin: 5px;
}

#subtitulo{
  color: black;
  text-align: center; /*alineacion*/
  font-size: 16px;  /*tamaño letra*/
  font-weight: 300; /*grosor letra*/
}

 /***********************************************************para pc*/
@media screen and (min-width: 1024px){								
	.input-group { 
		width: 30%;
	}
    #documento::placeholder, #email::placeholder, #email::placeholder, #codigo::placeholder, #clave::placeholder, #confirmacion::placeholder  {
    text-align: center;
    padding-top: 30px;
    font-size: 1vw;
  	}
}
/***********************************************************para tablets*/
@media screen and (min-width: 601px) and (max-width: 1023px){		
	.input-group { 
	   	width: 30%;
	}
	#documento::placeholder, #email::placeholder, #email::placeholder, #codigo::placeholder, #clave::placeholder, #confirmacion::placeholder  {
    text-align: center;
    padding-top: 10px;
    font-size: 1.5vw;
 	}
}
/***********************************************************para celulares*/
@media screen and (max-width: 600px){  							
   .input-group { 
	   	width: 60%;
	}
	#documento::placeholder, #email::placeholder, #email::placeholder, #codigo::placeholder, #clave::placeholder, #confirmacion::placeholder  {
    text-align: center;
    padding-top: 10px;
    font-size: 2vw;
 	}
}


</style>