<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = MDL_MNU;
	$___Ls->sch->f = 'clmnu_tt, clmnu_rel, clmnu_cns, clmnu_cls';
	$___Ls->edit->scrl = 'ok';
	$___Ls->img->dir = DMN_FLE_CL_MNU;
	$___Ls->new->w = 650;
	$___Ls->new->h = 650;
	$___Ls->edit->big = 'ok';
	$___Ls->ls->lmt = 500;

	$___Ls->_strt();
	$__fl .= $___Ls->_bld_f_q([ '_clmnu_tp', '_clmnu_chckmd', '_clmnu_sis' ]);

	

	if(!isN($___Ls->gt->i)){

		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_CL_MNU." INNER JOIN "._BdStr(DBM).TB_SIS_MNU_TP." ON clmnu_tp = id_sismnutp WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
	
	}elseif($___Ls->_show_ls == 'ok'){ 
		
		if(!ChckSESS_superadm()){ $__fl .= sprintf(' AND clmnur_cl = %s ', GtSQLVlStr($__dt_cl->id, "int")); }

		if(!isN($___Ls->gt->tsb)){ 
			if($___Ls->gt->tsb == 'sis'){ $__fl .= sprintf(' AND clmnu_sis = 1 '); }
			if($___Ls->gt->tsb == 'cl'){ $__fl .= sprintf(' AND clmnu_sis != 1 AND clmnu_main != 1'); }
			if($___Ls->gt->tsb == 'shct'){ $__fl .= sprintf(' AND clmnu_shct = 1 '); } 
			if($___Ls->gt->tsb == 'main'){ $__fl .= sprintf(' AND clmnu_main = 1 '); } 
		}
		
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_CL_MNU." 
						 INNER JOIN "._BdStr(DBM).TB_SIS_MNU_TP." ON clmnu_tp = id_sismnutp
						 LEFT JOIN "._BdStr(DBM).TB_CL_MNU_R." ON clmnur_clmnu = id_clmnu
					WHERE ".$___Ls->ino." != '' $__fl ".$___Ls->sch->cod." $__fl";
					
		$___Ls->qrys = "SELECT *, 
						  (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT."
						$Ls_Whr 
						/*GROUP BY clmnur_clmnu*/
						ORDER BY clmnu_shct DESC, clmnu_sis DESC, clmnu_main ASC, clmnur_cl ASC, clmnu_ord ASC";
						
	} 


	$___Ls->_bld(); 

?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>
<?php if(($___Ls->qry->tot > 0)){ ?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<thead>
		<tr>
		    <th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		    <th width="50%" <?php echo NWRP ?>><?php echo TX_TT ?></th>
		    <th width="5%" <?php echo NWRP ?>><?php echo TX_SHCT ?></th>
		    <th width="5%" <?php echo NWRP ?>><?php echo TX_SIS ?></th>  
		    <th width="5%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
		    <th width="5%" <?php echo NWRP ?>><?php echo TX_CNST ?></th>
		    <th width="5%" <?php echo NWRP ?>><?php echo TX_PRNT ?></th>
		    <th width="5%" <?php echo NWRP ?>><?php echo TX_RQRDPRM ?></th>
		    <th width="5%" <?php echo NWRP ?>><?php echo TX_PRMRQRD ?></th>
		    <th width="5%" <?php echo NWRP ?>><?php echo TX_SUPRADMN ?></th>
		    <th width="5%" <?php echo NWRP ?>><?php echo TX_MDLMAIN ?></th>
		    <th width="5%" <?php echo NWRP ?>><?php echo TX_ORDN ?></th>
		    <th width="1%" <?php echo NWRP ?>></th>
  		</tr>
	</thead>	
	<?php do { ?>
  	<?php 
			
		$__mnu_o = GtMnuClLs([ 'mnu'=>$___Ls->ls->rw['id_clmnu'] ]);			       
		$__cl = '';
		
		foreach($__mnu_o->ls as $_mnucl_k=>$_mnucl_v){

			$__cl .= '<li style="background-image:url('.$_mnucl_v->cl->img->th_50.');" alt="'.ctjTx( $_mnucl_v->cl->nm ,'in').'" title="'.ctjTx( $_mnucl_v->cl->nm ,'in').'"> </li>' ;
			
		}        
		        
	  	$___id = $___Ls->ls->rw[$___Ls->ino];
	  	$___mnu[$___id] = [ 
							'id'=>$___id, 
							'nm'=>ctjTx($___Ls->ls->rw['clmnu_tt'],'in'),
							'rel'=>ctjTx($___Ls->ls->rw['clmnu_rel'],'in'),
							'rel_sub'=>ctjTx($___Ls->ls->rw['clmnu_rel_sub'],'in'),
							'rel_tp'=>ctjTx($___Ls->ls->rw['clmnu_rel_tp'],'in'),
							'rel_data'=>ctjTx($___Ls->ls->rw['clmnu_rel_data'],'in'),
							'cl'=>ul($__cl, '_cl_avatar'),
							'tp'=>ShortTx(ctjTx($___Ls->ls->rw['sismnutp_tt'],'in'),150,'Pt', true), 
							'prnt'=>ShortTx(ctjTx($___Ls->ls->rw['clmnu_prnt'],'in'),150,'Pt', true),
							'cns'=>ShortTx(ctjTx($___Ls->ls->rw['clmnu_cns'],'in'),150,'Pt', true),
							'img'=>DMN_FLE_CL_MNU.$___Ls->ls->rw['clmnu_img'],
							'chckmd'=>mBln($___Ls->ls->rw['clmnu_chckmd']),
							'chckmd_v'=>ShortTx(ctjTx($___Ls->ls->rw['clmnu_chckmd_v'],'in'),150,'Pt', true),
							'shct'=>mBln($___Ls->ls->rw['clmnu_shct']),
							'sis'=>mBln($___Ls->ls->rw['clmnu_sis']),
							'spradmn'=>mBln($___Ls->ls->rw['clmnu_spradmn']),
							'main'=>mBln($___Ls->ls->rw['clmnu_main']),
							'clr'=>[
								'bck'=>ctjTx($___Ls->ls->rw['clmnur_clr_bck'],'in'),
								'fnt'=>ctjTx($___Ls->ls->rw['clmnur_clr_fnt'],'in')	
							],									
							'ord'=>ShortTx(ctjTx($___Ls->ls->rw['clmnu_ord'],'in'),150,'Pt', true),
							'hb'=>[
								'mod'=>$___Ls->hb->mod,
							],
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
				$__tt_img = fgr('<img src="'.$mn_v['img'].'">');
				$__id_prnt = $mn_v['prnt'];
				
				if($lvl==1){ $NmNw = 2; }
				
				 
				$__html_b .= '<tr '.cl($mn_v['trlnk'],$Nm,'','','','ok').'>';
				
				for($i=1; $i<$lvl;$i++){ if($lvl>$i && $__id_prnt != $_parent){ $__li_sub .= '—— '; } }
				if($mn_v['sis']=='ok'){ $_nm_sis='_sis'; }else{ $_nm_sis=''; }
				
				$__rel_sub = $mn_v['rel'];
				
				if(!isN($mn_v['rel_sub'])){ $__rel_sub .= ' - '.$mn_v['rel_sub']; }else{ $__rel_sub .= ''; }
				if(!isN($mn_v['rel_tp'])){ $__rel_sub .= ' - '.$mn_v['rel_tp']; }else{ $__rel_sub .= ''; }
				
				$__html_b .= '
					<td width="1%" '.NWRP.'>'.Spn($mn_v['id'],'','_nmr '.$_nm_sis,'background-color:'.$mn_v['clr']['bck'].'; color:'.$mn_v['clr']['fnt'].';').'</td>
				    <td width="50%" align="left" '.NWRP.' style="text-align:left !important;">'.
				    	
				    	$__li_sub.
				    	$__tt_img.
				    	$__tt_btn. 
				    	Spn($__rel_sub,'ok','_f').'</br>'. 
				    	$mn_v['cl'].
				    	
				    '</td>
				    <td width="5%" align="center" '.NWRP.'>'.($mn_v['shct']=='ok'?bdiv(['cls'=>'icn_shct']):'').'</td>
				    <td width="5%" align="center" '.NWRP.'>'.($mn_v['sis']=='ok'?bdiv(['cls'=>'icn_sis']):'').'</td>
				    <td width="5%" align="left" '.NWRP.'>'.$mn_v['tp'].'</td>
					<td width="5%" align="left" '.NWRP.'>'.$mn_v['cns'].'</td>
					<td width="5%" align="left" '.NWRP.'>'.$mn_v['prnt'].'</td>
					<td width="5%" align="left" '.NWRP.'>'.$mn_v['chckmd'].'</td>
					<td width="5%" align="left" '.NWRP.'>'.$mn_v['chckmd_v'].'</td>
					<td width="5%" align="left" '.NWRP.'>'.$mn_v['spradmn'].'</td>
					<td width="5%" align="left" '.NWRP.'>'.$mn_v['main'].'</td>
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

<div class="Tot_Tb"><?php echo PrG($startRow_Ls_Rg, (SIS_NMRG*5) ,TT_RWS,TT_PGS).PgsCnt(TT_PGS,$Pgs); ?></div>

<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>


<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
	<div class="__cl_slc">
		
		<div class="more_opt _anm">
			<div class="_ovr"></div>
			<div class="_bx">
				<?php echo Tra_Tag_Html('a-up'); ?>
				<div class="__fld">
					<?php echo h1(TX_CLR.' '.MDL_MNU); ?>
					<ul>
						<li><?php echo Strn(TX_CLR).HTML_inp_clr(['id'=>'clmnur_clr_fnt', 'plc'=>TX_CLR, 'vl'=>'']); ?></li>
						<li><?php echo Strn(TX_BCKG).HTML_inp_clr(['id'=>'clmnur_clr_bck', TX_CLR, '']); ?></li>
					</ul>
				</div>
			</div>
		</div>
	
	
	    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >

	      <?php $___Ls->_bld_f_hdr(); ?>

	       <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
	        <div class="ln_1">
	          <div class="col_1">
	          		<?php echo HTML_inp_tx('clmnu_tt', TX_TT, ctjTx($___Ls->dt->rw['clmnu_tt'],'in'), FMRQD);?>
			  		<?php echo HTML_inp_tx('clmnu_cns', TX_CNST, ctjTx($___Ls->dt->rw['clmnu_cns'],'in'), FMRQD);?>
			  		<?php 
				  		
				  		if(mBln($___Ls->dt->rw['clmnu_sis'])=='ok'){  
					  		$__mnuls_sis=1;
					  		$__mnuls_cl='';
				  		}else{
					  		$__mnuls_sis='';
					  		$__mnuls_cl=$__dt_cl->i;
				  		}

				  		echo LsSisMnu('clmnu_prnt','id_clmnu', $___Ls->dt->rw['clmnu_prnt'], TX_PRNT, 2, '', ['cl'=>$__mnuls_cl, 'sis'=>$__mnuls_sis] ); 
				  		
				  		$CntWb .= JQ_Ls('clmnu_prnt', TX_PRNT); 
				  	
				  	
				  	?>
			  		<?php echo LsSisMnuTp('clmnu_tp','id_sismnutp', $___Ls->dt->rw['clmnu_tp'], TX_TP, 1); $CntWb .= JQ_Ls('clmnu_tp', TX_TP); ?>
			  		
			  		<?php if($___Ls->dt->tot > 0){ ?>
			  		
			  			<?php 
				  			$___Ls->_dvlsfl_all([
								['n'=>'cl', 't'=>'cl_mnu_cl', 's'=>'ok']
							]); 
						?>	
		          	<div class="ln">
		                 <?php echo $___Ls->tab->cl->d ?> 
		                <?php       
							
							//$CntJV .= _DvLsFl_Vr([ 'i'=>$___Ls->dt->rw[$___Ls->ino], 'n'=>'_cl', 't'=>'cl_mnu_cl' ]);		  
							//$CntWb .= _DvLsFl([ 'i'=>'_cl', 't'=>'s' ]);

						?> 
		            </div> 
					<?php } ?>
					
	          </div>
	          <div class="col_2">
		        <?php echo OLD_HTML_chck('clmnu_chckmd', TX_RQRDPRM, $___Ls->dt->rw['clmnu_chckmd'], 'in'); ?>
		        <?php echo OLD_HTML_chck('clmnu_shct', TX_SHCT, $___Ls->dt->rw['clmnu_shct'], 'in'); ?>
		        <?php echo OLD_HTML_chck('clmnu_sis', TX_SIS, $___Ls->dt->rw['clmnu_sis'], 'in'); ?>
		        <?php echo OLD_HTML_chck('clmnu_spradmn', TX_SUPRADMN, $___Ls->dt->rw['clmnu_spradmn'], 'in'); ?>
		        <?php echo OLD_HTML_chck('clmnu_main', TX_MDLMAIN, $___Ls->dt->rw['clmnu_main'], 'in'); ?>
				<?php echo OLD_HTML_chck('clmnu_pop', TX_MDLOPNPOP, $___Ls->dt->rw['clmnu_pop'], 'in'); ?>
				<?php echo OLD_HTML_chck('clmnu_cche', MDL_ADMCCHE, $___Ls->dt->rw['clmnu_cche'], 'in'); ?>
		        <br><br>  
		        <?php echo HTML_inp_tx('clmnu_chckmd_v', TX_PRMRQRD, ctjTx($___Ls->dt->rw['clmnu_chckmd_v'],'in'), '');?>
		        <?php echo HTML_inp_tx('clmnu_cls', TX_CLSS, ctjTx($___Ls->dt->rw['clmnu_cls'],'in'), '');?>
		        
		        
		        <div class="__cx4">
		        	<div class="_c c1">
			        	<?php echo HTML_inp_tx('clmnu_rel', TX_TGREL, ctjTx($___Ls->dt->rw['clmnu_rel'],'in'), '');?>
			        </div>
					<div class="_c c2">
						<?php echo HTML_inp_tx('clmnu_rel_sub', TX_TGREL.' (Sub)', ctjTx($___Ls->dt->rw['clmnu_rel_sub'],'in'), '');?>
					</div>
					<div class="_c c3">
						<?php echo HTML_inp_tx('clmnu_rel_tp', TX_TGREL.' (Tp)', ctjTx($___Ls->dt->rw['clmnu_rel_tp'],'in'), '');?>
					</div>
					<div class="_c c4">
						<?php echo HTML_inp_tx('clmnu_rel_data', TX_TGREL.' (Data)', ctjTx($___Ls->dt->rw['clmnu_rel_data'],'in'), '');?>
					</div>
		        </div>
		        
		        
		        <?php echo HTML_inp_tx('clmnu_ord', TX_ORDN, ctjTx($___Ls->dt->rw['clmnu_ord'],'in'), '');?>
		        <?php echo HTML_inp_tx('clmnu_lnk', TX_LNK, ctjTx($___Ls->dt->rw['clmnu_lnk'],'in'), '');?>
		        
		        <?php echo HTML_inp_tx('clmnu_pop_w', TX_MDLOPNPOP.' '.TX_WDTH, ctjTx($___Ls->dt->rw['clmnu_pop_w'],'in'), ''); ?>
		        <?php echo HTML_inp_tx('clmnu_pop_h', TX_MDLOPNPOP.' '.TX_HEGT, ctjTx($___Ls->dt->rw['clmnu_pop_h'],'in'), ''); ?>
		        
		      </div>
	        </div>
	      </div>
	    </form>
    
    </div>
    
  </div>
</div>

<style>

	.__cx4{ display: flex; }
	.__cx4 ._c{ width: 25%; position: relative; }
	.__cx4 .c1{ padding: 0 30px 0 0; }
	.__cx4 .c2{ padding: 0 30px; }
	.__cx4 .c3{ padding: 0 30px; }
	.__cx4 .c4{ padding: 0 0 0 30px;  }
	.__cx4 input[type=text]{ text-align: center; }

	
	.__cx4 ._c.c2:before,
	.__cx4 ._c.c2:after{ width: 30px; height: 40px; position: absolute; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_ls_next.svg'); background-position: center center; background-repeat: no-repeat; background-size: 30px auto; top: 0; }
	
	.__cx4 ._c.c2:before{ left: -15px; }
	.__cx4 ._c.c2:after{ right: -15px; }
	
	.__cx4 input[type=text]::-webkit-input-placeholder { text-align: center !important; }
	.__cx4 input[type=text]::-moz-placeholder { text-align: center !important; }
	.__cx4 input[type=text]:-ms-input-placeholder { text-align: center !important; }
	.__cx4 input[type=text]:-moz-placeholder { text-align: center !important; }

	
</style>
	
<?php } ?>
<?php } ?>