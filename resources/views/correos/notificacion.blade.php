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
      background-color: #DEA064; /* Green */
      border: none;
      color: black;
      border-radius: 10px;
      padding: 8px 15px;
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
            <td align="center" style="padding:10px 0 10px 0; background:#131535;">
              <img src="https://reconoser.evolucion.co/dist/img/logo_evo.png" alt="Cargando imagen ..." style="width:50px; display:block;" />
            </td>
          </tr>
          <tr>
            <td style="padding:36px 30px 42px 30px;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">    
                <tr>
                  <td style="color:#153643;">
                    <h1 style="font-size:18px; font-family: Arial,sans-serif;">
                    ¡Genial noticia! 🎉 <span style="color:#Ffbd03;">
                       @if(isset($datos)) 
                          @if($val == '1') 
                              {{ $datos['nomrecibe'] }} {{ $datos['aperecibe'] }}
                          @else
                               {{ $datos['nomenvio'] }} {{ $datos['apenvio'] }}
                          @endif 
                       @endif</span>
                   </h1>
                   <h1 style="font-size:18px; margin:0 0 5px 0; font-family: Arial,sans-serif;">
                      <span style="color:#Ffbd03;"> @if(isset($datos)){{ $datos['nombre'] }} {{ $datos['apellido'] }} @endif</span> 
                      <span>
                        ha @if(isset($datos))
                            @if($datos['estado'] == 1) 
                              reaccionado: {{$datos['emoticon']}} 
                            @elseif($datos['estado'] == 2)
                              comentado: <em> {{$datos['emoticon']}}, </em>
                            @endif
                          @endif
                      </span>
                     <!----validar la parte del mensaje -->
                     <span>
                     @if(isset($val)) 
                        @if($val == '1') 
                          @if($datos['emailusulog'] != $datos['emailenvia'])
                               a tu reconocimiento hecho por: <span style="color:#Ffbd03;">{{ $datos['nomenvio'] }} {{ $datos['apenvio'] }}</span>
                          @else
                              a tu reconocimiento.
                          @endif
                        @else
                          @if($datos['emailusulog'] != $datos['emailrecibe'])
                             en el reconocimiento que realizaste a:  <span style="color:#Ffbd03;">{{ $datos['nomrecibe'] }} {{ $datos['aperecibe'] }}.</span>
                          @else
                            en el reconocimiento que realizaste.
                          @endif
                        @endif
                      @endif
                      </span>
                   </h1>
                  </td>
                </tr>
                <tr>
                  <td style="padding:0;">
                    <table role="presentation" style="width:100%; border-collapse:collapse; border:0; border-spacing:0;">
                      <tr>
                        <td style="width:260px; padding:0; vertical-align:top; color:#153643;">
                        
                         <p style="margin:0 0 12px 0;">
                         <!--Datos de la categoria y comportamiento-->
                         <form class="letraform" style="text-align: justify; border-radius:10px;">
                           <div class="container">
                            <label for="firstName" class="first-name">Reconocimiento: </label>
                            <label for="firstName" class="first-name">@if(isset($datos)){{ $datos['detalle'] }}@endif</label>
                            <br>
                          </div> 
                          <hr>
                        </form>
                         <!--end datos-->
                         </p>
                        </td>
                      
                      </tr>
                    </table>
                     <div style="text-align:center">
                     <h1 class="letraform" style=" margin:0 0 5px 0; color:black; text-align:center;">
                        ¡Tu esfuerzo ha sido notado y apreciado!
                     </h1>
                      <a class="botonclase boton2" href="https://reconoser.evolucion.co/" target="_blank"> Ve comenta y reacciona </a>
                     </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
           
            <td style="padding:30px; background:#EDAA27;">
              <table role="presentation" style="width:100%; border-collapse:collapse; border:0; border-spacing:0; font-size:9px; font-family:Arial,sans-serif;">
                <tr>
                  <td style="padding:0;width:50%;" align="left">
                    <a href="https://www.evolucion.co/" target="_blank" style="margin:0; font-size:14px; line-height:16px; font-family:Arial,sans-serif; color:white;">
                      &reg; Evolución, 2025<br/>
                   </a>
                   <label style="margin:0; font-size:14px; line-height:16px; font-family:Arial,sans-serif; color:white;" >@if(isset($datos)){{date ('Y-m-d', strtotime($datos['fecha']))}}@endif</label>
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