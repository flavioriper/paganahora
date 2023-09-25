<style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans&display=swap);

    * {
        margin: 0;
        padding: 0;
        font-family: Open Sans, sans-serif;
    }

    a {
        text-decoration: none;
        color: black;
    }

    .li {
        border-bottom: 1px solid black;
    }

    .header {
        padding: 25px;
        background: #0a0a0a;
    }

    .header a {
        color: white;
        font-size: 1.6em;
    }

    .block-main {
        height: 400px;
    }

    .container {
        position: relative;
        top: 50%;
        transform: translateY(-50%);
        margin-left: 75px;
    }

    p {
        font-size: 2em;
        font-weight: 600;
    }

    .desc {
        margin-top: 15px;
    }

    .s {
        margin-top: 35px;
    }

    .btn {
        padding: 15px;
        background: #27ae60;
        color: white;
    }
</style>

<div class="header">
    <span>Nome site</span>
</div>
<div class="block-main">
    <div class="container">
        <p>Recuperaçã de senha</p>
        <div class="desc">Você recebeu este e-mail porque você ou alguém tentou recuperar sua senha, usando seu endereço de email.<br>Se não foi você, então ignore esta mensagem.</div>
        <div class="s"><a href="{{$url}}" class="btn">Recuperar senha</a></div>
        <div class="s">Ou siga o link você mesmo: <span style="user-select: all">{{$url}}</span></div>
    </div>
</div>
