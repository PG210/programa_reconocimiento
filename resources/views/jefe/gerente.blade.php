<table>
     <thead>
         <tr>
         <th scope="col" style="background-color:#FFBD03;">No</th>
         <th scope="col" style="background-color:#FFBD03;">Nombres</th>
         <th scope="col" style="background-color:#FFBD03;">Cargo</th>
         <th scope="col" style="background-color:#FFBD03;">Area</th>
         <th scope="col" style="background-color:#FFBD03;">Recompensa</th>
         <th scope="col" style="background-color:#FFBD03;">Estado</th>
         </tr>
     </thead>
     <tbody>
  <?php   
    $con=1;
     for($i=0;$i<count($res);$i++) {

        for($j=0;$j<count($res[$i]);$j++) {
          
            if($res[$i][$j]->entregado == 1){   
                echo '<tr>
                <td>'.$con++.'</td>
                <td>'.$res[$i][$j]->nombre." ".$res[$i][$j]->apellido.'</td>
                <td>'.$res[$i][$j]->cargonom.'</td>
                <td>'.$res[$i][$j]->areanom.'</td>
                <td>'.$res[$i][$j]->despremio.'</td>
                <td>'."Sin entregar".'</td>
                </tr>';
           }else{
                echo '<tr>
                <td>'.$con++.'</td>
                <td>'.$res[$i][$j]->nombre." ".$res[$i][$j]->apellido.'</td>
                <td>'.$res[$i][$j]->cargonom.'</td>
                <td>'.$res[$i][$j]->areanom.'</td>
                <td>'.$res[$i][$j]->despremio.'</td>
                <td>'."Entregado".'</td>
                </tr>';
           }

        }
           

     }
?>
</tbody>
</table>