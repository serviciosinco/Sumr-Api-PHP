<?php

if(class_exists('CRM_Cnx')){		
		
	$___Ls->img->dir = DMN_FLE_MDL;
	$___Ls->fm->ing = $__md_ing;
	$___Ls->fm->mod = $__md_mod;
	$___Ls->new->w = 500;
	$___Ls->new->h = 600;
	$___Ls->edit->big = 'ok';
	$___Ls->sch->f = 'mdl_nm, mdlst.mdlstp_nm';
	$___Ls->cnx->cl = 'ok';
	$___Ls->img->dir = DMN_FLE_MDL;
	$___Ls->flt = 'ok';
	$___Ls->_strt();
	
	if(!ChckSESS_superadm() && !isN(SISUS_ARE) ){
		$__fl = " AND id_mdl IN ( SELECT mdlare_mdl FROM ".TB_MDL_ARE." WHERE mdlare_are IN (".SISUS_ARE.") ) ";
	}

	if(!isN($___Ls->gt->i)) {

		$___Ls->qrys = sprintf("	SELECT * 
							FROM ".TB_MDL."
								 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
								 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlst ON mdls_tp = mdlst.id_mdlstp
								 LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp 	
								  
							WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
		
		
		if(!isN($___Ls->gt->tsb)){ $__fl .= " AND mdlst.mdlstp_tp = '".$___Ls->gt->tsb."' "; }
		if(!isN($___Ls->gt->tsb_m)){ $__fl .= " AND mdlt.mdlstp_tp = '".$___Ls->gt->tsb_m."' "; }
		if(!ChckSESS_superadm()){ $__fl .= " AND mdl_est != '"._CId('ID_SISMDLEST_ELI')."' "; }	
		
		
		 if(!isN($___Ls->_fl->fk->clare_enc)){ 

			if(is_array($___Ls->_fl->fk->clare_enc)){
				$__all_are = implode(',', $___Ls->_fl->fk->clare_enc);
			}else{
				$__all_are = "'".$___Ls->_fl->fk->clare_enc."'";
			}
			
			$___Ls->qry_f .= ' AND id_mdl IN ( SELECT mdlare_mdl
										FROM '.TB_MDL_ARE.' 
											 INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON mdlare_are = id_clare
										WHERE clare_enc IN ('.$__all_are.') AND clare_est = 1
									) ';					
		}

		if(!isN($___Ls->_fl->fk->mdl_est)){
			$___Ls->qry_f .= ' AND mdl_est = '.$___Ls->_fl->fk->mdl_est.' ';	
		}
		
		
		if(!isN($___Ls->_fl->fk->mdls_enc)){ 
				
			if(is_array( $___Ls->_fl->fk->mdls_enc )){ $__all_mdls = implode(',', $___Ls->_fl->fk->mdls_enc); }else{ $__all_mdls = '"'.$___Ls->_fl->fk->mdls_enc.'"'; }
			
			if(!isN($__all_mdls)){
				$___Ls->qry_f .= ' AND mdls_enc IN ('.$__all_mdls.') ';							
			}														
		}

		$__are = 'no';

		foreach($___Ls->mdlstp->ctg->ls as $__k => $__v){
			if($__v->attr->cns == 'edc'){
				$__are = 'ok';
			}
		}  

		$Ls_Whr =  " FROM ".TB_MDL."
						 INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
						 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlst ON mdls_tp = mdlst.id_mdlstp
						 LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." AS mdlt ON mdl_mdlstp = mdlt.id_mdlstp 
						 
					WHERE ".$___Ls->ino." != ''  ".$___Ls->sch->cod." $__fl ".$___Ls->qry_f."
					ORDER BY ".$___Ls->ino." DESC";
					
		$___Ls->qrys = "SELECT id_mdl, mdl_enc, mdl_nm, mdl_est, mdl_tot_are, mdl_pml, mdls_nm, mdl_s3, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";			
 
	} 

	$___Ls->_bld(); 
		
?>
<?php if($___Ls->ls->chk=='ok'){ ?>	
<?php $___Ls->_bld_l_hdr(); ?>

<?php if(($___Ls->qry->tot > 0)){ ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Ls_Rg">
	<thead>
		<tr>
		    <th width="10%" <?php echo NWRP ?>><?php echo TX_FM_No ?></th>
			<th width="20%" <?php echo NWRP ?>><?php echo TX_NM ?></th>
			
			<?php if(ChckSESS_superadm()){ ?>
			<th width="1%" <?php echo NWRP ?>><?php echo TX_FA ?></th>
			<?php } ?>

		    <th width="20%" <?php echo NWRP ?>><?php echo MDL_S_PRD ?></th>
		    <th width="20%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
			<?php if($___Ls->gt->tsb == 'evn'){ ?><th width="20%" <?php echo NWRP ?>><?php echo TX_VL ?></th><?php } ?>
		    <th width="20%" <?php echo NWRP ?>><?php echo TX_ARE ?></th>
		    <th width="1%" <?php echo NWRP ?>><?php echo TX_ARE ?></th>
  		</tr>
  	</thead>
  	<tbody>
  	<?php do { ?>
		<?php $__ls_json[] = $___Ls->ls->rw['mdl_enc']; ?>
  		<?php if($___Ls->ls->rw['mdl_est'] == _CId('ID_SISMDLEST_ELI')){ $__cls='_eli'; }else{ $__cls=''; } ?>
  		<?php if($___Ls->ls->rw['mdl_tot_are'] == 0 && $__are == 'ok' ){ $__cls_are = ''; }else{ $__cls_are = ''; } ?>
  		<tr mdl-id-no="<?php echo $___Ls->ls->rw['mdl_enc']; ?>" class="<?php echo $__cls.' '.$__cls_are;?>">
	  		<td class="_img_rnd" width="10%" <?php echo NWRP ?>>
				<div class="_img_cod">
			    	<div class="_bimg"><?php echo $___Ls->_h_ls_img([ 'sz'=>'th_50' ]); ?></div>
			    	<div class="_btt"><?php echo Strn(ctjTx($___Ls->ls->rw[$___Ls->ino],'in'),'_nmb'); ?></div>
			    </div>
			</td>
  			<td width="20%" align="left" nowrap="nowrap">
  				<?php echo ShortTx(ctjTx($___Ls->ls->rw['mdl_nm'],'in'),150,'Pt', true).'</br>'.Spn($___Ls->ls->rw['mdl_pml'].'</br>'); ?>	  
  				<ul class="__btn_ul">	
					<li class="_btn"><?php echo HTML_Ls_Btn([ 't'=>'inf', 'l'=>Fl_Rnd(FL_FM_GN.__t('mdl_inf',true).Fl_i($___Ls->ls->rw[$___Ls->ik])), 'cls'=>'_dtl' ]); ?></li>
			        <li class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></li>
			        <li class="_btn">
			        	<?php 	
				        	echo HTML_Ls_Btn([ 't'=>'rss', 
				        					   'l'=>Fl_Rnd(FL_FM_GN.__t('mdl_cod_md',true).Fl_i($___Ls->ls->rw[$___Ls->ik])), 
				        					   'cls'=>'_md' ]); 
				        ?>
					</li>
			        <?php /*$onl= DMN_HTTP.DMN.PrmLnk('bld', '').PrmLnk('bld', $___Ls->ls->rw['mdl_pml']);*/ ?>
			        <li class="_btn"><?php echo HTML_Ls_Btn([ 't'=>'onl', 'l'=>$onl, 'trg'=>'_blank' ]); ?></li>	
				</ul>	
					
				</ul>
			</td>

			<?php if(ChckSESS_superadm()){ ?>
			<td width="1%" align="left" nowrap="nowrap">
				<?php if(mBln($___Ls->ls->rw['mdl_s3']) != 'ok'){ ?>
				<div class="_awss3"><div style="display: inline-block;" class="_tt_prd"></div><div class="icn"></div></div>
				<?php } ?>
			</td>
			<?php } ?>

			<td width="20%" align="left" nowrap="nowrap">
				<div class="_prdopn"><div style="display: inline-block;" class="_tt_prd"><?php echo bdiv([ 'cls'=>'bx_prd', 'c'=>'-' ]); ?></div><div class="icn"></div></div>
			</td>
			<td width="20%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['mdls_nm'],'in'),100,'Pt', true); ?></td>
			<?php if($___Ls->gt->tsb == 'evn'){ ?>
				<td width="1%" align="left" nowrap="nowrap"><?php echo bdiv([ 'cls'=>'bx_prc', 'c'=>'-' ]); ?></td>
			<?php } ?>
			<td width="20%" align="left"><div class="bx_are"><ul class="are_ls"></ul></div></td>
			<td width="1%" align="left" nowrap="nowrap"><?php echo ctjTx($___Ls->ls->rw['mdl_tot_are'],'in'); ?></td>
		</tr>
		<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
  	</tbody>
<?php $CntWb .= '$("._dtl").colorbox({ width:"95%", height:"95%", trapFocus:false, overlayClose:false, escKey:false }); '; ?>
<?php $CntWb .= '$("._md").colorbox({ width:"450px", height:"300px", trapFocus:false, overlayClose:false, escKey:false }); '; ?>
</table>
<?php

	
		$CntJV .=	"
		
			function __getMdlJs(){

				$.post('".Fl_Rnd(FL_JSON_GN.__t('mdl_ext',true))."', { tp:'".$___Ls->gt->tsb."', mdl:'".implode(',', $__ls_json)."' },
				
				function(d, status){
					if(d.e == 'ok'){
						if( d.total > 0 ){
							$.each(d.l, function(_k, _v) { 
								
								if(!isN(_v.prc)){ $('tr[mdl-id-no='+_v.id+'] .bx_prc').html( _v.prc ); }	
								if(!isN(_v.are)){ 
									$.each(_v.are, function(_are_k, _are_v) { 
										$('tr[mdl-id-no='+_v.id+'] .bx_are ul').append( '<li><span class=\"_clr\" style=\"background-color:'+_are_v.clr+'\"></span>'+_are_v.tt+'</li>' );
									});
								}
								if(!isN(_v.prd)){ 
									$.each(_v.prd, function(_prd_k, _prd_v) { 
										$('tr[mdl-id-no='+_v.id+'] ._tt_prd .bx_prd').html( _prd_v );
									});
								}
							});   
						}      
					}
				}); 
			}   
		";

		$CntWb .= " setTimeout(function(){ __getMdlJs(); ".$__grph_shw." }, 1000); ";		
	
	

?>
<?php $___Ls->_bld_l_pgs(); ?>

<style>
	
	._prdopn{ color: var(--main-bg-color); padding:6px 8px; display:block; font-size:11px; border-radius:5px; position:relative; overflow:visible; text-overflow: ellipsis; text-transform: lowercase; position: relative; text-align: center; }
	._prdopn .icn{ display:inline-block; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border: none; width: 20px; height: 20px; right: 4px; top:4px; cursor: pointer; background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>mdl_prd_live.svg'); background-repeat: no-repeat; background-position: center center; background-size: 70% auto; animation: _blnk 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; background-color:var(--second-bg-color); margin-bottom: -6px; margin-left: 4px; }
	
	._awss3{ padding:6px 8px; display:block; font-size:11px; border-radius:5px; position:relative; overflow:visible; text-overflow: ellipsis; text-transform: lowercase; position: relative; text-align: center; }
	._awss3 .icn{ display:inline-block; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border: none; width: 20px; height: 20px; right: 4px; top:4px; cursor: pointer; background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>upd_s3.svg'); background-repeat: no-repeat; background-position: center center; background-size: 90% auto; animation: _blnk 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; margin-bottom: -6px; margin-left: 4px; }
	

	.cnt_wrap .Ls_Rg .no_are{animation: _blnk 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate;background-color: #c78383;color: white; }

	.bx_are .are_ls {font-family: Roboto;padding: 0;margin: 0;list-style: none;white-space: normal;display: block;width: 100%;}
	.bx_are .are_ls li {display: inline-block;border-radius: 8px;-moz-border-radius: 8px;-webkit-border-radius: 8px;font-size: 10px;color: #9a9e9e;border: 1px solid #9a9e9e;padding: 3px 4px;margin: 0px 3px 3px 0px;}
	.bx_are .are_ls li ._clr {width: 8px;height: 8px;display: inline-block;margin-right: 3px;margin-bottom: -1px;border-radius: 200px;-moz-border-radius: 200px;-webkit-border-radius: 200px;}

</style>

<?php } ?>

<?php $___Ls->_h_ls_nr(); ?>
<?php } ?>


<?php if($___Ls->fm->chk=='ok'){ ?>
<div class="FmTb">
  	<div id="<?php echo $___Ls->fm->bx->id ?>">
	  	
     	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>" >
	     	

	     	<?php $___Ls->_bld_f_hdr(); ?>	 	

	 	
        	<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_BX ?>">
		   	 	
		   	 	
		   	 	<?php $__dt_img = _ImVrs([ 'img'=>ctjTx($___Ls->dt->rw['mdl_img'],'in'), 'f'=>DMN_FLE_MDL ]); ?>
		        
		        <div class="mdl_dsh_imgbn imgbn">
					<div class="_img" style="background-image:url(<?php echo $__dt_img->bn_800; ?>);"></div>
					<div class="_nm"><?php echo h1(ctjTx($___Ls->dt->rw['mdl_nm'],'in')); ?></div>
					
					<?php $__act_tabs = __LsDt([ 'k'=>'mdl_tabs' , 'cl'=>$__dt_cl->id, 'mdl_s_tp'=>$___Ls->gt->tsb ]); ?>
					
					<div class="_opt">
						<ul>
							<?php foreach($__act_tabs->ls->mdl_tabs as $_tab__k=>$_tab_v){ ?>
								<?php if($_tab_v->rel->vl == 'mdl_mdl'){ $_icn=$___Ls->mdlstp_m->img->big; }else{ $_icn=$_tab_v->img_v->big; } ?>
								<li>
									<button data-t="<?php echo $_tab_v->tp_rel->vl ?>" data-r="<?php echo $_tab_v->rel->vl ?>" title="<?php echo _Cns($_tab_v->plch->vl) ?>" class="_anm" style="background-image:url(<?php echo $_icn; ?>)">
									</button>
								</li>
							<?php } ?>
						</ul>
					</div>
					
					<?php 

			            $CntWb .= "
			            
			            		$('.mdl_dsh_imgbn ._opt button').click(function(e) {

									e.preventDefault();
		
									if(e.target != this){
										
								       e.stopPropagation();
									   return;
									   
									}else{
										
										var _data_trel = $(this).attr('data-t');
										var _data_rel = $(this).attr('data-r');
										
										if(_data_trel == 'ls'){ var _f='".FL_LS_GN."'; }else{ var _f='".FL_DT_GN."'; }
										
										_ldCnt({ 
											u:_f+'?_t='+_data_rel+'&__i=".$___Ls->dt->rw['mdl_enc'].$___Ls->ls->vrall."', 
											pop:'ok',
											pnl:{
												e:'ok',
												tp:'h',
												s:'l',
											},
											_cm:function(){		
												
											}
										});
										
									}
									 
								});
								
			             ";
			            
		            ?>
		            
	            </div>
		            
		            			
				<div class="mdl_dsh dsh_cnt <?php if($___Ls->dt->tot == 0){ echo '_new'; } ?>">
		            
					<div class="_c _c1 _anm">
							
						<?php include(DIR_EXT.'mdl_1.php'); ?> 
						
						
						<style type="text/css" media="screen">
							.mdl_dsh{ position: relative;  }
							.__cmpc{ background-color: #e3e3e3; display: block; width: 25px; height: 35px; text-indent: -2000px; position: absolute; right: 0; top: 5px; radius: 7px 0px 0px 7px; -moz-border-radius: 7px 0px 0px 7px; -webkit-border-radius: 7px 0px 0px 7px; border-left: 1px solid #ffffff; border-top: 1px solid #ffffff; border-bottom: 1px solid #ffffff; z-index: 99999; -webkit-box-shadow: -11px -6px 39px -9px rgba(0,0,0,0.4);-moz-box-shadow: -11px -6px 39px -9px rgba(0,0,0,0.4);box-shadow: -11px -6px 39px -9px rgba(0,0,0,0.4);background-image: url(<?php echo _iEtg(DMN_IMG_ESTR.'v_tbd.png') ?>); background-repeat: no-repeat; background-position: 10px center; background-size: auto 100%;}
							.mdl_dsh._mny .mdl_hor_tab { width: 35% !important; }
							.mdl_dsh._mny .mdl_hor_tab ._c._c2, 
							.mdl_dsh._mny .mdl_hor_tab ._c._c3, 
							.mdl_dsh._mny .mdl_hor_tab ._c._c4{ display: block;width: 100%; }
						    .mdl_dsh._mny ._c._c1{ width: 65% !important; }
						</style>
						<a href="<?php echo Void(); ?>" id="cmp_col" class="__cmpc"></a>
					 	<?php 
		            
				             $CntWb .= "
				             		$('#cmp_col').click(function() {
					             		if( $('.mdl_dsh').hasClass('_mny') ){
						             		$('.mdl_dsh').removeClass('_mny');
					             		}else{
						             		$('.mdl_dsh').addClass('_mny');
					             		} 
									});
				             ";
				            
			            ?>
					</div>
					
					<?php 
						/*Ricardo*/
						$__tabs = [
							['n'=>'mdl_fm', 't'=>'mdl_fm', 'l'=>'Formulario'],
							['n'=>'mdl_us', 't'=>'mdl_us', 't2'=>'mdl', 'l'=>'Usuarios (Asignación)'],
							['n'=>'mdl_grp', 't'=>'mdl_grp', 't2'=>'mdl', 'l'=>'Usuarios Grupo(Asignación)'],
							['n'=>'mdl_ctrl', 't'=>'mdl_ctrl', 't2'=>'mdl', 'l'=>'Lista de control']
						];
						$___Ls->_dvlsfl_all($__tabs);
						
					?>
					<?php $_id_tbpnl = 'TabPnl_'.Gn_Rnd(20); $CntWb .= " SUMR_Main.bxajx.".$_id_tbpnl." = new Spry.Widget.TabbedPanels('".$_id_tbpnl."' {$_tb_dfl}); "; 
						$CntWb .= _DvLsFl([ 'i'=>$___Ls->tb->eml ]);  ?>
						
						<?php /* Tab Horizontal */ ?>
						<div id="<?php echo $_id_tbpnl ?>" class="TabbedPanels TbGnrl mny mdl_hor_tab">
				          	<ul class="TabbedPanelsTabGroup">
					            <?php echo $___Ls->tab->bsc->l ?>
								<?php echo $___Ls->tab->mdl_fm->l ?>
								<?php echo $___Ls->tab->mdl_us->l ?>  
								<?php echo $___Ls->tab->mdl_grp->l ?> 
								<?php echo $___Ls->tab->mdl_ctrl->l ?> 
				          	</ul>
						  	<div class="TabbedPanelsContentGroup">
					        	<div class="TabbedPanelsContent">
					            	<div class="_c _c2 _anm _scrl">
										<?php echo h2('<button new-tp="prd"></button> '.TX_PRDO); ?>
										<div class="_wrp">
											<ul id="bx_prd_<?php echo $___Ls->id_rnd; ?>" class="_ls _anm dls"></ul>
											<div class="_new_fm" id="bx_fm_prd_<?php echo $___Ls->id_rnd; ?>"></div>	
										</div>	
									</div>
									<?php /* Ricardo Pasar texto a constante*/ ?>
									<div class="_c _c3 _anm _scrl">
										<?php echo h2('Áreas'); ?>
										<style>
											.__cnt_are::-webkit-scrollbar {width: 5px;}
											.__cnt_are::-webkit-scrollbar-thumb {background: #ccc;border-radius: 4px;}
											.__cnt_are::-webkit-scrollbar-thumb:active {background-color: #999999;}
											.__cnt_are::-webkit-scrollbar-thumb:hover {background: #b3b3b3;box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);}
											.__cnt_are::-webkit-scrollbar-track {background: #e1e1e1;border-radius: 4px;}
											.__cnt_are::-webkit-scrollbar-track:hover, 
											.__cnt_are::-webkit-scrollbar-track:active {background: #d4d4d4;}
										</style>
										<div class="_wrp __cnt_are" style="overflow: auto;">
											<ul id="bx_are_<?php echo $___Ls->id_rnd; ?>" class="_ls _anm dls"></ul>
											<div class="_new_fm" id="bx_fm_are_<?php echo $___Ls->id_rnd; ?>"></div>
										</div>
									</div>
									<?php /* Ricardo Pasar texto a constante*/ ?>
									<div class="_c _c4 _anm _scrl">
										<?php echo h2('Email'); ?>
										<div class="_wrp">
											<ul id="bx_us_<?php echo $___Ls->id_rnd; ?>" class="_ls _anm dls"></ul>
											<div class="_new_fm" id="bx_fm_us_<?php echo $___Ls->id_rnd; ?>"></div>
										</div>
									</div> 	  
					        	</div>
					        	<div class="TabbedPanelsContent">
					            	<?php echo $___Ls->tab->mdl_fm->d; ?>
								</div>
								<div class="TabbedPanelsContent">
					            	<?php echo $___Ls->tab->mdl_us->d; ?>
					        	</div>
								<div class="TabbedPanelsContent">
					            	<?php echo $___Ls->tab->mdl_grp->d; ?>
					        	</div>
								<div class="TabbedPanelsContent">
					            	<?php echo $___Ls->tab->mdl_ctrl->d; ?>
					        	</div>
				          	</div>
				        </div>
						<?php /* -------------- */ ?>
						
						
				</div> 
				
				     
        	</div>
    	</form>
  	</div>
</div>

<?php
	        
    $__Cl = new CRM_Cl();
	
	
	$CntJV .= " 

	var SUMR_Mdl = {
		prd : $('#bx_prd_".$___Ls->id_rnd."'),	
		are : $('#bx_are_".$___Ls->id_rnd."'),
		us : $('#bx_us_".$___Ls->id_rnd."'),
		
		mdlsprd : {},
		mdlsare : {},
		mdlsus : {}
	}; 	
	
	function Mdl_Dom_Rbld(){
		
		var __mdls_bx_prd_itm = $('#bx_prd_".$___Ls->id_rnd." > li.itm ');
		var __mdls_bx_are_itm = $('#bx_are_".$___Ls->id_rnd." > li.itm ');
		var __mdls_bx_us_itm = $('#bx_us_".$___Ls->id_rnd." > li.itm ');

		__mdls_bx_prd_itm.not('.sch').off('click').click(function(e){

			if(e.target != this){
		    	e.stopPropagation(); return;
			}else{
				
				var est = $(this).hasClass('on') ? 'no' : 'ok'; 
				var _id = $(this).attr('rel');
				
				_Rqu({ 
					t:'mdl', 
					d:'prd',
					est: est,
					_id_prd : _id,
					_id_mdl : '".Php_Ls_Cln($___Ls->gt->i)."',
					_bs:function(){ SUMR_Mdl.prd.addClass('_ld'); },
					_cm:function(){ SUMR_Mdl.prd.removeClass('_ld'); },
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.cl)){
								MdlSet(_r.cl);													
							}
						}
					} 
				});	
			}
		});
		
		
		__mdls_bx_are_itm.not('.sch').off('click').click(function(e){
			if(e.target != this){
		    	e.stopPropagation(); return;
			}else{	
				
				var est = $(this).hasClass('on') ? 'no' : 'ok';
				var _id = $(this).attr('rel');	
					
				_Rqu({ 
					t:'mdl', 
					d:'are',
					est: est,
					_id_are : _id,
					_id_mdl : '".Php_Ls_Cln($___Ls->gt->i)."',
					_bs:function(){ SUMR_Mdl.are.addClass('_ld'); },
					_cm:function(){ SUMR_Mdl.are.removeClass('_ld'); },
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.cl)){
								MdlSet(_r.cl);													
							}
						}
					} 
				});	
			}	
		});
		
		__mdls_bx_us_itm.not('.sch').off('click').click(function(e){
			if(e.target != this){
		    	e.stopPropagation(); return;
			}else{	

				var est = $(this).hasClass('on') ? 'no' : 'ok';	
				var _id = $(this).attr('rel');	
						
				_Rqu({ 
					t:'mdl', 
					d:'us',
					est: est,
					_id_us : _id,
					_id_mdl : '".Php_Ls_Cln($___Ls->gt->i)."',
					_bs:function(){ SUMR_Mdl.us.addClass('_ld'); },
					_cm:function(){ SUMR_Mdl.us.removeClass('_ld'); },
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.cl)){
								MdlSet(_r.cl);													
							}
						}
					} 
				});	
			}	
		});	
	
		SUMR_Main.LsSch({ str:'#prd_sch_".$___Ls->id_rnd."', ls: __mdls_bx_prd_itm });
		SUMR_Main.LsSch({ str:'#are_sch_".$___Ls->id_rnd."', ls: __mdls_bx_are_itm });
		SUMR_Main.LsSch({ str:'#us_sch_".$___Ls->id_rnd."', ls: __mdls_bx_us_itm });
		
		_DshPopH({ c:'.mdl_dsh', ov:80 });
	}
	
	function MdlSPrd_Html(){
		
		SUMR_Mdl.prd.html('');
		SUMR_Mdl.prd.append('<li class=\"sch\">".HTML_inp_tx('prd_sch_'.$___Ls->id_rnd, TX_SEARCH, '')."</li>');
		
		if(!isN(SUMR_Mdl.mdlsprd['ls'])){
			$.each(SUMR_Mdl.mdlsprd['ls'], function(k, v) { 
				if(!isN(v.in) && !isN(v.in.est) && v.in.est == 'ok'){ var _cls = 'on'; }else{ var _cls = 'off'; }
				SUMR_Mdl.prd.append('<li class=\"_anm itm prd '+_cls+'\" prd-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" ><span>'+v.nm+'</span></li>');
			});	
		}
		
		Mdl_Dom_Rbld();
	}
	
	function MdlSAre_Html(){
		
		SUMR_Mdl.are.html('');
		SUMR_Mdl.are.append('<li class=\"sch\">".HTML_inp_tx('are_sch_'.$___Ls->id_rnd, TX_SEARCH, '')."</li>');
		
		if(!isN(SUMR_Mdl.mdlsare['ls'])){
			$.each(SUMR_Mdl.mdlsare['ls'], function(k, v) { 
				if(!isN(v.est) && v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
				SUMR_Mdl.are.append('<li class=\"_anm itm are '+_cls+'\" are-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" >'+v.nm+'</li>');
			});	
		}
		
		Mdl_Dom_Rbld();
	}
	
	function MdlSUs_Html(){
		
		SUMR_Mdl.us.html('');
		SUMR_Mdl.us.append('<li class=\"sch\">".HTML_inp_tx('us_sch_'.$___Ls->id_rnd, TX_SEARCH, '')."</li>');
		
		if(!isN(SUMR_Mdl.mdlsus['ls'])){
			$.each(SUMR_Mdl.mdlsus['ls'], function(k, v) { 
				if(!isN(v.est) && v.est > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
				SUMR_Mdl.us.append('<li class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\" >'+v.nm+' ('+v.user+')</li>');
			});	
		}
		
		Mdl_Dom_Rbld();
	}
	
	";
	
	
	
	$l = __Ls(['k'=>'sis_prd',
			'id'=>'mdlsprd_tp',
			'v'=>'sisslc_enc',
			'ph'=>FM_LS_PRD,
			'va'=>$___Ls->dt->rw['mdlsprd_tp']
		]);
		
	$Years = Ls_Vl_Year('mdlsprd_y', 'mdlsprd_y', $___Ls->dt->rw['mdlsprd_y'],TX_YR,'');
	
	/*$CntJV .= " var __prd = '".$l->html."'; ";
	$CntJV .= " var __yrd = '".$Years."'; ";*/
	
	$CntJV .= "
	
		function MdlSet(p){
			if( !isN(p) ){	
				
				if( !isN(p.mdls.prd) ){ SUMR_Mdl.mdlsprd['ls'] = p.mdls.prd.ls; SUMR_Mdl.mdlsprd['tot'] = p.mdls.prd.tot; }
				if( !isN(p.mdls.are) ){ SUMR_Mdl.mdlsare['ls'] = p.mdls.are.ls; SUMR_Mdl.mdlsare['tot'] = p.mdls.are.tot; }
				if( !isN(p.mdls.us) ){ SUMR_Mdl.mdlsus['ls'] = p.mdls.us.ls; SUMR_Mdl.mdlsus['tot'] = p.mdls.us.tot; }
				
				MdlSPrd_Html();
				MdlSAre_Html();
				MdlSUs_Html();
			}
			Mdl_Dom_Rbld();
		}
		
		";

	if($___Ls->dt->tot > 0){
	
		$CntJV .= " 

			_Rqu({ 
				t:'mdl', 
				_id_mdl : '".Php_Ls_Cln($___Ls->gt->i)."',
				_cl:function(_r){
					if(!isN(_r)){
						if(!isN(_r.cl)){
							MdlSet(_r.cl);			
						}
					}
				} 
			});
			
		";
		
	}
	

?>
    
<style>
	
	
	.mdl_dsh{ display: flex; width: 100%; min-height: 200px; z-index: 2; }
	.mdl_dsh ._c{ display: inline-block; vertical-align: top; border-right: 1px solid #c8cacb; padding: 0 10px; }	
	.mdl_dsh ._c:first-child{ padding-left: 0; }
	.mdl_dsh ._c:last-child{ border-right: none; }
	
	
	.mdl_dsh ._c._c1{ width: 40%; }
	.mdl_dsh ._c._c2,
	.mdl_dsh ._c._c3,
	.mdl_dsh ._c._c4{ width: 33%; }			
	
	.mdl_dsh ._c ul .itm.prd.on{ border: 2px solid var(--second-bg-color); color:var(--main-bg-color); }
	.mdl_dsh ._c ul .itm.prd.on .btn{ animation: _blnk 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; background-color:var(--second-bg-color);  }
	
	.mdl_dsh ._c ul .itm.prd.off{ opacity: 0.5; }
	.mdl_dsh ._c ul .itm.prd:hover{ opacity: 1; }
	.mdl_dsh ._c ul .itm.prd span{ pointer-events: none; }
	
	
	.mdl_dsh ._c ul .itm.are.on{ color: white; background-color:var(--main-bg-color);}
	
	
	.mdl_dsh ._c ul .itm.prd .btn{ position: absolute; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; border: none; background-color: #c7c7c7; width: 20px; height: 20px; right: 4px; top:4px; cursor: pointer; background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>mdl_prd_live.svg'); background-repeat: no-repeat; background-position: center center; background-size: 70% auto; }
		

	.mdl_dsh._new_prd ._c._c2{ width: 60%; border: none; }
    .mdl_dsh._new_prd ._c._c2 ._ls{ display: none; pointer-events: none; }
    .mdl_dsh._new_prd ._c._c2 h2 button{ display: inline-block; }
    
    
    .mdl_dsh._new_prd ._c._c1,
    .mdl_dsh._new_prd ._c._c3{ max-width: 20%; opacity: 0.3; -webkit-filter: grayscale(100%); filter: grayscale(100%); pointer-events: none; }
	.mdl_dsh._new_prd ._scrl ._new_fm{ padding-top:100px; }
	        	
				
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup{ width: 15% !important; background-color:white; }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab{ min-height: 45px; background-size: 50% auto; background-position: center center; border-color: #BABABA; }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsContentGroup{ width: 85% !important; }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsContentGroup .TabbedPanelsContent{ padding: 0 15px !important; }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected{ border: none; }
	
	
	/*.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._bsc{ background-image:url('<?php echo $___Ls->mdlstp->img->big; ?>'); }}*/
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._bsc{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl.svg'); }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected._bsc{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>cnt_dtl_w.svg'); }
	
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._attr{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>mdl_attr.svg'); }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected._attr{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>mdl_attr_w.svg'); }
	
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._form{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>mdl_form.svg'); }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected._form{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>mdl_form_w.svg'); }
	
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._mdl_sch{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>mdl_sch.svg'); }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected._mdl_sch{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>mdl_sch_w.svg'); }
	
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._mdl_fle{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>file.svg'); }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected._mdl_fle{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>file-w.svg'); }
	
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._act_mdl{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>'); }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected._act_mdl{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>'); }

	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._act_org{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>org.svg'); }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected._act_org{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>org_w.svg'); }
	
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._act_rsp{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>act_rsp.svg'); }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected._act_rsp{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>act_rsp_w.svg'); }
	
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._mdl_attr{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>'); }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected._mdl_attr{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>'); }
	
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._mdl_chk{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>mdl_chk.svg'); }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected._mdl_chk{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>mdl_chk_w.svg'); }
	
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTab._mdl_mdl{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>modules.svg'); }
	.mdl_dsh .VTabbedPanels.mny .TabbedPanelsTabGroup .TabbedPanelsTabSelected._mdl_mdl{ background-image:url('<?php echo DMN_IMG_ESTR_SVG ?>modules_w.svg'); }


	.mdl_dsh._new .mdl_hor_tab{ display: none; }
	.mdl_dsh._new ._c._c1{ width: 100%; display: block; border:none; }
	.mdl_dsh._new .VTabbedPanels.mny .TabbedPanelsTabGroup{ display: none; }
	.mdl_dsh._new .VTabbedPanels.mny .TabbedPanelsContentGroup{ width: 100% !important; }
	
	
	
	.mdl_dsh_imgbn{ min-height: 200px; height: 200px; position: relative; background-image: none !important; z-index: 1; }
	
	.mdl_dsh_imgbn::before{ z-index: 1; position: absolute; left: 0; top: 0; width: 100%; height: 100%; background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>ec_broken.svg); background-color: #bfc3c5; background-size: 50% auto; opacity: 0.2; background-size: auto 60%; background-repeat: no-repeat; background-position: center center; }
	.mdl_dsh_imgbn ._img{ position: absolute; left: 0; top: 0; width: 100%; height: 100%; background-size: cover; background-repeat: no-repeat; background-position: center center; z-index: 2; }
	.mdl_dsh_imgbn ._img::after{ position: absolute; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.4); }
	.mdl_dsh_imgbn ._nm{ position: absolute; right: 50px; bottom: 15px; width: 70%; pointer-events: none; }
	.mdl_dsh_imgbn ._opt{ position: absolute; right:0; top:0; height: 100%; width: 50px; padding: 0 5px; z-index: 10; }
	
	.mdl_dsh_imgbn ._opt::after{ position: absolute; right: 0; top: 0; height: 100%; width: 200px; z-index: 1; background: rgba(0,0,0,0); background: -moz-linear-gradient(left, rgba(0,0,0,0) 18%, rgba(0,0,0,0.14) 28%, rgba(0,0,0,0.59) 62%, rgba(0,0,0,1) 92%, rgba(0,0,0,1) 100%); background: -webkit-gradient(left top, right top, color-stop(18%, rgba(0,0,0,0)), color-stop(28%, rgba(0,0,0,0.14)), color-stop(62%, rgba(0,0,0,0.59)), color-stop(92%, rgba(0,0,0,1)), color-stop(100%, rgba(0,0,0,1))); background: -webkit-linear-gradient(left, rgba(0,0,0,0) 18%, rgba(0,0,0,0.14) 28%, rgba(0,0,0,0.59) 62%, rgba(0,0,0,1) 92%, rgba(0,0,0,1) 100%); background: -o-linear-gradient(left, rgba(0,0,0,0) 18%, rgba(0,0,0,0.14) 28%, rgba(0,0,0,0.59) 62%, rgba(0,0,0,1) 92%, rgba(0,0,0,1) 100%); background: -ms-linear-gradient(left, rgba(0,0,0,0) 18%, rgba(0,0,0,0.14) 28%, rgba(0,0,0,0.59) 62%, rgba(0,0,0,1) 92%, rgba(0,0,0,1) 100%); background: linear-gradient(to right, rgba(0,0,0,0) 18%, rgba(0,0,0,0.14) 28%, rgba(0,0,0,0.59) 62%, rgba(0,0,0,1) 92%, rgba(0,0,0,1) 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#000000', GradientType=1 ); opacity: 0.6;
	}
	
	.mdl_dsh_imgbn ._opt ul{ z-index: 2; list-style: none; padding: 0; margin: 0; position: relative; }
	.mdl_dsh_imgbn ._opt ul li{}
	.mdl_dsh_imgbn ._opt ul li button{ text-indent: -1000px; width: 40px; height: 40px; overflow: hidden; background-color: transparent; background-position: center center; background-repeat: no-repeat; background-size: auto 60%; margin-bottom: 5px; border: none; }
	.mdl_dsh_imgbn ._opt ul li button:hover{ background-size: auto 40%; }

</style>

<?php } ?>
<?php } ?>