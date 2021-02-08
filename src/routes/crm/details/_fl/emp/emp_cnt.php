<?php $_dt_empcnt = GtEmpCntDt($__i); ?>

<div class="__cnt_dt"> 
 	<div class=" __bx_dt"> 	                    
	 		<div class="col_1"> 
				<?php echo h2(TX_DTLL.' '.TX_CNT) ?>
			    <ul class="ls_1" >
				    <li id="_li_ap"><?php if($_dt_empcnt->nm != NULL){ echo Strn(TT_FM_NM,'',true).ctjTx($_dt_empcnt->nm,'in'); } ?></li>
			        <li id="_li_nm"><?php if($_dt_empcnt->ap != NULL){ echo Strn(TT_FM_AP,'',true).ctjTx($_dt_empcnt->ap,'in'); } ?></li>
			        <li id="_li_ap"><?php if($_dt_empcnt->cel != NULL){ echo Strn(TX_CEL,'',true).ctjTx($_dt_empcnt->cel,'in'); } ?></li>
			        <li id="_li_ap"><?php if($_dt_empcnt->tel != NULL){ echo Strn(TX_TEL,'',true).ctjTx($_dt_empcnt->tel,'in'); } ?></li>
				</ul>
			</div>
			<div class="col_1"> 	
				<br><br>	
			    <ul class="ls_1" >
				   	<li id="_li_ap"><?php if($_dt_empcnt->ext != NULL){ echo Strn(TX_EXT,'',true).ctjTx($_dt_empcnt->ext,'in'); } ?></li>
					<li id="_li_ap"><?php if($_dt_empcnt->depto != NULL){ echo Strn(TX_DEPTO,'',true).ctjTx($_dt_empcnt->depto,'in'); } ?></li>
			        <li id="_li_ap"><?php if($_dt_empcnt->crg != NULL){ echo Strn(TT_FM_CRG,'',true).ctjTx($_dt_empcnt->crg,'in'); } ?></li>
			        <li id="_li_ap"><?php if($_dt_empcnt->eml != NULL){ echo Strn(TT_FM_EML,'',true).ctjTx($_dt_empcnt->eml,'in'); } ?></li>
				</ul>
			</div>
	</div>
</div>




