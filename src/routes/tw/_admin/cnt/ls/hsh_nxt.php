	<?php 
		$_rg = 100; $pageNum = 0; 
		if (isset($_GET['pageNum'])) {$pageNum = $_GET['pageNum']+1;}
		$startRow_Ls_Rg = $pageNum * $_rg; 

		$Ls_Qry = "SELECT * FROM hsh_msg WHERE hshmsg_est = 2 AND hshmsg_hsh = '".GtSQLVlStr($_hshtg_svid,"int")."' ORDER BY id_hshmsg DESC";
		$Ls_Qry_Lmt = sprintf("%s LIMIT %d, %d", $Ls_Qry, $startRow_Ls_Rg, $_rg);
		$Ls = $__cnx->_qry($Ls_Qry_Lmt); 
		$row_Ls = $Ls->fetch_assoc(); 
		$Tot_Ls = $Ls->num_rows;
	?>
    <?php if (($Tot_Ls > 0)){ ?>
            <ul class="msgnxt">
                    <?php do { ?>
                            <li id="LiNxt_<?php echo $row_Ls['id_hshmsg'] ?>">
                                    <img src="<?php echo ctjTx($row_Ls['hshmsg_profileimageurl'],'in') ?>" width="30" height="30" id="ImgNxt_<?php echo $row_Ls['id_hshmsg'] ?>">
                                    <div class="ldr"></div>
                                    <div class="item" id="DvNxt_<?php echo $row_Ls['id_hshmsg'] ?>">     
                                        <h2><?php echo ctjTx($row_Ls['hshmsg_fromusername'],'in').' <span>@'.ctjTx($row_Ls['hshmsg_fromuser'],'in').'</span>' ?></h2>
                                        <?php echo ctjTx($row_Ls['hshmsg_text'],'in') ?>
                                            <div class="btn">
                                                <form name="NxtMsgTw_<?php echo $row_Ls['id_hshmsg'] ?>" id="NxtMsgTw_<?php echo $row_Ls['id_hshmsg'] ?>" method="post" action="<?php echo PRC_HSH ?>">
                                                        <input type='submit' name='del<?php echo $row_Ls['id_hshmsg'] ?>' id='del<?php echo $row_Ls['id_hshmsg'] ?>' value='X'>
                                                        <input name='id_hshmsg' type='hidden' id='id_hshmsg' value='<?php echo $row_Ls['id_hshmsg'] ?>' />
                                                        <input name='MM_delete' type='hidden' id='MM_delete' value='EdTwMsg' /> 
                                                </form>
                                            </div>
                                        <?php $_phpjq .= "$('#NxtMsgTw_". $row_Ls['id_hshmsg'] ."').validate();
                                                                                            $('#NxtMsgTw_". $row_Ls['id_hshmsg'] ."').ajaxForm({
                                                                                                    dataType:'json', 
                                                                                                    beforeSubmit: function(){ TwNxt_InLd('". $row_Ls['id_hshmsg'] ."'); },
                                                                                                    success: function(data){ TwNxt_RslLd('". $row_Ls['id_hshmsg'] ."', data); }
                                                                                            });"; ?>
                                    </div>
                            </li>         
                    <?php } while ($row_Ls = $Ls->fetch_assoc()); ?>
            </ul>
            <input id="ItmLs" class="ItmLs" type="hidden" value="<?php echo $pageNum ?>"/>
    <?php } ?>
    		<input id="_nxttot" name="_nxttot" type="hidden" value="<?php echo GtTotNxt(GtSQLVlStr($_hshtg_svid,"int")); ?>" />

<script type="text/javascript">
	$(document).ready(function(){
		<?php if(GtDt_HSHTw($_hshtg_svid, 'est') == 1){ ?>			
			NwBx_Est('', 2);
			$("#BtnNx").hide('fast', function(){ $("#BtnPsNx").show('fast'); });			
		<?php } else{ ?>		
			NwBx_Est('ps', 2);
			$("#BtnPsNx").hide('fast', function(){ $("#BtnNx").show('fast'); });		
		<?php } ?>	
		<?php echo $_phpjq; ?>
		
	});	
</script>  
<?php $__cnx->_clsr($Ls); ?>