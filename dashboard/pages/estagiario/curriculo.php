<?php
session_start();
include_once '../../../server/conexao.php'; // Inclui a conexão com o banco de dados

if (!isset($_SESSION['idUsuarioLogin'])) {
    echo json_encode(['mensagem' => 'Sessão inválida.', 'code' => 1]);
    exit;
}

// Verifica se o estagiário está autenticado
if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] !== 'estagiario') {
    echo json_encode(['mensagem' => 'Usuário não autenticado.', 'code' => 2]);
    exit;
}

$idEstagiario = $_SESSION['idUsuarioLogin'];

try {
    // Consulta para obter o ID do currículo do estagiário
    $stmt = $conn->prepare("SELECT curriculo_id FROM estagiario WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param('i', $idEstagiario);
    $stmt->execute();
    $stmt->bind_result($curriculo_id);
    $stmt->fetch();
    $stmt->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['mensagem' => 'Erro interno: ' . $e->getMessage(), 'code' => 3]);
    exit;
} finally {
    $conn->close();
}
?>

<section class="sectionPages sectionPagesEstagiario" id="sectionPageCurriculo">
    <link rel="stylesheet" href="../assets/css/dashboard/estagiario/curriculo.css">
    <script src="../assets/js/dashboard/estagiario/curriculo.js"></script>
    <h1 class="tituloPage mb-5">CURRÍCULO</h1>

    <div class="text-center" id="overlay">
        <div class="spinner-border text-light" id="loading" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
    </div>

    <div class="w-75 bg-light rounded">
        <div class="accordion" id="acordeao">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#acordeaoPrimeiro" aria-controls="acordeaoPrimeiro">
                        Formação
                    </button>
                </h2>
                <div id="acordeaoPrimeiro" class="accordion-collapse collapse" data-bs-parent="#acordeao">
                    <div class="accordion-body">
                        <form class="p-4">
                            <div class="mb-3">
                                <h5 for="experiencias" class="form-label">Escolaridade:</h5>
                                <div class="row">
                                    <div class="col">

                                        <div class="form-check">
                                            <input type="radio" name="escolaridade" id="fundIncom" class="form-check-input">
                                            <label class="form-check-label" for="fundIncom">
                                                Fundamental Incompleto
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="escolaridade" id="fundCom" class="form-check-input">
                                            <label class="form-check-label" for="fundCom">
                                                Fundamental Completo
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="escolaridade" id="medioIncom" class="form-check-input">
                                            <label class="form-check-label" for="medioIncom">
                                                Médio Incompleto
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="escolaridade" id="medioCom" class="form-check-input">
                                            <label class="form-check-label" for="medioCom">
                                                Médio Completo
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input type="radio" name="escolaridade" id="supIncom" class="form-check-input">
                                            <label class="form-check-label" for="supIncom">
                                                Superior Incompleto
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="escolaridade" id="supCom" class="form-check-input">
                                            <label class="form-check-label" for="supCom">
                                                Superior Completo
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="escolaridade" id="posIncom" class="form-check-input">
                                            <label class="form-check-label" for="posIncom">
                                                Pós-Graduação Incompleto
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="escolaridade" id="posCom" class="form-check-input">
                                            <label class="form-check-label" for="posCom">
                                                Pós-Graduação Completo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="formacao" class="form-label">Coloque aqui suas experiências:</label>
                                <textarea class="form-control" id="formacao" aria-describedby="formacao" style="height: 150px"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#acordeaoSegundo" aria-controls="acordeaoSegundo">
                        Experiências
                    </button>
                </h2>
                <div id="acordeaoSegundo" class="accordion-collapse collapse" data-bs-parent="#acordeao">
                    <div class="accordion-body">
                        <form class="p-4">
                            <div class="mb-3">
                                <label for="experiencias" class="form-label">Coloque aqui suas experiências:</label>
                                <textarea class="form-control" id="experiencias" aria-describedby="experiencias" style="height: 150px"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="divBlocos row row-cols-2">

        <div class="blocos col-md arquivo visually-hidden mt-2">
            <iframe id="iframeArquivo" frameborder="0" class="rounded"></iframe>
        </div>

        <div class="col-md mt-2 w-100">
            <div class="row formulario visually-hidden bg-light rounded" id="divInformacoes">
                <div class="p-3" enctype="multipart/form-data">
                    <h4 class="form-label">Informações:</h4>
                    <div class="mb-1">
                        <div class="row">
                            <h6 class="form-label col">Nome do arquivo:</h6>
                            <p id="resNomeArquivo" class="col"></p>
                        </div>
                        <div class="row">
                            <h6 class="form-label col">Data de submissão:</h6>
                            <p id="resSubmissao" class="col"></p>
                        </div>
                        <div class="row">
                            <h6 class="form-label col">Observações:</h6>
                            <p id="resObservacoes"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-2 row formulario w-100 bg-light rounded">
                <form id="formUploadArquivo" class="p-3" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="curriculo" class="form-label">Faça upload de seu currículo aqui:</label>
                        <input class="form-control form-control" id="curriculo" name="curriculo" type="file" accept="application/pdf" required>
                    </div>
                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações:</label>
                        <textarea class="form-control form-control-sm" id="observacoes" name="observacoes" type="text" maxlength="500"></textarea>
                    </div>
                    <input type="submit" class="btn btn-primary sm" value="Salvar">
                    <button type="button" class="btn btn-danger sm" id="btnExcluir" data-bs-toggle="modal" data-bs-target="#modalExcluir">Excluir</button>
                </form>
            </div>
        </div>

    </div>

    <!-- Modal Excluir -->
    <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluir" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Deseja excluir o currículo atual?</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnModalExcluir" data-bs-dismiss="modal" class="btn btn-danger">Excluir</button>
                </div>
            </div>
        </div>
    </div>

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
</section>