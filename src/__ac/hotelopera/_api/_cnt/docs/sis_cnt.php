<?php 
	$__id_tab = 'TabbedPanels_'.Gn_Rnd(20);	
	$CntWb .= "var $__id_tab = new Spry.Widget.TabbedPanels('$__id_tab');";
?>
<div id="<?php echo $__id_tab ?>" class="VTabbedPanels">
    <ul class="TabbedPanelsTabGroup">
        <li class="TabbedPanelsTab" tabindex="1" id="estados"><?php echo Spn('','','_tt_icn _tt_icn_bsc').MDL_SIS_CNT_EST ?></li>
        <li class="TabbedPanelsTab" tabindex="2" id="fuentes"><?php echo Spn('','','_tt_icn _tt_icn_crc').MDL_SIS_FNT ?></li>
        <li class="TabbedPanelsTab" tabindex="3" id="genero"><?php echo Spn('','','_tt_icn _tt_icn_chck').MDL_SIS_SX ?></li>
        <li class="TabbedPanelsTab" tabindex="4" id="documento_tipo"><?php echo Spn('','','_tt_icn _tt_icn_rqu').MDL_SIS_DOC ?></li>
        <li class="TabbedPanelsTab" tabindex="5" id="no_interes"><?php echo Spn('','','_tt_icn _tt_icn_rose').MDL_NOI ?></li>
        <li class="TabbedPanelsTab" tabindex="8" id="eps"><?php echo Spn('','','_tt_icn _tt_icn_pln').MDL_EPS ?></li>
        <li class="TabbedPanelsTab" tabindex="9" id="gestion_tipo"><?php echo Spn('','','_tt_icn _tt_icn_est').MDL_HIS_TP ?></li>
    </ul>
    <div class="TabbedPanelsContentGroup">
        <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>TB_SIS_CNT_EST, 'i'=>'id_siscntest', 't'=>'siscntest_tt', 'c'=>'siscntest_clr_bck', 'con'=>'siscntest_con', 'prg'=>'siscntest_prg', 'psg'=>'siscntest_psg']); ?></div>
        <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>TB_SIS_FNT, 'i'=>'id_sisfnt', 't'=>'sisfnt_nm']); ?></div>
        <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>TB_SIS_SX, 'i'=>'id_sissx', 't'=>'sissx_tt']); ?></div>
        <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_SISDOC_BD, 'i'=>'id_sisdoc', 't'=>'sisdoc_nm']); ?></div>
        <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>TB_SIS_CNT_NOI, 'i'=>'id_siscntnoi', 't'=>'siscntnoi_nm']); ?></div>
    </div>
</div>