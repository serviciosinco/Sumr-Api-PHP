<?php 
	$__id_tab = 'TabbedPanels_'.Gn_Rnd(20);	
	$CntWb .= "var $__id_tab = new Spry.Widget.TabbedPanels('$__id_tab');";
?>
<div id="<?php echo $__id_tab ?>" class="VTabbedPanels">
    <ul class="TabbedPanelsTabGroup">

         <li class="TabbedPanelsTab" tabindex="11" id="colegiosvariables"><?php echo Spn('','','_tt_icn _tt_icn_cod').TX_VRBLS ?></li>
                            <li class="TabbedPanelsTab" tabindex="12" id="colegiostipologia"><?php echo Spn('','','_tt_icn _tt_icn_est').TX_TPLG ?></li>
                            <li class="TabbedPanelsTab" tabindex="13" id="colegiosportafolio"><?php echo Spn('','','_tt_icn _tt_icn_brf').TX_PRTFL ?></li>
                            <li class="TabbedPanelsTab" tabindex="14" id="colegiostamaño"><?php echo Spn('','','_tt_icn _tt_icn_bnch').TX_SIZE ?></li>
                            <li class="TabbedPanelsTab" tabindex="15" id="colegiosbachiderato"><?php echo Spn('','','_tt_icn _tt_icn_psg').TX_BCH ?></li>
                            <li class="TabbedPanelsTab" tabindex="16" id="colegiosgrupos"><?php echo Spn('','','_tt_icn _tt_icn_con').TX_GRP ?></li>
                            <li class="TabbedPanelsTab" tabindex="17" id="colegioszonas"><?php echo Spn('','','_tt_icn _tt_icn_wrl').TX_ZNS ?></li>
                            <li class="TabbedPanelsTab" tabindex="18" id="colegiosestados"><?php echo Spn('','','_tt_icn _tt_icn_bsc').TX_ESTS ?></li>
                            
                            <li class="TabbedPanelsTab" tabindex="19" id="colegiosexamenes"><?php echo Spn('','','_tt_icn _tt_icn_crc').TX_EXA ?></li>
                            <li class="TabbedPanelsTab" tabindex="20" id="colegiosenfasis"><?php echo Spn('','','_tt_icn _tt_icn_gstn').TX_ENF ?></li>
        
							<li class="TabbedPanelsTab" tabindex="21" id="cargocontacto"><?php echo Spn('','','_tt_icn _tt_icn_bsc').TX_PRSCHRGCNT ?></li>
                            <li class="TabbedPanelsTab" tabindex="22" id="funcioncontacto"><?php echo Spn('','','_tt_icn _tt_icn_crc').TX_FNCPRSCNT ?></li>
                            <li class="TabbedPanelsTab" tabindex="23" id="tratamiento"><?php echo Spn('','','_tt_icn _tt_icn_rqu').TX_TTRTMT ?></li>
                            <li class="TabbedPanelsTab" tabindex="24" id="religion"><?php echo Spn('','','_tt_icn _tt_icn_rose').TX_RLGN ?></li>

							<li class="TabbedPanelsTab" tabindex="27" id="tipocolegio"><?php echo Spn('','','_tt_icn _tt_icn_est').TX_TP ?></li>
                            <li class="TabbedPanelsTab" tabindex="28" id="calendario"><?php echo Spn('','','_tt_icn _tt_icn_ent').TX_CLNDR ?></li>
                            <li class="TabbedPanelsTab" tabindex="26" id="genero"><?php echo Spn('','','_tt_icn _tt_icn_pln').TX_SX ?></li>

    </ul>
    <div class="TabbedPanelsContentGroup">
        <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_CLG_VAR_BD, 'i'=>'id_clgvar', 't'=>'clgvar_nm']); ?></div>
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_CLG_TP_BD, 'i'=>'id_clgtp', 't'=>'clgtp_tt']); ?></div>
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_CLG_PTF_BD, 'i'=>'id_clgptf', 't'=>'clgptf_tt']); ?></div>
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_SIS_CLG_TMN_BD, 'i'=>'id_clgtmn', 't'=>'clgtmn_tt']); ?></div>
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_SIS_CLG_BCH_TP_BD, 'i'=>'id_clgbchtp', 't'=>'clgbchtp_tt']); ?></div>
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_CLG_GRP_BD, 'i'=>'id_clggrp', 't'=>'clggrp_nm']); ?></div>
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>'clg_zna', 'i'=>'id_clgzna', 't'=>'clgzna_tt']); ?></div>
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_CLG_SDS_EST_BD, 'i'=>'id_clgsdsest', 't'=>'clgsdsest_tt']); ?></div>
                            
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_SIS_EXA_BD, 'i'=>'id_sisexa', 't'=>'sisexa_tt']); ?></div>
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_SIS_ENF_BD, 'i'=>'id_sisenf', 't'=>'sisenf_tt']); ?></div>
                            
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_SIS_CRG_BD, 'i'=>'id_siscrg', 't'=>'siscrg_tt']); ?></div>
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_SIS_FNC_BD, 'i'=>'id_sisfnc', 't'=>'sisfnc_tt']); ?></div>
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_SIS_TRT_BD, 'i'=>'id_sistrt', 't'=>'sistrt_tt']); ?></div>
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_SIS_RLG_BD, 'i'=>'id_sisrlg', 't'=>'sisrlg_tt']); ?></div>
                            
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>MDL_CLG_TP_BD, 'i'=>'id_clgtp', 't'=>'clgtp_tt']); ?></div>
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>'prg_cln', 'i'=>'id_prgcln', 't'=>'prgcln_nm']); ?></div>
                            <div class="TabbedPanelsContent"><?php echo __bl_Ls(['bd'=>'sis_clgsds_sx', 'i'=>'id_clgsdssx', 't'=>'clgsdssx_nm']); ?></div>
    </div>
</div>