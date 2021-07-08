<?php
// List of events
include 'Conexao.php';

$conexao = new Conexao();

 // connection to the database
 
 $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
 // Execute the query
 
 $query = "select glpi_tickets.id, glpi_tickettasks.content as descri_tarefa, glpi_tickettasks.begin, glpi_tickettasks.end, glpi_tickettasks.state, glpi_tickets.name, glpi_tickets.status, glpi_tickets.content as descri_chamado, glpi_users.firstname "
."from glpi_tickettasks "
."inner join glpi_tickets on (glpi_tickets.id=glpi_tickettasks.tickets_id) "
."inner join glpi_users on (glpi_users.id=glpi_tickettasks.users_id_tech) "
."order by glpi_tickets.id desc";
 
 $stmt = $conexao->query($query);
 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
 $linha = array();
 $items = array();
 
 foreach ($rows as $row) {
	if ($row['status'] === 'closed') {
		$cor = '#000000';
	} else if ($row['status'] === 'solved') {
		$cor = '#cccccc';
	} else {
		$cor = '#1592d0';
	}
	$linha = array("id" => $row['id'], "title" => $row['name'], "start" => $row['begin'], "end" => $row['end'], "color" => $cor);
	array_push($items, $linha);	 
 }
  

									
                                  
 
 

 // sending the encoded result to success page
  echo json_encode($items);

?>