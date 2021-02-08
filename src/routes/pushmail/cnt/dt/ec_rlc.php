<?php 
	$Ls_N = 10;
	$Ls_Pg = 0; 
	$Ls_St = $Ls_Pg * SIS_NMRG;	
	
	if($__dtec->tp != NULL){ $_fl = " AND id_ec IN (SELECT ectp_ec FROM "._BdStr(DBM).TB_EC_TP." WHERE ectp_tp IN (".$__dtec->tp.") ) "; }
	
	$Ls_Qry = "SELECT * FROM "._BdStr(DBM).TB_EC." WHERE ec_est = 1 AND ec_oth = 1 AND id_ec != ".$__dtec->id." $_fl ORDER BY id_ec DESC";
	$Ls_Lmt = sprintf("%s LIMIT %d, %d", $Ls_Qry, $Ls_St, $Ls_N);
	$Ec_Rlc = $__cnx->_qry($Ls_Lmt); 
	$row_Ec_Rlc = $Ec_Rlc->fetch_assoc(); 
	$Tot_Ec_Rlc = $Ec_Rlc->num_rows; 
?>

	<div class="sl_d" id="ec_rlc_sld" style="width:<?php echo $__dtec->sz->w ?>px;">
        <h2>
			<?php echo 'Otros' ?>
            <a class="buttons next" href="#">right</a>
            <a class="buttons prev" href="#">left</a>   
        </h2>
        
        <div class="viewport">
            <ul class="overview">
                <?php do{ ?>
                <?php $_img = _ImVrs([ 'img'=>$row_Ec_Rlc['ec_img'], 'f'=>DMN_FLE_EC, 'img_ste'=>$row_Ec_Rlc['ec_enc'] ]); ?>
                <li>
                    <a href="<?php echo PrmLnk('bld', $row_Ec_Rlc['ec_pml']); ?>" target="_self">
                        <img src="<?php echo $_img->img_v->th_50 ?>" alt="<?php echo ctjTx($row_Ec_Rlc['ec_tt'],'in'); ?>" />
                        <?php echo ctjTx($row_Ec_Rlc['ec_tt'],'in'); ?>
                    </a>
                </li>									
            	<?php } while ($row_Ec_Rlc = $Ec_Rlc->fetch_assoc()); ?>
            </ul>
        </div>  
          
	</div>
<?php $_CntJQ .= "$('#ec_rlc_sld').tinycarousel({ interval: false });"; $__cnx->_clsr($Ec_Rlc); ?>