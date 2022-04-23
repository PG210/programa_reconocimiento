<!--tabla para ver los valores-->
<table class="table">
              <thead class="table-warning">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Dirección</th>
                <th scope="col">Imagen</th>
                <th scope="col">Acción</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <th scope="row">{{$post->id}}</th>
                  <td>{{ $post->name }}</td>
                  <td>{{ $post->apellido }}</td>
                  <td>{{ $post->direccion }}</td>
                  <td>
                    
                   <!--imagen-->
                   <div class="user-panel mt-0 pb-0 mb-0 d-flex">
                    <div class="image">
                      <img src="{{ asset('dist/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                  </div>
                    <!---end imagen-->
                  
                </td>
                <td>
                <a href="{{route('listareconocer',$post->id)}}" type="button" class="btn" style="color:#ffbd03;" data-toggle="tooltip" title="Enviar Reconocimiento"><i class="fas fa-award  fa-2x"></i></a>
              </td>
                <!--  <td><button type="button" class="btn btn-success">Actualizar</button></td>
                  <td><button type="button" class="btn btn-danger">Eliminar</button></td>
                 -->
                </tr>
            </tbody>
          </table>

        <!--end tabla-->
