<h3>Gerenciar vídeo</h3>
<div class="text-right">
    {!! Button::primary('Listagem de vídeos')->asLinkTo(route('admin.videos.index')) !!}
</div>

{!!
    Navigation::tabs([
        [
            'title' => 'Informações',
            'link' => isset($video) ? route('admin.videos.edit', ['video' => $video->id]) : route('admin.videos.create')
        ],
        [
            'title' => 'Playlist e categorias',
            'link' => isset($video) ? route('admin.videos.relations.edit', ['video' => $video->id]) : 'javascript:void',
            'disabled' => ! isset($video)
        ],
        [
            'title' => 'Vídeo e thumbnail',
            'link' => isset($video) ? route('admin.videos.uploads.edit', ['video' => $video->id]) : 'javascript:void',
            'disabled' => ! isset($video)
        ]
    ])
!!}

{!! $slot !!}