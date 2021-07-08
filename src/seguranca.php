<?php

require 'config.inc.php';

/**
 * Sistema de segurança com acesso restrito
 *
 * Usado para restringir o acesso de certas páginas do seu site
 *
 *
 * @version 1.0
 * @package SistemaSeguranca
 */
//  Configurações do Script
// ==============================

$_SG['abreSessao'] = false;         // Inicia a sessão com um session_start()?

$_SG['caseSensitive'] = false;     // Usar case-sensitive? Onde 'thiago' é diferente de 'THIAGO'

$_SG['validaSempre'] = false;       // Deseja validar o usuário e a senha a cada carregamento de página?
// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.

$_SG['paginaLogin'] = '/login.php'; // Página de login

$_SG['tabela'] = 'usuario';       // Nome da tabela onde os usuários são salvos
// ==============================
// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================
// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true) {
    session_start();
}

/**
 * Função que valida um usuário e senha
 *
 * @param string $usuario - O usuário a ser validado
 * @param string $senha - A senha a ser validada
 *
 * @return bool - Se o usuário foi validado ou não (true/false)
 */
function validaUsuario($usuario, $senha) {
    global $_SG;

    $cS = ($_SG['caseSensitive']) ? 'BINARY' : '';

// Usa a função addslashes para escapar as aspas
    $nusuario = addslashes($usuario);
    $nsenha = addslashes($senha);

// Monta uma consulta SQL (query) para procurar um usuário
//include 'conexao/Conexao.php';
//$conexao = new Conexao();
    $conexao = new Conexao();
    $sql = $conexao->prepare("SELECT id, nome, avatar FROM " . $_SG['tabela'] . " WHERE " . $cS . " login = '" . $nusuario . "' AND " . $cS . " senha = '" . $nsenha . "'");
    $sql->execute();
//$sql = "SELECT id_usuario, nome FROM ".$_SG['tabela']." WHERE ".$cS." login = '".$nusuario."' AND ".$cS." senha = '".$nsenha."'";
//$query = pg_query($sql);
    $resultado = $sql->fetch(PDO::FETCH_ASSOC);

// Verifica se encontrou algum registro
    if (empty($resultado)) {
// Nenhum registro foi encontrado => o usuário é inválido
        return false;
    } else {
// O registro foi encontrado => o usuário é valido
// Definimos dois valores na sessão com os dados do usuário
        $_SESSION['usuarioID'] = $resultado['id']; // Pega o valor da coluna 'id do registro encontrado no MySQL
        $_SESSION['usuarioNome'] = $resultado['nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
        $_SESSION['usuarioAvatar'] = $resultado['avatar'];
// Verifica a opção se sempre validar o login
        if ($_SG['validaSempre'] == true) {
// Definimos dois valores na sessão com os dados do login
            $_SESSION['usuarioLogin'] = $usuario;
            $_SESSION['usuarioSenha'] = $senha;
        }

        return true;
    }
}

/**
 * Função que protege uma página
 */
function protegePagina() {
    global $_SG;

    if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome'])) {
// Não há usuário logado, manda pra página de login
        expulsaVisitante();
    } else {
// Há usuário logado, verifica se precisa validar o login novamente
        if ($_SG['validaSempre'] == true) {
// Verifica se os dados salvos na sessão batem com os dados do banco de dados
            if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) {
// Os dados não batem, manda pra tela de login
                expulsaVisitante();
            }
        }
    }
}

/**
 * Função para expulsar um visitante
 */
function expulsaVisitante() {
    global $_SG;

// Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'], $_SESSION['usuarioAvatar']);

// Manda pra tela de login
    header("Location: " . HOME_URI . $_SG['paginaLogin']);
}

function erroLogin() {
    global $_SG;

// Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'], $_SESSION['usuarioAvatar']);

// Manda pra tela de login
    header("Location: " . HOME_URI . $_SG['paginaLogin'] . "?erro=1");
}

protegePagina();
