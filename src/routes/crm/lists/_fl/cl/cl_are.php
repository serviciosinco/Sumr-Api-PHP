<?php
if(class_exists('CRM_Cnx')){

	
	$___Ls->img->dir = DMN_FLE_CL_ARE;
	$___Ls->ls->lmt = 1000;
	$___Ls->_strt();
	
	
	if(!isN($___Ls->gt->i)){	
		 
		$___Ls->qrys = sprintf("	SELECT *,
								"._QrySisSlcF([ 'als'=>'t', 'als_n'=>'tag' ])."	
							FROM ".TB_CL_ARE."
								".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clare_tp', 'als'=>'t' ])."
							WHERE ".$___Ls->ik." = %s 
							LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));	
		
	}elseif($___Ls->_show_ls == 'ok'){
	
		$Ls_Count = "	
					(	SELECT COUNT(*)
						FROM 
							".TB_CL_ARE." 
							INNER JOIN ".TB_CL." ON clare_cl = id_cl
							INNER JOIN ".TB_SIS_SLC." ON clare_tp = id_sisslc	
						WHERE ".$___Ls->ino." != '' AND clare_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '$__i')	 ".$___Ls->sch->cod." 
						ORDER BY ".$___Ls->ino." DESC
						
					) AS ".QRY_RGTOT.",";
								
		$___Ls->qrys = "	SELECT *, 
						 ".$Ls_Count."
						 "._QrySisSlcF([ 'als'=>'t', 'als_n'=>'tipo' ])."	 
					FROM 
						".TB_CL_ARE." 
						INNER JOIN ".TB_CL." ON clare_cl = id_cl
						".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clare_tp', 'als'=>'t' ])."		
					WHERE ".$___Ls->ino." != '' AND clare_cl = (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = '$__i') ".$___Ls->sch->cod." 
					ORDER BY ".$___Ls->ino." DESC";
					
	} 

	
	$___Ls->_bld();

?>
<?php if($___Ls->ls->chk=='ok'){ ?>

<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<tr>
	    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
	    <th width="50%" <?php echo NWRP ?>><?php echo TX_TT ?></th> 
	    <th width="5%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
	    <th width="5%" <?php echo NWRP ?>><?php echo TX_PRNT ?></th>
	    <th width="5%" <?php echo NWRP ?>><?php echo TX_ORDN ?></th>
	    <th width="1%" <?php echo NWRP ?>></th>
	</tr>
	<?php do { ?>
  	<?php 
	  	
	  	
		  	$_lnktr_l = FL_LS_GN.__t($__bdtp,true).

			        			_SbLs_ID().ADM_LNK_DT.$___Ls->ls->rw[$___Ls->ino].

			        			$___Ls->ls->vrall.$_adsch;
			        			
			$_lnk = _Ls_Lnk_Rw(['l'=>$_lnktr_l, 'sb'=>$__lssb, 'r'=>$___Ls->bx_rld]);		       
			$__cl = '';    
			        

		  	$___id = $___Ls->ls->rw[$___Ls->ino];

		  	$___mnu[$___id] =[ 
								'id'=>$___id, 
								'nm'=>ctjTx($___Ls->ls->rw['clare_tt'],'in'),
								'tp'=>ShortTx(ctjTx($___Ls->ls->rw['sisslc_tt'],'in'),150,'Pt', true), 
								'prnt'=>ShortTx(ctjTx($___Ls->ls->rw['clare_prnt'],'in'),150,'Pt', true),
								'cns'=>ShortTx(ctjTx($___Ls->ls->rw['clare_cns'],'in'),150,'Pt', true),
								'img'=>DMN_FLE_CL_MNU.$___Ls->ls->rw['clare_img'],							
								'ord'=>ShortTx(ctjTx($___Ls->ls->rw['clare_ord'],'in'),150,'Pt', true),

								'btn'=>[
									'edt'=>$___Ls->_btn([ 't'=>'mod' ])
								]
							];
	
  	?>
  	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  	<?php 

	
		$__row = _bTree( $___mnu, '', 'a');
		
		function _BldLs($p=NULL, $lvl_set='', $_parent_sub=''){
			
			if($lvl_set != NULL){ $lvl=$lvl_set; }else{ /*$lvl=0;*/ } $lvl=$lvl+1;
			
			foreach($p as $mn_v){
				
				$__tt_btn = $mn_v['nm'];
				$__id_prnt = $mn_v['prnt'];
				
				if($lvl==1){ $NmNw = 2; }
				
				 
				$__html_b .= '<tr>';
				
				for($i=1; $i<$lvl;$i++){ if($lvl>$i && $__id_prnt != $_parent){ $__li_sub .= '—— '; } }
				if($mn_v['sis']=='ok'){ $_nm_sis='_sis'; }else{ $_nm_sis=''; }
				
				$__html_b .= '
					<td width="1%" '.NWRP.'>'.Spn($mn_v['id'],'','_nmr '.$_nm_sis,'background-color:'.$mn_v['clr']['bck'].'; color:'.$mn_v['clr']['fnt'].';').'</td>
				    <td width="50%" align="left" '.NWRP.' style="text-align:left !important;">'. 	
				    	$__li_sub.
				    	$__tt_btn. 
				    	$mn_v['cl'].	
				    '</td>
				    <td width="5%" align="left" '.NWRP.'>'.$mn_v['tp'].'</td>
					<td width="5%" align="left" '.NWRP.'>'.$mn_v['prnt'].'</td>
				    <td width="5%" align="left" '.NWRP.'>'.$mn_v['ord'].'</td>
				    <td width="1%" align="left" '.NWRP.' class="_btn">'.$mn_v['btn']['edt'].'</td>
				';
				
				if($mn_v['sub'] != NULL){
					$__chld = _BldLs($mn_v['sub'], $lvl, $__id_prnt);
					$__html_b .= $__chld;	
				}
								
				$_parent = $mn_v['prnt'];
				$__html_b .= '</tr>';
				
			}
				
			return $__html_b;
		}
	
		$__html = _BldLs($__row);
		
		echo $__html;
	?>
</table>


<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb __cl_are_detail">
	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>">
		                 
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">

     	<?php $___Ls->_bld_f_hdr(); ?>
	 	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">

	  
        <div class="ln_1">
          <div class="col_1">
                <?php echo HTML_inp_hd('clare_cl', $__i); ?>
                <?php 
	                $l = __Ls([ 'k'=>'cl_are_tp', 'id'=>'clare_tp', 'va'=>$___Ls->dt->rw['clare_tp'] , 'ph'=>FM_LS_SLTP, 'fcl'=>'ok' ]); 
	                echo $l->html; $CntWb .= $l->js;    
					
					$__mnuls_cl=$__dt_cl->i;
					
					echo LsClAre([
									'id'=>'clare_prnt',
									'v'=>'id_clare',
									'va'=>$___Ls->dt->rw['clare_prnt'],
									'rq'=>2,
									'mlt'=>'no'
								]); 
			
					$CntWb .= JQ_Ls('clare_prnt', TX_PRNT);
					
					echo OLD_HTML_chck('clare_est', TX_ACTV, $___Ls->dt->rw['clare_est'], 'in');
				
				?>
				
				
				<ul class="upl_img_opt">
			  		<li><button class="_anm upl_img upl_hdr" id="<?php echo 'upl_hdr_'.$___Ls->fm->id; ?>"> <span class="_anm">Pushmail Header</span></button></li>
			  		<li><button class="_anm upl_img upl_lgo" id="<?php echo 'upl_lgo_'.$___Ls->fm->id; ?>"> <span class="_anm">Logo</span></button></li>
	          	</ul>
				<?php 
				  	
					$_f = HTML_ClrBxImg('cl_are_hdr').$___Ls->uidn;
					$CntWb .= $___Ls->_h_fm_img([ 'b'=>'upl_hdr_'.$___Ls->fm->id, 'u'=>$_f ]);
					
					$_f = HTML_ClrBxImg('cl_are_lgo').$___Ls->uidn;
					$CntWb .= $___Ls->_h_fm_img([ 'b'=>'upl_lgo_'.$___Ls->fm->id, 'u'=>$_f ]);
				  	
			  	?>
						  	   	
          </div>
          <div class="col_2">
		  		<?php echo HTML_inp_tx('clare_tt', TX_NM , ctjTx($___Ls->dt->rw['clare_tt'],'in'), FMRQD); ?>
		  		<?php echo HTML_inp_tx('clare_cod', TX_COD , ctjTx($___Ls->dt->rw['clare_cod'],'in') ); ?>
		  		<?php echo HTML_inp_clr([ 'id'=>'clare_clr', 'plc'=>TX_CLR, 'vl'=>ctjTx($___Ls->dt->rw['clare_clr'],'in') ]); ?>
          </div>
        </div>
      </div>
    </form>
  	</div>
</div>

 <style>
    
    .__cl_are_detail .upl_img_opt{ text-align: center; margin: 50px 0 0 0; padding: 0; }
    .__cl_are_detail .upl_img_opt li{ display: inline-block; vertical-align: top; margin: 0 10px; } 
    .__cl_are_detail .upl_img_opt .upl_img{ border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; width:55px; height:55px; border: 2px solid #b4b8b9; background-size: 100% auto; background-position: center center; position: relative; }
    .__cl_are_detail .upl_img_opt .upl_img:hover{ border-color: #777b7c; background-size: 120% auto; }
    .__cl_are_detail .upl_img_opt .upl_img:hover span{ background-color: #676a6c; }
    
    .__cl_are_detail .upl_img_opt .upl_img.upl_hdr{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_are_hdr.svg); }
    .__cl_are_detail .upl_img_opt .upl_img.upl_lgo{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_are_lgo.svg); }
    
     .__cl_are_detail .upl_img_opt .upl_img span{ display:block; background-color: #bcc2c5; color: #ffffff; font-family: Roboto; font-weight: bolder; font-size: 10px; padding: 5px 10px; white-space: nowrap; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; width: 100%; position: absolute; bottom: -5px; left: 0; }
    
</style>

<?php } ?>
<?php } ?>
