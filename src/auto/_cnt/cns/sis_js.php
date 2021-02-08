<style>
	span._ok{ color: #106100; }
	span._no{ color: #ff0000; }	
	span._w{ color: #ffffff; }	
</style>
<?php 

if(class_exists('CRM_Cnx')){

	if(!isN($this->g__s2)){ 

		echo $this->h1('Build '.$this->g__s2.'.js');
		$this->_BldJs(['a'=>[ ['s'=>$this->g__s2.'.js'] ], 'd'=>'crm', 'f'=>$this->g__s2.'.js' ]);
		
	}else{
		
		//-------------------- CRM JS BASIC --------------------//	
		
			
			echo $this->h1('Basics JS');
			
			$this->_BldJs(['a'=>[ ['s'=>'jquery.js'] ], 'd'=>'crm', 'f'=>'jquery.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'jquery.slim.js'] ], 'd'=>'crm', 'f'=>'jquery.slim.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js.js'] ], 'd'=>'crm', 'f'=>'js.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_crm.js'] ], 'd'=>'crm', 'f'=>'js_crm.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_app_dsktp.js'] ], 'd'=>'crm', 'f'=>'js_app_dsktp.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_app_mbl.js'] ], 'd'=>'crm', 'f'=>'js_app_mbl.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_tra.js'] ], 'd'=>'crm', 'f'=>'js_tra.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_dsh.js'] ], 'd'=>'crm', 'f'=>'js_dsh.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_chat.js'] ], 'd'=>'crm', 'f'=>'js_chat.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_dwn.js'] ], 'd'=>'crm', 'f'=>'js_dwn.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_lopt.js'] ], 'd'=>'crm', 'f'=>'js_lopt.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_mdlcnt.js'] ], 'd'=>'crm', 'f'=>'js_mdlcnt.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'jquery-ui-timepicker.js'] ], 'd'=>'crm', 'f'=>'jquery-ui-timepicker.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'jquery.carousel.js'] ], 'd'=>'crm', 'f'=>'jquery.carousel.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'jquery.mCustomScrollbar.js'] ], 'd'=>'crm', 'f'=>'jquery.mCustomScrollbar.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'html5.js'] ], 'd'=>'crm', 'f'=>'html5.js' ]);
			
			$this->_BldJs(['a'=>[ ['s'=>'js_ec.js'] ], 'd'=>'crm', 'f'=>'js_ec.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_eml.js'] ], 'd'=>'crm', 'f'=>'js_eml.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_lnd.js'] ], 'd'=>'crm', 'f'=>'js_lnd.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_pnl.js'] ], 'd'=>'crm', 'f'=>'js_pnl.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_lnd.js'] ], 'd'=>'crm', 'f'=>'js_lnd.js' ]);
			
			$this->_BldJs(['a'=>[ ['s'=>'js_scl.js'] ], 'd'=>'crm', 'f'=>'js_scl.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_scrpt.js'] ], 'd'=>'crm', 'f'=>'js_scrpt.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_sms.js'] ], 'd'=>'crm', 'f'=>'js_sms.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_ws.js'] ], 'd'=>'crm', 'f'=>'js_ws.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_call.js'] ], 'd'=>'crm', 'f'=>'js_call.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_call_video.js'] ], 'd'=>'crm', 'f'=>'js_call_video.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_html.js'] ], 'd'=>'crm', 'f'=>'js_html.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_img.js'] ], 'd'=>'crm', 'f'=>'js_img.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_vtex.js'] ], 'd'=>'crm', 'f'=>'js_vtex.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'js_upl.js'] ], 'd'=>'crm', 'f'=>'js_upl.js' ]);

			$this->_BldJs(['a'=>[ ['s'=>'uploadnew/jquery.knob.js'] ], 'd'=>'crm', 'f'=>'uploadnew/jquery.knob.js' ]);
			
			
			$this->_BldJs(['a'=>[ ['s'=>'SUMR_Widgets.js'] ], 'd'=>'crm', 'f'=>'SUMR_Widgets.js' ]);

			$this->_BldJs(['a'=>[ ['s'=>'_ld.js'] ], 'd'=>'crm', 'f'=>'_ld.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'_front.js'] ], 'd'=>'crm', 'f'=>'_front.js' ]);
		
		//-------------------- JS Colegios --------------------//		
				
			echo $this->h1('Colegios Basic JS');
			$this->_BldJs(['a'=>[ ['s'=>'sb/clg/base.js'] ], 'd'=>'crm', 'f'=>'sb/clg/base.js' ]);		
		
		//-------------------- JS Flipbook --------------------//		
			
			
			echo $this->h1('Flipbook JS');
			$this->_BldJs(['a'=>[ ['s'=>'flipbook/flipbook.min.js'] ], 'd'=>'crm', 'f'=>'flipbook/flipbook.min.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'flipbook/flipbook.book3.min.js'] ], 'd'=>'crm', 'f'=>'flipbook/flipbook.book3.min.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'flipbook/flipbook.pdfservice.min.js'] ], 'd'=>'crm', 'f'=>'flipbook/flipbook.pdfservice.min.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'flipbook/flipbook.swipe.min.js'] ], 'd'=>'crm', 'f'=>'flipbook/flipbook.swipe.min.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'flipbook/flipbook.webgl.js'] ], 'd'=>'crm', 'f'=>'flipbook/flipbook.webgl.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'flipbook/flipbook.webgl.min.js'] ], 'd'=>'crm', 'f'=>'flipbook/flipbook.webgl.min.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'flipbook/iscroll.min.js'] ], 'd'=>'crm', 'f'=>'flipbook/iscroll.min.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'flipbook/pdf.min.js'] ], 'd'=>'crm', 'f'=>'flipbook/pdf.min.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'flipbook/pdf.worker.min.js'] ], 'd'=>'crm', 'f'=>'flipbook/pdf.worker.min.js' ]);
			//$this->_BldJs(['a'=>[ ['s'=>'flipbook/three.min.js'] ], 'd'=>'crm', 'f'=>'flipbook/three.min.js' ]);	
		
		
		//-------------------- JS Summernote --------------------//
			
			echo $this->h1('Summernote JS');
			//$this->_BldJs(['a'=>[ ['s'=>'summernote/summernote.js'] ], 'd'=>'crm', 'f'=>'summernote/summernote.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'summernote/lng/es.js'] ], 'd'=>'crm', 'f'=>'summernote/lng/es.js' ]);

			
			//$__js_smrnte[] = ['s'=>'summernote/cleaner.js'];
			$__js_smrnte[] = ['s'=>'summernote/list-styles.js'];
			$__js_smrnte[] = ['s'=>'summernote/br.js'];
			
			
			$this->_BldJs(['a'=>$__js_smrnte, 'd'=>'crm', 'f'=>'summernote/plugins.js' ]);


		//-------------------- JS Particles --------------------//
		
			echo $this->h1('Particles JS');
			$this->_BldJs(['a'=>[ ['s'=>'particles/particles.js'] ], 'd'=>'crm', 'f'=>'particles/particles.js' ]);
			$this->_BldJs(['a'=>[ ['s'=>'particles/main.js'] ], 'd'=>'crm', 'f'=>'particles/main.js' ]);
		
		//-------------------- JS Notifications --------------------//
			
			echo $this->h1('Push Notifications');
			$this->_BldJs(['a'=>[ ['s'=>'js_push.js'] ], 'd'=>'crm', 'f'=>'js_push.js' ]);
		
		//-------------------- JS VTex --------------------//
			
			echo $this->h1('VTex');
			$this->_BldJs(['a'=>[ ['s'=>'sb/vtex/base.js'] ], 'd'=>'crm', 'f'=>'sb/vtex/base.js' ]);
		
		//-------------------- JS Down --------------------//
			
			echo $this->h1('Download');
			$this->_BldJs(['a'=>[ ['s'=>'sb/dwn/base.js'] ], 'd'=>'crm', 'f'=>'sb/dwn/base.js' ]);

		//-------------------- CRM JS PRIMERA CARGA --------------------//
				
			echo $this->h1('_all.js');
				
			$__js_1[] = ['s'=>'js.js'];
			$__js_1[] = ['s'=>'js_crm.js'];
			$__js_1[] = ['s'=>'jquery-ui.js'];
			$__js_1[] = ['s'=>'jquery.form.js'];
			$__js_1[] = ['s'=>'jquery.validate.js'];
			$__js_1[] = ['s'=>'jquery.noty.js'];
			$__js_1[] = ['s'=>'jquery.noty_theme.js'];
			$__js_1[] = ['s'=>'sweetalert.js'];
			$__js_1[] = ['s'=>'_crm.js'];
			
			$this->_BldJs(['a'=>$__js_1, 'd'=>'crm', 'f'=>'_all.js' ]);
				
		//-------------------- CRM JS SEGUNDA CARGA --------------------//
				
			
			echo $this->h1('_all_m.js');
				
			$__js_2[] = ['s'=>'highcharts/highcharts.js'];
			$__js_2[] = ['s'=>'highcharts/highcharts-more.js'];
			$__js_2[] = ['s'=>'highcharts/modules/funnel.js'];
			$__js_2[] = ['s'=>'highcharts/modules/solid-gauge.js'];
			$__js_2[] = ['s'=>'highcharts/modules/map.js'];
			$__js_2[] = ['s'=>'highcharts/_mapdata/world.js'];	
			/*$__js_2[] = ['s'=>'highcharts/highcharts-3d.js'];
			$__js_2[] = ['s'=>'highcharts/maps/map.js'];*/
			$__js_2[] = ['s'=>'js_sms.js'];
			$__js_2[] = ['s'=>'jquery.chosen.js'];
			$__js_2[] = ['s'=>'select2.js'];
			$__js_2[] = ['s'=>'jquery.tag.js'];
			$__js_2[] = ['s'=>'jquery.caret.js'];
			$__js_2[] = ['s'=>'superfish.js'];
			$__js_2[] = ['s'=>'jquery-ui-timepicker.js'];
			$__js_2[] = ['s'=>'datedropper.js'];
			$__js_2[] = ['s'=>'SpryTabbedPanels.js'];
			$__js_2[] = ['s'=>'SpryCollapsiblePanel.js'];					
			$__js_2[] = ['s'=>'tiny.editor.packed.js'];
			$__js_2[] = ['s'=>'autogrow.js'];
			$__js_2[] = ['s'=>'jquery.colorbox-min.js'];
			$__js_2[] = ['s'=>'jquery.carousel.js'];
			$__js_2[] = ['s'=>'uploadnew/jquery.knob.js'];
			$__js_2[] = ['s'=>'jquery.mCustomScrollbar.js'];
			$__js_2[] = ['s'=>'jquery.mCustomScrollbar_MW.js'];
			$__js_2[] = ['s'=>'jquery.fancybox.js'];
			$__js_2[] = ['s'=>'js_ec.js'];
			$__js_2[] = ['s'=>'js_pnl.js'];
			$__js_2[] = ['s'=>'js_eml.js'];
			$__js_2[] = ['s'=>'js_lopt.js'];
			$__js_2[] = ['s'=>'js_tra.js'];
			$__js_2[] = ['s'=>'js_dsh.js'];
			$__js_2[] = ['s'=>'js_chat.js'];
			$__js_2[] = ['s'=>'js_dwn.js'];
			$__js_2[] = ['s'=>'js_ws.js'];
			$__js_2[] = ['s'=>'js_grph.js'];
			$__js_2[] = ['s'=>'js_img.js'];
			$__js_2[] = ['s'=>'js_mdlcnt.js'];
			$__js_2[] = ['s'=>'js_upl.js'];
			$__js_2[] = ['s'=>'tinysort.js'];
			$__js_2[] = ['s'=>'SUMR_Mic.js'];
			//$__js_2[] = ['s'=>'boostrap/boostrap.js'];
			//$__js_2[] = ['s'=>'boostrap/popover.js'];
			
			
			$this->_BldJs(['a'=>$__js_2, 'd'=>'crm', 'f'=>'_all_m.js' ]);

		//-------------------- CRM JS SEGUNDA CARGA --------------------//
					
			echo $this->h1('sb/meet/main.js');
			$__js_meet[] = ['s'=>'js.js'];
			$__js_meet[] = ['s'=>'jquery-ui.js'];
			$__js_meet[] = ['s'=>'jquery.ui.touch.js'];
			$__js_meet[] = ['s'=>'SpryTabbedPanels.js'];
			$__js_meet[] = ['s'=>'js_call_video.js'];
			
			$this->_BldJs(['a'=>$__js_meet, 'd'=>'crm', 'f'=>'sb/meet/main.js' ]);
			
		//-------------------- JS FORMS --------------------//
				
			echo $this->h1('sb/fm/main.js');
			$__js_fm[] = ['s'=>'jquery.js'];
			$__js_fm[] = ['s'=>'js.js'];
			$__js_fm[] = ['s'=>'select2.js'];
			$__js_fm[] = ['s'=>'jquery-ui.js'];
			$__js_fm[] = ['s'=>'jquery.validate.js'];
			$__js_fm[] = ['s'=>'jquery-ui-timepicker.js'];	
			$__js_fm[] = ['s'=>'sb/fm/base.js'];

			$this->_BldJs(['a'=>$__js_fm, 'd'=>'crm', 'f'=>'sb/fm/main.js' ]);	

		//-------------------- JS FORMS --------------------//
				
			echo $this->h1('sb/rd/main.js');
			$__js_rd[] = ['s'=>'jquery.js'];
			$__js_rd[] = ['s'=>'sb/rd/base.js'];
			$this->_BldJs(['a'=>$__js_rd, 'd'=>'crm', 'f'=>'sb/rd/main.js' ]);

		//-------------------- JS Particles --------------------//
		
			echo $this->h1('CKEditor JS');
			$__js_cke[] = ['s'=>'ckeditor/main.js'];
			$this->_BldJs(['a'=>$__js_cke, 'd'=>'crm', 'f'=>'ckeditor/main.js', 'cmpr'=>'no' ]);

		//-------------------- JS FORMS --------------------//
				
			echo $this->h1('sb/lnd/main.js');
			$__js_lnd[] = ['s'=>'jquery.js'];
			$__js_lnd[] = ['s'=>'_lnd.js'];

			$this->_BldJs(['a'=>$__js_lnd, 'd'=>'crm', 'f'=>'sb/lnd/main.js' ]);	

	}

}



?>