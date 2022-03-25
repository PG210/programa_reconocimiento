<br>
<ul class="list-unstyled w-100">
    @forelse ($results as $post)
    <div class="alert alert-primary" role="alert">
    <i class="fas fa-user-check"></i><a style="text-decoration:none" href="#" class="post-link" data-id="{{ $post->id }}"> &nbsp;{{ $post->name }}</a>
    </div>
    @empty
        <div class="alert alert-warning" role="alert" data-id="0">
        <i class="fas fa-heart-broken"></i>&nbsp; Disculpa, No hay coincidencia con la busqueda "{{ $search }}"
        </div>
    @endforelse
</ul>