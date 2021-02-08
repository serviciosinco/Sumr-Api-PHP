<?php

if(class_exists('CRM_Cnx')){

	$___Ls->tt = 'Codigo de Acceso';
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("SELECT *
								FROM  "._BdStr(DBM).TB_ORG_SDS_PASS."
								INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdspass_orgsds = id_orgsds
								INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
								WHERE ".$___Ls->ik." = %s 
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
									
	}elseif($___Ls->_show_ls == 'ok'){
		
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_ORG_SDS_PASS."
					INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsdspass_orgsds = id_orgsds
					INNER JOIN "._BdStr(DBM).TB_ORG."  ON orgsds_org = id_org
					WHERE ".$___Ls->ino." != '' 	
					AND  org_enc = '{$__i}'
					ORDER BY ".$___Ls->ino." DESC";
		$___Ls->qrys = "SELECT *,
                           (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";
				   		
	} 

	$___Ls->_bld(); ?>
<?php if($___Ls->ls->chk=='ok'){ ?>

	<?php $___Ls->_bld_l_hdr(); ?>
	<?php if(($___Ls->qry->tot > 0)){  ?>
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
			<tr>
			    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_PSS ?></th>
			    <th width="5%" <?php echo NWRP ?>><?php echo TX_SDS ?></th>
			</tr>
			<?php do {  ?>
		  		<tr>  
					<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
				    <td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['orgsdspass_pass'],'in'); ?></td>
				    <td width="30%" align="left" <?php echo $_clr_rw ?>><?php echo ctjTx($___Ls->ls->rw['orgsds_nm'],'in'); ?></td>
				</tr>
		  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
		</table>
		<?php $___Ls->_bld_l_pgs(); 
	}
	$___Ls->_h_ls_nr(); 
} ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  <div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
  	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
     	<?php $___Ls->_bld_f_hdr(); ?>
	 	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	    <div class="ln_1">
          	<div class="col_1">
    
                <?php echo LsOrgSds([ /*'cl'=>'ok',*/ 'id'=>'orgsdspass_orgsds', 'v'=>'id_orgsds', 'va'=>$___Ls->dt->rw['orgsdspass_orgsds'], 'rq'=>1, 'org'=>$__i ]);
					$CntWb .= JQ_Ls('orgsdspass_orgsds'); 
				?>
            
          	</div>
		  	<div class="col_2">
                <?php echo OLD_HTML_chck('orgsdspass_est', TX_ACTV, $___Ls->dt->rw['orgsdspass_est'], 'in'); ?>

				<?php $_pass = Gn_Rnd(6); ?>
				<?php echo HTML_inp_hd('orgsdspass_pass', $_pass); ?>
				<div class="pass">
					La contraseña es: <b><?php echo $_pass; ?></b>
				</div>
				
				<?php 
										    	
					$CntWb .= "
						_Rqu({ 
							t:'org_sds_pass', 
							id: '".$_pass."',
							_cl:function(d){
								if(d.e == 'no'){
									$('#orgsdspass_pass').val(d.pss);
									$('.pass b').html(d.pss);
								}
							}
						});
					";
				
				?>

	    	</div>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>
<style>
	.pass{
		width: 100%;
		border: 2px dashed #cccccc;
		background-color: #ececec;
		border-radius: 10px;
		padding: 20px;
		margin-top: 17px;
		color: gray;
	}
</style>
