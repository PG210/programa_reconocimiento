<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title>Feliz Cumpleaños</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@200;500;700&display=swap" rel="stylesheet">
  <style>
    table, td, div, h1, p {font-family: 'Roboto Slab', serif;}
    * {
       box-sizing: border-box;
        }
    
    .texto1{
        font-size: 18px; 
        margin: 0 0 15px 0;
        font-family: Arial, sans-serif;
    }

    .texto2{
        font-size: 16px; 
        margin: 0 0 15px 0;
        font-family: Arial, sans-serif;
        line-height: 1.6;
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
            <td style="padding:20px;">
               <p class="texto1" style="text-align:center;"> ¡Feliz cumpleaños, @if(isset($usuario->name))<strong>{{$usuario->name}} {{$usuario->apellido}}</strong>@endif!</p>
                <div align="center">
                 @if(isset($datos->imagen))
                  <img src="{{asset('/dist/eventos/'.$datos->imagen)}}" alt="Cargando imagen ..." style="display:block; width:60%;" /><br>
                 @endif
                </div>
               <p class="texto2"> @if(isset($datos->descrip)) {{$datos->descrip}} @endif</p>
            </td>
          </tr>
          <tr>
            <td style="padding:30px; background:#EDAA27;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                <tr>
                  <td style="padding:0;width:50%;" align="left">
                    <a href="https://www.evolucion.co/" style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:black; color:white;">
                      &reg; Evolución, 2025<br/>
                   </a>
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