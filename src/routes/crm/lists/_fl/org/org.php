<?php
	
if(class_exists('CRM_Cnx')){
	
	if($___Ls->gt->tsb == "clg"){
		$___Ls->tt = _Cns('TX_SCHLS');
	}else{
		$___Ls->tt = _Cns('TX_'.strtoupper($___Ls->gt->tsb));
	} 
	
	$___Ls->img->dir = DMN_FLE_ORG;
	$___Ls->flt = 'ok';
	$___Ls->sch->f = 'id_org, org_nm';
	$___Ls->sch->m = ' || (
		EXISTS (SELECT * FROM '._BdStr(DBM).TB_ORG_SDS.' WHERE orgsds_org = id_org AND orgsds_nm LIKE \'%[-SCH-]%\' )  ||
		EXISTS (SELECT * FROM '._BdStr(DBM).TB_ORG_WEB.' WHERE orgweb_org = id_org AND orgweb_web LIKE \'%[-SCH-]%\' ) ||
		EXISTS (SELECT * 
				FROM '._BdStr(DBM).TB_ORG_SDS_DC.' 
					 INNER JOIN '._BdStr(DBM).TB_ORG_SDS.' ON orgsdsdc_orgsds = id_orgsds
				WHERE orgsds_org = id_org AND orgsdsdc_dc LIKE \'%[-SCH-]%\' 
			) 
	)';
	
	$___Ls->cnx->cl = 'ok';
	$___Ls->edit->scrl = 'ok';

	if($__t2 == 'marks'){ 
		$___Ls->grph->tot = 6;
	}elseif($___Ls->gt->tsis!='ok'){
		$___Ls->grph->tot = 3;
	}
	
	$___Ls->new->w = 700;
	$___Ls->new->h = 500;
	$___Ls->edit->big = 'ok';


	$___Ls->_strt();
	
	$__org_tabs = __LsDt([ 'k'=>'org_tabs' ]);
	
	foreach($__org_tabs->ls->org_tabs as $_k_tabs_ord => $_v_tabs_ord){
		if($_v_tabs_ord->{$___Ls->gt->tsb}->vl == 1){
			$_org_tabs_ord[$_v_tabs_ord->ord->vl] = $_v_tabs_ord;
		}
	}
	
	ksort($_org_tabs_ord); //Ordenar tabs

	if(!isN($___Ls->gt->i)){				
				
		if($__t2 == 'clg'){ $___fl = 'LEFT JOIN '._BdStr(DBM).TB_ORG_ATTR.' ON orgattr_org = id_org'; }
		if($__t2 == 'emp'){ $___fl = 'LEFT JOIN '._BdStr(DBM).TB_ORG_SCEC.' ON orgscec_org = id_org'; }
		
		$___Ls->qrys = sprintf("SELECT *
								FROM "._BdStr(DBM).TB_ORG."
								LEFT JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org $___fl
								WHERE ".$___Ls->ik." = %s
								LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text")
							);
			
	}elseif($___Ls->_show_ls == 'ok'){		
		
		$__org_tp = __LsDt([ 'k'=>'org_tp' ]);
		
		foreach($__org_tp->ls->org_tp as $_k => $_v){
			if($___Ls->gt->tsb == $_v->key->vl){ 
				$_fl_org[] = $_k;
				$_tp_org = $_v->id;
			}
			
			if(!isN($_fl_org)){ $_fl .= " AND id_org IN ( SELECT orgtp_org FROM "._BdStr(DBM).TB_ORG_TP." WHERE orgtp_tp IN (".implode(',',$_fl_org).") ) "; }
		}
			
		if($___Ls->gt->tsis != 'ok'){	
			$__fl = " AND id_org IN (SELECT orgcl_org FROM "._BdStr(DBM).TB_ORG_CL.", "._BdStr(DBM).TB_CL." WHERE orgcl_cl = ".$__dt_cl->id." ) ";
		 
		}

		if(!isN($___Ls->_fl->fk->cllcl_lvl)){
			$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
						INNER JOIN "._BdStr(DBM).TB_ORG_SDS." ON orgsds_org = id_org
						INNER JOIN "._BdStr(DBM).TB_ORG_SDS_ARR." ON orgsdsarr_orgsds = id_orgsds
						INNER JOIN "._BdStr(DBM).TB_CL_LCL." ON orgsdsarr_lcl = id_cllcl WHERE cllcl_lvl = ".$___Ls->_fl->fk->cllcl_lvl." )";	
		}

		if(!isN($___Ls->_fl->fk->_fl_orgls)){

			$__fl .= " AND id_org IN ( ".$___Ls->_fl->fk->_fl_orgls." )";

		}

		if(!isN($___Ls->_fl->fk->_fl_orgest)){
			$__fl .= " AND org_est = ".$___Ls->_fl->fk->_fl_orgest;	
		}

		if(!isN($___Ls->_fl->fk->_fl_orgtag)){

			$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
						INNER JOIN "._BdStr(DBM).TB_ORG_TAG." ON orgtag_org = id_org
							WHERE orgtag_tag = ".$___Ls->_fl->fk->_fl_orgtag." )";

		}
		// ------ Filtro de Colegios ---- //
		if(!isN($___Ls->_fl->fk->_fl_orgenf)){

			$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
						INNER JOIN "._BdStr(DBM).TB_ORG_ENF." ON orgenf_org = id_org
							WHERE orgenf_enf = ".$___Ls->_fl->fk->_fl_orgenf." )";

		}
		if(!isN($___Ls->_fl->fk->_fl_orglng)){

			$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
						INNER JOIN "._BdStr(DBM).TB_ORG_LNG." ON orglng_org = id_org
							WHERE orglng_lng = ".$___Ls->_fl->fk->_fl_orglng." )";

		}
		if(!isN($___Ls->_fl->fk->_fl_orgbch)){

			$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
						INNER JOIN "._BdStr(DBM).TB_ORG_BCH." ON orgbch_org = id_org
							WHERE orgbch_bch = ".$___Ls->_fl->fk->_fl_orgbch." )";

		}
		if(!isN($___Ls->_fl->fk->_fl_orgexa)){

			$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
						INNER JOIN "._BdStr(DBM).TB_ORG_EXA." ON orgexa_org = id_org
							WHERE orgexa_exa = ".$___Ls->_fl->fk->_fl_orgexa." )";

		}

		if(!isN($___Ls->_fl->fk->_fl_orgrdm)){ $__fl_attr .= " AND orgattr_rdm = ".$___Ls->_fl->fk->_fl_orgrdm; }

		if(!isN($___Ls->_fl->fk->_fl_orgnvs)){ $__fl_attr .= " AND orgattr_nvs = ".$___Ls->_fl->fk->_fl_orgnvs; }

		if(!isN($___Ls->_fl->fk->_fl_orgtpclg)){ $__fl_attr .= " AND orgattr_tp = ".$___Ls->_fl->fk->_fl_orgtpclg; }

		if(!isN($___Ls->_fl->fk->_fl_orgnvlatc)){ $__fl_attr .= " AND orgattr_nva = ".$___Ls->_fl->fk->_fl_orgnvlatc; }

		if(!isN($___Ls->_fl->fk->_fl_orgprtf)){ $__fl_attr .= " AND orgattr_prtf = ".$___Ls->_fl->fk->_fl_orgprtf; }

		if(!isN($___Ls->_fl->fk->_fl_orgtmn)){ $__fl_attr .= " AND orgattr_tmn = ".$___Ls->_fl->fk->_fl_orgtmn; }

		if(!isN($___Ls->_fl->fk->_fl_orgntz)){ $__fl_attr .= " AND orgattr_ntz = ".$___Ls->_fl->fk->_fl_orgntz; }

		if(!isN($__fl_attr)){
			$__fl .= " AND id_org IN ( SELECT id_org FROM "._BdStr(DBM).TB_ORG." 
						INNER JOIN "._BdStr(DBM).TB_ORG_ATTR." ON orgattr_org = id_org
							WHERE id_orgattr != '' ".$__fl_attr." )";	
		}

		// ------ Fin Filtro de Colegios ---- //
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_ORG." 
					WHERE ".$___Ls->ino." != '' $_fl $__fl ".$___Ls->sch->cod." 
					ORDER BY org_vrf DESC, org_nm ASC";	
						
					
		$___Ls->qrys = "SELECT *,
				   		(SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." 
						   $Ls_Whr";	 
				   	
	}else{
		
		$__org_tp = __LsDt([ 'k'=>'org_tp' ]);
		
		foreach($__org_tp->ls->org_tp as $_k => $_v){
			if($___Ls->gt->tsb == $_v->key->vl){ 
				$_org_tp = $_v;
			}
		}
		
	} 
	
	$___Ls->_bld();
	
	
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); ?>

<?php 
	
	 
	$__grph_shw = "
		
		
		SUMR_Main.bxajx.__grph_fl = { fl:{ f:".json_encode($___Ls->c_f_g)."} };
		
		
		_ldCnt({ 
			u:'".Fl_Rnd(FL_GRPH_GN.__t($___Ls->gt->t, true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=".$___Ls->gt->tsb."&_t3=".$___Ls->gt->tsb_m."&_tp=grph_1&_g_r=".$___Ls->id_rnd."' , 
			c:'bx_grph_".$___Ls->id_rnd."_1',
			d:SUMR_Main.bxajx.__grph_fl,
			trs:false, 
			anm:'no',
			_cl:function(){
				
				_ldCnt({ 
					u:'".Fl_Rnd(FL_GRPH_GN.__t($___Ls->gt->t, true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=".$___Ls->gt->tsb."&_t3=".$___Ls->gt->tsb_m."&_tp=grph_2&_g_r=".$___Ls->id_rnd."' , 
					c:'bx_grph_".$___Ls->id_rnd."_2',
					d:SUMR_Main.bxajx.__grph_fl,
					trs:false,
					anm:'no',
					_cl:function(){
						
						_ldCnt({ 
							u:'".Fl_Rnd(FL_GRPH_GN.__t($___Ls->gt->t, true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=".$___Ls->gt->tsb."&_t3=".$___Ls->gt->tsb_m."&_tp=grph_3&_g_r=".$___Ls->id_rnd."' , 
							c:'bx_grph_".$___Ls->id_rnd."_3',
							d:SUMR_Main.bxajx.__grph_fl,
							trs:false,
							anm:'no',
							_cl:function(){
								

								_ldCnt({ 
									u:'".Fl_Rnd(FL_GRPH_GN.__t($___Ls->gt->t, true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=".$___Ls->gt->tsb."&_t3=".$___Ls->gt->tsb_m."&_tp=grph_4&_g_r=".$___Ls->id_rnd."' , 
									c:'bx_grph_".$___Ls->id_rnd."_4',
									d:SUMR_Main.bxajx.__grph_fl,
									trs:false,
									anm:'no',
									_cl:function(){

										_ldCnt({ 
											u:'".Fl_Rnd(FL_GRPH_GN.__t($___Ls->gt->t, true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=".$___Ls->gt->tsb."&_t3=".$___Ls->gt->tsb_m."&_tp=grph_5&_g_r=".$___Ls->id_rnd."' , 
											c:'bx_grph_".$___Ls->id_rnd."_5',
											d:SUMR_Main.bxajx.__grph_fl,
											trs:false,
											anm:'no',
											_cl:function(){


											}
										});
								
									}
								});							
							}
						});	

					}
				});
			
			}
		});

	
	";
	
	
?>

<?php if(($___Ls->qry->tot > 0)){ ?>  
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<tr>
		<th width="1%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
		<th width="1%" <?php echo NWRP ?>></th>
		<th width="1%" <?php echo NWRP ?>></th>
		<th width="30%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
		<th width="5%" <?php echo NWRP ?>><?php echo TX_SDS ?></th>
		<th width="5%" <?php echo NWRP ?>><?php echo TX_CNT ?></th>
		<th width="5%" <?php echo NWRP ?>><?php echo TX_GST ?></th>
		<th width="5%" <?php echo NWRP ?>><?php echo TX_DOCS ?></th>
		
		<?php if($___Ls->gt->tsb == "clg"){ ?>
		<th width="5%" <?php echo NWRP ?>><?php echo TX_ENF ?></th>
		<th width="5%" <?php echo NWRP ?>><?php echo TX_SIS_LNG ?></th>
		<th width="5%" <?php echo NWRP ?>><?php echo TX_BCH ?></th>
		<th width="5%" <?php echo NWRP ?>><?php echo TX_EXA ?></th>
		<?php } ?>
		
		<th width="1%" <?php echo NWRP ?>></th>
	</tr>
  	<?php do { ?>
  	<?php $__ls_json[] = $___Ls->ls->rw['org_enc']; ?>
    <tr id="<?php echo $___Ls->ls->nxt->id.$___Ls->ls->rw['org_enc'] ?>" org-id-no="<?php echo $___Ls->ls->rw['org_enc']; ?>">  
		<td align="left" <?php echo $_clr_rw ?>><?php echo $___Ls->ls->rw[$___Ls->ino]; ?></td>
		<td width="1%" <?php echo NWRP ?>>
			<?php $__org_logo = _ImVrs([ 'img'=>$___Ls->ls->rw['org_img'], 'f'=>DMN_FLE_ORG ]); ?>
            <div class="_img_o" style="background-image: url(<?php echo $__org_logo->th_100 ?>);"></div>
		</td>
		<td width="1%" align="left" nowrap="nowrap"><?php echo Spn(mBln($___Ls->ls->rw['org_vrf']),'',mBln($___Ls->ls->rw['org_vrf'])); ?></td>
	    <td width="30%" align="left" <?php echo $_clr_rw ?>>
		    <?php echo Spn('','', '_clr_icn','background-color:'.$___Ls->ls->rw['org_clr'].'; ').ctjTx($___Ls->ls->rw['org_nm'],'in'); ?>
		    <?php echo bdiv([ 'cls'=>'bx_cities', 'c'=>'-' ]); ?>
			<?php echo bdiv([ 'cls'=>'bx_dc', 'c'=>'-' ]); ?>
		</td>
	    <td width="5%" align="left" <?php echo $_clr_rw ?>><?php echo bdiv([ 'cls'=>'bx_sds', 'c'=>'-' ]) ?></td>
	    <td width="5%" align="left" <?php echo $_clr_rw ?>><?php echo bdiv([ 'cls'=>'bx_cnt', 'c'=>'-' ]) ?></td>
	    <td width="5%" align="left" <?php echo $_clr_rw ?>><?php echo bdiv([ 'cls'=>'bx_gst', 'c'=>'-' ]) ?></td>
	    <td width="5%" align="left" <?php echo $_clr_rw ?>><?php echo bdiv([ 'cls'=>'bx_docs', 'c'=>'-' ]) ?></td>
	    
	    <?php if($___Ls->gt->tsb == "clg"){ ?>
	    <td width="5%" align="left" <?php echo $_clr_rw ?>><?php echo bdiv([ 'cls'=>'bx_enf', 'c'=>'-' ]) ?></td>
	    <td width="5%" align="left" <?php echo $_clr_rw ?>><?php echo bdiv([ 'cls'=>'bx_lng', 'c'=>'-' ]) ?></td>
	    <td width="5%" align="left" <?php echo $_clr_rw ?>><?php echo bdiv([ 'cls'=>'bx_bch', 'c'=>'-' ]) ?></td>
	    <td width="5%" align="left" <?php echo $_clr_rw ?>><?php echo bdiv([ 'cls'=>'bx_exa', 'c'=>'-' ]) ?></td>
	    <?php } ?>

 	    <td width="1%" align="left" nowrap="nowrap" class="_btn">
	 		<div class="edt_all_prgrs">
		 		<div class="_avnc"></div>    
	 	    	<?php echo $___Ls->_btn([ 't'=>'mod' ]); ?>
	 		</div>
	 	</td>
   	</tr>
   	<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
</table>
<style>
	
	.Ls_Rg .edt_all_prgrs{ width: 30px; height: 30px; position: relative; }
	.Ls_Rg .edt_all_prgrs ._avnc{ position: absolute; left:-1px; top:-1px; pointer-events: none; }
	.Ls_Rg .edt_all_prgrs ._avnc .g_tot{ font-size: 11px !important; font-family: Economica !important; position: absolute !important; left: 0; top:30%;  width: 100% !important; margin:0 !important;  }
	.Ls_Rg .edt_all_prgrs .ls_btn:link{ border: none !important; background-size: 40% auto; display: none; }
	.Ls_Rg .edt_all_prgrs:hover .ls_btn:link{ display: block; }
	.Ls_Rg .edt_all_prgrs:hover .__avnc_l .g_tot{ display: none; }
	
	
	.Ls_Rg .bx_cities{ font-size: 11px; color: #aaa7a7 }
	.Ls_Rg .bx_cities::before{ display: inline-block; width: 13px; height: 13px; margin-bottom: -3px; margin-right: 5px; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>icn_map.svg); background-repeat: no-repeat; background-position: center center; background-size: auto 100%; opacity: 0.4; }
	
	.Ls_Rg .bx_dc{ font-size: 11px; color: #aaa7a7 }

	
	.Ls_Rg .edt_all_prgrs .HiChrt_Logo_Th{  }
			

</style>	

<?php 

	$CntJV .=	"
	
		function __getOrgJs(){

			$.post('".Fl_Rnd(FL_JSON_GN.__t('org_ext',true))."', { tp:'".$___Ls->gt->tsb."', org:'".implode(',', $__ls_json)."' },
            
            function(d, status){
                if(d.e == 'ok'){
                    if( d.total > 0 ){
                        $.each(d.l, function(_k, _v) { 
	                        
							if(!isN(_v.cty)){ $('tr[org-id-no='+_v.id+'] .bx_cities').html( _v.cty ); }
							
							if(!isN(_v.___dc)){ $('tr[org-id-no='+_v.id+'] .bx_dc').html( _v.___dc ); }
	                           
                       		if(!isN(_v.tot.sds)){ $('tr[org-id-no='+_v.id+'] .bx_sds').html( _v.tot.sds ); }
                       		if(!isN(_v.tot.cnt)){ $('tr[org-id-no='+_v.id+'] .bx_cnt').html( _v.tot.cnt ); }	                           		
                       		if(!isN(_v.tot.gst)){ $('tr[org-id-no='+_v.id+'] .bx_gst').html( _v.tot.gst ); }
                       		if(!isN(_v.tot.dc)){ $('tr[org-id-no='+_v.id+'] .bx_docs').html( _v.tot.dc ); }
                       		
                       		
                       		if(!isN(_v.tot.enf)){ $('tr[org-id-no='+_v.id+'] .bx_enf').html( _v.tot.enf ); }
                       		if(!isN(_v.tot.lng)){ $('tr[org-id-no='+_v.id+'] .bx_lng').html( _v.tot.lng ); }
                       		if(!isN(_v.tot.bch)){ $('tr[org-id-no='+_v.id+'] .bx_bch').html( _v.tot.bch ); }
                       		if(!isN(_v.tot.exa)){ $('tr[org-id-no='+_v.id+'] .bx_exa').html( _v.tot.exa ); }
                       		
                       		
                       		if(!isN(_v.avnc) && !isN(_v.avnc.html)){ $('tr[org-id-no='+_v.id+'] ._avnc').html( _v.avnc.html ); }
                       		if(!isN(_v.avnc) && !isN(_v.avnc.js)){ eval( _v.avnc.js ); }	
                       		
                        });   
                    }      
                }  
                
            });       
                
        }       
        
	";
	
	
	$CntWb .= " setTimeout(function(){ __getOrgJs(); ".$__grph_shw." }, 1000); ";

?>


<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>

<?php if($___Ls->fm->chk=='ok'){ ?>

<?php

	$__org_tp = __LsDt([ 'k'=>'org_tp' ]);

	foreach($__org_tp->ls->org_tp as $k => $v){
		if($v->key->vl == $___Ls->gt->tsb){
			$_tp_org = $v->id;
		}
	}

?>

<div class="FmTb __org_detail _anm <?php if($___Ls->dt->tot == 0){ echo '_new'; } ?>" id="__org_detail_<?php echo $___Ls->id_rnd; ?>">
	<div id="<?php  echo DV_GNR_FM ?>">

		<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
		<?php $___Ls->_bld_f_hdr(); ?>    
        
        <div class="attr_editor _anm" id="attr_editor<?php echo $___Ls->id_rnd; ?>"></div>
        
        <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">   
	        
        <?php 
			
			$_org_dt = GtOrgDt([ 'i'=>$___Ls->dt->rw['org_enc'], 't'=>'enc', 'tp'=>$_org_tp ]);
			       		
       		$__tabs = [];	
       		
       		if(!isN($_org_tabs_ord)){
				
				$__tabs[] = ['n'=>'bsc', 'l'=>TX_INIC];
					
				foreach($_org_tabs_ord as $_k_tabs => $_v_tabs){
					if($_v_tabs->{$___Ls->gt->tsb}->vl){
						if($_v_tabs->key->vl != "dtbsc"){
							$__tabs[] = ['n'=>$_v_tabs->key->vl, 't'=>'org_'.$_v_tabs->key->vl, 't3'=>$__t3, 'l'=>$_v_tabs->tt, 'bimg'=>$_img = $_v_tabs->img ];
						}				
					}
				}
				if($__t2 == 'marks'){
					$__tabs[] = ['n'=>'org_sds_pass', 't' => 'org_sds_pass', 'l'=>'Codigo de Acceso'];	
				}
				
			}

								
			$___Ls->_dvlsfl_all($__tabs,
			[
				'idb'=>'ok',
				'hd'=>'no',
				'sng'=>'ok',
				'icn_sty'=>'d2',
				'tomny'=>'ok',
				'dtb'=>1
			]);
					
		?>
		
		<?php if($___Ls->dt->tot != 1){ $_cls = "_othr"; } ?>
		
		<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels TbGnrl mny">
			<ul class="TabbedPanelsTabGroup _tb_pnl">				
				<li class="TabbedPanelsTab" style="display: none;"></li>
				<?php echo $___Ls->tab->bsc->l ?>	
				<?php 
					
					if(!isN($_org_tabs_ord)){
						
						foreach($_org_tabs_ord as $_k_tabs => $_v_tabs){
							if($_v_tabs->{$___Ls->gt->tsb}->vl){
								if($_v_tabs->key->vl != "dtbsc"){
									echo $___Ls->tab->{$_v_tabs->key->vl}->l;
								}
							}
						}
					
					}
					if($__t2 == 'marks'){
						echo $___Ls->tab->org_sds_pass->l;	
					}		
				?>
				
			</ul>
            <div class="TabbedPanelsContentGroup">
	            
	            	            
	            <section class="_cvr">
		            <div class="mapbck _ovrmap_emp _anm" style="height:auto;">		   
			            <div class="_ovrmap_logo _anm">
			            	<?php 
				            	
				            	if($___Ls->gt->tsb == 'clg'){
									$org_b_d_img = DMN_IMG_ESTR_SVG.'org_tp_fc_clg.svg';
									$org_b_d_clr = '#00a077';
								}elseif($___Ls->gt->tsb == 'uni'){
									$org_b_d_img = DMN_IMG_ESTR_SVG.'org_tp_fc_uni.svg';
									$org_b_d_clr = '#6c3189';
								}elseif($___Ls->gt->tsb == 'emp'){
									$org_b_d_img = DMN_IMG_ESTR_SVG.'org_tp_fc_emp.svg';
									$org_b_d_clr = '#4eb5ff';
								}
									
				            	if($___Ls->dt->tot != 1){
					            	
					           		$org_d_img = $org_b_d_img;
					           		$org_d_clr = $org_b_d_clr;	
			
				            	}else{
					            	
					            	$__cl_logo = _ImVrs([ 'img'=>$___Ls->dt->rw['org_img'], 'f'=>DMN_FLE_ORG ]);
					            	
					            	if(!isN($__cl_logo->th_400)){
					            		$org_d_img = $__cl_logo->th_400;
					            	}else{
						            	$org_d_img = $org_b_d_img;
						            	$org_d_img_cls = '_empty';
					            	}
					            	
					            	$org_d_clr = $___Ls->dt->rw['org_clr'];
					            	
				            	}
			            		
								echo _DivLogoTM([ 'i'=>$org_d_img, 'c'=>$org_d_clr, 'cls'=>$org_d_img_cls ]);

								
								
				            ?>
			            </div>
			            <!--<button id="mod_attr_<?php echo $___Ls->id_rnd; ?>" class="btn_attr_mod _anm">Editar Atributos</button>-->
			            <?php 
				            
				            $CntWb .= "
				            
				            	$('#mod_attr_".$___Ls->id_rnd."').off('click').click(function(e){
									
									e.preventDefault();
									
									_cl_dtl = $('#__org_detail_".$___Ls->id_rnd."');
									
									if(_cl_dtl.hasClass('_mod_attr')){
										
										_cl_dtl.removeClass('_mod_attr');
										
									}else{
										
										_cl_dtl.addClass('_mod_attr');
									
										_ldCnt({ 
											u:'".Fl_Rnd(FL_DT_GN.__t('org_attr', true))."&_t2=".$___Ls->gt->tsb."', 
											c:'attr_editor".$___Ls->id_rnd."'
										});
										
									}
								});
				            ";
				            
			            ?>
			            
			            <?php if($___Ls->dt->tot > 0){ ?>
							<div id="__org_tp_slc" class="__org_tp_slc_bx"></div>
						<?php } ?>
							
			        </div>
	            </section> 
				
				
				<div class="TabbedPanelsContent">
					<?php if($___Ls->dt->tot > 0){$_cols = 3;}else{$_cols = 2;} ?>
					
					<div class="ln_1 colx<?php echo $_cols; ?>">
						
						<?php if($___Ls->dt->tot != 1){  ?>
						
						<div class="__sch_json_tt">
							<?php echo h1(TX_NW.' '.$_org_tp->tt); ?>
						</div>
						
						<div class="__sch_json" id="__sch_json">
							<div class="_c1">								
								<?php echo '<div class="_sl"><select id="'.$___Ls->fm->id.'_nm_sch" name="'.$___Ls->fm->id.'_nm_sch" class="required"></select></div>'; ?> 
								<?php $CntWb .= " SUMR_Main.slc_sch({ id:'".$___Ls->fm->id."_nm_sch', ph:'- ingresa un nombre, pagina web o id -', t:'org' });"; ?>
							</div>	
					    </div> 
						<div class="__sch_json_note">Nota: Antes de ingresar un(a) nuevo(a) <?php echo Strn($_org_tp->tt) ?> verifica que no exista, <br> a través del buscador usando el dominio de la pagina web, nombre o documento de relación.</div>
							
				    	<?php } ?>
				    			    										    	
				    	<div class="col_1">
					    	<div class="_new">
					          	<?php
						          	
						          	echo HTML_inp_hd('org_enc', NULL);
						          	echo HTML_inp_tx('org_nm', TX_NM, ctjTx($___Ls->dt->rw['org_nm'],'in'), FMRQD);
								  	echo HTML_inp_tx('org_dir', TX_ADRS, ctjTx($___Ls->dt->rw['org_dir'],'in'), '');
							  		echo LsCdOld([ 'id'=>'org_cd', 'v'=>'id_siscd', 'va'=>$___Ls->dt->rw['org_cd'], 'rq'=>1 ]);

									$CntWb .= JQ_Ls('org_cd',FM_LS_SLCD);
									
									$l = __Ls([
											'k'=>'tel',
											'id'=>'orgsdstel_tp',
											'ph'=>TX_TYPPHN,
											'va'=>$___Ls->dt->rw['orgsdstel_tp']
									]);
									
									echo $l->html; $CntWb .= $l->js;
									
									echo HTML_inp_tx('orgsdstel_tel', TX_TEL , ctjTx($___Ls->dt->rw['orgsdstel_tel'],'in'), '');
									
									/*$l = __Ls(['k'=>'emp_scec',
												'id'=>'emp_scec',
												'ph'=>TX_SCT_EMP,
												'va'=>$___Ls->dt->rw['orgdc_tp']
											]);
									echo $l->html; $CntWb .= $l->js; */
									
									echo HTML_inp_clr([ 'id'=>'org_clr', 'plc'=>TX_NM_CL, 'vl'=>$___Ls->dt->rw['org_clr'] ]);
									
								?>
					    	</div>
							<div class="_mod _dts">
								<ul id="_dtll1" class="ls_1"></ul>
							</div>
							<div class="ls_1 __org <?php echo $_cls ?> __edt_dtl" id="dtll3">
								
								<?php 
									
									$___js_avnc = _Kn_Prcn([ 'id'=>Gn_Rnd(5).'_avnc', 'w'=>'100', 'di'=>'ok', 'ds'=>'0.01', 'dt'=>'10', 'v'=>$_org_dt->cmpl->p, 'bclr'=>'bfc6c7' ]); 	
								
									echo '<div class="info_fll">
											<div class="__avnc_l_big">'.$___js_avnc->html.'</div>
											<div class="__tt">Información <div class="__sbt">Completa</div></div>
										</div>';
									
									$CntWb .= $___js_avnc->js;
									
									
								?>
								
								<a href="<?php echo Void(); ?>" class="___edt_btn"><?php echo TX_EDIT; ?></a>
								
							 
						            
					            <?php 
									$CntWb .= '$(".___edt_btn").click(function(){ 
													$(".__edt_dtl").fadeOut("fast", function(){
														$(".__edt").fadeIn();	
													});
												}); ';
								?>	
								
								<?php echo h2(TX_DTSBSC) ?>
								
								<?php if(!isN($___Ls->dt->rw['org_nm'])){ ?><li class="" id="_li_nm"><?php echo Strn(TX_NM,'',true).ctjTx($___Ls->dt->rw['org_nm'],'in'); ?></li><?php } ?>
								<?php if(!isN($___Ls->dt->rw['org_dir'])){ ?><li class="" id="_li_nm"><?php echo Strn(TX_DIRC,'',true).ctjTx($___Ls->dt->rw['org_dir'],'in'); ?></li><?php } ?>
								<?php if(!isN($___Ls->dt->rw['org_web'])){ ?><li class="" id="_li_nm"><?php echo Strn(TX_WEB,'',true).$___Ls->dt->rw['org_web']; ?></li><?php } ?>
								
								<?php echo h2(TX_OTHDT) ?>
								<?php if($__t2 == 'clg'){ ?>
									<li id="_li_nm"><?php echo Strn(TX_RDM,'',true).__LsDt(['k'=>'ls_rdm','id'=>$___Ls->dt->rw['orgattr_rdm']])->d->tt; ?></li>
									<li id="_li_nm"><?php echo Strn(TX_NVS,'',true).__LsDt(['k'=>'nvs','id'=>$___Ls->dt->rw['orgattr_nvs']])->d->tt; ?></li>
									<li id="_li_nm"><?php echo Strn(TX_TP_CLG,'',true).__LsDt(['k'=>'tp_clg','id'=>$___Ls->dt->rw['orgattr_tp']])->d->tt; ?></li>
									<li id="_li_nm"><?php echo Strn(TX_NVL_ATC,'',true).__LsDt(['k'=>'nvl_atc','id'=>$___Ls->dt->rw['orgattr_nva']])->d->tt; ?></li>
									<li id="_li_nm"><?php echo Strn(TX_PRTFL,'',true).__LsDt(['k'=>'pft','id'=>$___Ls->dt->rw['orgattr_prtf']])->d->tt; ?></li>
									<li id="_li_nm"><?php echo Strn(TX_SIZE,'',true).__LsDt(['k'=>'org_tmn','id'=>$___Ls->dt->rw['orgattr_tmn']])->d->tt; ?></li>
									<li  id="_li_nm"><?php echo Strn(TX_NTZ,'',true).__LsDt(['k'=>'org_ntz','id'=>$___Ls->dt->rw['orgattr_ntz']])->d->tt; ?></li>
									<li id="_li_nm"><?php echo Strn(TX_FCH_BNF,'',true).$___Ls->dt->rw['orgattr_fch_bnf']; ?></li>		
								<?php } ?>
								
								
								<?php
									$_eml = explode(",", $___Ls->dt->rw['_eml']); $i_eml = 1;
									foreach($_eml as $_v_eml){
										if(!isN($_v_eml)){ ?><li class="" id="_li_nm"><?php echo Strn(TX_EML."-".$i_eml,'',true).ctjTx($_v_eml, 'in'); ?></li><?php $i_eml++; }
									}
								
									$_tel = explode(",", $___Ls->dt->rw['_tel']); $i_tel = 1;
									foreach($_tel as $_v_tel){
										if(!isN($_v_tel)){ ?><li class="" id="_li_nm"><?php echo Strn(TX_TEL."-".$i_tel,'',true).ctjTx($_v_tel, 'in'); ?></li><?php $i_tel++; }
									}
								
									$_dc = explode(",", $___Ls->dt->rw['_dc']); $i_dc = 1;
									foreach($_dc as $_v_dc){
										if(!isN($_v_dc)){ ?><li class="" id="_li_nm"><?php echo Strn(TX_DC."-".$i_dc,'',true).ctjTx($_v_dc, 'in'); ?></li><?php $i_dc++; }
									}
									
									$_web = explode(",", $___Ls->dt->rw['_web']); $i_web = 1;
									foreach($_web as $_v_web){
										if(!isN($_v_web)){ ?><li class="" id="_li_nm"><?php echo Strn(TX_WEB."-".$i_web,'',true).ctjTx($_v_web, 'in'); ?></li><?php $i_web++; }
									}
								?>
								
								
							</div>
							<ul class="ls_1 __org <?php echo $_cls ?> __edt" id="dtll3" style="display: none">

								<?php 
								
									if(ChckSESS_superadm() || _ChckMd('org_mod')){
										
										echo HTML_inp_hd('org_enc_mod', $___Ls->dt->rw['org_enc']);
										echo HTML_inp_tx('org_nm_mod', TX_NM, ctjTx($___Ls->dt->rw['org_nm'],'in'), FMRQD);
									  	echo HTML_inp_tx('org_dir_mod', TX_ADRS, ctjTx($___Ls->dt->rw['org_dir'],'in'), '');
								  		echo LsCdOld([ 'id'=>'org_cd_mod', 'v'=>'id_siscd', 'va'=>$___Ls->dt->rw['org_cd'], 'rq'=>1 ]);
										$CntWb .= JQ_Ls('org_cd_mod',FM_LS_SLCD);
										echo HTML_inp_clr([ 'id'=>'org_clr_mod', 'plc'=>TX_NM_CL, 'vl'=>$___Ls->dt->rw['org_clr'] ]);
										
										if(ChckSESS_superadm()){
											echo OLD_HTML_chck('org_vrf', 'Verificado', $___Ls->dt->rw['org_vrf'], 'in'); 		
										}

										echo OLD_HTML_chck('org_est', 'Estado', $___Ls->dt->rw['org_est'], 'in'); 

										if($__t2 == 'clg'){
											
											echo h2('Atributos');
										
											echo HTML_inp_hd('org_clg_attr', 1);
											$l = __Ls(['k'=>'ls_rdm','id'=>'orgattr_rdm','ph'=>TX_RDM,'va'=>$___Ls->dt->rw['orgattr_rdm'],'fcl'=>'ok', 'rq' => 2]); echo $l->html; $CntWb .= $l->js;
											$l = __Ls(['k'=>'nvs','id'=>'orgattr_nvs','ph'=>TX_NVS,'va'=>$___Ls->dt->rw['orgattr_nvs'],'fcl'=>'ok', 'rq' => 2]); echo $l->html; $CntWb .= $l->js;
											$l = __Ls(['k'=>'tp_clg','id'=>'orgattr_tp','ph'=>TX_TP_CLG,'va'=>$___Ls->dt->rw['orgattr_tp'],'fcl'=>'ok', 'rq' => 2]); echo $l->html; $CntWb .= $l->js;
											$l = __Ls(['k'=>'nvl_atc','id'=>'orgattr_nva','ph'=>TX_NVL_ATC,'va'=>$___Ls->dt->rw['orgattr_nva'],'fcl'=>'ok', 'rq' => 2]); echo $l->html; $CntWb .= $l->js;
											$l = __Ls(['k'=>'pft','id'=>'orgattr_prtf','ph'=>TX_PRTFL,'va'=>$___Ls->dt->rw['orgattr_prtf'],'fcl'=>'ok', 'rq' => 2]); echo $l->html; $CntWb .= $l->js;
											$l = __Ls(['k'=>'org_tmn','id'=>'orgattr_tmn','ph'=>TX_SIZE,'va'=>$___Ls->dt->rw['orgattr_tmn'],'fcl'=>'ok', 'rq' => 2]); echo $l->html; $CntWb .= $l->js;
											$l = __Ls(['k'=>'org_ntz','id'=>'orgattr_ntz','ph'=>TX_NTZ,'va'=>$___Ls->dt->rw['orgattr_ntz'],'fcl'=>'ok', 'rq' => 2]);echo $l->html; $CntWb .= $l->js;
											echo SlDt(['id'=>'orgattr_fch_bnf','va'=>$___Ls->dt->rw['orgattr_fch_bnf'],'lmt'=>'no','yr'=>'ok','mth'=>'ok','rq'=>'no','ph'=>TX_FCH_BNF]);
												
										}
									
									}
									
								?>
							</ul>	
				      	</div>

						<?php if($___Ls->dt->tot > 0 && ($___Ls->gt->tsb == 'marks' || $___Ls->gt->tsb == 'clg')){ 
							$class = 'grph_col2'; 
						}else{ 
							$class = ''; 
						} ?>

					  	<div class="col_2 <?php echo $class; ?> ">
						  	<div class="_new">
						  		<?php
							  		$l = __Ls([
							  					'k'=>'orgsdsdc_tp',
												'id'=>'orgsdsdc_tp',
												'ph'=>TX_DC_TP,
												'va'=>$___Ls->dt->rw['orgsdsdc_tp'],
												'cls'=>'orgsdsdc_dc_'.$__t2,
												'slc'=>[ 
													'opt'=>[
														'attr'=>[
															'itm-key'=>'key',
															$__t2=>$__t2												
														]	
													] 
												]
											]);
											
									echo $l->html; $CntWb .= $l->js;
									
									echo HTML_inp_tx('orgsdsdc_dc', TX_DC , ctjTx($___Ls->dt->rw['orgsdsdc_dc'],'in'), '');
									echo HTML_inp_tx('orgsdseml_eml', TX_EML , ctjTx($___Ls->dt->rw['orgsdseml_eml'],'in'), '');
									echo HTML_inp_tx('orgweb_web', TX_WEB , ctjTx($___Ls->dt->rw['orgweb_web'],'in'), '');
									
									echo HTML_inp_hd('org_tp', $___Ls->gt->tsb );
						  		?>
						  	</div>
						  	<div class="_mod _dts">
								<ul id="_dtll2" class="ls_1"></ul>
							</div>

							<?php include('org_dsh.php'); ?>

				    	</div>
						
						
				    </div>
				</div>
				
	            <?php
	                	
	                if(!isN($_org_tabs_ord)){	
						foreach($_org_tabs_ord as $_k_tabs => $_v_tabs){
							if($_v_tabs->{$___Ls->gt->tsb}->vl){	
								if($_v_tabs->key->vl != "dtbsc"){
									echo "<div class='TabbedPanelsContent'>".$___Ls->tab->{$_v_tabs->key->vl}->d."</div>";
								}
							}
						}
					} 
					
					if($__t2 == 'marks'){ ?>
						<div class="TabbedPanelsContent">
						    <?php echo $___Ls->tab->org_sds_pass->d; ?>
					    </div>	
					<?php }

            	?>
                  
            </div>
		</div>
		
        <?php 
										    	
	    	$CntWb .= "
	    	
	    		var _sch_bx = $('#__sch_json');
                var _sch_lead = $('#".$___Ls->fm->id."_nm_sch');

				setTimeout(function(){ 
					_ldCnt({ 
						u:'".Fl_Rnd(FL_LS_GN.__t('org_tp',true))."".ADM_LNK_SB.$___Ls->dt->rw[$___Ls->ik].$___Ls->dt->vrall."',
						c:'__org_tp_slc', 
						trs:false
					});
				}, 300);	

				$('#".$___Ls->fm->id."_nm_sch').change(function(e) {
					__sch_lst = $(this).val();
					__sch_cnt();	
				});

                function __rsz_dsh(p){
                    if(!isN(p) && !isN(p.t) && p.t == 'fll'){
                    	$.colorbox.resize({ width:'600', height:'580' });
                    }else{    
                        $.colorbox.resize({ width:'".$___Ls->edit->w."', height:'".$___Ls->edit->h."' });
                	} 
                }

                function __sch_cnt(){	
                    
                    var __q = _sch_lead.val();
                    
					if(_sch_lead.valid()){
							
                		_sch_lead.val(__q);
					
                    	_Rqu({ 
                        	
							t:'org', 
							enc:$('#".$___Ls->fm->id."_nm_sch').val(),
							_bs:function(){ _sch_bx.addClass('__ld'); },
							_cm:function(){ _sch_bx.removeClass('__ld'); },
							_cl:function(d){
								
								if(!isN(d)){
									
									var _vl = $('#".$___Ls->fm->id."_nm_sch').val();
									
									try{
                                   
										if(d.e == 'ok'){
		                                    
		                                    $('._tb_pnl').addClass('_hd');
											$('#".$___Ls->fm->id."_nm_sch').hide();
											
											$('#org_enc').val(d.enc);
											$('.__cnt_dtl').addClass('_exist');
											
											$('#_dtll1').html('
                                            	".h2('Datos Basicos')."
                                            	<li id=\"_li_nm\">".Strn(TX_TT, '' ,true)." '+d.nm+' </li>
                                            	<li id=\"_li_nm\">".Strn(TX_CLR, '' ,true)." '+d.clr+' </li>
                                            	<li id=\"_li_nm\">".Strn(TX_ADRS, '' ,true)." '+d.dir+' </li>
                                            ');
                                            
                                            $('#_dtll2').html('
                                            	".h2('Otros Datos')."
                                            ');
                                            
                                            $.each(d._dc, function(k_dc, v_dc) {
												if(!isN(v_dc)){
													$('#_dtll2').append('<li id=\"_li_nm\">".Strn(TX_DC, '' ,true)." '+v_dc+' </li>');
											    }
											});
											
											$.each(d._tel, function(k_tel, v_tel) {
												if(!isN(v_tel)){
													$('#_dtll2').append('<li id=\"_li_nm\">".Strn(TX_TEL, '' ,true)." '+v_tel+' </li>');
											    }
											});
											
											$.each(d._eml, function(k_eml, v_eml) {
												if(!isN(v_eml)){
													$('#_dtll2').append('<li id=\"_li_nm\">".Strn(TX_EML, '' ,true)." '+v_eml+' </li>');
											    }
											});
											
											$.each(d._web, function(k_web, v_web) {
												if(!isN(v_web)){
													$('#_dtll2').append('<li id=\"_li_nm\">".Strn(TX_WEB, '' ,true)." '+v_web+' </li>');
											    }
											});
											
											$('.TabbedPanelsTab').removeClass('_othr');
											$('._mod').removeClass('_dts');

                                        }else if(d.e == 'no'){ 

	                                        $('.ln_1 ._new').removeClass('_new'); 
	                                    	
	                                    	__rsz_dsh({ t:'fll' });
	                                    	
	                                    	var __fllv = SUMR_Main.slc.sch;
	                                    	
			                            	if(isNmb(__fllv)){ console.log('Is a Number');
				                         		if(__fllv.length == 10 && __fllv.charAt(0) == '3'){ var _cls_t='orgsdstel_tel'; }else{ var _cls_t='orgsdsdc_dc'; }
				                         		$('#'+_cls_t).val(__fllv);
			                            	}else if(isUrl(__fllv) || __fllv.includes('.')){ console.log('Is a URL');
				                            	$('#orgweb_web').val(__fllv);
			                            	}else{ console.log(__fllv+' Is a Name');
				                            	$('#org_nm').val(__fllv);
			                            	}
	                                    	
                                        }
                                   
									}catch(e) {
										
										SUMR_Main.log.f({ t:'Error en _Rqu', m:e });
										
									}
									
                                    $('#".$___Ls->fm->id." .Tt_Tb').show();
                                    $('.__sch_json, .__sch_json_note, .__sch_json_tt').addClass('_cls');
                                    $('.__org_detail').addClass('_new_fill');
                                    
								}
							} 
						});
					}
				}
			";
			
		?>
		
        <style>
	        
	        :root{   
		        --cl-dt-clr:<?php echo $___Ls->dt->rw['org_clr']; ?>;   
	        }
	        
	        .__org_detail._new .bnr__logo ._im{ background-size: auto 50%; width: 150px; height: 150px; }
	        .__org_detail ._ovrmap_logo .bnr__logo._empty ._im{  background-size: auto 50%; -webkit-filter: grayscale(100%); filter: grayscale(100%); opaci }
	        
	        
	        .__org_detail._new ._ovrmap_logo{  }
	        .__org_detail._new .bnr__logo{ min-height: 130px; max-height: 130px; }
	        
	        
	        .__org_detail._new ._ovrmap_emp .__org_tp_slc_bx{ display: none; }
	        
	        .__org_detail._new .VTabbedPanels.mny > ul.TabbedPanelsTabGroup{ display: none; }
	        .__org_detail._new .VTabbedPanels.mny > div.TabbedPanelsContentGroup{ width: 100%; border: none; }
	        

	        
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3{ display: flex; }
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_1,
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2,
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_3{ width: 33% }
	        
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_3 h2{ margin-bottom: 60px; }
	        
	        
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_1{ padding-left: 20px; }
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2{ border-right: 1px dotted #CCC; padding-right: 20px; }
	        
	        
	        
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3  .ls_rsmn{ display: flex; padding: 0 6px;margin-top: 25px;margin-bottom: 15px; align-content: center;list-style-type: none; }
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3  .ls_rsmn li{ border: 1px dashed #e6e9ea; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; padding: 30px 20px; width: 32.3%; margin-right:1%; text-align: center !important; }
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3  .ls_rsmn li:last-child{ margin-right: 0px; }
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3  .ls_rsmn li strong{ font-weight: 700; color: var(--cl-dt-clr); display: block; width: 100%; text-align: center; font-family: Economica; font-weight: 300; font-size: 30px; }
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3  .ls_rsmn li strong::before{ display: inline-block; width: 25px; height: 25px; margin-right: 3px; margin-bottom: -3px; background-position: center center; background-size: auto 90%; background-repeat: no-repeat; }
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3  .ls_rsmn li span{ font-family: Economica; font-weight: 300; font-size: 16px; color: #aaadae; }
	        
	        
	        
	        
	        
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2 .ls_rsmn.buy_rsmn{ margin-top: 25px; margin-bottom: 15px; }
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2 .ls_rsmn.buy_rsmn li{  }
	        
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2 .ls_rsmn.acdmc_rsmn{ margin-top: 40px; }
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2 .ls_rsmn.acdmc_rsmn li{ width: 24%; }
	        
	        
	        
	        
	        /*.__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2 .ls_rsmn.buy_rsmn li.est_act strong::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_clg_estact.svg); } 
			.__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2 .ls_rsmn.buy_rsmn li.est_egr strong::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_clg_estegr.svg); } 
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2 .ls_rsmn.buy_rsmn li.est_vip strong::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_clg_estvip.svg); } */
	        
	        
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2 .ls_rsmn.acdmc_rsmn li strong::before{ opacity: 0.3; }
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2 .ls_rsmn.acdmc_rsmn li.clg_enf strong::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_clg_acdmc_enf.svg); } 
			.__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2 .ls_rsmn.acdmc_rsmn li.clg_lng strong::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_clg_acdmc_lng.svg); } 
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2 .ls_rsmn.acdmc_rsmn li.clg_bch strong::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_clg_acdmc_bch.svg); }
	        .__org_detail .VTabbedPanels.mny .ln_1.colx3 .col_2 .ls_rsmn.acdmc_rsmn li.clg_exm strong::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_clg_acdmc_exm.svg); } 
	        
	        
	         
	         
	        .__org_detail._new:not(._new_fill) .VTabbedPanels.mny .ln_1 .col_1,
	        .__org_detail._new:not(._new_fill) .VTabbedPanels.mny .ln_1 .col_2,
	        .__org_detail._new:not(._new_fill) .VTabbedPanels.mny .ln_1 .col_3{ display: none; }
	        
	       
	       
	        
	        
	        .__org_detail .VTabbedPanels.mny{ display: flex; }
	        .__org_detail .VTabbedPanels.mny > ul.TabbedPanelsTabGroup._tb_pnl._hd{ display: none!important; }
	        .__org_detail .VTabbedPanels.mny > ul.TabbedPanelsTabGroup{ background-color: white; width: 53px !important;  }
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup{ border-left: 1px dotted #bcbfbf; width: 100%; }
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .TabbedPanelsContent{ padding-top: 30px; }
	        .__org_detail .VTabbedPanels.mny > ul.TabbedPanelsTabGroup ._tab{ background-size: 55%!important; }
	        .__org_detail .VTabbedPanels .Tt_Tb .btn{ margin-right: 0 !important; }
	        
	        
	        ._othr{ display: none!important; }
	        
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .__sch_json{ width: 50%; margin: auto; margin-top: 2%; }
	        
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .__sch_json._cls,
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .__sch_json_note._cls,
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .__sch_json_tt._cls{ display: none; }
	        
	        
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .__sch_json ._c2{ right: 25%;  margin-top: 2%; }
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .__sch_json_tt{}
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .__sch_json_tt h1{ margin: 0; padding: 0; border: none; }
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .__sch_json_note{ display: block; width: 100%; text-align: center; color: #bfbdbd; margin-top: 50px; font-size: 10px; }
	        
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup ._dts{ display:none; }
	        
	        
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .col_1 ._new{ display: none!important; }
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .col_2 ._new{ display: none!important; }
	        .__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .col_3 ._new{ display: none!important; }
	        
	        /*.__org_detail .VTabbedPanels.mny > div.TabbedPanelsContentGroup .col_2{ display: none; }*/
	        
	        
	        .__org_detail .VTabbedPanels .TabbedPanelsTab{ background-size: 60% auto; background-position: center center; min-height: 40px; min-width: 40px; max-width: 40px; background-repeat: no-repeat; opacity: 0.3; } 
	        .__org_detail .VTabbedPanels .TabbedPanelsTabSelected,
	        .__org_detail .VTabbedPanels .TabbedPanelsTabHover{ opacity: 1; background-color: <?php echo $org_d_clr; ?> !important; }
	        .__org_detail .VTabbedPanels .TabbedPanelsTab:first-child{ background-color:var(--cl-dt-clr) !important; background-image: url(<?php echo $__cl_logo->th_400; ?>); background-size: 100% auto; opacity: 1; }
	        .__org_detail .VTabbedPanels .TabbedPanelsTab._tt_icn_oth{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_oth.svg); }
	        .__org_detail .VTabbedPanels .TabbedPanelsTab._tt_icn_dc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_dc.svg); }
	        .__org_detail .VTabbedPanels .TabbedPanelsTab._tt_icn_tel{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_tel.svg); }
	        .__org_detail .VTabbedPanels .TabbedPanelsTab._tt_icn_eml{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_eml.svg); }
	        .__org_detail .VTabbedPanels .TabbedPanelsTab._tt_icn_hme{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_hme.svg); background-size: 25px!important; }
	        .__org_detail .VTabbedPanels .TabbedPanelsTab._tt_icn_us{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_us.svg); }
	        .__org_detail .VTabbedPanels .TabbedPanelsTab._tt_icn_org_sds_pass{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cnt_sec.svg); }
			.__org_detail .VTabbedPanels .TabbedPanelsTab._tt_icn_scec{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>precio.svg); }

			.__org_detail .VTabbedPanels .TabbedPanelsTabSelected._tt_icn_scec{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>precio_w.svg); }
	        .__org_detail .btn_attr_mod{ border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px; padding: 10px 15px; position: absolute; right: 10px; bottom: 10px; font-weight: 400; font-size: 11px; text-transform: lowercase; cursor: pointer; border: 1px solid var(--main-bg-color); color: var(--main-bg-color); }
	        .__org_detail .btn_attr_mod:hover{ padding: 12px 17px; background-color: var(--main-bg-color); color:white; }
	         
	        .__org_detail .attr_editor{ /*border:1px solid red;*/ width: 1px; height: 1px; overflow:hidden; opacity: o;  }
	        
	        .__org_detail._mod_attr .VTabbedPanels{ display: none; }
	        .__org_detail._mod_attr .attr_editor{ display: block; width: 100%; min-height:200px; opacity: 1; }
	        .__org_detail._mod_attr .mapbck{ height: 100px !important; }
	        .__org_detail._mod_attr .bnr__logo{ min-height: 100px; max-height: 100px; }
	        .__org_detail._mod_attr .bnr__logo ._im{ width: 110px; height: 110px; }
	        
	        
	        .__org_detail ._ovrmap_emp .__org_tp_slc_bx{ position: absolute; right: 5px; bottom: 10px; z-index: 1; }
	        
	        
	        .__org_detail .info_fll{ display: flex; margin-bottom: 50px; }
	        .__org_detail .info_fll .__avnc_l_big{ position: relative; width: 55%; height: 100px; margin-left: auto; margin-right: 0; text-align: right;  }
	        .__org_detail .info_fll .__avnc_l_big > div{ position: relative; margin-right: 0; margin-left: auto; display: block !important; }
	        .__org_detail .info_fll .__avnc_l_big input[type=text]{ position: absolute !important; left: 0; top: 23px; text-align: center !important; width: 100% !important; margin: 0 !important; font-family: Economica !important; font-weight: 100 !important; font-size: 50px !important; height: 50px !important;  }
	        
	        
	        .__org_detail .info_fll .__tt{ width: 45%; font-family: Economica; font-size: 20px; font-weight: 300; color: #4b4747; text-transform: uppercase; text-align: left; line-height: 20px; padding-left: 15px; padding-top: 25px; }
	        .__org_detail .info_fll .__tt .__sbt{ font-size: 27px; color: #b3b8bc; }
	        
	        .col_2.grph_col2 {
				width: 66% !important;
				border-right: 0px dotted #CCC !important;
			}
			.grph_col2 ul li { width: 100% !important  }
			/*.grph_col2 ul.ls_rsmn.buy_rsmn {
				width: 250px !important;
				height: fit-content;
				margin-right: 20px !important;
			}*/
	        .grph_col2 #bx_org_marks_1,
			.grph_col2 #bx_org_marks_2,
			.grph_col2 #bx_org_marks_3{width: calc(100% - 270px);}
			.grph_col2 ul.ls_rsmn.buy_rsmn li{ display: block }


			/*.grph_col2 ul.ls_rsmn.buy_rsmn li.est_act strong::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_marks_price.svg) !important;   }
			.grph_col2 ul.ls_rsmn.buy_rsmn li.est_egr strong::before{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>org_marks_walk.svg) !important;   }*/
			.items_info{ display: flex }
        </style>
        
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php } ?>

<style>
	.cont_grph i{width: 30px;height: 30px;display: inline-block;background-repeat: no-repeat;background-position: center;background-size: 100% auto;}
	.cont_grph strong{ display: inline-block !important;width: auto !important;margin-left: -25px !important; }

	.cont_grph{ position:relative; }
	.__chld_1 li{width:100% !important;}
	.__chld_2 li{width:50% !important;}
	.__chld_3 li{width:33.3% !important;}
	.__chld_4 li{width:25% !important;}
	.__chld_5 li{width:20% !important;}
</style>