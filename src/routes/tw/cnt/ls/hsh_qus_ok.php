<?php 
		$_rg = 10;
		$pageNum = 0; 
		$startRow_Ls_Rg = $pageNum * $_rg; 	
		
		$Ls_Qry = "SELECT * FROM hsh_msg WHERE hshmsg_hsh = '".GtSQLVlStr($_hshtg_svid,"int")."' AND hshmsg_qus = 1 ORDER BY id_hshmsg ASC";
		$Ls_Qry_Lmt = sprintf("%s LIMIT %d, %d", $Ls_Qry, $startRow_Ls_Rg, $_rg);
		$Ls = $__cnx->_qry($Ls_Qry_Lmt); 
		$row_Ls = $Ls->fetch_assoc(); 
		$Tot_Ls = $Ls->num_rows;

if (($Tot_Ls > 0)){ ?>
		<div>Preguntas </div>
        <ul>
                <?php $_i= 1; do { ?>
                    <li><a href="/cnt/dt/_gn.php?_t=qus&_h=<?php echo $row_Ls['id_hshmsg'] ?>" class="qus"><?php echo $_i ?></a></li>         
                <?php $_i++; } while ($row_Ls = $Ls->fetch_assoc()); ?>
        </ul>
        <script type="text/javascript">
            $(document).ready(function(){
				 $('.qus').colorbox({escKey:false, overlayClose:false});
            });	
        </script>
<?php } ?>
<?php $__cnx->_clsr($Ls); ?>