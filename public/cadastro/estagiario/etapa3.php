$nacionalidade = (isset($_SESSION["nacionalidadeEstagiario"]) && $_SESSION["nacionalidadeEstagiario"] != NULL) ? $_SESSION["nacionalidadeEstagiario"] : NULL;

    $dataNascimento = (isset($_SESSION["dataNascimentoEstagiario"]) && $_SESSION["dataNascimentoEstagiario"] != NULL) ? $_SESSION["dataNascimentoEstagiario"] : NULL;

    $dependentes = (isset($_SESSION["dependentesEstagiario"]) && $_SESSION["dependentesEstagiario"] != NULL) ? $_SESSION["dependentesEstagiario"] : NULL;

    $cnh = (isset($_SESSION["cnhEstagiario"]) && $_SESSION["cnhEstagiario"] != NULL) ? $_SESSION["cnhEstagiario"] : NULL;