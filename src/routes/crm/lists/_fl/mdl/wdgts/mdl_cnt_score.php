<div id="Lead_Score_Bx">
    
    <section class="--ord-scre _anm">
	    
	    <?php echo h2('NPS '.Spn('Net Promote Score')); ?>
	    
	    <div class="_tml_est">
			<ul>
				<li class="pick">Atención <div class="rsl bad"> <i>5</i></div></li>
				<li class="gen">Productos <div class="rsl mdm"> <i>8</i></div></li>
				<li class="asg">Tiempo Entrega <div class="rsl good"> <i>10</i></div></li>	
			</ul>
		</div>
	</section>
</div>

<style>
	
	
	/*-------------- PEDIDOS - CALIFICACIÓN --------------*/
	
		.--ord-scre{ padding: 10px 30px 30px 30px; margin-top: 30px; margin-bottom: 30px; border:none; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; background-color: #eef0f1; }
		
		.--ord-scre h2{ text-align: center !important; width: 100%; border: none !important; background-color: transparent !important; margin-bottom: 20px; padding-bottom: 20px !important; }
		.--ord-scre h2 span{ color: #b4b3b3; font-size: 0.8em; }
		
		.--ord-scre ul{ list-style: none; margin: 0; padding: 0; }
		.--ord-scre ul li{ text-align: left; position: relative; width: 100%; padding: 0 30px 10px 0; margin-bottom: 10px; border-bottom: 2px solid white;  }
		.--ord-scre ul li .rsl{  position: absolute; right: 0; top: 0; }	
		.--ord-scre ul li .rsl::after{ border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; display: block; width: 20px; height: 20px; display: inline-block; margin-left: 5px; margin-bottom: -5px; background-repeat: no-repeat; background-position: center center; background-size: auto 100%; }
		
		.--ord-scre ul li .rsl i{ font-style: normal; font-weight: bolder; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; width: 20px; height: 20px; line-height: 20px; color: white; display: inline-block; font-size: 12px; font-weight: 700; text-align: center; }
		
		
		.--ord-scre ul li .rsl.bad i{ background-color: #9d0000; }
		.--ord-scre ul li .rsl.mdm i{ background-color: #c69100; }
		.--ord-scre ul li .rsl.good i{ background-color: #167100; }
		
		
		.--ord-scre ul li .rsl.bad::after{ background-image: url('https://pickr.sumrdev.com/<?php echo DB_CL_FLD; ?>/img/score_bad.svg'); }
		.--ord-scre ul li .rsl.mdm::after{ background-image: url('https://pickr.sumrdev.com/<?php echo DB_CL_FLD; ?>/img/score_mdm.svg');  }
		.--ord-scre ul li .rsl.good::after{ background-image: url('https://pickr.sumrdev.com/<?php echo DB_CL_FLD; ?>/img/score_good.svg'); }
		
		
		.--ord-scre ul li .rsl i{}
	
</style>	