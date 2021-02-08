<?php 
	$__id_tab = 'TabbedPanels_'.Gn_Rnd(20);	
	$CntWb .= "var $__id_tab = new Spry.Widget.TabbedPanels('$__id_tab');";
?>
<div id="<?php echo $__id_tab ?>" class="VTabbedPanels">
    <ul class="TabbedPanelsTabGroup">
		<li class="TabbedPanelsTab" tabindex="6" id="modulos_tipo"><?php echo Spn('','','_tt_icn _tt_icn_bnch').TX_TPPRGS ?></li>
		<li class="TabbedPanelsTab" tabindex="9" id="periodos"><?php echo Spn('','','_tt_icn _tt_icn_strt').TX_PRDS ?></li>
		<li class="TabbedPanelsTab" tabindex="9" id="posgrados"><?php echo Spn('','','_tt_icn _tt_icn_psg').MDL_PSG ?></li>
		<li class="TabbedPanelsTab" tabindex="9" id="pregrado"><?php echo Spn('','','_tt_icn _tt_icn_prg').TT_PRG ?></li>
		<li class="TabbedPanelsTab" tabindex="9" id="educon"><?php echo Spn('','','_tt_icn _tt_icn_con').TX_COND ?></li>
		<li class="TabbedPanelsTab" tabindex="9" id="educon"><?php echo Spn('','','_tt_icn _tt_icn_rose').TX_ROSEA ?></li>
     </ul>
    <div class="TabbedPanelsContentGroup">
        <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_SIS_PRO_TP_BD, 'i'=>'id_protp', 't'=>'protp_nm']); ?></div>
		<div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_SIS_PRO_PRD_BD, 'i'=>'id_proprd', 't'=>'proprd_tt']); ?></div>
		<div class="TabbedPanelsContent"><?php echo __bl_Ls2(['bd'=>'_pro, sis_pro_tp', 'i'=>'pro_cdc', 't'=>'pro_nm', 'tp'=>'2']); ?></div>
		<div class="TabbedPanelsContent"><?php echo __bl_Ls2(['bd'=>'_pro, sis_pro_tp', 'i'=>'pro_cdc', 't'=>'pro_nm', 'tp'=>'3']); ?></div>		
		<div class="TabbedPanelsContent"><?php echo __bl_Ls2(['bd'=>'_pro, sis_pro_tp', 'i'=>'id_pro', 't'=>'pro_nm', 'tp'=>'1']); ?></div>
		<div class="TabbedPanelsContent"><?php echo __bl_Ls2(['bd'=>'_pro, sis_pro_tp', 'i'=>'id_pro', 't'=>'pro_nm', 'tp'=>'4']); ?></div>
    </div>
</div>