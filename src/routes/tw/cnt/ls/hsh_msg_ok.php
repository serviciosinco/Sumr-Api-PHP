<?php 
$__max = Php_Ls_Cln($_GET['_max']);
$__prflbig = Php_Ls_Cln($_GET['_prflbig']);	
	
if($__max != ''){  
	define('TWS_TOT', $__max);
}else{
	define('TWS_TOT', 4);
}	



if(isset($_GET['_p']) && ($_GET['_p'] == 'upd')){ 
	$__t = 'ls'; 
	$_rg = TWS_TOT;
	if(isset($_GET['_n']) && ($_GET['_n'] != '') or (GtTotTw($_hshtg_svid) == 0)){
		if(GtDt_HSHTw($_hshtg_svid, 'est') == 1){		
			if(MsjTw_UpdShw('', $_hshtg_svid)){
				$__hbltanm = 'ok';
			}
		}
		$_n = GtSQLVlStr($_GET['_n'],"int");	
	}	
}else{ 
	$_rg = TWS_TOT; 
}				
		
		$pageNum = 0; 
		if (isset($_GET['pageNum'])) {$pageNum = $_GET['pageNum']+1;}
		$startRow_Ls_Rg = $pageNum * $_rg; 
		
		$Ls_Qry = "SELECT * FROM hsh_msg WHERE hshmsg_est = 1 AND hshmsg_hsh = '".GtSQLVlStr($_hshtg_svid,"int")."' ORDER BY id_hshmsg DESC"; 
		$Ls_Qry_Lmt = sprintf("%s LIMIT %d, %d", $Ls_Qry, $startRow_Ls_Rg, $_rg);
		$Ls = $__cnx->_qry($Ls_Qry_Lmt); 
		$row_Ls = $Ls->fetch_assoc(); 
		$Tot_Ls = $Ls->num_rows;

if (($Tot_Ls > 0)){ ?>
        <ul class="msg">
                <?php $_i = 0; do { ?>
                	<?php if(($_i == 0)){ $_ianm = $row_Ls['id_hshmsg']; } ?>
                    <li id="LsStrm_<?php echo $row_Ls['id_hshmsg'] ?>" <?php if(($_i == 0) && ($__hbltanm == 'ok')){ ?>style="display:none;"<?php } ?>>
                    	
                    	<?php
	                    	if($__prflbig == 'ok'){
		                    	$__imgprf_big = str_replace(array('_normal.jpeg','_normal.jpg'), array('.jpeg', '.jpg'), ctjTx($row_Ls['hshmsg_profileimageurl'],'in') );
		                    }else{	
                    			$__imgprf_big = ctjTx($row_Ls['hshmsg_profileimageurl'],'in');
                    		}
                    	?>
                    	
                        <img src="<?php echo $__imgprf_big ?>" width="60" height="60" class="__img">
                        <div class="__cnt">
                        	<?php if($_i == 0){ $_ilst = $row_Ls['id_hshmsg']; }?>
                            <div class="__wrp">
                                <?php echo ctjTx($row_Ls["hshmsg_text"],'in') ?>
                                <?php if($row_Ls['hshmsg_media'] != ''){ ?>
                                	<div class="__med">
                                    <img src="<?php echo $row_Ls['hshmsg_media'] ?>">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="__usr">
                             	<strong>
									<?php echo ctjTx($row_Ls['hshmsg_fromusername'],'in') . HTML_BR . Spn('@'.ctjTx($row_Ls['hshmsg_fromuser'],'in')) ?>
                                </strong>
                                <?php if($row_Ls['hshmsg_tp'] == 1){ $_icn = 'tw'; $_icn_tx = 'Twitter'; }elseif($row_Ls['hshmsg_tp'] == 2){ $_icn = 'igr'; $_icn_tx = 'Instagram'; } ?>
                                <div class="_icn">
									<div class="_tx"><?php echo Spn('vía').HTML_BR.$_icn_tx; ?></div>
                                    <div class="_ic"><?php echo Spn('','','_sclicn _sclicn_'.$_icn) ?></div>		
                                </div>
                            </div>                              
                        </div>
                    </li>         
                <?php $_i++;  } while ($row_Ls = $Ls->fetch_assoc()); ?>
        </ul>     
<script type="text/javascript">
			$(document).ready(function(){
				<?php if(($__hbltanm == 'ok')){ ?>
					Strm_GtTw_Sh(<?php echo $_ianm ?>);		
				<?php } ?>
				GtStrmTot('<?php echo GtTotTw($_hshtg_svid) ?>');
				Strm___GtTw_Qus('<?php echo $_GET['_h'] ?>');	
				
				$('#Strm_Lst').val("<?php echo $_ianm ?>");	
				$('#IgrStrm_Lst').val("<?php echo $_ianm ?>");				
			});				
</script>
        
<?php } ?>
<?php $__cnx->_clsr($Ls); ?>