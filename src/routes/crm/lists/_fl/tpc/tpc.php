<?php
if(class_exists('CRM_Cnx')){
	
	$___Ls->sch->f = 'tpctp_tt';
	$___Ls->new->w = 500;
	$___Ls->new->h = 500;
	$___Ls->edit->w = 500;
	$___Ls->edit->h = 500;

	$___Ls->img->dir = DMN_FLE_TPC;
	
	$___Ls->_strt();
	
	if(!isN($___Ls->gt->i)){	
		
		$___Ls->qrys = sprintf("SELECT * FROM ".TB_TPC." WHERE ".$___Ls->ik." = %s LIMIT 1", GtSQLVlStr($___Ls->gt->i, "text"));
		
	}elseif($___Ls->_show_ls == 'ok'){  
		
		$Ls_Whr = "FROM "._BdStr(DBM).TB_TPC." INNER JOIN "._BdStr(DBM).TB_TPC_TP." ON tpc_tp = id_tpctp WHERE  ".$___Ls->ino." != '' ".$___Ls->sch->cod." ORDER BY ".$___Ls->ino." DESC";
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
					<th width="1%" <?php echo NWRP ?>><?php  ?></th>
					<th width="49%" <?php echo NWRP ?>><?php echo TX_TTLO ?></th>
					<th width="29%" <?php echo NWRP ?>><?php echo TX_TP ?></th>
					<th width="29%" <?php echo NWRP ?>><?php echo TX_KEY ?></th>
					<th width="1%" <?php echo NWRP ?>></th>
				</tr>
				<?php do { ?>
				<tr>    
					<?php $__tt_img = fgr('<img src="'.DMN_FLE_TPC.$___Ls->ls->rw['tpc_img'].'">'); ?>   
					<td width="1%" <?php echo NWRP ?>><?php echo Spn($___Ls->ls->rw[$___Ls->ino]); ?></td>
					<td width="1%" align="left"><?php echo $__tt_img; ?></td>
					<td width="49%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['tpc_tt'],'in'),40,'Pt', true); ?></td>
					<td width="29%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['tpctp_tt'],'in'),40,'Pt', true); ?></td>
					<td width="29%" align="left" nowrap="nowrap"><?php echo ShortTx(ctjTx($___Ls->ls->rw['tpc_key'],'in'),40,'Pt', true); ?></td>
					<td width="1%" align="left" nowrap="nowrap" class="_btn"><?php echo $___Ls->_btn([ 't'=>'mod' ]); ?></td>
				</tr>
				
				<?php } while ($___Ls->ls->rw = $___Ls->sql->fetch_assoc()); ?>
			</table>
			
			<?php $___Ls->_bld_l_pgs(); ?>
			
		<?php } ?>
		
		<?php $___Ls->_h_ls_nr(); ?>
		
	<?php } ?>
	<?php if($___Ls->fm->chk=='ok'){ ?>
		<?php 

			$CntJV .= " 

				var SUMR_Dsh_Tpc_Cl = {
					bx_cl:$('#bx_cl_".$__Rnd."'),
					tpccl : {}
				};

				function Tpc_Dom_Rbld(){
					SUMR_Dsh_Tpc_Cl.cl_itm = $('#bx_cl_".$__Rnd." > li.itm.us ');
					SUMR_Dsh_Tpc_Cl.cl_itm.not('.sch, .nosnd').off('click').click(function(){					
						var est = $(this).hasClass('on') ? 'del' : 'in'; 	
						var _id = $(this).attr('rel');
						
						_Rqu({ 
							t:'tpc', 
							d:'cl',
							est: est,
							_id_tpc : '".Php_Ls_Cln($___Ls->gt->i)."',
							_id_cl : _id,
							_bs:function(){ SUMR_Dsh_Tpc_Cl.bx_cl.addClass('_ld'); },
							_cm:function(){ SUMR_Dsh_Tpc_Cl.bx_cl.removeClass('_ld'); },
							_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ TpcClSet(_r.tpc.cl); } } } 
						});	
					});
					
					SUMR_Main.LsSch({ str:'#cl_sch_".$__Rnd."', ls: SUMR_Dsh_Tpc_Cl.cl_itm  });	
				}
				
				function TpcCl_Html(){

					SUMR_Dsh_Tpc_Cl.bx_cl.html('');
					SUMR_Dsh_Tpc_Cl.bx_cl.append('<li class=\"sch\">".HTML_inp_tx('cl_sch_'.$__Rnd, TX_SEARCH, '')."<button class=\"_new _anm\" new-tp=\"us\"></button></li>');
					
					$.each(SUMR_Dsh_Tpc_Cl.tpccl['ls'], function(k, v) { 
						if(v.tot > 0){ var _cls = 'on'; var clr = 'background-color: '+v.clr; }else{ var _cls = 'off'; var clr = '';}
						if(!isN(v.img)){
							if(!isN(v.img.sm_s)){ var img = v.img.sm_s; }else{ var img = v.img; }
						}else{ var img = ''; }
						SUMR_Dsh_Tpc_Cl.bx_cl.append('<li style=\"'+clr+'\" class=\"_anm itm us '+_cls+'\" us-id=\"'+v.enc+'\" rel=\"'+v.enc+'\"><figure style=\"background-image:url('+img+')\" class=\"_bg\"></figure><span>'+v.nm+'</span></li>');
					});	

					Tpc_Dom_Rbld();
				}
			";

			$CntJV .= "	
				function TpcClSet(p){	
					if( !isN(p) ){	
						if( !isN(p) ){ SUMR_Dsh_Tpc_Cl.tpccl['ls'] = p.ls; SUMR_Dsh_Tpc_Cl.tpccl['tot'] = p.tot; } 
						TpcCl_Html();
					}
				}	
			";

			if($___Ls->dt->tot > 0){							
				$CntJV .= "
				 
					_Rqu({ 
						t:'tpc', 
						_id_tpc : '".Php_Ls_Cln($___Ls->gt->i)."',
						_cl:function(_r){ if(!isN(_r)){ if(!isN(_r)){ TpcClSet(_r.tpc.cl); } } } 
					});
				";
			}			
		?>
		<div class="FmTb">
			<div id="<?php echo $___Ls->fm->bx->id ?>" class="<?php echo DV_GNR_FM_BX ?>" >
				<form method="POST" name="<?php echo $___Ls->fm->id; ?>" target="_self" id="<?php echo $___Ls->fm->id; ?>">
					
					<?php $___Ls->_bld_f_hdr(); ?>  
					 
					<div id="<?php echo $___Ls->fm->fld->id ?>" class="<?php echo DV_GNR_FM_CMP ?>"> 
					<div class="ln_1">
						<div class="col_1">
							<?php echo LsTpcTp('tpc_tp','id_tpctp', $___Ls->dt->rw['tpc_tp'], '', 2); $CntWb .= JQ_Ls('tpc_tp',FM_LS_TP); ?>
							<?php echo HTML_inp_tx('tpc_tt', TX_TTLO , ctjTx($___Ls->dt->rw['tpc_tt'],'in'), FMRQD); ?>  
							<?php echo HTML_inp_tx('tpc_key', TX_KEY , ctjTx($___Ls->dt->rw['tpc_key'],'in'), FMRQD); ?>  	
						</div>
						<div class="col_2">
							<div class="ln_1 sisslcf_dsh dsh_cnt _anm">
							  	<div class="_c _anm _scrl" style="width: 100%;">
								  	<?php echo h2( TX_CL ); ?>
									<ul id="bx_cl_<?php echo $__Rnd; ?>" class="_ls dls _anm"></ul>	 
									<div class="_new_fm" id="bx_fm_cl_<?php echo $__Rnd; ?>"></div>
							  	</div>
						  	</div>			
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php } ?>
<?php } ?> 
<style>
	.dsh_cnt ._c ul .itm.on figure { background-color: white !important; }
</style>