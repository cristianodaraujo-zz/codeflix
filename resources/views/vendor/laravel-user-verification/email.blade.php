<h3>{{ config('app.name') }}</h3>

<p>Sua conta na plataforma foi criada.</p>
<p>Usuário: <strong>{{ $user->email }}</strong></p>

<p>
    Clique aqui para confirmar sua conta
    <a href="{{ $link = route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) }}">
        {{ $link }}
    </a>
</p>

<p><strong>Importante</strong>: esta é uma mensagem automática e não deve ser respondida.</p>