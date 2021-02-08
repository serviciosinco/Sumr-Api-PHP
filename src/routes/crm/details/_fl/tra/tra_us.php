<?php 
  	
  	$_dt_tra = GtTraDt([ 'id'=>$___Dt->gt->i, 't'=>'enc', 'ext'=>['obs'=>'ok'] ]);
  		
  	$___Ls = new CRM_Ls();
  	$___Ls->qry->all = 'ok';
  	$___Ls->cnx->cl = 'ok';
  	$___Ls->_strt();	
  	
  	$__tpR = $_GET['_t2'];
  	
  	if($__tpR=='obs'){ 
		$__fl .= " AND id_us != ".SISUS_ID." "; 
		$__tpuscol = _CId('ID_USROL_OBS');
	}elseif($__tpR=='rsp'){
		$__tpuscol = _CId('ID_USROL_RSP');
	}
  
  	$___Ls->qrys = "	SELECT *, 
  								(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT.",
  								(SELECT COUNT(*) FROM "._BdStr(DBM).TB_TRA_RSP." WHERE trarsp_us = id_us AND trarsp_tra='".$_dt_tra->id."' ) AS __tot_rsp
  						FROM "._BdStr(DBM).TB_US."
  							INNER JOIN "._BdStr(DBM).TB_US_EST." ON us_est = id_usest
  							INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON us_gnr = id_sisslc
  						WHERE
  					  		 id_us IN ( SELECT uscl_us 
  					  		 			FROM "._BdStr(DBM).TB_US_CL."
												INNER JOIN "._BdStr(DBM).TB_CL." ON uscl_cl = id_cl
												INNER JOIN "._BdStr(DBM).TB_TRA_COL_US." ON tracolus_us = uscl_us
										WHERE 	cl_sbd = '".Gt_SbDMN()."' AND 
												tracolus_tracol = '".$_dt_tra->col->id."' AND
												tracolus_tp = '".$__tpuscol."'
  					  		 ) 
  					  		 $__fl
  					  	ORDER BY __tot_rsp DESC, us_ap ASC, us_nm ASC";
  	
	$___Ls->_bld();
	  
?>	
  <?php if(($___Ls->qry->tot > 0)){ ?>
  	<div class="Dsh_Tra_Us">
  		
  		<ul>
  			
  			<li class="sch"><?php echo HTML_inp_tx('us_sch_'.$___Ls->id_rnd, TX_SEARCH, ''); ?></li>
  			
  			<?php do { ?>
  		  		
  		  		<?php 
  			  		
  			  		$__slc = 'off';
  			  		
  			  		if( !isN($___Ls->ls->rw['us_img']) ){
  						$_img = _ImVrs(['img'=>$___Ls->ls->rw['us_img'], 'f'=>DMN_FLE_US ]);
  						$_img = $_img->th_50;
  					}else{
						$_img = GtUsImg([ 'img'=>$___Ls->ls->rw['us_img'], 'gnr'=>$___Ls->ls->rw['us_gnr'] ]);
  					} 
  					
  					if($___Ls->gt->tsb == 'rsp'){ 
  						if($_dt_tra->rsp->id == $___Ls->ls->rw['id_us']){ $__slc = 'on'; }
  					}elseif($___Ls->gt->tsb == 'obs'){
  						foreach($_dt_tra->obs->ls as $_obs_k=>$_obs_v){
  							if($_obs_v->id == $___Ls->ls->rw['id_us']){
  								$__slc = 'on'; break;
  							}
  						}
  					}
  		
  							
  		  		?>
  		  		
  		  		<li id="traus_slc_<?php echo $___Ls->ls->rw['us_enc']; ?>" us-id="<?php echo $___Ls->ls->rw['us_enc']; ?>" us-est="<?php echo $__slc; ?>" class="us-itm">
  		  			<span style="background-image:url(<?php echo $_img; ?>);" class="_icn _anm"></span>
  		  			<?php echo ctjTx($___Ls->ls->rw['us_nm'].' '.$___Ls->ls->rw['us_ap'],'in') ?>
  		  		</li>
  		  	
  		  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  	  	
  		</ul>
  		
  	</div>
  	
  	<?php 
  		
  		$CntWb .= " 
  			SUMR_Main.LsSch({ str:'#us_sch_".$___Ls->id_rnd."', ls:$('.Dsh_Tra_Us ul > li:not(.sch) ') }); 
  			SUMR_Tra.f.DtDom();
  		";	
  		
  	?>
  	
  <?php $___Ls->_bld_l_pgs(); ?>
  <?php } ?>