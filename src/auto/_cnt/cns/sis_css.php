<style>
	span._ok{ color: #106100; }
	span._no{ color: #ff0000; }
	span._w{ color: #ffffff; }
</style>
<?php
if(class_exists('CRM_Cnx')){


	if(!isN($this->g__s2)){

		echo $this->h1('Build '.$this->g__s2.'.css');
		$this->_BldCss(['a'=>[ ['s'=>$this->g__s2.'.css'] ], 'd'=>'css', 'f'=>$this->g__s2.'.css' ]);

	}else{

		//-------------------- CRM CSS PRIMERA CARGA --------------------//

			echo $this->h1('all.css');

			$__css_1[] = ['s'=>'superfish.css'];
			$__css_1[] = ['s'=>'anm.css'];
			$__css_1[] = ['s'=>'cl.css'];
			$__css_1[] = ['s'=>'estr.css'];
			$__css_1[] = ['s'=>'SpryTabbedPanels.css'];
			$__css_1[] = ['s'=>'inf.css'];
			$__css_1[] = ['s'=>'panel.css'];
			$__css_1[] = ['s'=>'lginagn.css'];
			$__css_1[] = ['s'=>'dcs.css'];
			$__css_1[] = ['s'=>'updb.css'];
			$__css_1[] = ['s'=>'sim.css'];
			$__css_1[] = ['s'=>'myp.css'];
			$__css_1[] = ['s'=>'plcy.css'];
			$__css_1[] = ['s'=>'sms.css'];
			$__css_1[] = ['s'=>'tablas.css'];
			$__css_1[] = ['s'=>'jquery-te-1.4.0.css'];
			$__css_1[] = ['s'=>'jquery.Jcrop.css'];
			$__css_1[] = ['s'=>'ui/jquery-ui.css'];
			$__css_1[] = ['s'=>'ui/jquery-ui-theme.css'];

			$__css_1[] = ['s'=>'datedropper.css'];
			$__css_1[] = ['s'=>'datedropper_cliente.css'];
			$__css_1[] = ['s'=>'gn.css'];
			$__css_1[] = ['s'=>'fm.css'];
			$__css_1[] = ['s'=>'SpryCollapsiblePanel.css'];
			$__css_1[] = ['s'=>'chosen.css'];
			$__css_1[] = ['s'=>'select2.css'];
			$__css_1[] = ['s'=>'jquery.tag.css'];
			$__css_1[] = ['s'=>'timeline.css'];
			$__css_1[] = ['s'=>'sweetalert.css'];
			$__css_1[] = ['s'=>'informes.css'];
			$__css_1[] = ['s'=>'ec.css'];
			$__css_1[] = ['s'=>'dashboards.css'];
			$__css_1[] = ['s'=>'SUMR_Mic.css'];
			$__css_1[] = ['s'=>'cnt.css'];
			$__css_1[] = ['s'=>'carousel.css'];
			$__css_1[] = ['s'=>'snd.css'];
			$__css_1[] = ['s'=>'up.css'];
			//$__css_1[] = ['s'=>'bootstrap.css'];


			$this->_BldCss(['a'=>$__css_1, 'd'=>'css', 'f'=>'all.css' ]);

		//-------------------- CRM CSS PRIMERA CARGA --------------------//

			echo $this->h1('all_m.css');

			$__css_1_1[] = ['s'=>'dsh.css'];
			$__css_1_1[] = ['s'=>'chck.css'];
			$__css_1_1[] = ['s'=>'eml.css'];
			$__css_1_1[] = ['s'=>'atmt.css'];
			$__css_1_1[] = ['s'=>'mdlcnt.css'];

			$this->_BldCss(['a'=>$__css_1_1, 'd'=>'css', 'f'=>'all_m.css' ]);


		//-------------------- CRM CSS PRIMERA CARGA --------------------//

			echo $this->h1('all_print.css');
			$__css_2[] = ['s'=>'tablas.css'];
			$__css_2[] = ['s'=>'fm.css'];
			$this->_BldCss(['a'=>$__css_2, 'd'=>'css', 'f'=>'all_print.css' ]);

		//-------------------- CRM CSS PACK MIRROR --------------------//

			echo $this->h1('codemirror.css');
			$__css_3[] = ['s'=>'codemirror.css'];
			$__css_3[] = ['s'=>'codemirror/3024-night.css'];
			$__css_3[] = ['s'=>'codemirror/solarized.css'];
			$this->_BldCss(['a'=>$__css_3, 'd'=>'css', 'f'=>'codemirror.css' ]);

		//-------------------- COMPACT JQUERY UI --------------------//

			echo $this->h1('jquery-ui-all.css');

			$__css_jqueryui[] = ['s'=>'ui/jquery-ui.css'];
			$__css_jqueryui[] = ['s'=>'ui/jquery-ui-theme.css'];

			$this->_BldCss(['a'=>$__css_smrnte, 'd'=>'css', 'f'=>'ui/jquery-ui-all.css' ]);

		//-------------------- CRM CSS MEETS --------------------//

			echo $this->h1('meet.css');
			$__css_meet[] = ['s'=>'sb/meet/main.css'];
			$__css_meet[] = ['s'=>'sb/meet/tab.css'];
			$__css_meet[] = ['s'=>'chck.css'];
			$this->_BldCss(['a'=>$__css_meet, 'd'=>'css', 'f'=>'sb/meet/all.css' ]);

		//-------------------- CRM ACCOUNTS --------------------//

			echo $this->h1('acc.css');
			$__css_acc[] = ['s'=>'sb/acc/base.css'];
			$__css_acc[] = ['s'=>'sb/acc/hd/all.css'];
			$__css_acc[] = ['s'=>'sb/acc/large/all.css'];
			$__css_acc[] = ['s'=>'sb/acc/medium/all.css'];
			$__css_acc[] = ['s'=>'sb/acc/small/all.css'];
			$__css_acc[] = ['s'=>'sweetalert.css'];
			$this->_BldCss(['a'=>$__css_acc, 'd'=>'css', 'f'=>'sb/acc/main.css' ]);


		//-------------------- CRM CSS FORMS THEMES PICKER --------------------//

			echo $this->h1('thm.css');
			$__css_fm_pck[] = ['s'=>'sb/form/thm.css'];
			$__css_fm_pck[] = ['s'=>'chck.css'];
			$this->_BldCss(['a'=>$__css_fm_pck, 'd'=>'css', 'f'=>'sb/form/thm.css' ]);

		//-------------------- CRM CSS FORMS --------------------//

			echo $this->h1('forms.css');
			$__css_fm[] = ['s'=>'sb/form/themes/base/main.css'];
			$__css_fm[] = ['s'=>'sb/form/themes/base/dark.css'];
			$__css_fm[] = ['s'=>'sb/form/themes/base/icn.css'];
			$__css_fm[] = ['s'=>'ui/jquery-ui.css'];
			$__css_fm[] = ['s'=>'ui/jquery-ui-theme.css'];
			$__css_fm[] = ['s'=>'select2.css'];
			$this->_BldCss(['a'=>$__css_fm, 'd'=>'css', 'f'=>'sb/form/all.css' ]);

		//-------------------- CRM CSS FORMS - APPS --------------------//

			echo $this->h1('app.css');
			$__css_fm[] = ['s'=>'sb/form/themes/base/main.css'];
			$this->_BldCss(['a'=>[['s'=>'sb/form/app.css']], 'd'=>'css', 'f'=>'sb/form/app.css' ]);

		//-------------------- FORMS - THEMES --------------------//

			$__themes = __LsDt(['k'=>'fm_thm' ]);

			foreach($__themes->ls->fm_thm as $_th_k=>$_th_v){

				if($_th_v->key->vl != 'bsc'){

					$__css_thm_m=[];
					$__css_thm_md=[];
					$__css_thm_f=[];
					$__css_thm_fd=[];

					echo $this->h1('Theme '.$_th_v->tt.' Basic');
					$__css_thm_m[] = ['s'=>'sb/form/themes/'.$_th_v->key->vl.'/main.css'];
					$this->_BldCss(['a'=>$__css_thm_m, 'd'=>'css', 'f'=>'sb/form/themes/'.$_th_v->key->vl.'/main.css' ]);

					echo $this->h1('Theme '.$_th_v->tt.' Basic - Dark');
					$__css_thm_md[] = ['s'=>'sb/form/themes/'.$_th_v->key->vl.'/main.css'];
					$__css_thm_md[] = ['s'=>'sb/form/themes/'.$_th_v->key->vl.'/dark.css'];
					$this->_BldCss(['a'=>$__css_thm_md, 'd'=>'css', 'f'=>'sb/form/themes/'.$_th_v->key->vl.'/main-dark.css' ]);

					echo $this->h1('Theme '.$_th_v->tt.' Full');
					$__css_thm_f[] = ['s'=>'sb/form/themes/'.$_th_v->key->vl.'/main.css'];
					$__css_thm_f[] = ['s'=>'sb/form/themes/'.$_th_v->key->vl.'/icn.css'];
					$this->_BldCss(['a'=>$__css_thm_f, 'd'=>'css', 'f'=>'sb/form/themes/'.$_th_v->key->vl.'/full.css' ]);

					echo $this->h1('Theme '.$_th_v->tt.' Full - Dark');
					$__css_thm_fd[] = ['s'=>'sb/form/themes/'.$_th_v->key->vl.'/main.css'];
					$__css_thm_fd[] = ['s'=>'sb/form/themes/'.$_th_v->key->vl.'/dark.css'];
					$__css_thm_fd[] = ['s'=>'sb/form/themes/'.$_th_v->key->vl.'/icn.css'];
					$this->_BldCss(['a'=>$__css_thm_fd, 'd'=>'css', 'f'=>'sb/form/themes/'.$_th_v->key->vl.'/full-dark.css' ]);


				}

			}

		//-------------------- COMPACT SUMMERNOTE --------------------//

			echo $this->h1('summernote.css');

			$__css_smrnte[] = ['s'=>'summernote/summernote.css'];
			$__css_smrnte[] = ['s'=>'summernote/list-styles.css'];
			$__css_smrnte[] = ['s'=>'summernote/cleaner.css'];
			$__css_smrnte[] = ['s'=>'summernote/custom.css'];

			$this->_BldCss(['a'=>$__css_smrnte, 'd'=>'css', 'f'=>'summernote/all.css' ]);

		//-------------------- CRM CSS INDIVIDUALS --------------------//

			echo $this->h1('noty_animate.css');
			$this->_BldCss(['a'=>[['s'=>'noty_animate.css']], 'd'=>'css', 'f'=>'noty_animate.css' ]);

			echo $this->h1('uploadify.css');
			$this->_BldCss(['a'=>[['s'=>'uploadify.css']], 'd'=>'css', 'f'=>'uploadify.css' ]);

			echo $this->h1('call.css');
			$this->_BldCss(['a'=>[['s'=>'call.css']], 'd'=>'css', 'f'=>'call.css' ]);

			echo $this->h1('colorbox.css');
			$this->_BldCss(['a'=>[['s'=>'colorbox.css']], 'd'=>'css', 'f'=>'colorbox.css' ]);

			echo $this->h1('fancybox.css');
			$this->_BldCss(['a'=>[['s'=>'fancybox.css']], 'd'=>'css', 'f'=>'fancybox.css' ]);

			echo $this->h1('mCustomScrollbar.css');
			$this->_BldCss(['a'=>[['s'=>'mCustomScrollbar.css']], 'd'=>'css', 'f'=>'mCustomScrollbar.css' ]);

			echo $this->h1('summernote.css');
			$this->_BldCss(['a'=>[['s'=>'summernote/summernote.css']], 'd'=>'css', 'f'=>'summernote/summernote.css' ]);

			echo $this->h1('summernote/cleaner.css');
			$this->_BldCss(['a'=>[['s'=>'summernote/cleaner.css']], 'd'=>'css', 'f'=>'summernote/cleaner.css' ]);

			echo $this->h1('chat.css');
			$this->_BldCss(['a'=>[['s'=>'chat.css']], 'd'=>'css', 'f'=>'chat.css' ]);

			echo $this->h1('spectrum.css');
			$this->_BldCss(['a'=>[['s'=>'spectrum.css']], 'd'=>'css', 'f'=>'spectrum.css' ]);

			echo $this->h1('carousel.css');
			$this->_BldCss(['a'=>[['s'=>'carousel.css']], 'd'=>'css', 'f'=>'carousel.css' ]);

			echo $this->h1('jquery.upload.css');
			$this->_BldCss(['a'=>[['s'=>'jquery.upload.css']], 'd'=>'css', 'f'=>'jquery.upload.css' ]);

			echo $this->h1('bootstrap.css');
			$this->_BldCss(['a'=>[['s'=>'bootstrap.css']], 'd'=>'css', 'f'=>'bootstrap.css' ]);

			echo $this->h1('jquery-ui.css');
			$this->_BldCss(['a'=>[['s'=>'ui/jquery-ui.css']], 'd'=>'css', 'f'=>'ui/jquery-ui.css' ]);
			$this->_BldCss(['a'=>[['s'=>'ui/jquery-ui-theme.css']], 'd'=>'css', 'f'=>'ui/jquery-ui-theme.css' ]);

			echo $this->h1('sweetalert.css');
			$this->_BldCss(['a'=>[['s'=>'sweetalert.css']], 'd'=>'css', 'f'=>'sweetalert.css' ]);

			echo $this->h1('select2.css');
			$this->_BldCss(['a'=>[['s'=>'select2.css']], 'd'=>'css', 'f'=>'select2.css' ]);

			echo $this->h1('tra.css');
			$this->_BldCss(['a'=>[['s'=>'tra.css']], 'd'=>'css', 'f'=>'tra.css' ]);

			echo $this->h1('dsh.css');
			$this->_BldCss(['a'=>[['s'=>'dsh.css']], 'd'=>'css', 'f'=>'dsh.css' ]);

			echo $this->h1('SUMR_Widgets.css');
			$this->_BldCss(['a'=>[['s'=>'SUMR_Widgets.css']], 'd'=>'css', 'f'=>'SUMR_Widgets.css' ]);



			echo $this->h1('scl.css');
			$this->_BldCss(['a'=>[['s'=>'scl.css']], 'd'=>'css', 'f'=>'scl.css' ]);


			echo $this->h1('gn.css');
			$this->_BldCss(['a'=>[['s'=>'gn.css']], 'd'=>'css', 'f'=>'gn.css' ]);

			echo $this->h1('fullcalendar.css');
			$this->_BldCss(['a'=>[['s'=>'fullcalendar.css']], 'd'=>'css', 'f'=>'fullcalendar.css' ]);

			echo $this->h1('dev.css');
			$this->_BldCss(['a'=>[['s'=>'dev.css']], 'd'=>'css', 'f'=>'dev.css' ]);

			echo $this->h1('login.css');
			$this->_BldCss(['a'=>[['s'=>'login.css']], 'd'=>'css', 'f'=>'login.css' ]);

			echo $this->h1('basic.css');
			$this->_BldCss(['a'=>[['s'=>'basic.css']], 'd'=>'css', 'f'=>'basic.css' ]);


			echo $this->h1('flipbook.css');
			$this->_BldCss(['a'=>[['s'=>'flipbook/flipbook.style.css']], 'd'=>'css', 'f'=>'flipbook/flipbook.style.css' ]);
			$this->_BldCss(['a'=>[['s'=>'flipbook/font-awesome.css']], 'd'=>'css', 'f'=>'flipbook/font-awesome.css' ]);


			echo $this->h1('error.css');
			$this->_BldCss(['a'=>[['s'=>'sb/err/main.css']], 'd'=>'css', 'f'=>'sb/err/main.css' ]);
			$this->_BldCss(['a'=>[['s'=>'sb/err/d2.css']], 'd'=>'css', 'f'=>'sb/err/d2.css' ]);

			echo $this->h1('monitor.css');
			$this->_BldCss(['a'=>[['s'=>'sb/mntr/main.css']], 'd'=>'css', 'f'=>'sb/mntr/main.css' ]);


			echo $this->h1('widget.css');
			$this->_BldCss(['a'=>[['s'=>'sb/wdgt/main.css']], 'd'=>'css', 'f'=>'sb/wdgt/main.css' ]);

			echo $this->h1('act.css');
			$this->_BldCss(['a'=>[['s'=>'sb/act/main.css']], 'd'=>'css', 'f'=>'sb/act/main.css' ]);


		//-------------------- VTEX --------------------//

			echo $this->h1('app.css');
			$this->_BldCss(['a'=>[['s'=>'sb/vtex/app.css']], 'd'=>'css', 'f'=>'sb/vtex/app.css' ]);

			echo $this->h1('base.css');
			$this->_BldCss(['a'=>[['s'=>'sb/vtex/base.css']], 'd'=>'css', 'f'=>'sb/vtex/base.css' ]);

			echo $this->h1('hemes/dark-block.css');
			$this->_BldCss(['a'=>[['s'=>'sb/vtex/themes/dark-block.css']], 'd'=>'css', 'f'=>'sb/vtex/themes/dark-block.css' ]);

			echo $this->h1('sty.css');
			$this->_BldCss(['a'=>[['s'=>'sb/vtex/sty.css']], 'd'=>'css', 'f'=>'sb/vtex/sty.css' ]);


		//-------------------- INFORMES --------------------//

			echo $this->h1('informes.css');
			$this->_BldCss(['a'=>[['s'=>'informes.css']], 'd'=>'css', 'f'=>'informes.css' ]);

		//-------------------- ERROR CRM --------------------//

			echo $this->h1('crm-error.css');
			$this->_BldCss(['a'=>[['s'=>'crm-error.css']], 'd'=>'css', 'f'=>'crm-error.css' ]);

		//-------------------- CRM CSS FORMS --------------------//

			echo $this->h1('rd.css');
			$__css_rd[] = ['s'=>'sb/rd/all.css'];
			$__css_rd[] = ['s'=>'flipbook/flipbook.style.css'];
			$__css_rd[] = ['s'=>'flipbook/font-awesome.css'];
			$this->_BldCss(['a'=>$__css_rd, 'd'=>'css', 'f'=>'sb/rd/all.css' ]);

	}

}



?>