<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->tt = MDL_NOI;
	$___Ls->sch->f = 'siscntnoi_nm';
	$___Ls->new->h = 300;
	
	$___Ls->edit->h = 650;
	$___Ls->edit->w = 800;
	
	$___Ls->_strt();

	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM "._BdStr(DBM).TB_SIS_CNT_NOI." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){ 
	
		$Ls_Whr = "	FROM "._BdStr(DBM).TB_SIS_CNT_NOI." 
						 INNER JOIN "._BdStr(DBM).TB_CL." ON siscntnoi_cl = id_cl 
					WHERE cl_enc = '".DB_CL_ENC."' AND ".$___Ls->ino." != '' ".$___Ls->sch->cod." 
					ORDER BY id_siscntnoi ASC, siscntnoi_prnt ASC, siscntnoi_nm ASC";
					
		$___Ls->qrys = "SELECT *, (SELECT COUNT(*) $Ls_Whr) AS ".QRY_RGTOT." $Ls_Whr";


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
								'nm'=>ctjTx($___Ls->ls->rw['siscntnoi_nm'],'in'),
								'tp'=>ShortTx(ctjTx($___Ls->ls->rw['sisslc_tt'],'in'),150,'Pt', true), 
								'prnt'=>ShortTx(ctjTx($___Ls->ls->rw['siscntnoi_prnt'],'in'),150,'Pt', true),
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
<div class="FmTb">
  	<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >                  
    	<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
     		<?php $___Ls->_bld_f_hdr(); ?>
	 		<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>">
		 		<?php 
		        $__Cl = new CRM_Cl();
		        $__Rnd = Gn_Rnd(20);
				$CntJV .= " 
				
					var SUMR_Cnt_Noi = {
						
						are : $('#bx_are_".$__Rnd."'),
						cntnoiare: {},
						
					};
					
					function Dom_Rbld(){
						
						var __cntnoi_bx_are_itm = $('#bx_are_".$__Rnd." li.itm.are ');
						var __cntnoi_bx_are_fm = $('#bx_fm_are_".$__Rnd."');
						
						__cntnoi_bx_are_itm.not('.sch').off('click').click(function(){
							var est1 = $(this).hasClass('on') ? 'del' : 'in'; 		
							var _id = $(this).attr('rel');
							
							_Rqu({ 
								t:'sis_cnt_noi_are', 
								d:'are',
								est: est1,
								_id_are : _id,
								_id_cntnoi : '".Php_Ls_Cln($___Ls->gt->i)."',
								_bs:function(){ SUMR_Cnt_Noi.are.addClass('_ld'); },
								_cm:function(){ SUMR_Cnt_Noi.are.removeClass('_ld'); },
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.cnt)){
											ClSet(_r.cnt);			
										}
									}
								} 
							});
						});

						SUMR_Main.LsSch({ str:'#are_sch_".$__Rnd."', ls: __cntnoi_bx_are_itm });
						
					}
					
					function ClGrpAre_Html(){

						SUMR_Cnt_Noi.are.html('');
						SUMR_Cnt_Noi.are.append('<li class=\"sch\">".HTML_inp_tx('are_sch_'.$__Rnd, TX_SEARCH, '')."</li>');
						
						$.each(SUMR_Cnt_Noi.cntnoiare['ls'], function(k, v) {

							if(v.tot > 0){ var _cls = 'on'; }else{ var _cls = 'off'; }
							if(!isN(v.img)){
								if(!isN(v.img.sm_s)){ var img = v.img.sm_s; }else{ var img = v.img; }
							}else{ var img = ''; }
							SUMR_Cnt_Noi.are.append('<li class=\"_anm itm are '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
						});	
						
						$('#tot_are_".$__Rnd."').html( SUMR_Cnt_Noi.cntnoiare['tot'] );
						
						Dom_Rbld();
					}

				";

			$CntJV .= "
				function ClSet(p){
					if( !isN(p) ){
						SUMR_Cnt_Noi.cntnoiare = {}; 
						SUMR_Cnt_Noi.cntnoiare['dt'] = {};
						if( !isN(p.noi.are) ){ SUMR_Cnt_Noi.cntnoiare['ls'] = p.noi.are.ls; SUMR_Cnt_Noi.cntnoiare['tot'] = p.noi.tot; }
						ClGrpAre_Html();
					}
				}		
			";
				
	    ?>

				<div class="ln_1">
					
					<?php if(!isN($___Ls->dt->tot)){ $cls = 'col_1';  } ?>
					
					<div class="<?php echo $cls; ?>">
						<?php 	
							echo LsSisCntNoi('siscntnoi_prnt','id_siscntnoi', $___Ls->dt->rw['siscntnoi_prnt'], TX_PRNT, 2); 
							$CntWb .= JQ_Ls('siscntnoi_prnt', TX_PRNT);
						?>
				  		<?php echo HTML_inp_tx('siscntnoi_nm', TX_NM , ctjTx($___Ls->dt->rw['siscntnoi_nm'],'in'), FMRQD); ?>

					</div>
					
					<?php if(!isN($___Ls->dt->tot)){ 
						
						$CntJV .= " 
							_Rqu({ 
								t:'sis_cnt_noi_are', 
								_id_cntnoi : '".Php_Ls_Cln($___Ls->gt->i)."',
								_cl:function(_r){
									if(!isN(_r)){
										if(!isN(_r.cnt)){
											ClSet(_r.cnt);	
										}
									}
								} 
							});
							
						";
						
						
					?>
						<div class="col_2">
						<div class="cnt_noi_are_dsh dsh_cnt lead_data">
				            <div class="_c _c1 _anm _scrl">
						        <?php echo h2('<button new-tp="are"></button> '.TX_ARE); ?>
						        <div class="_wrp">
							    	<ul id="bx_are_<?php echo $__Rnd; ?>" class="_ls _anm dls"></ul>	
							    	<div class="_new_fm" id="bx_fm_are_<?php echo $__Rnd; ?>"></div>	 
						        </div>
					        </div>	   
				        </div> 
				        <style>
					        .cnt_noi_are_dsh{ text-align: center; margin-top: 10px; display: flex; }
							.cnt_noi_are_dsh ._c{ width: 33%; }
					        .cnt_noi_are_dsh ._c._c1{ width: 100%; } 
					        .cnt_noi_are_dsh ._c._c1 h2{ text-align: right; } 
					        .cnt_noi_are_dsh ._c h2{ text-align: center; }  
					        .cnt_noi_are_dsh ._c ul .itm.are_tp{ padding: 0; margin: 0 0 10px 0; position: relative; }
					        .cnt_noi_are_dsh ._c ul .itm.are_tp ul{ padding: 0 0 0 30px; margin: 0; z-index: 10; }
					        .cnt_noi_are_dsh ._c ul .itm.are_tp h2{ display: block; position: absolute; left: 0; top: 0; padding: 10px 0; width: 35px; height: 100%; border: none; background-color: #6a6d6e; color: white; z-index: 0; writing-mode: tb-rl; line-height: 38px; font-size: 11px; font-weight: 300; text-overflow: ellipsis; border-radimdl: 10px 0px 0px 10px; -moz-border-radimdl: 10px 0px 0px 10px; -webkit-border-radimdl: 10px 0px 0px 10px; }
				        </style>  
					</div>
					<?php } ?>
		        </div>
      		</div>
    	</form>
  	</div>
</div>
<?php } ?>
<?php } ?>