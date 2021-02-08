	<?php 	
		$_rg = 10; $pageNum = 0; 
		if (isset($_GET['pageNum'])) {$pageNum = $_GET['pageNum']+1;}
		$startRow_Ls_Rg = $pageNum * $_rg; 

		$Ls_Qry = "SELECT * FROM hsh_msg WHERE hshmsg_qus = 1 AND hshmsg_hsh = '".GtSQLVlStr($_hshtg_svid,"int")."' ORDER BY id_hshmsg DESC";
		$Ls_Qry_Lmt = sprintf("%s LIMIT %d, %d", $Ls_Qry, $startRow_Ls_Rg, $_rg);
		$Ls = $__cnx->_qry($Ls_Qry_Lmt);
		$row_Ls = $Ls->fetch_assoc(); 
		$Tot_Ls = $Ls->num_rows;
	?>
    <?php if (($Tot_Ls > 0)){ ?>
            <ul class="msgqus">
                    <?php $__i = 1; do { ?>
                            <li id="LiQus_<?php echo $row_Ls['id_hshmsg'] ?>">
                                    <div class="TwIm">
                                    	<img src="<?php echo ctjTx($row_Ls['hshmsg_profileimageurl'],'in') ?>" width="30" height="30" id="ImgQus_<?php echo $row_Ls['id_hshmsg'] ?>">
                                    	<div><?php echo $__i ?></div>
                                    </div>
                                    <div class="ldr"></div>
                                    <div class="item" id="DvQus_<?php echo $row_Ls['id_hshmsg'] ?>">     
                                        <h2><?php echo ctjTx($row_Ls['hshmsg_fromusername'],'in').' <span>@'.ctjTx($row_Ls['hshmsg_fromuser'],'in').'</span>' ?></h2>
                                        <?php echo ctjTx($row_Ls['hshmsg_text'],'in') ?>
                                            <div class="btn">
                                                <form name="QusMsgTw_<?php echo $row_Ls['id_hshmsg'] ?>" id="QusMsgTw_<?php echo $row_Ls['id_hshmsg'] ?>" method="post" action="<?php echo PRC_QUS ?>">
                                                        <input type='submit' name='del<?php echo $row_Ls['id_hshmsg'] ?>' id='del<?php echo $row_Ls['id_hshmsg'] ?>' value='X'>
                                                        <input name='id_hshmsg' type='hidden' id='id_hshmsg' value='<?php echo $row_Ls['id_hshmsg'] ?>' />
                                                        <input name='MM_delete' type='hidden' id='MM_delete' value='EdTwQus' /> 
                                                </form>
                                            </div>
                                        <?php $_phpjq .= "$('#QusMsgTw_". $row_Ls['id_hshmsg'] ."').validate();
                                                                                            $('#QusMsgTw_". $row_Ls['id_hshmsg'] ."').ajaxForm({
                                                                                                    dataType:'json', 
                                                                                                    beforeSubmit: function(){ TwQus_InLd('". $row_Ls['id_hshmsg'] ."'); },
                                                                                                    success: function(data){ TwQus_RslLd('". $row_Ls['id_hshmsg'] ."', data); }
                                                                                            });"; ?>
                                    </div>
                            </li>         
                    <?php $__i++; } while ($row_Ls = $Ls->fetch_assoc()); ?>
            </ul>
    <?php } ?>
<script type="text/javascript">
$(document).ready(function(){
	<?php echo $_phpjq; ?>	
});	
</script> 
<?php $__cnx->_clsr($Ls); ?>