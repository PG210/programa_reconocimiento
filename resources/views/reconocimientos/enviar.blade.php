@extends('usuario.principa_usul')
@section('content')
<div class="alert alert-success text-center" role="alert">
 Enviar Reconocimientos
</div>
<br>

<div class="container-fluid">
    <div class="row" id="map_section">
        <div class="col-12">
        <form action="#" id="search-form">
                          @csrf
                          <div class="row">
                              <div class="col-12" id="search-wrapper">
                                  <input type="text" class="form-control w-100 m-0 search" placeholder="Ingrese el nombre a buscar ..." aria-label="Search">

                                  <div id="results">

                                  </div>
                              </div>
                          </div>
                      </form>
                      <br>    
                      <div id="post" class="mt-5"></div><!--retorna la informacion-->     
                </div>
         </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script>
        $(function ()
        {
            'use strict';

            $(document).on('keyup', '#search-form .search', function ()
            {
                if($(this).val().length > 0)
                {
                    var search = $(this).val();

                    $.get("{{ route('posts.search') }}", {search: search}, function (res)
                    {
                        $('#results').html(res);
                    });

                    return;
                }

                $('#results').empty();
            });

            $(document).on('click', '.post-link', function ()
            {
                var postId = $(this).data('id');

                $.get("{{ url('posts/show') }}", {id: postId}, function (res)
                {
                    $('#results').empty();
                    $('.search').val('');
                    $('#post').html(res);
                });
            });
        });
        </script>


@endsection
