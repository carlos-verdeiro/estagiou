<section id="contatos">
<link rel="stylesheet" href="assets/css/index/suporte.css">
    <h1>Suporte ao Cliente</h1>
    <p><strong> Email:</strong> suporte@estagiou.com</p>
    </section>
    <section class="feedback">
        <form action="#" method="post">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" required placeholder="Seu nome">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Seu e-mail">

            <label for="message">Mensagem:</label>
            <textarea id="message" name="message" rows="4" required placeholder="Sua mensagem"></textarea>

            <button type="submit">Enviar mensagem</button>
        </form>
    </section>
</section>
<?php
include_once "../../assets/templates/index/footer.php";
?>