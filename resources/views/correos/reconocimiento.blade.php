<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title>Evolución</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@200;500;700&display=swap" rel="stylesheet">
  <style>
    table, td, div, h1, p {font-family: 'Roboto Slab', serif;}
    * {
       box-sizing: border-box;
        }

        form {
          padding: 1em;
          border: 1px solid #c1c1c1;
          background-color:#ECE9E9;
          margin-top: 2rem;
          max-width: 600px;
          margin-left: auto;
          margin-right: auto;
          padding: 1em;
        }
        form input {
          margin-bottom: 1rem;
          background: #fff;
          border: 1px solid #9c9c9c;
        }
        form button {
          background: lightgrey;
          padding: 0.7em;
          border: 0;
        }
        form button:hover {
          background: gold;
        }

        label {
          text-align: left;
          display: block;
          padding: 0.5em 1.5em 0.5em 0;
        }

        input {
          width: 100%;
          padding: 0.7em;
          margin-bottom: 0.5rem;
        }
        input:focus {
          outline: 3px solid gold;
        }

        @media (min-width: 400px) {
          form {
            overflow: hidden;
          }

          label {
            float: left;
            width: 200px;
          }

          input {
            float: left;
            width: calc(100% - 200px);
          }

          button {
            float: right;
            width: calc(100% - 200px);
          }
        }
        .container {
          margin: 0 0 1rem;
          display: flex;
          /* align-items por defecto tiene el valor `stretch` */
          align-items: start;
        }
    .letraform{
      font-family: 'Roboto Slab', serif;
      font-size:17px;
      line-height: 1.3;
      font-weight: 500;
      text-align:left; 
    }
    /*Boton de enviar reconocimiento */
    .botonclase {
      background-color: #EF464B; /* Green */
      border: none;
      color: white;
      border-radius: 10px;
      padding: 16px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      transition-duration: 0.4s;
      cursor: pointer;
    }

    .button2 {
      background-color: white; 
      color: black; 
      border: 2px solid #008CBA;
    }

    .button2:hover {
      background-color: #008CBA;
      color: white;
    }

  </style>
</head>
<body style="margin:0;padding:0;">
  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
      <td align="center" style="padding:0;">
        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
          <tr>
            <td align="center" style="padding:10px 0 10px 0; background:#6D7274;">
             <img src="https://asareconoser.evolucion.co/dist/img/logoas.png" alt="Cargando imagen ..." style="height:auto;display:block;" />
             <h1 style="font-size:24px;margin:0 0 10px 0;font-family:Arial,sans-serif; color:white;">¡Felicidades! <span style="color:white;">  @if(isset($datosrec)) {{$datosrec->nomrecibe}} {{$datosrec->aperecibe}} @endif</span></h1>
            </td>
          </tr>
          <tr>
            <td style="padding:20px 30px 42px 30px;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">    
                <tr>
                  <td style="padding:0 0 10px 0;color:#153643;">
                    <h1 style="font-size:18px;margin:0 0 15px 0;font-family:Arial,sans-serif;"><span style="color:#Ffbd03;"> @if(isset($datosrec)) {{$datosrec->nomenvia}} {{$datosrec->apenvia}}@endif </span> Te acaba de enviar un reconocimiento.</h1>
                  </td>
                </tr>
                <tr>
                  <td style="padding:0;">
                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                      <tr>
                        <td style="width:260px;padding:0;vertical-align:top;color:#153643;">
                        
                         <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                         <!--Datos de la categoria y comportamiento-->
                         <form class="form1 letraform" style="font-size:14px;font-family:Arial,sans-serif; text-align: justify;">
                           <div class="container">
                            <label for="firstName" class="first-name">Detalle: </label>
                            <label for="firstName" class="first-name">@if(isset($datosrec)){{$datosrec->detalle}}@endif</label>
                            <br>
                          </div>
                          <hr>
                          <div class="container">
                             <label for="lastName" class="last-name">Categoría: </label>  <!-- rutaimagen-->
                             <label for="lastName" class="last-name">@if(isset($datosrec)){{$datosrec->categoria}}@endif</label> 
                             <br>
                          </div>
                          <hr>
                          <div class="container">
                            <label for="job">Comportamiento: </label>
                            <label for="job">@if(isset($datosrec)){{$datosrec->comportamiento}}@endif</label>
                            <br>
                          </div>
                          <hr>
                          <div class="container">
                            <label for="age">Puntos: </label>
                            <label for="age">@if(isset($datosrec)){{$datosrec->puntos}}@endif</label>
                          </div>
                          
                          <hr>
                         </form>
                        
                         <!--end datos-->
                         </p>
                        </td>
                      
                      </tr>
                    </table>
                    <br>
                    <p style="font-size:18px;margin:0 0 15px 0;font-family:Arial,sans-serif; text-align: justify;"><span style="color:black;">Recibir un reconocimiento es premiar tus esfuerzos, espero que esto te siga motivando para lograr nuevos proyectos que te impulsen a avanzar.</p>
                     <div style="text-align:center">
                      <a class="botonclase boton2" href="https://asareconoser.evolucion.co/" target="_blank"> Ve y reconoce </a>
                     </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
           
            <td style="padding:30px; background:#EF464B;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                <tr>
                  <td style="padding:0;width:50%;" align="left">
                    <a href="https://www.evolucion.co/" style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:black; color:white;">
                      &reg; Evolución, 2024<br/>
                   </a>
                   <label style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:black;" > @if(isset($datosrec)){{date ('Y-m-d', strtotime($datosrec->fecha))}}@endif</label>
                  </td>
                  <td style="padding:0;width:50%;" align="right">
                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                      <tr>
                        <td style="padding:0 0 0 10px;width:38px;">
                         
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>