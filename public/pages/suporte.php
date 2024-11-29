<section id="contatos">
    <link rel="stylesheet" href="assets/css/index/suporte.css">
    <h1>Suporte ao Cliente</h1>
    <p><strong> Email:</strong> suporte@estagiou.com</p>
</section>
<section class="feedback">
    <form method="post" id="formSupote">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="nome" required placeholder="Seu nome" maxlength="100">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="Seu e-mail" maxlength="200">

        <label for="message">Mensagem:</label>
        <textarea id="message" name="mensagem" rows="4" required placeholder="Sua mensagem" maxlength="1000"></textarea>

        <button type="submit">Enviar mensagem</button>
    </form>
</section>
</section>
<!--TOAST INFORMAÇÃO-->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toastInformacao" class="toast" role="information" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Estagiou</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="corpoToastInformacao">
            Text
        </div>
    </div>
</div>
<script src="assets/js/index/suporte.js"></script>
<?php
include_once "../../assets/templates/index/footer.php";
?>