<?php
	
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'id_bco, bco_img, bco_org, bco_ext';
	$___Ls->flt = 'ok';
	$___Ls->new->w = 500;
	$___Ls->new->h = 350;
	$___Ls->edit->w = 600;
	$___Ls->edit->h = 600;
	//$___Ls->ls->lmt = 300;
	
	$___Ls->upl_f='ok';
	
	if(_ChckMd('bco_grph')){
		$___Ls->grph->h = 'mny';
		$___Ls->grph->tot = 1;
	}
	
	$___Ls->sch->m = ' || (
		id_bco IN (	SELECT bcotag_bco FROM '._BdStr(DBM).TB_BCO_TAG.' WHERE bcotag_tag_es LIKE \'%[-SCH-]%\' || 
																bcotag_tag_en LIKE \'%[-SCH-]%\' ||
																bcotag_tag_it LIKE \'%[-SCH-]%\' ||
																bcotag_tag_fr LIKE \'%[-SCH-]%\' ||
																bcotag_tag_gr LIKE \'%[-SCH-]%\' ||
																bcotag_tag_krn LIKE \'%[-SCH-]%\' ||
																bcotag_tag_jpn LIKE \'%[-SCH-]%\' ||
																bcotag_tag_ptg LIKE \'%[-SCH-]%\' ||
																bcotag_tag_mdn LIKE \'%[-SCH-]%\'
					)
	)';
	
	$___Ls->_strt();	
	
	$_Bco_Chk_Org = "(SELECT COUNT(*)FROM "._BdStr(DBM).TB_BCO_CHK." WHERE bcochk_bco = id_bco AND bcochk_chktp = 1 LIMIT 1) AS _img_org,";
	$_Bco_Chk_Md = "(SELECT COUNT(*) FROM "._BdStr(DBM).TB_BCO_CHK." WHERE bcochk_bco = id_bco AND bcochk_chktp = 2 LIMIT 1) AS _img_md,";
	$_Bco_Chk_Bg = "(SELECT COUNT(*) FROM "._BdStr(DBM).TB_BCO_CHK." WHERE bcochk_bco = id_bco AND bcochk_chktp = 3 LIMIT 1) AS _img_bg,";
	$_Bco_Chk_Th = "(SELECT COUNT(*) FROM "._BdStr(DBM).TB_BCO_CHK." WHERE bcochk_bco = id_bco AND bcochk_chktp = 4 LIMIT 1) AS _img_th";
	
	
	if(!isN($___Ls->gt->i)){
		
		$_BcoAre = ",(SELECT GROUP_CONCAT(bcoare_are) FROM "._BdStr(DBM).TB_BCO_ARE." WHERE bcoare_bco = id_bco ) AS _are, ";
		$_BcoCd = "(SELECT GROUP_CONCAT(bcocd_cd) FROM "._BdStr(DBM).TB_BCO_CD."  WHERE bcocd_bco = id_bco ) AS _cd, ";
 
		$___Ls->qrys = sprintf("	SELECT  * $_BcoAre $_BcoCd $_Bco_Chk_Org $_Bco_Chk_Md $_Bco_Chk_Bg $_Bco_Chk_Th 
									FROM ".TB_BCO." 
										 LEFT JOIN ".TB_CL_FTP_SVC." ON bco_out = id_clftpsvc 
									WHERE ".$___Ls->ino." = %s 
									LIMIT  1", 
									
							GtSQLVlStr($___Ls->gt->i, "text"));
							
					//echo $___Ls->qrys; 		
					
	}elseif($___Ls->_show_ls == 'ok'){	
		
		if($___Ls->_fl->bcotag_chk == 1){ $___Ls->qry_f .= " AND id_bco IN ( SELECT bcotag_bco FROM "._BdStr(DBM).TB_BCO_TAG." WHERE bcotag_tag_es IS NOT NULL AND bcotag_tag_es != '' ) "; }
		
		if(!ChckSESS_superadm()){ 
			$__fl .= "bco_est = '"._CId('ID_SISBCOEST_ACTV')."' AND"; 
		}

		if(!isN($___Ls->_fl->fk->clare_enc)){ 

			if(is_array($___Ls->_fl->fk->clare_enc)){
				$__all_are = implode(',', $___Ls->_fl->fk->clare_enc);
			}else{
				$__all_are = "'".$___Ls->_fl->fk->clare_enc."'";
			}
			
			$___Ls->qry_f .= ' AND id_bco IN ( SELECT bcoare_bco
										FROM '._BdStr(DBM).TB_BCO_ARE.' 
											INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON bcoare_are = id_clare
										WHERE clare_enc IN ('.$__all_are.') AND clare_est = 1
									) ';					
			
		}

		if(!isN($___Ls->_fl->f1) && !isN($___Ls->_fl->f2)){ 
			$___Ls->qry_f .= ' AND DATE_FORMAT(bco_fi, "%Y-%m-%d") BETWEEN "'.$___Ls->_fl->f1.'" AND "'.$___Ls->_fl->f2.'" '; 
		}elseif(!isN($___Ls->_fl->f1)){
			$___Ls->qry_f .= ' AND DATE_FORMAT(bco_fi, "%Y-%m-%d")  = "'.$___Ls->_fl->f1.'" ';
		}elseif(!isN($___Ls->_fl->f2)){
			$___Ls->qry_f .= ' AND DATE_FORMAT(bco_fi, "%Y-%m-%d")  = "'.$___Ls->_fl->f2.'" '; 
		}

		if(!ChckSESS_superadm() && !_ChckMd('bco_are_all') && defined('SISUS_ARE') && !isN(SISUS_ARE) ){ 
			$__fl .= " id_bco IN(
							SELECT
								id_bco
							FROM
								"._BdStr(DBM).TB_BCO."
							LEFT JOIN "._BdStr(DBM).TB_BCO_ARE." ON bcoare_bco = id_bco
							WHERE
								bcoare_are IN(".SISUS_ARE.", 64) OR id_bcoare IS NULL
					) AND ";
		}
		
		
		
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_BCO." 
						 INNER JOIN "._BdStr(DBM).TB_CL." ON bco_cl = id_cl
						 LEFT JOIN "._BdStr(DBM).TB_CL_FTP_SVC." ON bco_out = id_clftpsvc 
						 $__bd1
					WHERE ".$___Ls->ino." != '' ".$___Ls->qry_f." ".$___Ls->sch->cod." AND 
						  $__fl 
						  cl_enc = '".DB_CL_ENC."' 
						  
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT 	(	SELECT COUNT(*) 
									FROM "._BdStr(DBM).TB_BCO_TAG."
									WHERE bcotag_bco = id_bco /*AND bcotag_aws = 2*/
								) AS _tot_tag, 
								id_bco, bco_enc, bco_est, bco_img, clftpsvc_rmte, clftpsvc_rmte, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr"; 
 
		?> <div class="______consulta" style=" display:none "><?php echo  $___Ls->qrys; ?></div> <?php
		 
	}
	
	$___Ls->_bld();  
?>
<?php if($___Ls->ls->chk=='ok'){ ?>
<?php $___Ls->_bld_l_hdr(); 
	
	$CntWb .= "
		
		SUMR_Main.bxajx.__grph_fl = { fl:{ f:".json_encode($___Ls->c_f_g)."} };
		
		_ldCnt({ 
			u:'".Fl_Rnd(FL_GRPH_GN.__t($___Ls->gt->t, true).$_adsch.$___Ls->ls->vrall)."&_h=300&_t2=".$___Ls->gt->tsb."&_t3=".$___Ls->gt->tsb_m."&_tp=grph_1&_g_r=".$___Ls->id_rnd."' , 
			c:'bx_grph_".$___Ls->id_rnd."_1',
			d:SUMR_Main.bxajx.__grph_fl,
			trs:false, 
			anm:'no',
			_cl:function(){
			
			}
		});
	
	";
	
?>
<?php if(($___Ls->qry->tot > 0)){ ?>
<div class="Ls_Rg">
  	<div class="_GrdImg">	 
    <?php do { ?>
    <?php if($___Ls->ls->rw['_tot_tag'] == '0'){ $__cls_notag = 'notag' ; }else{ $__cls_notag = ''; } ?>
    <?php 
	    
	    if(!isN($___Ls->ls->rw['clftpsvc_rmte']) && mBln($___Ls->ls->rw['bco_out']) == 'ok'){ 
		   $_img_url = $___Ls->ls->rw['clftpsvc_rmte'];
	    }else{
		   $_img_url = DMN_FLE_BCO;
	    }

	    
	    $_img_big = $_img_url.DR_IMG_TH.'bg_'.$___Ls->ls->rw['bco_img']; 
		$_img_dwn = $_img_url.$___Ls->ls->rw['bco_img'].'?_dwn=ok';
		
		if($___Ls->ls->rw['bco_est'] == _CId('ID_SISBCOEST_INCTV')){ $__cl = " inctv"; }else{ $__cl = ""; }
    
    ?>

    <div class="_th <?php echo $__cls_notag.''.$__cl; ?>" id="_th_<?php echo $___Ls->ls->rw['id_bco'] ?>">
    	<div class="__ovly"></div> 
    	 <?php if(!isN($___Ls->ls->rw['_tot_tag'])){ ?>
	    	<div class="_tot_tag"><?php echo $___Ls->ls->rw['_tot_tag']; ?></div>
		<?php } ?> 
		<div class="_tot_tag _id_tag"><?php echo $___Ls->ls->rw['id_bco']; ?></div>	
    	<?php echo '<a href="'.$_img_big.'" title="'.$___Ls->ls->rw['id_bco'].'" class="_bco_pag _dwn"> <img class="_____ld_img" src="'.$_img_url.DR_IMG_TH.'th_'.$___Ls->ls->rw['bco_img'].'" width="150" style=""></a>'; ?>
		<h3> 
			<div style="position: relative;right: 2px; padding-left: 4px;" class="_id _anm" ><span><?php echo $___Ls->ls->rw['id_bco']; ?></span></div>
			<div style="left: 7px;position: relative;" class="_anm" >      
		        <?php $_lnktr_l = FL_LS_GN.__t('bco',true)._SbLs_ID().ADM_LNK_DT.$___Ls->ls->rw['id_bco'].$__vrall.$_adsch;
				echo HTML_Ls_Btn(['t'=>'edt', 'js'=>'ok', 'l'=> _Ls_Lnk_Rw(['l'=>$_lnktr_l, 'jv'=>'no', 'sb'=>'ok', 'r'=>$__bxrld, 'h'=>'95%', 'w'=>'95%' ]) ]); ?>   
	        </div>
			<div style="left: 7px;position: relative;" class="_anm"><?php echo HTML_Ls_Btn(['t'=>'rote', 'l'=>'javaScript:void(0)', 'cls'=>'img_rote', 'id'=>$___Ls->ls->rw['bco_enc']]); ?></div>
  			<div style="left: 7px;position: relative;" class="_anm"><?php echo HTML_Ls_Btn(['t'=>'dwn', 'l'=>$_img_dwn, 'trg'=>'_blank', 'cls'=>'_dwn_bco']);?></div>
	        <div style="left: 7px;position: relative;" class="_anm"><?php echo HTML_Ls_Btn(['t'=>'onl', 'l'=>$_img_big, 'cls'=>'_dwn _bco_pag_btn']); ?><?php $CntWb .= '$("._dwn").colorbox();'; ?></div>
  		</h3>
      <?php if(_ChckMd('bco_eli')){ ?>
      <div class="_cls"> <a href="javascript:void(0);" id="ElBtn_<?php echo $___Ls->ls->rw['id_bco'] ?>" name="ElBtn_<?php echo $___Ls->ls->rw['id_bco'] ?>" style="z-index: 99; position: relative;">x</a>
        <?php 
            $CntWb .= "
                
                $('.img_rote').off('click').click(function (){
	                
					var id_bco = $(this).attr('id');
					
					".JQ__ldCnt([ 
							'u'=>FL_FM_GN.__t('bco_rote',true).TXGN_ING.TXGN_BX.$__bxrld."&_i='+id_bco+'", 
							'c'=>$__bxrld, 
							'p'=>'ok',
							'w'=>'80%', 
							'h'=>'80%' 
						])."
				});
				
            	$('._bco_pag').colorbox({ rel:'_bco_pag' });
            	$('._bco_pag_btn').colorbox({ rel:'_bco_pag_btn' });
            	
            	$('#_th_".$___Ls->ls->rw['id_bco']."').hover(function(){
	            	$('#_th_".$___Ls->ls->rw['id_bco']." ._id_tag').show('slow');
            	});
            	
            	$('#_th_".$___Ls->ls->rw['id_bco']."').mouseover(function(){
	            	$('#_th_".$___Ls->ls->rw['id_bco']." ._id_tag').hide('slow');
            	});
            	
                $('#ElBtn_".$___Ls->ls->rw['id_bco']."').click(function() { 
	                
                    SUMR_Main.btn_eli_c({
						tp:'el',
						_c:function(){
							SUMR_Main.itm_del('".$___Ls->ls->rw['id_bco']."', 'bco');
						}
					});
                });
                
            ";
      ?>
      </div>
      <?php } ?>
    </div>
    <?php //echo $___Ls->ls->rw['id_bco']" <--  oe |"; ?>
    <?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  	</div>
</div>

<style>
	
	
	._____ld_img._noldd{ background-image: url(<?php echo IMG_NP; ?>); background-position: center center; background-repeat: no-repeat; }
	
	
	
	.Ls_Rg ._GrdImg{ margin-top: 50px; display: block; }
	.Ls_Rg ._GrdImg ._th:hover h3 {left: 0px;bottom: 0px;position: absolute;}
	
	.Ls_Rg ._GrdImg ._th h3{ height: 23px; display: flex; }
	.Ls_Rg ._GrdImg ._th h3 div {display: inline-table; height: 20px; width: 20px; top: -13px; vertical-align: top; }
	
	.Ls_Rg ._GrdImg ._th h3 div a{width: 20px;height: 20px; border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px; background-color: var(--second-bg-color); overflow: hidden;background-size: 65%;background-repeat: no-repeat;background-position: center; top: 4px;position: relative;} 
	.Ls_Rg ._GrdImg ._th h3 div a:hover{ background-color: var(--main-bg-color); }
	.Ls_Rg .ls_btn:hover span{ background-color: transparent; }
	
	/*CSS Inactivo*/
	.Ls_Rg ._GrdImg .inctv .__ovly{ background-color: rgba(255, 0, 0, 0.21) !important; position: absolute; top:0; left: 0; width: 100%; height: 100%; z-index: 10; display: block; }
	.Ls_Rg ._GrdImg ._th.inctv:hover{ border: 3px solid #c40404 !important; }
	.Ls_Rg ._GrdImg ._th.inctv h3 div a{ background-color: rgba(217, 0, 0, 0.82) !important; }
	.Ls_Rg ._GrdImg .inctv .__ovly {background-color: rgba(255, 0, 0, 0.21) !important;background-position: center;background-repeat: no-repeat;background-size: 20% auto;background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>eml_spam.svg);}
	

	._GrdImg ._tot_tag{border:2px solid #089c5c;width:18%;border-radius:200px 200px 200px 200px;position:absolute;background-color:rgba(0,0,0,0.88);border-radius:200px 200px 200px 200px;-moz-border-radius:200px;-webkit-border-radius:200px 200px 200px 200px;font-size:14px;color:#fff;font-family:Economica;width:24px;height:24px;line-height:18px}
	h3._alrt{text-align:center;font-family:Economica;color:#9e9e9e}
	span._alrt{text-align:center;font-family:Economica;color:#9e9e9e;margin:auto;display:block}
	._id_tag{border:none!important;background-color:rgba(0,0,0,0.38)!important;color:#fff!important;position:absolute!important;margin-top:50%!important;width:100%!important;border-radius:0 0 0 0!important}
	.Ls_Rg span{font-family:Economica;font-size:15px;color:#fff}
	.Ls_Rg ._GrdImg ._th a img{border-radius:7px 7px 7px 7px;-moz-border-radius:7px;-webkit-border-radius:7px 7px 7px 7px;background-color:var(--second-bg-color);overflow:hidden}
	.bco.VTabbedPanels li.TabbedPanelsTab{ opacity: 0.5; height: 50px; background-size: 50%;background-position: center center; background-repeat: no-repeat; }
	.bco.VTabbedPanels li.TabbedPanelsTab.TabbedPanelsTabSelected{ opacity: 1; background-size:65%;}
	.bco.VTabbedPanels li.TabbedPanelsTab._bsc{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>bco_are.svg);}
	.bco.VTabbedPanels li.TabbedPanelsTab._tag{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>bco_tag.svg);}
	.bco.VTabbedPanels li.TabbedPanelsTab._chr{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>bco_chr.svg);}
	.bco.VTabbedPanels li.TabbedPanelsTab._use{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>bco_use.svg);}
	.bco.VTabbedPanels li.TabbedPanelsTab._are{background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>cl_are.svg);}
	
	.pic_chrch .ls_chrc {list-style: none;padding: 0;margin: 0;text-align: right;width: 100%;}
	.pic_chrch .ls_chrc li {background-color: #f5f5f5;border-radius: 9px;-moz-border-radius: 9px;-webkit-border-radius: 9px;padding: 5px 7px;margin: 0 0 5px 3px;font-size: 10px;}
	
	
</style>
	
	
<?php $___Ls->_bld_l_pgs(); ?>
<?php } ?>
<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>
<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  	<div id="<?php  echo DV_GNR_FM ?>" class="dsh_bco face_on"> 
	  	
  	<?php 
	  	
	  	$__tabs = [
			['n'=>'tag',  't'=>'bco_tag', 'l'=>'Etiquetas'],
			['n'=>'chr',  'l'=>'Caracteristicas'],
			['n'=>'use',  'l'=>'Uso'],
			['n'=>'are',  't'=>'bco_are', 'l'=>'Area']
		];
	
		$___Ls->_dvlsfl_all($__tabs);
	  	
	  	$_bcodt = GtBcoDt([ 'id'=>$___Ls->dt->rw['id_bco'] ]);

  	?>
	  	
	  	                       
    <form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
      	<?php $___Ls->_bld_f_hdr(); ?> 

	    <div class="__cl_slc">  
		    <div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
			
		        <div class="ln_1 flx">
		          	<div class="col_1">
		          	<?php echo h3($___Ls->dt->rw['id_bco'], 'h3_id_bco', $_clr); ?> 
					<div id="ls_are<?php echo $__Rnd; ?>">
						<ul></ul>
					</div>

					<?php $CntJV .= " 

						SUMR_Bco_Hm = {
							are : $('#ls_are".$__Rnd." ul'),
							bcoare: {},
							BcoSet:function(p){
								if( !isN(p) ){
									if( !isN(p.are) ){ 
										SUMR_Bco_Hm.bcoare['ls'] = p.are.ls; 
										SUMR_Bco_Hm.bcoare['tot'] = p.are.tot; 
									}
									SUMR_Bco_Hm.Are_Html();
								}	
							},
							Are_Html:function(){
								SUMR_Bco_Hm.are.html('');
								if(SUMR_Bco_Hm.bcoare['tot'] > 0){
									$.each(SUMR_Bco_Hm.bcoare['ls'], function(k, v) {
										SUMR_Bco_Hm.are.append('<li style=\"background-color:'+v.clr+'\">'+v.nm+'</li>');
									});
								}	
							}
						};

						_Rqu({ 
							t:'bco_are', 
							_id_bco : '".$___Ls->dt->rw['bco_enc']."',
							_id_tp : 'hm',
							_cl:function(_r){
								if(!isN(_r)){
									if(!isN(_r.bco)){
										SUMR_Bco_Hm.BcoSet(_r.bco);	 			
									}
								}
							} 
						});



					"; ?>
		          	
		          	<?php 
			          	
			          	if(!isN($___Ls->dt->rw['clftpsvc_rmte']) && mBln($___Ls->ls->rw['bco_out']) == 'ok'){
						   $_img_url = $___Ls->dt->rw['clftpsvc_rmte'];
					    }else{
						   $_img_url = DMN_FLE_BCO;
					    }
			          	
		          	?>
		          	
	            	<div class="_upl_i">
		            	<div class="_pic">
			            	<img src="<?php echo $_img_url.DR_IMG_TH.'bg_'.$___Ls->dt->rw['bco_img']; ?>">
			            	<?php 
				            	if(!isN($_bcodt->fce->ls)){
					            	foreach($_bcodt->fce->ls as $_div_k=>$_div_v){
										echo html_entity_decode($_div_v->attr->div->bg->vl);
								  	}
							  	}
			            	?>
		            	</div>
	            	</div>
	            	
	            	<?php if($_bcodt->fce->tot > 0){ ?>
						<ul class="_faces">
							<li class="opt"><button class="hd_bound"></button></li>
	            		<?php foreach($_bcodt->fce->ls as $_fce_k=>$_fce_v){ ?>
							<li class="face _anm" data-fce-id="<?php echo $_fce_v->enc; ?>" data-image-big="<?php echo $_fce_v->img->main; ?>" data-image-th="<?php echo $_fce_v->img->th; ?>" style="background-image: url(<?php echo $_fce_v->img->th; ?>)"></li>	
						<?php } ?>
						</ul>
	            	<?php } ?>
	            	
	            	
	            	<div id="_upl_fle" style="display: none!important;"></div>
	            	
	            	
	          </div>
	          <div class="col_2"> 
		          		
		          		
		          		<?php
			          		$___Ls->inotp_use = 'bco_use';
				            $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."', {defaultTab:0}); ";
						?>
					
			            <div id="<?php echo $_id_tbpnl ?>" class="VTabbedPanels mny bco">
			                  <ul class="TabbedPanelsTabGroup">
				                  	<?php echo $___Ls->tab->bsc->l ?>
			                        <?php echo $___Ls->tab->are->l ?>
			                        <?php echo $___Ls->tab->tag->l ?>
			                        <?php echo $___Ls->tab->chr->l ?>
			                        <?php echo $___Ls->tab->use->l ?>
			                  </ul>
			                  <div class="TabbedPanelsContentGroup">
			                        <div class="TabbedPanelsContent _bsc"> 
				                     	
				                     	<?php /*echo h3(TX_ARE, '', $_clr);*/ ?>
									 	<?php echo HTML_inp_hd('id_bco',  $___Ls->dt->rw['id_bco']); ?>
									 	<?php 	
											 	/*echo LsClAre([
															 	'id'=>'bcoare_are',
															 	'v'=>'id_clare',
															 	'va'=>$___Ls->dt->rw['_are'],
															 	'rq'=>1,
															 	'mlt'=>'ok'
															]); 
											 	
											 	$CntWb .= JQ_Ls('bcoare_are',MDL_CL_ARE); */
										 
										?> 
				                        <?php
					                        echo LsCdOld(['id'=>'bco_cd','v'=>'id_siscd','va'=>$___Ls->dt->rw['_cd'],'rq'=>2,'mlt'=>'ok']); 
					                        $CntWb .= JQ_Ls('bco_cd',FM_LS_SLCD);
					                    ?> 
									 	<?php echo h3(TX_DSC, '', $_clr); ?>
									 	<?php echo HTML_inp_tx('bco_dsc', TX_DSC, ctjTx($___Ls->dt->rw['bco_dsc'],'in')); ?> 				                        
			                        </div>    
			                        <div class="TabbedPanelsContent">

										<?php echo $___Ls->tab->are->d ?>	
										
			                        </div>
			                        <div class="TabbedPanelsContent">

										<?php echo $___Ls->tab->tag->d ?>
										
			                        </div>
			                        <div class="TabbedPanelsContent">

						            	<?php $bcoDt = GtBcoAttrDt(['id'=>$___Ls->dt->rw['id_bco']]);  ?>
							            	
							            	<div class="pic_chrch">
								            	<ul class="ls_chrc">
									            	<li style="<?php echo ($___Ls->dt->rw['_img_org'] == 1) ? "background:#b1d0b1" : "background:#d0b1b1"; ?>">
									            		<?php if($___Ls->dt->rw['_img_org'] == 0){ echo '<div class="_img_bco_chk _img_org"><span>Reconstruir</span></div>'; } ?> Imagen Original
									            	</li>
									            	<li style="<?php echo ($___Ls->dt->rw['_img_bg'] == 1) ? "background:#b1d0b1" : "background:#d0b1b1"; ?>">
									            		<?php if($___Ls->dt->rw['_img_bg'] == 0){ echo '<div class="_img_bco_chk _img_bg"><span>Reconstruir</span></div>'; } ?> Imagen Grande
									            	</li>
									            	<li style="<?php echo ($___Ls->dt->rw['_img_md'] == 1) ? "background:#b1d0b1" : "background:#d0b1b1"; ?>">
									            		<?php if($___Ls->dt->rw['_img_md'] == 0){ echo '<div class="_img_bco_chk _img_md"><span>Reconstruir</span></div>'; } ?> Imagen Mediana
									            	</li>
									            	<li style="<?php echo ($___Ls->dt->rw['_img_th'] == 1) ? "background:#b1d0b1" : "background:#d0b1b1"; ?>">
									            		<?php if($___Ls->dt->rw['_img_th'] == 0){ echo '<div class="_img_bco_chk _img_th"><span>Reconstruir</span></div>'; } ?> Imagen Miniatura
									            	</li>
									            	<?php foreach($bcoDt as $_k => $_v){ ?>
									            		<?php if($_v->k != NULL && $_v->v != NULL){ ?>
											            	<li>
											            		<?php echo Strn($_v->k.': ').ctjTx($_v->v,'in').HTML_BR."</li>"; ?>
															</li>
										            	<?php } ?> 
											        <?php }	?>
										        </ul> 
										        <div class="_spc"></div>
							            	</div>
											
								        <?php 
									        
									        $CntWb .= '
									        	
									        	$("#'.$_id_tbpnl.'_chrc").click(function() {
													$(".pic_chrch").mCustomScrollbar({ setHeight:"500px", theme:"dark-3" });
												});	
									        
									        ';
									        
								        ?>
			                        </div> 
			                        
		                        	<div class="TabbedPanelsContent">
				                        <div class="__dts_snd">
											<div class="ln comments">
		            							
		            							<a href="javascript:void(0)" id="_new_use" name="_new_use" class="_new_use" style="text-align: center; display: block;">Nuevo Uso</a><br>
												
												<form method="POST" id="frm_new" class="FmTb" name="frm_new" target="_self">
													<div id="dv_new_<?php echo $___Ls->id_rnd; ?>" name="dv_new_<?php echo $___Ls->id_rnd; ?>" class="_new_use_bx">
														 <div class="_use_cls"></div>
														<?php echo HTML_inp_tx('_use_add', 'Observación', ctjTx($___Ls->dt->rw[''],'in'), 2, '', '', '').HTML_BR; ?>
														<?php //echo LsBcoUseTp('bco_use_tp','id_bcousetp', $___Ls->dt->rw[''], '', 2, ''); $CntWb .= JQ_Ls('bco_use_tp',''); ?>
														<?php echo HTML_inp_tx('bco_use_tp_txt', 'Tipo de uso', ctjTx($___Ls->dt->rw[''],'in'), 2, '', '', '', 'display:none;').HTML_BR; ?>
														<a href="javascript:void(0)" id="_ing_use" name="_ing_use" class="_ing_use" style="text-align: center; display: block;">Guardar</a>
													</div>
												</form>
						                        
												<?php echo bdiv(['id'=>DV_LSFL.$___Ls->inotp_use, "sty"=>"margin-top:5%;"]); ?>
											</div>
										</div>
									</div>  
									                         
			                  </div>
			            </div>
            
						<?php 
							
							$CntJV .= _DvLsFl_Vr(['i'=>$___Ls->dt->rw['id_bco'], 'n'=>$___Ls->inotp_use, 't'=>'bco_use']);
							$CntWb .= _DvLsFl(['i'=>$___Ls->inotp_use]); 
							
							$CntWb .= "
							
							
								function Dom_Bco_Rbld(){									
									
									$('#bco_use_tp').change(function(){
										if($('#bco_use_tp').val() == 1){
											$('#bco_use_tp_txt').show('slow');
										}else{
											$('#bco_use_tp_txt').hide('slow');
											$('#bco_use_tp_txt').val('');
											$('#bco_use_tp_txt').html('');
										}	
									});
									
									
									
									$('#_new_use').click(function(){
										$('#dv_new_".$___Ls->id_rnd."').show('slow');
										$('#_use_add').focus();
										$('#".DV_LSFL.$___Ls->inotp_use."').css('margin-top', '15%');
									});
								    
									
									$('#_ing_use').click(function(e) {
										var cl_nm = $('#cl_nm_p').val();
										_dsc = $('#_use_add').val();
										_tp = $('#bco_use_tp').val();
										_tp_txt = $('#bco_use_tp_txt').val();
										
									    if(_tp != ''){
										   if(_tp == 1 && (_tp_txt == '' || _tp_txt == undefined) ){
											    sweetAlert('Alerta', 'Ingrese Tipo de Uso', 'error');
											    console.log('algo pasa 1');
										    }else{
											    console.log('algo pasa 2');
											    _new_cl({ 'dsc':_dsc, 'tp':_tp, 'tp_txt':_tp_txt });
										    }
								       	}else{
									       	sweetAlert('Alerta', 'Ingrese Tipo de Uso', 'error');
								       	}
									});
									
									
									$('#".TBGRP.$___Ls->inotp_use.", ._use_cls').click(function(){
										$('#dv_new_".$___Ls->id_rnd."').hide('slow');	
										$('#".DV_LSFL.$___Ls->inotp_use."').css('margin-top', '5%');			
									});
									
									$('._img_bco_chk').click(function(){
										
										if($('._img_bco_chk').hasClass('_img_org')){ 
											var _tp = '_org'; 
											$('._upl_i').hide();
											_ldCnt({ u:'".Fl_Rnd(FL_FM_GN.__t('up_bco',true)).Fl_i($___Ls->dt->rw['id_bco'])."&_tp='+_tp+'&_frm=".$___Ls->dt->rw['bn_frm']."', c:'_upl_fle' });
										}else{
											
											if($('._img_bco_chk').hasClass('_img_bg')){ var _tp = '_bg'; }
											else if($('._img_bco_chk').hasClass('_img_md')){ var _tp = '_md'; }
											else if($('._img_bco_chk').hasClass('_img_th')){ var _tp = '_th'; }
											
											$.ajax({
												type: 'POST',
												dataType: 'json',
												url:'".PRC_UPLD_GN.__t('upl_bco', true)."&Sv=ok',
												data: {'_tp':_tp, '_id': 6994},
												beforeSend: function() {
													
												},
												success: function(d) {
												    if(d.e == 'ok'){
														swal('Bien', 'Se guardó con exito', 'success');
												    }else{
														swal('Error', 'Error, no se guardó', 'error');
												    }
												}
											});
											
										}
									});
									
									
									$('#".$___Ls->fm->id." ._pic .bounding').click(function(e){
										
										e.preventDefault();
										
										if(e.target != this){
									    	e.stopPropagation(); return;
										}else{
											
											var _fce_id = $(this).attr('data-fce-id');
											
											_ldCnt({
										        u:'".FL_DT_GN.__t('bco_face', true)."&_i='+_fce_id+'".Fl_i($___Ls->gt->i).TXGN_POP.$___Ls->ls->vrall."',
												c:'',
												pop:'ok',
												pnl:{
													e:'ok',
													s:'l',
													tp:'h'
												}
											});
							
							
										}
					
									});
									
									
									$('#".$___Ls->fm->id." ._faces .opt button').click(function(e){
										
										e.preventDefault();
										
										if(e.target != this){
									    	e.stopPropagation(); return;
										}else{
											if( $('.dsh_bco').hasClass('face_on') ){
												$('.dsh_bco').removeClass('face_on');
											}else{
												$('.dsh_bco').addClass('face_on');		
											}	
										}
					
									});
									
									
									$('#".$___Ls->fm->id." ._faces .face').hover(
										function() {
											
									    	var _fce_id = $(this).attr('data-fce-id');
									    	var _fce_big = $(this).attr('data-image-big');
									    	$(this).css('background-image', 'url('+_fce_big+')'); 
									    	 
									    	$('.dsh_bco ._upl_i ._pic').addClass('dtl');	
									    	$('.dsh_bco ._upl_i ._pic .bounding[data-fce-id=\"'+_fce_id+'\"]').addClass('hvr');	
									    	
										}, function() {
											
									    	var _fce_id = $(this).attr('data-fce-id');
									    	var _fce_th = $(this).attr('data-image-th');
									    	$(this).css('background-image', 'url('+_fce_th+')'); 
									    	
									    	$('.dsh_bco ._upl_i ._pic').removeClass('dtl');
									    	$('.dsh_bco ._upl_i ._pic .bounding[data-fce-id=\"'+_fce_id+'\"]').removeClass('hvr');
										}
									);


								
								}
								
								
								
								function _new_cl(e){
									_desc = e.dsc;
									_tp = e.tp;
									_tp_txt = e.tp_txt;
									$.ajax({
										type: 'POST',
										dataType: 'json',
										url:'".FL_JSON_GN.__t('bco_use_nw', true)."',
										data: '_desc='+_desc+'&_bco='+".$___Ls->dt->rw['id_bco']."+'&_us='+".SISUS_ID."+'&_tp='+_tp+'&_tp_txt='+_tp_txt,
										beforeSend: function() {
											
										},
										success: function(d) {
										    if(d.e == 'ok'){
											    console.log('Bien');
											    $('#dv_new_".$___Ls->id_rnd.", #bco_use_tp_txt').hide('slow');
											    $('#_use_add, #bco_use_tp_txt').html('');
											    $('#_use_add, #bco_use_tp_txt, #bco_use_tp').val('');	
											    if(d._tp_nw == 'ok'){
													$('#bco_use_tp').append('<option value=\"'+d._id+'\">'+d._vlr+'</option>');    
											    }
											    $('#".TBGRP.$___Ls->inotp_use."').click();
										    }else{
												sweetAlert('Error', 'Error en el sistema', 'error');
												$('#dv_new_".$___Ls->id_rnd."').hide('slow');
										    }
										    $('#cl_nm_p').val('');
										}
									});
								}; 
								
								
								Dom_Bco_Rbld();
								
						    ";
						?>
						
	          		</div>
		        </div>
		    </div>
	    </div>    
    </form>
  	</div>
</div>
<style>
	
	
	
	.bcouse_tb{position:relative!important;top:-40px!important;left:45px!important}
	._ing_tp{float:left}
	._ing_use{width:20%;float:right;background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>save.svg')}
	._new_use{width:40%;background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>ec_cmnt_add.svg')}
	._img_bco_chk{background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>return.svg');position:relative;height:16px;width:16px;background-repeat:no-repeat;float:left;bottom:3px;cursor:pointer}
	._img_bco_chk span{position:relative;left:20px;top:3px}
	._img_bco_chk:Hover{opacity:.6}
	._new_use,._ing_use{color:#a9a9a9!important;text-transform:uppercase;font-family:Economica;display:none;font-size:12px;font-weight:300;margin-right:10px;border-radius:20px 20px 20px 20px;-moz-border-radius:20px;-webkit-border-radius:20px 20px 20px 20px;background-color:#fff;margin-left:auto;margin-right:auto;padding:10px 35px;text-decoration:none!important;background-size:20px auto;background-position:10px center;background-repeat:no-repeat;border:1px solid #bbb!important;white-space:nowrap;background-color:transparent!important}
	._new_use:hover,._ing_use:hover,_ing_tp:hover{color:#000!important;text-decoration:none;border:1px solid #232323}
	._new_use_bx{width:100%;margin:auto;display:none;position:relative}
	._new_use_bx ._use_cls{width:16px;height:16px;cursor:pointer;position:absolute!important;z-index:10;width:16px;cursor:pointer;position:relative;top:0!important;z-index:10;right:0!important;background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cancel.svg')}
	._new_use_bx .___txar input[type=text]{width:100%!important;margin:auto!important;πheight:50px!important;background:rgba(255,255,255,0.7);width:100%}
	._new_use_bx .___txar input[type=text]:hover,._new_use_bx .___txar input[type=text]:focus{background:#fff}
	
	
	
	
	
	
	
	
	.dsh_bco{  }
	.dsh_bco ._upl_i{ min-height: 400px; max-width:none; width: 100%; background-repeat: no-repeat; background-size: contain; background-position: center center; position: relative; text-align: center; }
	.dsh_bco ._upl_i ._pic{ position: relative; width: auto; display: inline-block;  }
	.dsh_bco ._upl_i ._pic img{ max-width: none; }
	
	.dsh_bco ._upl_i ._pic.dtl{ }
	.dsh_bco ._upl_i ._pic.dtl .bounding:not(.hvr){ border: none; }
	
	.dsh_bco.face_on ._upl_i .bounding{ display: block; }
	.dsh_bco.face_on ._upl_i .landmark{ display: block; }
	
	.dsh_bco ._upl_i .bounding{ border: 2px solid #65da65; display: none; }
	.dsh_bco ._upl_i .bounding:hover{ -webkit-animation: _puff 0.4s ease-out; cursor: pointer; border-width: 1px; }
	.dsh_bco ._upl_i .bounding.hvr{ border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; }
	
	.dsh_bco ._upl_i .landmark{ width: 2px; height: 3px; display: none; background-color: #fff; }
	
	
	
	.dsh_bco ._faces{ display: block; text-align: center; list-style: none; }
	.dsh_bco ._faces li{ display: inline-block; width: 40px; height: 40px; vertical-align: top; background-repeat: no-repeat; background-size:cover; background-position: center center; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border: 3px solid var(--main-bg-color); position: relative; overflow: hidden; cursor: pointer; }	
	.dsh_bco ._faces li::before{ width: 36px; height: 36px; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border: 2px solid white; position: absolute; left: -1px; top: -1px; }
	.dsh_bco ._faces li:not(.opt):hover{ width: 70px; height: 70px;  -webkit-animation: _puff 0.4s ease-out; border-color: var(--second-bg-color); }
	.dsh_bco ._faces li:hover::before{ width: 66px; height: 66px; border-width: 4px; }
	
	.dsh_bco ._faces li.opt{ border-color: #c3c3c3; }
	.dsh_bco ._faces li.opt button{ position: absolute; left: 0; top: 0; width: 100%; height: 100%; background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>bco_fce_hd.svg'); background-repeat: no-repeat; background-position: center center; background-size: auto 50%; border: none; }
	.dsh_bco ._faces li.opt button.on{ opacity: 1; }
	.dsh_bco ._faces li.opt button.off,
	.dsh_bco ._faces li.opt button:hover{ opacity: 0.3; }
	
	
	.dsh_bco .ln_1.flx{ display: flex; }
	.dsh_bco .ln_1.flx .col_1{ width: 70%; }
	.dsh_bco .ln_1.flx .col_2{ width: 30%; }
	
	.dsh_bco .ln_1.flx h3{ margin-bottom: 0px; }
	
	#ls_are ul{margin: 10px 0 0 10px;padding: 0;}
	#ls_are ul li{display: inline-block;border-radius: 8px;-moz-border-radius: 8px;-webkit-border-radius: 8px;font-size: 10px;color: white;border: 0px solid #9a9e9e;font-weight: 700;padding: 5px 6px;margin: 0px 3px 3px 0px;}
	#ls_are ul li span {width: 8px;height: 8px;display: inline-block;margin-right: 3px;margin-bottom: -1px;border-radius: 200px;-moz-border-radius: 200px;-webkit-border-radius: 200px;}
	.h3_id_bco{margin: 0px 0 0 40px !important;background-color: #1d1d1d;border-radius: 8px;display: inline-block;padding: 2px 8px;color: #ffffff !important;border: 0 !important;vertical-align: middle;}
	#ls_are{ display: inline-block; }
	
</style>
<?php } ?>
<?php } ?>