<?php

include '../../../seguranca.php';
require '../../assistencia/plugin/PHPMailer/PHPMailerAutoload.php';

$destinatario = filter_input(INPUT_POST, "email");

$emails_filtrados = str_replace(';', ',', $destinatario);
$emails = explode(',', $emails_filtrados);

$mensagem = array();

$usuario = 'mkt@tecsmart.com.br';
$senha = 'TeC141607';

$mail = new PHPMailer;

$mail->CharSet = 'UTF-8';
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Host = 'smtp.tecsmart.com.br';
$mail->Username = $usuario;
$mail->Password = $senha;
$mail->Port = 587;

$mail->From = $usuario;
$mail->FromName = 'Loja Tecsmart';
$mail->addReplyTo('vendas@tecsmart.com.br', 'Loja Tecsmart');

$mail->isHTML(true);

$mail->Subject = 'Loja Tecsmart - Pesquisa de Satisfação';
$mail->Body = file_get_contents("pesquisa_loja_template.php");
$mail->AltBody = 'Este e-mail contém html. Se não estiver conseguindo visualizar este e-mail baixe a mensagem em anexo.';

foreach ($emails as $email) {
    if (!empty($email)) {
        $mail->addAddress($email, 'Loja Tecsmart');
        if (!$mail->send()) {
            $mensagem["erro"] = 'Erro no envio, revise o e-mail!';
        } else {
            $mensagem["sucesso"] = 'E-mail enviado com sucesso!';
        }
    }
    $mail->clearAddresses();
}

echo json_encode($mensagem);