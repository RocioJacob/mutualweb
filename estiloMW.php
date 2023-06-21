<style type="text/css">
body{
  background-image: url("imagenes/fondo2.jpg");
  font-family: 'Georgia';


    /*background-color: #8faed6;*/
}

hr{
  border-color: #FFC947;
}

#datos{
  font-size: 14px;
}

#cajaDeBotones{
  margin: 0 auto;
  text-align: center;

}


.container{
   text-align: center;
    /*background-color: #fff;*/
}

#saludo{
  font-family: 'Georgia' cursive; 
  font-size: 15px; 
  color: #3A73A8; 
  text-align: left;
  margin-top: 2%;
}

#titulo{
  color: #0F4C75;
  text-align: center;
  font-size: 160%;
  font-weight: 15px;
}


#subtitulo{
  color: #0A1931;
  text-align: center; /*alineacion*/
  font-size: 15px;  /*tamaño letra*/
  font-weight: 300; /*grosor letra*/
  /*font-family: 'Georgia', cursive;*/
}

#textoizq{
  text-align: left;
}

#iconos{
  height: 5%;
  width: 5%;
  margin-left: 2%;
}

#red{
  height: 5%;
  width: 5%;
  margin-right: 2%;
  margin-left: 2%;
}

#red:hover{
  transform: scale(1.1);
}

#advertencia{
  font-family: bold;
  font-size: 130%;
  color: #1B262C;
  text-align: center;
}

.boton{/*el boton es responsive y con un tamaño independiente al texto para que todos tengan un tamaño fijo*/
  font-size: 110%;
  color: #EFEFEF;
  border-color: #BBE1FA;
  background-color: #0F4C75;
  height: 10vh;
  width: 30%;
  margin-bottom: 3%;
  margin-right: 2%;
  border-radius: 2vh;   /*uso vh para que el radio se base en la altura y se modifique cuando cambia el tamaño de los botones*/
}

.boton:hover{
  color: #0F4C75;
  background-color: #EFEFEF;
  transform: scale(1.1);
}

#logonav{
  height: 20vh;
}
#leyenda{
  color: white;
  margin: 0%;       /* centra el texto en la barra de navegacion*/
  font-size: 2.5vw;
}

#barra{
  background-image: url("imagenes/fondoBarra.png");
  
  /*background: #003366;*/
  color: EFEFEF;
  height: 20%;
}

#salir{
  text-decoration:none;
  color: white;
  font-size: 18px;
  font-family: Georgia;
}
#botonMenu{
  float:right;
  margin-right: 15%;
  background-color: #3282B8;
  color: white;
  border: 2px solid;
  border-radius: 2vh;
  text-align: left;
  border-color: #EFEFEF;
  font-size: 1vw;
}

#botonMenu:hover{
  color: #0072BC;
  background-color:#EFEFEF;
  border-color: #3282B8;
  -webkit-transform:scale(1.1);transform:scale(1.1); /*Acercamiento*/
}

      /*ESTILO CAMBIAR CLAVE*/

#clave{
  border-color: #2874A6; 
  border-radius: 25px; 
  text-align: center;
  margin:5px;
}
#confirmacion{
  border-color: #2874A6; 
  border-radius: 25px; 
  text-align: center;
  margin:5px;
}


#loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('imagenes/loader.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}
//**{
  font-family: 'Georgia', cursive;
}*//
.input-group-text{
  border: solid 1px #2874A6;
  background-color: white;
}
.input-group { 
  width: 35%;
}
a{
  color: #2874A6;
  /*font-family: 'Georgia', cursive;*/
}
a:hover{
  cursor: pointer;
  color: black;
}

#contenedor{
  width: 750px;
  height: 550px;
  margin: 50px auto;
  background-color: white;
  /*border: 1px solid #1E90FF;*/
  /*border-radius:8px;*/
  /*padding: 0px 9px 0px 9px;*/
}
#container{
  display: flex;
}
#containerMenu{
  flex-basis: 33%;
}
#botonCambiar{
  background-color: #3282B8;
  height:40px; 
  width:180px;
  border: 2px solid;
  border-radius: 25px;
  font-size: 15px;
  /*font-family: 'Georgia', cursive;*/
}
#botonCambiar{
  /*background: #003366;*/
  color: white;
  background-color: #185ADB!important ;
}
#botonCambiar:hover{
  background: #BBE1FA !important;
  /*color: #003366 !important;*/
  color: #148F77 !important;
}

#botonVolver{
  margin: 0 auto;
  margin-bottom: 5px;
  height:90%; 
  width:20vh;
  border: 2px solid;
  border-radius: 25px;
  font-size: 15px;
  /*font-family: 'Georgia', cursive;
  /*background: #003366;*/
  color: white;
  background-color: #062863;
  text-align: center ;
  float: right;
}
#botonVolver:hover{
  background: white;
  color: #062863 !important;
}

#clave::placeholder, #confirmacion::placeholder{
  text-align: center;
  padding-top: 30px;
  font-size: 15px;
  /*font-family: 'Georgia', cursive;*/
}


#titulochico{
  color: #003366;
  text-align: center; /*alineacion*/
  font-size: 25px;  /*tamaño letra*/
  font-weight: 500; /*grosor letra*/
  /*font-family: 'Georgia', cursive;*/
  margin:5px;
}

.input-groupchico { 
  width: 50%;
}

      /* ESTILO HISTORIALES */


<style type="text/css">
h6{
  font-family: 'italic'; 
  color: #3A73A8;
  font-weight: normal;
}
#iconos{
  height: 5%;
  width: 5%;
  margin-left: 2%;
}

#fila{
  background-color: #1c4c96; 
  color: #EFEFEF; 
  font-weight: 200;
  font-family: 'italic';
  font-size: 130%;
}
#detalle{
  font-family: 'Verdana';
  /*font-family: 'Georgia';*/
  /*font-family: 'italic';*/
  /*color:#003366;*/
  color:black;
  font-size: 13px;
}
#fila1{
  border:none;
}
#tablaCarga{
  background-color: #3282B8;
}

#botonver{
  width: 90%;
  background-color: #3282B8;
  color: #EFEFEF;
  border: 2px solid;
  border-radius: 10px;
  border-color: #EFEFEF;
}

#botonver:hover{
  color: #0072BC;
  background-color:#EFEFEF;
  border-color: #3282B8;
  -webkit-transform:scale(1.1);transform:scale(1.1); /*Acercamiento*/
}


      /*ESTILO ACTIVAR*/


.form-control{
  text-transform:uppercase; 
  border-color: #BBE1FA; 
  border-radius: 25px; 
  text-align: center;
  margin:5px;
}

#loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('imagenes/loader.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}

.input-group-text{
  border: solid 1px #2874A6;
  background-color: white;
}

.input-group { 
  width: 35%;
}

@media (max-width: 767px) {
   .input-group { 
    width: 60%;
    }
 }

a{
  color: #2874A6;
  /*font-family: 'Georgia', cursive;*/
}
a:hover{
  cursor: pointer;
  color: black;
}

#contenedor{
  width: 750px;
  height: 550px;
  margin: 50px auto;
  background-color: white;
  /*border: 1px solid #1E90FF;*/
  /*border-radius:8px;*/
  /*padding: 0px 9px 0px 9px;*/
}

#botonActivar , #botonRecuperar , #botonReestablecer, #botonRegistrar, #botonVerificar{
  height:40px; 
  width:180px;
  border: 2px solid;
  border-radius: 25px;
  font-size: 15px;
  /*font-family: 'Georgia', cursive;*/
  color: white;
  background-color: #1c4c96;
}

#botonActivar:hover, #botonRecuperar:hover, #botonReestablecer:hover, #botonRegistrar:hover, #botonVerificar:hover{
  background: white;
  /*color: #003366 !important;*/
  color:#1c4c96 !important;
}
 #imagen{
    height: 25%;
    width: 25%;
    margin-top:3%;
  }
#usuario::placeholder, #documento::placeholder, #email::placeholder, #clave::placeholder, #confirmacion::placeholder{
  /*color: #3391FF;*/
  /*color: #2874A6;*/
  text-align: center;
  padding-top: 30px;
  font-size: 15px;
  /*font-family: 'Georgia', cursive;*/
  margin: 2%;
  border-color: #BBE1FA;
}

    /* ACTUALIZACIONES */


#alerta{
    color: #0072BC;
    text-align:center;
}
#tabla{
    text-align: center;
}
#mensaje{
    color: #0072BC;
    text-align: center;
}



      /* BUSQUEDA */


#alerta2{
    color: black;
}


    /*ESTILO CREDENCIAL*/


.btninter{
  border: 2px solid;
  border-color: #0072BC;
  transition: all 1s ease;
  position: relative;
  padding: 5px 1px; /*arriba-abajo, izq-der*/
  margin: 0px 10px 10px 0px;
  float: center;
  border-radius: 15px; /*redondeo de las esquinas*/
  /*font-family: 'Georgia', cursive;*/
  /*font-family: 'Georgia', cursive;*/
  font-size: 17px; /*tamaño letra*/
  color: white; /*color letra*/
  /*text-decoration: none;  */
  width: 180px !important; /*tamaño botones*/
  height: 40px !important;
  text-align: center; /*alineacion de texto*/
  background: #0072BC;

}
.btninter:hover {
  background: white;
  color: #0072BC !important;
  -webkit-transform:scale(1.1);transform:scale(1.1); /*Acercamiento*/
}

      /*ESTILO CUENTA CORRIENTE */


#botonDeuda{
  float:right;
  /*margin-right: 5vh;*/
  background-color: #1B262C;
  color: white;
  border: 2px solid;
  border-radius: 10vh;
}

#mas:hover{
  title:'HOLA';
}

#detalle1{
  font-family: 'Verdana';
  /*font-family: 'Georgia';*/ 
  /*font-family: 'italic';*/
  color:red;
  font-size: 13px;
}
#detalle2{
  font-family: 'Verdana';
  /*font-family: 'Georgia';*/ 
  /*font-family: 'italic';*/
  color:#003366;
  font-weight: bold;
  font-size: 13px;
}

th {
    width: 200px;
    word-wrap: break-word;
}


#botonCuenta{
  margin: 0 auto;
  margin-bottom: 5px;
  height:90%; 
  width:20vh;
  border: 2px solid;
  border-radius: 25px;
  font-size: 15px;
  /*font-family: 'Georgia', cursive;*/
  /*background: #003366;*/
  color: white;
  background-color: #062863;
  text-align: center ;
  float: right;
}
#botonCuenta:hover{
  background: white;
  color: #062863 !important;
}

    /* FORMULARIOS */


#pieDePaginaTramites{
  color: #EFEFEF;
  text-align: center;
  background-image: url(imagen/fondoBarra.png);  
}

#nomTramite{
  font-size: 300%;
  font-family: 'Georgia';
}
.caja { 
font-family: Georgia;
font-size: 100%;
color: #1B262C; 
/*border-radius: 5vh;*/
border-top: 1vh solid #0072BC;
border-right: 1vh solid #0072BC;
border-bottom: 1vh solid #0072BC;
border-left: 1vh solid #0072BC;
padding: 5px;
}

/*#botonMenu{    esta incluido en la barra de navegacion
  float:right;
  margin-right: 5px;
  background-color: #148F77;
  color: white;
  border: 2px solid;
  border-radius: 10px;
}*/
#botonEnviar{
  float:left;
}
#botonEnviar{
  
  margin-right: 10px;
  background-color: #3282B8;
  color: white;
  border: 2px solid;
  border-radius: 10px;
  text-align: center;
  border-color: #EFEFEF;
}

#botonEnviar:hover{
   color: #0072BC;
   background-color:#EFEFEF;
   border-color: #3282B8;
  -webkit-transform:scale(1.1);transform:scale(1.1); /*Acercamiento*/
}


#loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('imagenes/loader.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}
h6{
  font-family: 'italic'; 
  color: #3A73A8;
  font-weight: normal;
}

      /*RECUPERACION */


#documento::placeholder {
  /*color: #3391FF;*/
  /*color: #2874A6;*/
  text-align: center;
  padding-top: 30px;
  font-size: 15px;
  /*font-family: 'Georgia', cursive;*/
}
#img-menu{
  height: 20%;
  width: 20%;
  border-radius: 10%;
  margin: 2%;
}
#img-menu:hover{
  transform: scale(1.1);
}


</style>