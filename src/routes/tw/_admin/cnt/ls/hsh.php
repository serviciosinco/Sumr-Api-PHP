<?php 
	
		$_rg = 10; $pageNum = 0; 
		if (isset($_GET['pageNum'])) {$pageNum = $_GET['pageNum']+1;}
		$startRow_Ls_Rg = $pageNum * $_rg; 	
			
		$UsNiv=$_SESSION['us_nivel'];
		 
		if(!ChckSESS_superadm() && defined('SISUS_HSH') && SISUS_HSH != ''){ 
			$__fl= " AND id_hsh IN (".SISUS_HSH.")"; 
		}
		
		$Ls_Qry = "SELECT * FROM hsh WHERE id_hsh != '' $__fl ORDER BY id_hsh DESC";
		$Ls_Qry_Lmt = sprintf("%s LIMIT %d, %d", $Ls_Qry, $startRow_Ls_Rg, $_rg);
		$Ls = $__cnx->_qry($Ls_Qry_Lmt); 
		$row_Ls = $Ls->fetch_assoc(); 
		$Tot_Ls = $Ls->num_rows;
	
?>
<header>
	  <div id="LgIn_Hdr">
      	
      </div>
</header>
  
<div id="Adm_Mn">
        	<?php do { ?>
        		<a href="/<?php echo ctjTx($row_Ls['hsh_tx'],'in') ?>" target="_self"><div><?php echo '#'.ctjTx($row_Ls['hsh_tx'],'in'); ?></div></a>
            <?php } while ($row_Ls = $Ls->fetch_assoc()); ?>
            	<a href="/logout/" target="_self" class="lgout"><div>salir</div></a>
</div>

<?php $__cnx->_clsr($Ls); ?>