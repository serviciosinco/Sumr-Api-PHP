<div id="<?php echo $__ec->id_rnd ?>_rsl" class="_sch">
	<div class="_cblq" id="inp_sch<?php echo $__ec->id_rnd ?>">
		<?php echo _HTML_Input('Cnt_Doc_Sch'.$__ec->id_rnd , TT_FM_DC.' / '.TT_FM_EML, '', FMRQD_NM, 'text', ['ac'=>'off']); ?>
		<button class="_sch_go _anm" id="Cnt_Doc_Sch_Btn<?php echo $__ec->id_rnd ?>"></button>
	</div>
	
	<div class="_rsl" id="Cnt_Doc_Sch_Rsl<?php echo $__ec->id_rnd  ?>">
		<p></p>
		<ul class="dvorf_ls"></ul>
		<div class="dvorf_cod">
			<?php echo HTML_inp_hd('CRef'.$__ec->id_rnd, $_ref); ?>
			<?php echo _HTML_Input('Dvrf'.$__ec->id_rnd, TX_VRFCOD, '', FMRQD, 'text'); ?>
			<button class="_sch_go _anm" id="Cnt_Doc_Sch_Btn_All<?php echo $__ec->id_rnd ?>" data-prc="<?php echo $__tpp; ?>"></button>
			<!--<button class="_sch_bck _anm" id="Cnt_Doc_Sch_Btn_Bck<?php echo $__ec->id_rnd ?>"></button>-->
		</div>
	</div>
</div>