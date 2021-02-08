<?php 
	
if(class_exists('CRM_Cnx')){

	$_enc = $___Ls->gt->i;
	        
?>
<!-- HTML -->
<div class="Dsh_Tra<?php //if(!ChckSESS_superadm()){ echo ' nusr'; } ?>" id="Dsh_Tra" us-ses-id="<?php echo SISUS_ENC; ?>">
	
	<div class="_ovr _anm"></div>
	
	<?php 
	
		echo h1('	<div class="c1"></div>
					<div class="c2">'.
						TX_TRA.' / '.MDL_PQR.' 
						<button id="Tra_Update" onclick="" class="_anm upd">
							<div class="flg _anm"><div class="wrp">Actualizar</div></div>
						</button>
					</div>
					<div class="c3">
						

						<button id="Tra_LsFull" onclick="SUMR_Tra.f.dsgn.fll();" class="_anm fll off">
							<div class="flg _anm"><div class="wrp">Ampliar Ticket</div></div>
						</button>

						<button id="Tra_LsDtl" onclick="SUMR_Tra.f.dsgn.dtl();" class="_anm dtl off">
							<div class="flg _anm"><div class="wrp">Detalles Ticket</div></div>
						</button>

						<div class="sep"></div>

						'.(ChckSESS_superadm()?'<button id="Tra_Filter" onclick="" class="_anm flt">
							<div class="flg _anm"><div class="wrp">Filtrar</div></div>
						</button>':'').'

						<div class="tra_sch_wrp">
							<button id="Tra_Search" onclick="SUMR_Tra.f.sch.on();" class="_anm sch">
								<div class="flg _anm"><div class="wrp">Buscar</div></div>
							</button> 
							<div class="sch_bx _anm">'.HTML_inp_tx('cols_tra_sch', TX_SEARCH, '').'</div>
						</div>

						<button id="Tra_Eml_Chck" onclick="SUMR_Tra.f.eml.chk(); SUMR_Tra.f.eml.bdg(\'50\');" class="_anm eml">
							<div class="flg _anm"><div class="wrp">Check Mail</div></div>
							<span class="bnce"></span>
						</button> 

						<button id="TraApi_TmeDct_Cnct" onclick="SUMR_Tra.f.Pop_TimeDoctor();">Connect TimeDoctor</button>

					</div>' 
				,'_tt');
	?>
	
	<?php				
		$__idtp_cmpg = '_cmpg';	
		$__idtp_tmpl = '_tmpl';	       		
							
		$___Ls->_dvlsfl_all([
			['n'=>'dsh', 'l'=>TX_DSH ],
			['n'=>'todo', 'l'=>'Gestionar' ],
			['n'=>'whtsp', 't'=>'whtsp_ifr', 'f'=>'dt', 'l'=>'Whatsapp', 'rld'=>'no' ],
			['n'=>'lists', 't'=>'mdl_cnt', 't2'=>$___Ls->gt->tsb, 'wrp'=>'ok', 'l'=>'Listado' ],
			['n'=>'cnv', 't'=>'cnv', 't2'=>$___Ls->gt->tsb, 'f'=>'dt', 'wrp'=>'ok', 'l'=>'Mensajería' ]
		],[
			'idb'=>'ok'
		]);
	?>

	<div id="<?php echo $___Ls->tab->id ?>" class="VTabbedPanels mny ignr DhsTraTab">
		<ul class="TabbedPanelsTabGroup">
			<?php if(_ChckMd('tra_dsh')){ echo $___Ls->tab->dsh->l; } ?>
			<?php echo $___Ls->tab->todo->l; ?>
			<?php if(_ChckMd('scl_whtsp')){ echo $___Ls->tab->whtsp->l; } ?>
			<?php if(_ChckMd('sac_mdl_cnt')){ echo $___Ls->tab->lists->l; } ?>
			<?php if(_ChckMd('sac_cnv') && Dvlpr()){ echo $___Ls->tab->cnv->l; } ?>
		</ul>
		<div class="TabbedPanelsContentGroup">
			<?php if(_ChckMd('tra_dsh')){ ?>
				<div class="TabbedPanelsContent">
					<?php include('tra_dsh.php'); ?>
				</div>
			<?php } ?>
			<div class="TabbedPanelsContent">
				<div class="_col_scrll">
					<div class="_col_ls _anm">
						<div class="_col_wrp">
							<div class="_col_new _anm">
								<div class="tt_tx"><?php echo HTML_inp_tx('tracol_tt', '', '', '', '', '_anm tracol_tt');?></div>
								<!--<div class="btn_add_col _anm"></div>-->
							</div>
						</diV>
					</div>
				</div>
			</div>	
			<?php if(_ChckMd('scl_whtsp')){ ?>
				<div class="TabbedPanelsContent" style="background-color:#fff; min-height:7000px;">
					<?php echo $___Ls->tab->whtsp->d ?>
				</div>
			<?php } ?>
			<?php if(_ChckMd('sac_mdl_cnt')){ ?>
				<div class="TabbedPanelsContent" style="background-color:#fff; min-height:7000px;">
					<?php echo $___Ls->tab->lists->d ?>
				</div>
			<?php } ?>
			<?php if(_ChckMd('sac_cnv') && Dvlpr()){ ?>
				<div class="TabbedPanelsContent" style="background-color:#fff; min-height:7000px;">
					<?php echo $___Ls->tab->cnv->d ?>
				</div>
			<?php } ?>
		</div>
	</div>

	<!--
    <div class="_col_us _anm">
    	<div class="_actv">
	    	<div class="_hdr">
		    	<span class="_tt"><?php echo TX_ACTVD; ?></span>
		    	<div class="_fl"></div>
		    	<div class="_act _ok"></div>
		    </div>
	    	<div class="_bdy">
		    	<div class="_act _ok"></div>
		    	
		    	<div class="_fl">
			    	<?php echo HTML_textarea('fl_sch', TX_BTN_FL.' '.TX_TRA, '', '', '', '_anm fl_sch', '1', '200', '', 'onkeydown="if(event.keyCode == 13){ SUMR_Tra.f.TxA({id:this}); return false; }"'); ?><hr/>
			    	<?php echo SlDt([ 'id'=>'fl_fi', 'rq'=>'no', 'ph'=>TX_FI, 'lmt'=>'no', 'cls'=>CLS_CLND ]);  ?><hr/>
			    	
			    	<button class="_prc"> <span><?php echo TX_INPROCSS; ?></span> <div></div> </button><hr/> 
			    	<button class="_cmpl"> <span><?php echo TX_TRMNDA; ?></span> <div></div> </button><hr/> 
			    	<button class="_ach"> <span><?php echo TX_ARCHVD; ?></span>  <div></div> </button><hr/>
			    	
			    	<div class="btn_sch"><button class="_anm"><?php echo TX_SEARCH; ?></button></div>
		    	</div>
	    	</div>
    	</div>
    	<div class="_lsus">
	    	<div class="ftr"><div class="btn_opn"></div></div>
    	</div>	
    </div>
	-->      
	    
</div>
<style>
	.Dsh_Tra .VTabbedPanels .TabbedPanelsTab._dsh{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tra_dsh.svg); }
	.Dsh_Tra .VTabbedPanels .TabbedPanelsTab._todo{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tra_todo.svg); }
	.Dsh_Tra .VTabbedPanels .TabbedPanelsTab._lists{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tra_list.svg); }
	.Dsh_Tra .VTabbedPanels .TabbedPanelsTab._whtsp{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tra_whtsp.svg); }
	.Dsh_Tra .VTabbedPanels .TabbedPanelsTab._cnv{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>tra_cnv.svg); }
</style>
<?php include('tra_js.php'); ?>
<?php } ?>