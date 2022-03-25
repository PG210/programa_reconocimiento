<!--tabla para ver los valores-->
<table class="table">
              <thead class="table-warning">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Dirección</th>
                <th scope="col">Imagen</th>
                <th scope="col">Reconocer</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <th scope="row">{{$post->id}}</th>
                  <td>{{ $post->name }}</td>
                  <td>{{ $post->apellido }}</td>
                  <td>{{ $post->direccion }}</td>
                  <td>
                    <div class="text-center">
                   <!--imagen-->
                  </div>
                </td>
                <td>
                <a style="text-decoration:none" type="button" class="btn btn-warning">Reconocer</a>
                </td>
                <!--  <td><button type="button" class="btn btn-success">Actualizar</button></td>
                  <td><button type="button" class="btn btn-danger">Eliminar</button></td>
                 -->
                </tr>
            </tbody>
          </table>

        <!--end tabla-->
