<?php
	
	$file="sorteo.xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	
	
	$r['e'] = 'no';
	
	
	$_number = Php_Ls_Cln($_POST['number']);
	
	
	$_qry = "	SELECT  *	
				FROM con_registers_t
					 INNER JOIN int_companies_t ON con_registers_t.company_id = int_companies_t.id		 	 
				WHERE is_completed = 't' AND con_registers_t.company_id = '".$__dt_sort->msv->cid."'
			";
	
			
	$_chk = $cnx->prepare($_qry);	
	$_chk->execute(); 
	
	$row_chk = $_chk->fetchAll(PDO::FETCH_ASSOC); 
	$tot_chk = Pdo_Fix_RwTot($_chk); 
	
if($tot_chk > 0){					
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
  	<thead>
	    <tr>
	    	<th>Nombre</th>
	    	<th>Correo</th>
	    	<th>Documento</th>
	    	<th>Creado</th>
	    	<th>Modificado</th>
	    	<th>Company</th>
	    	<th>Concourse ID</th>
	    	<th>Ticket ID</th>
	    	<th>Interface ID</th>
	    	<th>Origin ID</th>
	    	<th>Ciudad</th>
	    	<th>Completo</th>
	    	<th>Ganador</th>
	    	<th>Mensaje</th>
	    	<th>Archivo</th>
	    </tr>
  	</thead>
  	<tbody>
	<?php foreach ($row_chk as $r_c) { ?>
    	<tr>
	    	<td><?php echo $r_c['name'] ?></td>
	    	<th><?php echo $r_c['email'] ?></th>
	    	<th><?php echo $r_c['document_id'] ?></th>
	    	<th><?php echo $r_c['created'] ?></th>
	    	<th><?php echo $r_c['modified'] ?></th>
	    	<th><?php echo $r_c['company_id'] ?></th>
	    	<th><?php echo $r_c['concourse_id'] ?></th>
	    	<th><?php echo $r_c['ticket_id'] ?></th>
	    	<th><?php echo $r_c['interface_id'] ?></th>
	    	<th><?php echo $r_c['origin_id'] ?></th>
	    	<th><?php echo $r_c['city'] ?></th>
	    	<th><?php echo $r_c['is_completed'] ?></th>
	    	<th><?php echo $r_c['winner'] ?></th>
	    	<th><?php echo $r_c['message_text'] ?></th>
	    	<th><?php echo $r_c['file'] ?></th>
      </tr>
      <?php } ?>

  	</tbody>
</table>
<?php } ?>