<?php

	$_up_cls = 'MyUp_FmUp'; $_up_fm_cls = 'MyUp_FmUpBd'; $__up_ls = 'up'; $__up_fm = 'fm_up';

?>
<div class="Cvr_UpDb">

	<?php

		$__ld_mdl_cnt = __MnBtn(['li'=>'no', 'h'=>__t('mdl_cnt',true), 't'=>$__up_fm, 'c'=>Spn('Cargar', 'ok'), 'cls'=>$_up_fm_cls]);
		$__ld_mdl_cnt_tra = __MnBtn(['li'=>'no', 'h'=>__t('mdl_cnt_tra',true), 't'=>$__up_fm, 'c'=>Spn('Cargar', 'ok'), 'cls'=>$_up_fm_cls]);
		$__ld_cnt = __MnBtn(['li'=>'no', 'h'=>__t('cnt',true), 't'=>$__up_fm, 'c'=>Spn('Cargar', 'ok'), 'cls'=>$_up_fm_cls]);

		$___Dt->_dvlsfl_all([
			['n'=>'bsc', 'l'=>TX_INIC],
			['n'=>'cnt', 't'=>'cnt', 'l'=>'Informacion Contactos'.$__ld_cnt, 'f'=>'up'],
			['n'=>'mdl_cnt', 't'=>'mdl_cnt', 'l'=>'Oportunidades - Contactos'.$__ld_mdl_cnt, 'f'=>'up' ],
			['n'=>'mdl_cnt_tra', 't'=>'mdl_cnt_tra', 'l'=>'Tickets'.$__ld_mdl_cnt_tra, 'f'=>'up' ],
			['n'=>'snd_ec_lsts', 't'=>'snd_ec_lsts_up', 'l'=>'Correos Listas'.$__ld_mdl_cnt, 'f'=>'up' ],
			['n'=>'snd_sms_cmpg', 't'=>'snd_sms_cmpg', 'l'=>'Campaña SMS'.$__ld_mdl_cnt, 'f'=>'up']
		],[
			'idb'=>'ok',
			'hd'=>'no',
			'sng'=>'ok',
			'icn_sty'=>'bsc',
			'tomny'=>'ok',
			'dtb'=>1
		]);


	?>

	<div id="<?php echo $___Dt->tab->id ?>" class="VTabbedPanels">

    <ul class="TabbedPanelsTabGroup">
	    	<li class="TabbedPanelsTab" style="display: none;"></li>
	        <?php echo $___Dt->tab->bsc->l ?>
	        <?php echo $___Dt->tab->cnt->l ?>
	        <?php echo $___Dt->tab->mdl_cnt->l ?>
			<?php echo $___Dt->tab->mdl_cnt_tra->l ?>
	        <?php echo $___Dt->tab->snd_ec_lsts->l ?>
	        <?php echo $___Dt->tab->snd_sms_cmpg->l ?>
        </ul>
        <div class="TabbedPanelsContentGroup">

	        <section class="_cvr" style="background-color:#a0d6e6;">
		        <iframe src="<?php echo DMN_ANM; ?>cargas_masivas/index.html" frameborder="0" width="100%" scrolling="no" height="200"></iframe>
		    </section>

            <div class="TabbedPanelsContent">
	            <div class="_intro">
				    <section class="_p">
						<div class="_c c1">
							<h2>Comencemos</h2>
							<div class="_img books"></div>
							<p>Esta sección de nuestra herramienta está diseñada para ayudarte en el proceso de aprendizaje y a mejorar tu experiencia con ella. Construimos de forma constante y didáctica todo el material para acelerar tu curva de aprendizaje e impactar de manera positiva los procesos de implementación de nuestra aplicación.</p>
						</div>
						<div class="_c c2">
							<h2>Video-Tutoriales</h2>
							<div class="_img studnt"></div>
							<p>Consulta todas las secciones ubicadas en la barra lateral, a través de diferentes cápsulas u objetos de aprendizaje, donde podrás conocer paso a paso cómo desarrollar cada acción o actividad dentro de nuestra aplicación. Consulta el botón más información para obtener detalles e incluso deja tus comentarios sobre estos.</p>
						</div>
						<div class="_c c3">
							<h2>Mejoramiento</h2>
							<div class="_img knw"></div>
							<p>Conoce en detalle el manejo de nuestra herramienta y tu rol asignado, de esta manera podrás impactar de manera positiva tu área y así lograr actividades sistematizadas, organizadas y con medición que apunten al mejoramiento continuo de los diferentes procesos comerciales, estratégicos y operativos de tu organización.</p>
						</div>
				    </section>
				</div>

            </div>
            <div class="TabbedPanelsContent">
                <?php echo $___Dt->tab->cnt->d ?>
            </div>
            <div class="TabbedPanelsContent">
                <?php echo $___Dt->tab->mdl_cnt->d ?>
            </div>
			<div class="TabbedPanelsContent">
                <?php echo $___Dt->tab->mdl_cnt_tra->d ?>
            </div>
            <div class="TabbedPanelsContent">
                <?php echo $___Dt->tab->snd_ec_lsts->d ?>
            </div>
            <div class="TabbedPanelsContent">
                <?php echo $___Dt->tab->snd_sms_cmpg->d ?>
            </div>
        </div>
    </div>
	<?php
		$CntWb .= "$('.Cvr_UpDb .TabbedPanelsTab').click(function(){ $('.Cvr_UpDb ._cvr').delay(300).show(); });";
	?>
</div>

<style>

	.Cvr_UpDb .VTabbedPanels { overflow: hidden; zoom: 1; width: 100%; }
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsTabGroup{ float: left; width: 20%; height: 50em; position: relative; border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; padding: 0px; background-color: var(--tabs-bg-color) !important; margin: 0px; padding-top: 40px; }
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsTabGroup ._hd{ display: none; }
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsTab { background-repeat: no-repeat; background-position: center center; position: relative; float: none; list-style: none; cursor: pointer; font-family: Economica; font-size: 1.1em; font-weight: 300; margin-top: 0px; margin-right: 1px; margin-bottom: 0px; margin-left: 0px; padding-top: 7px; padding-right: 20px; padding-bottom: 14px; padding-left: 0px; /*background-color: #FFF;*/ border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #D3D1D5; -webkit-transition: all 0.3s ease 0s; -moz-transition: all 0.3s ease 0s; -ms-transition: all 0.3s ease 0s; -o-transition: all 0.3s ease 0s; transition: all 0.3s ease 0s; color: #999; text-align: left; }
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsTabSelected { border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #333; }
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsContentGroup { clear: none; float: left; padding: 0px 0px 100px 0px; width: 80%; height: auto; }
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsContent{ width: 99%; padding-left: 1%; padding-right: 0% !important; }
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsContent .ln_1 h2,
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsContent > h2{ font-family: Economica; color: #CCC; font-weight: 300; margin-bottom: 15px; border-bottom-width: 1px; border-bottom-style: dotted; border-bottom-color: #CCC; padding-bottom: 15px; }
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsTab ._tt_icn{ margin-left: 20px; background-size: auto 70%; width: 40px; height: 40px; background-position: center center; }


	.Cvr_UpDb .VTabbedPanels .TabbedPanelsContent .Tt_Tb h2 span { color: var(--main-bg-color) !important; }

	.Cvr_UpDb .VTabbedPanels .TabbedPanelsTab ._tt_icn._tt_icn_bsc{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_upl_main.svg); }
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsTab ._tt_icn._tt_icn_cnt{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_upl_cnt.svg); }
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsTab ._tt_icn._tt_icn_mdl_cnt{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_upl_mdl_cnt.svg); }
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsTab ._tt_icn._tt_icn_mdl_cnt_tra{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_upl_mdl_cnt_tra.svg); }
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsTab ._tt_icn._tt_icn_snd_ec_lsts{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_upl_snd_ec_lsts.svg); }
	.Cvr_UpDb .VTabbedPanels .TabbedPanelsTab ._tt_icn._tt_icn_snd_sms_cmpg{ background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>dsh_upl_snd_sms_cmpg.svg); }


	.Cvr_UpDb .VTabbedPanels.mny .TabbedPanelsTab{ padding: 0; }
	.Cvr_UpDb .VTabbedPanels.mny .TabbedPanelsTab ._tt_icn{ margin-left: 0px; width:50px; height:50px; background-size: auto 40%; margin: 0; }
	.Cvr_UpDb .VTabbedPanels.mny .TabbedPanelsTab._ldp ._tt_icn { background-image: url(<?php echo DMN_IMG_ESTR_SVG ?>loader_black.svg) !important; }
	.Cvr_UpDb .VTabbedPanels.mny .TabbedPanelsTabSelected{ background-size: auto 70%; background-color: rgba(255, 255, 255, 0.5); border: 2px dashed var(--main-bg-color) !important; }

	.Cvr_UpDb ._intro ._p{ display: flex; padding-bottom: 100px; }
	.Cvr_UpDb ._intro ._p ._c{ vertical-align: top; min-height: 200px; width: 33.3%; font-size: 11px; font-family: Work Sans, Roboto, Tahoma; padding: 40px 50px 20px 50px; color: #64757b;
	}
	.Cvr_UpDb ._intro ._p ._c h2{ font-weight: 500; font-size: 23px; border: none; text-align: center; color: #0e0e0e; }
	.Cvr_UpDb ._intro ._p ._c ._img{ width: 100px; height: 100px; margin-left: auto; margin-right: auto; background-size: 100% auto; background-position: center center; background-repeat: no-repeat; margin-top: 20px; margin-bottom: 20px; }
	.Cvr_UpDb ._intro ._p ._c ._img.books{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lrn_intro_books.svg');}
	.Cvr_UpDb ._intro ._p ._c ._img.studnt{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lrn_intro_student.svg');}
	.Cvr_UpDb ._intro ._p ._c ._img.knw{ background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>lrn_intro_know.svg');}
	.Cvr_UpDb ._intro ._p ._c p{ font-weight: 300; text-align: justify; }


</style>


<?php

	$CntWb .= '

	$(".'.$_up_fm_cls.'").click(function(){

		var lurl = $(this).attr("l-url")+"'.TXGN_POP.'&Rd="+Math.random();

		$.colorbox({
			href:lurl,
			width:"400",
			height:"255",
			overlayClose:false,
			escKey:false,
			onLoad:function(){
				$("#colorbox").removeAttr("tabindex");
			},
			onClosed:function(){
				SUMR_Main.anm.h_cmpct();
			}
		});

	});

	$(".'.$_up_cls.'").click(function(){

		var lurl = $(this).attr("l-url")+"'.TXGN_POP.'&Rd="+Math.random();

		$.colorbox({
			href:lurl,
			width:"95%",
			height:"95%",
			overlayClose:false,
			escKey:false,
			onLoad:function(){ $("#colorbox").removeAttr("tabindex");},
			onClosed:function(){ SUMR_Main.anm.h_cmpct();}
		});

	});



	';

?>