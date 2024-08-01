<section class="sectionPages sectionPagesEscola" id="sectionPageMenu">
    <link rel="stylesheet" href="../assets/css/dashboard/menu.css">

    <h1 class="tituloPage">MENU</h1>

    <div class="container text-center containerBlocosMenu">
        <div class="row row-cols-2 divBlocosMenu">
            <?php
            session_start();
            // Conectar com usuário e senha específicos para atualização
            $dsn = 'mysql:host=localhost;dbname=estagiou;charset=utf8mb4';
            $updateUser = 'root';
            $updatePassword = '';

            $connUpdate = new PDO($dsn, $updateUser, $updatePassword);
            $connUpdate->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $update_stmt = $connUpdate->prepare("SELECT ultimo_login FROM escola WHERE id = :id");
            $update_stmt->bindValue(':id', $_SESSION['idUsuarioLogin'], PDO::PARAM_INT);
            $update_stmt->execute();
            $row = $update_stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row['ultimo_login']) {
                echo '
                <div class="col blocosMenu">
                    <div class="card boasVindas" style="width: 18rem;">
                        <div class="col card-body">
                            <h5 class="card-title">Bem-vindo!</h5>
                            <p class="card-text">Seja bem vindo ao <strong>Estagiou</strong>, esperamos que goste da nossa plataforma😉</p>
                            <button class="btn btn-secondary btnFecharBoasVindas">Fechar</button>
                        </div>
                    </div>
                </div>
                <script> $(".btnFecharBoasVindas").on("click", ()=>{ $(".boasVindas").remove();})</script>
                ';

                // Atualiza o timestamp de último login
                $updateUser = 'root';
                $updatePassword = '';

                $connUpdate = new PDO($dsn, $updateUser, $updatePassword);
                $connUpdate->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $user_id = $_SESSION['idUsuarioLogin'];
                $update_stmt = $connUpdate->prepare("UPDATE escola SET ultimo_login = NOW() WHERE id = :id");
                $update_stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
                $update_stmt->execute();
            }
            ?>

            <div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Currículos</h5>
                        <p class="card-text">Publique os currículos para que as empresas visualizem.</p>
                        <button class="btn btn-primary">Ver mais</button>
                    </div>
                </div>
            </div>
            <div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Vagas</h5>
                        <p class="card-text">Veja as vagas disponíveis.</p>
                        <button class="btn btn-primary">Ver mais</button>
                    </div>
                </div>
            </div>
            <div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Empresas</h5>
                        <p class="card-text">Aqui você pode ver as empresas.</p>
                        <button class="btn btn-primary">Ver mais</button>
                    </div>
                </div>
            </div>
            <div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Notificações</h5>
                        <p class="card-text">Aqui você pode ver suas notificações.</p>
                        <button class="btn btn-primary">Ver mais</button>
                    </div>
                </div>
            </div>
            <div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Mensagens</h5>
                        <p class="card-text">Converse com empresas.</p>
                        <button class="btn btn-primary">Ver mais</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>