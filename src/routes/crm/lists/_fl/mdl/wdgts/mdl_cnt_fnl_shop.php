<div class="_fnl_tml_est">
	<ul>
		<li title="Generado" class="gen"><div class="_lbl">Generado</div></li>
		<li title="Asignado" class="asg"><div class="_lbl">Asignado</div></li>
		<li title="Picking" class="pick on"><div class="_lbl">Picking</div></li>
		<li title="Facturado" class="fac"><div class="_lbl">Facturado</div></li>
		<li title="Despachado" class="dspc"><div class="_lbl">Despachado</div></li>
		<li title="Entregado" class="entr"><div class="_lbl">Entregado</div></li>
	</ul>
</div>

<style>
	
		
	._fnl_tml_est{ position: relative; display: block; width: 100%; margin-top: 50px; margin-bottom: 50px; height: 50px; }
	._fnl_tml_est::before{ width: 100%; height: 4px; background-color: #bfc4c4; position: absolute; left: 0; top: 50%; margin-top: 13px; display: block; z-index: 1; }
	._fnl_tml_est ul{ padding: 0; margin: 0; text-align: center; list-style: none; display: block; width: 100%; z-index: 2; position: absolute; left: 0; top: 7px; }
			
	._fnl_tml_est ul li{ display: inline-block; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px;  position: relative; background-color: white; width: 60px; height: 60px; margin-right:5%; background-color: white; cursor: pointer; }
	._fnl_tml_est ul li ._lbl{ display: none; font-size: 9px; text-align: center; border:none; color: white; padding: 2px 3px; position: absolute; top: -25px; width: 60px; text-overflow: ellipsis; overflow: hidden; left: 50%; margin-left: -30px; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; font-weight: 700; }
	._fnl_tml_est ul li.on ._lbl{ display: block; }
	._fnl_tml_est ul li:hover ._lbl{ display: block; }
	
	._fnl_tml_est ul li::before{ border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; position: absolute; left: 0; top:0; border: 2px solid #cfcbcb; width: 60px; height: 60px; background-repeat: no-repeat; background-position: center center; background-size: auto 60%; background-color: white; z-index: 2; opacity: 0.2; }
	
	._fnl_tml_est ul:hover li.on ._lbl{ display: none; }
	
	
	
	._fnl_tml_est ul li.gen::before{ border-color:#a20000; background-image:url('<?php echo DMN_IMG_ESTR_SVG; ?>ord_est_gen.svg');  }
	._fnl_tml_est ul li.gen ._lbl{ background-color:#a20000; }
	._fnl_tml_est ul li.asg::before{ border-color:#dd5d00; background-image:url('<?php echo DMN_IMG_ESTR_SVG; ?>ord_est_asg.svg'); }
	._fnl_tml_est ul li.asg ._lbl{ background-color:#dd5d00; }
	._fnl_tml_est ul li.pick::before{ border-color:#ead300; background-image:url('<?php echo DMN_IMG_ESTR_SVG; ?>ord_est_pick.svg'); opacity: 1; }
	._fnl_tml_est ul li.pick ._lbl{ background-color:#ead300; }
	._fnl_tml_est ul li.fac::before{ border-color:#a8c600; background-image:url('<?php echo DMN_IMG_ESTR_SVG; ?>ord_est_fac.svg'); }
	._fnl_tml_est ul li.fac ._lbl{ background-color:#a8c600; }
	._fnl_tml_est ul li.dspc::before{ border-color:#2ca000; background-image:url('<?php echo DMN_IMG_ESTR_SVG; ?>ord_est_dspc.svg'); }
	._fnl_tml_est ul li.dspc ._lbl{ background-color:#2ca000; }
	._fnl_tml_est ul li.entr::before{ border-color:#00a0a5; background-image:url('<?php echo DMN_IMG_ESTR_SVG; ?>ord_est_entr.svg'); }
	._fnl_tml_est ul li.entr ._lbl{ background-color:#00a0a5; }
	
	._fnl_tml_est ul li:last-child{ margin-right: 0 !important; }
	
	

</style>	