<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title></title>
  <!--[if mso]>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  <style>
    table, td, div, h1, p {font-family: Arial, sans-serif;}
    * {
       box-sizing: border-box;
        }

        form {
          padding: 1em;
          border: 1px solid #c1c1c1;
          background-color:#D1FFF8;
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
  </style>
</head>
<body style="margin:0;padding:0;">
  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
      <td align="center" style="padding:0;">
        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
          <tr>
            <td align="center" style="padding:20px 0 20px 0;background:#08FFD5;">
             <!-- <img src="https://assets.codepen.io/210284/h1.png" alt="" width="300" style="height:auto;display:block;" />-->
             <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">¡Felicidades! <span style="color:#Ffbd03;">{{$datosrec->nomrecibe}} {{$datosrec->aperecibe}}</span></h1>
            </td>
          </tr>
          <tr>
            <td style="padding:36px 30px 42px 30px;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">    
                <tr>
                  <td style="padding:0 0 36px 0;color:#153643;">
                    <h1 style="font-size:18px;margin:0 0 15px 0;font-family:Arial,sans-serif; text-align: justify;"><span style="color:#Ffbd03;"> {{$datosrec->nomenvia}} {{$datosrec->apenvia}} </span> Te acaba de enviar un reconocimiento.</h1>
                  </td>
                </tr>
                <tr>
                  <td style="padding:0;">
                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                      <tr>
                        <td style="width:260px;padding:0;vertical-align:top;color:#153643;">
                          <!-- <div style="text-align:center;">
                          <img src="https://assets.codepen.io/210284/left.gif" alt="" />
                         </div>-->
                         <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                         <!--Datos de la categoria y comportamiento-->
                         <form class="form1" style="font-size:14px;font-family:Arial,sans-serif; text-align: justify;">
                           <div class="container">
                            <label for="firstName" class="first-name">Detalle:</label>
                            <label for="firstName" class="first-name">{{$datosrec->detalle}}</label>
                            <br>
                          </div>
                          <hr>
                          <div class="container">
                             <label for="lastName" class="last-name">Categoria</label>  <!-- rutaimagen-->
                             <label for="lastName" class="last-name">{{$datosrec->categoria}}</label> 
                             <br>
                          </div>
                          <hr>
                          <div class="container">
                            <label for="job">Comportamiento</label>
                            <label for="job">{{$datosrec->comportamiento}}</label>
                            <br>
                          </div>
                          <hr>
                          <div class="container">
                            <label for="age">Puntos</label>
                            <label for="age">{{$datosrec->puntos}}</label>
                          </div>
                          
                          <hr>
                        </form>
                         <!--end datos-->
                         </p>
                        </td>
                      
                       <!-- <td style="width:20px;padding:0;font-size:0;line-height:0;">&nbsp;</td>-->
                        <!--<td style="width:260px;padding:0;vertical-align:top;color:#153643;">
                          <p style="margin:0 0 25px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><img src="https://assets.codepen.io/210284/right.gif" alt="" width="260" style="height:auto;display:block;" /></p>
                          <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Morbi porttitor, eget est accumsan dictum, nisi libero ultricies ipsum, in posuere mauris neque at erat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis, sit amet blandit ipsum volutpat sed.</p>
                          <p style="margin:0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;"><a href="http://www.example.com" style="color:#ee4c50;text-decoration:underline;">In tempus felis blandit</a></p>
                        </td>-->
                      </tr>
                    </table>
                    <br>
                    <p style="font-size:18px;margin:0 0 15px 0;font-family:Arial,sans-serif; text-align: justify;"><span style="color:black;">Recibir un reconocimiento es premiar tus esfuerzos, espero que esto te siga motivando para lograr nuevos proyectos que te impulsen a avanzar.</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
           
            <td style="padding:30px;background:#Ffbd03;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                <tr>
                  <td style="padding:0;width:50%;" align="left">
                    <a href="https://www.evolucion.co/" style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:black;">
                      &reg; Evolución, 2022<br/>
                   </a>
                   <label style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:black;" >{{date ('Y-m-d', strtotime($datosrec->fecha))}}</label>
                  </td>
                  <td style="padding:0;width:50%;" align="right">
                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                      <tr>
                        <td style="padding:0 0 0 10px;width:38px;">
                          <a href="https://www.facebook.com/evolucion.aprendizajedivertido/" style="color:black;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
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