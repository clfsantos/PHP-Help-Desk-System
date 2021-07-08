<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <ol class="breadcrumb">
            <li><a href="<?php echo HOME_URI; ?>/home">Raíz</a></li>
            <li class="active">Releases do Sistema</li>
        </ol>
        <div id="page-content">
            <div class="bt-panel">
                <div class="bt-panel-heading">
                    <h3 class="bt-panel-title">
                        Releases do Sistema
                    </h3>
                </div>
                <div class="bt-panel-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <p class="clfs-rl-primary">Marcados com esta cor significa mudança drástica na interface ou adição de módulos ou recursos novos</p>
                                <p class="clfs-rl-alert">Marcados com esta cor significa adição de recursos novos em módulos já existentes</p>
                                <p class="clfs-rl-danger">Marcados com esta cor significa correção de bugs ou melhorias em recursos já existentes</p>
                                <br />
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Versão</th>
                                                <th>Nota de Lançamento</th>
                                                <th>Data de Modificação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="clfs-rl-primary">
                                                <td>1.0.0</td>
                                                <td>Versão inicial de lançamento com os módulos de assistência e marketing</td>
                                                <td>13/06/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-danger">
                                                <td>1.0.1</td>
                                                <td>Correção de Bug relacionado as janelas secundárias, as mesmas não estavam abrindo centralizadas quando o scroll da página acontecia</td>
                                                <td>14/06/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-alert">
                                                <td>1.1.0</td>
                                                <td>Adicionado página de perfil de usuário com opção de troca de senha e troca de foto de perfil</td>
                                                <td>14/06/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-danger">
                                                <td>1.1.1</td>
                                                <td>Melhoria na página inicial da assistência, colocado evento de followup e usuário nas tabelas de SLA vencidos e assistências abertas a mais de 30 dias</td>
                                                <td>15/06/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-danger">
                                                <td>1.1.2</td>
                                                <td>Implementado aba de histórico de assistência no registro de assistências</td>
                                                <td>15/06/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-danger">
                                                <td>1.1.3</td>
                                                <td>Efetuado melhorias na tela de estatísticas de envio de newsletter, adicionado possíbilidade de ver baixas de determinado envio</td>
                                                <td>16/06/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-danger">
                                                <td>1.1.4</td>
                                                <td>Implementado um histórico de leituras por campanha no cadastro do contato</td>
                                                <td>16/06/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-primary">
                                                <td>2.0.0</td>
                                                <td>Adicionado o módulo de Suporte com opção de abertura de chamados</td>
                                                <td>12/08/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-alert">
                                                <td>2.1.0</td>
                                                <td>Adicionado agenda no módulo de chamados</td>
                                                <td>29/08/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-danger">
                                                <td>2.1.1</td>
                                                <td>Implementado um histórico de chamados na assistência</td>
                                                <td>30/08/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-danger">
                                                <td>2.1.2</td>
                                                <td>Adicionado opção para bloquear o suporte no cadastro de cliente</td>
                                                <td>30/08/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-alert">
                                                <td>2.2.0</td>
                                                <td>Adicionado cadastro de release e vinculação de chamado com releases</td>
                                                <td>13/10/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-danger">
                                                <td>2.2.1</td>
                                                <td>Colocado alguns gráficos no painel de chamado</td>
                                                <td>17/10/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-danger">
                                                <td>2.2.2</td>
                                                <td>Feito melhorias internas na hora de salvar ou atualizar os dados.</td>
                                                <td>19/10/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-alert">
                                                <td>2.3.0</td>
                                                <td>Adicionado cadastro de grupos e sub-grupos de produtos no módulo de suporte</td>
                                                <td>24/11/2016</td>
                                            </tr>
                                            <tr class="clfs-rl-danger">
                                                <td>2.3.1</td>
                                                <td>Adicionado opção para cancelar tarefa</td>
                                                <td>06/02/2017</td>
                                            </tr>
                                            <tr class="clfs-rl-alert">
                                                <td>2.4.0</td>
                                                <td>Adicionado fluxo de implantação na abertura dos chamados do tipo "Implantação"</td>
                                                <td>13/12/2018</td>
                                            </tr>
                                            <tr class="clfs-rl-danger">
                                                <td>2.4.1</td>
                                                <td>Feito melhorias no fluxo de atendimento, implementado quantidades de retornos e opção de edição.</td>
                                                <td>04/04/2019</td>
                                            </tr>
                                            <tr class="clfs-rl-alert">
                                                <td>2.5.0</td>
                                                <td>Adicionado tela de cadastro e controle de recados</td>
                                                <td>18/04/2019</td>
                                            </tr>
                                            <tr class="clfs-rl-primary">
                                                <td>3.0.0</td>
                                                <td>Deixado o sistema de chamado compatível com o PHP versão 7</td>
                                                <td>20/05/2019</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--extractor-->
