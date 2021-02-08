<?php 

    $Dt_Qry = "SELECT * FROM hsh_msg WHERE id_hshmsg = '".GtSQLVlStr($_hshtg_dt,"int")."'"; 
    $Dt_Rg = $__cnx->_qry($Dt_Qry);
    $row_Dt_Rg = $Dt_Rg->fetch_assoc(); 
    $Tot_Dt_Rg = $Dt_Rg->num_rows;
		
if (($Tot_Dt_Rg > 0)){ ?>

    <div class="clrbx">
        <div class="tw_dt">
            <img src="<?php echo GtTwBgImg(ctjTx($row_Dt_Rg['hshmsg_profileimageurl'],'in')); ?>" width="30" height="30">
                <div>
                    <?php if($_i == 0){ $_ilst = $row_Dt_Rg['id_hshmsg']; }?>
                    <h2><?php echo ctjTx($row_Dt_Rg['hshmsg_fromusername'],'in').' <span>@'.ctjTx($row_Dt_Rg['hshmsg_fromuser'],'in').'</span>' ?></h2>
                    <?php echo ctjTx($row_Dt_Rg['hshmsg_text'],'in') ?>                            
                </div>
        </div>                    
    </div>
    
<?php } ?>
<?php $__cnx->_clsr($Dt_Rg); ?>