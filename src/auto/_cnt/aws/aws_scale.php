<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'aws_scale' ]);

if( $_g_alw->est == 'ok' ){

	$__e2_mail_bld = $this->_aws->_rsrc_sclg_chck([ 'id'=>2 ]);
	$__e2_mail_snd = $this->_aws->_rsrc_sclg_chck([ 'id'=>10 ]);
	$__e2_gral = $this->_aws->_rsrc_sclg_chck([ 'id'=>8 ]);
	$__e2_dev = $this->_aws->_rsrc_sclg_chck([ 'id'=>11 ]);
    $__rds_bck = $this->_aws->_rsrc_sclg_chck([ 'id'=>1 ]);
    $__rds_frnt = $this->_aws->_rsrc_sclg_chck([ 'id'=>9 ]);

    if($__e2_mail_bld->e != 'ok' || $__e2_gral->e != 'ok'){ exit(); }

    define('SCLE_BTWN_STR', '22');
    define('SCLE_BTWN_END', '5');

    define('AWS_EC2_BCKMAIL_BUILD_ID', $__e2_mail_bld->cid);
    define('AWS_EC2_BCKMAIL_BUILD_LOW', $__e2_mail_bld->low);
    define('AWS_EC2_BCKMAIL_BUILD_MDM', $__e2_mail_bld->mdm);
    define('AWS_EC2_BCKMAIL_BUILD_HIG', $__e2_mail_bld->hig);
	define('AWS_EC2_BCKMAIL_BUILD_XTRM', $__e2_mail_bld->xtrm);

	define('AWS_EC2_BCKMAIL_SEND_ID', $__e2_mail_snd->cid);
    define('AWS_EC2_BCKMAIL_SEND_LOW', $__e2_mail_snd->low);
    define('AWS_EC2_BCKMAIL_SEND_MDM', $__e2_mail_snd->mdm);
    define('AWS_EC2_BCKMAIL_SEND_HIG', $__e2_mail_snd->hig);
    define('AWS_EC2_BCKMAIL_SEND_XTRM', $__e2_mail_snd->xtrm);

    define('AWS_EC2_BCKGRAL_ID', $__e2_gral->cid);
    define('AWS_EC2_BCKGRAL_LOW', $__e2_gral->low);
    define('AWS_EC2_BCKGRAL_MDM', $__e2_gral->mdm);
    define('AWS_EC2_BCKGRAL_HIG', $__e2_gral->hig);
	define('AWS_EC2_BCKGRAL_XTRM', $__e2_gral->xtrm);


	define('AWS_EC2_DEV_ID', $__e2_dev->cid);
    define('AWS_EC2_DEV_LOW', $__e2_dev->low);
    define('AWS_EC2_DEV_MDM', $__e2_dev->mdm);
    define('AWS_EC2_DEV_HIG', $__e2_dev->hig);
    define('AWS_EC2_DEV_XTRM', $__e2_dev->xtrm);

    define('AWS_RDS_BCK_ID', $__rds_bck->cid);
    define('AWS_RDS_BCK_LOW', 'db.t3.micro');
    define('AWS_RDS_BCK_MDM', 'db.t3.medium');
    define('AWS_RDS_BCK_HIG', 'db.t3.large');
    define('AWS_RDS_BCK_XTRM', 'db.t3.large');

    define('AWS_RDS_FRNT_ID', $__rds_frnt->cid);
    define('AWS_RDS_FRNT_LOW', 'db.t3.small');
    define('AWS_RDS_FRNT_MDM', 'db.t3.medium');
    define('AWS_RDS_FRNT_HIG', 'db.t3.large');
    define('AWS_RDS_FRNT_XTRM', 'db.t3.xlarge');


	echo $this->h1('Scaling '.date('H'));

    if($this->_s_cl->tot > 0){

        foreach($this->_s_cl->ls as $_cl_k=>$_cl_v){

            if( $this->tallw_cl([ 't'=>'key', 'id'=>'snd_ec', 'cl'=>$_cl_v->id ])->est == 'ok' ){

                $__gtot = GtClSndTot([ 'bd'=>$_cl_v->bd, 'cl'=>$_cl_v->id ]); if(!isN($__gtot->w)){ echo $this->err($__gtot->w); }
                $__ghtot = GtClSndHtmlTot([ 'bd'=>$_cl_v->bd, 'cl'=>$_cl_v->id ]); //print_r( $__ghtot );


                if(!isN($__gtot->w)){ echo $this->err('GtClSndTot:'.$__gtot->w); }
                if(!isN($__ghtot->w)){ echo $this->err('GtClSndHtmlTot:'.$__ghtot->w); }


                $__send_tot = $__send_tot+$__gtot->tot;
                $__send_html_tot = $__send_html_tot+$__ghtot->tot;

				//echo $this->li(MACHINE_BCK_TP.' - '.$_cl_v->nm.' R: '. print_r($__gtot, true) ) ;

				if(!isN($__gtot->tot)){
					echo $this->li(MACHINE_BCK_TP.' - '.$_cl_v->nm.' Total Mails to Send: '. $this->Spn($__gtot->tot) ) ;
				}
				if(!isN($__ghtot->tot)){
					echo $this->li(MACHINE_BCK_TP.' - '.$_cl_v->nm.' Total HTML to Build: '. $this->Spn($__ghtot->tot) );
				}

            }else{

				echo $this->nallw($_cl_v->nm.' AWS Save Money - Off');

			}

			$__dtot = GtClDwnTot([ 'cl'=>$_cl_v->id ]);
			$__ttot = GtClTraRspTot([ 'cl'=>$_cl_v->id ]);

			if(!isN($__dtot->w)){ echo $this->err('GtClDwnTot:'.print_r($__dtot, true)); }
			if(!isN($__ttot->w)){ echo $this->err('GtClTraRspTot:'.print_r($__ttot, true)); }

			$__downloads_tot = $__downloads_tot+$__dtot->tot;
			$__tasksrsp_tot = $__tasksrsp_tot+$__ttot->tot;

			if(!isN($__dtot->tot)){
				echo $this->li(MACHINE_BCK_TP.' - '.$_cl_v->nm.' Total to Download: '. $this->Spn($__dtot->tot) );
			}
			if(!isN($__ttot->tot)){
				echo $this->li(MACHINE_BCK_TP.' - '.$_cl_v->nm.' Total to Task Asign: '. $this->Spn($__ttot->tot) );
			}

        }

    }

	if(!isN($__downloads_tot)){
		echo $this->li(MACHINE_BCK_TP.' - '.$_cl_v->nm.' Big Total to Download: '. $this->Spn($__downloads_tot) );
	}

	// MAILING - BUILD

		if($__send_html_tot > 1000){
			$__scle_hgh_mail_bld_tp = AWS_EC2_BCKMAIL_BUILD_XTRM;
		}elseif($__send_html_tot > 500){ // So much records to process, so put a bigger machine
			$__scle_hgh_mail_bld_tp = AWS_EC2_BCKMAIL_BUILD_HIG;
		}else{
			$__scle_hgh_mail_bld_tp = AWS_EC2_BCKMAIL_BUILD_MDM;
		}


	// MAILING - SEND


		if($__send_tot > 1000){
			$__scle_hgh_mail_snd_tp = AWS_EC2_BCKMAIL_SEND_XTRM;
		}elseif($__send_tot > 500){ // So much records to process, so put a bigger machine
			$__scle_hgh_mail_snd_tp = AWS_EC2_BCKMAIL_SEND_HIG;
		}else{
			$__scle_hgh_mail_snd_tp = AWS_EC2_BCKMAIL_SEND_MDM;
		}


	// GENERAL PROCESS


    if($__downloads_tot > 10000 || $__tasksrsp_tot > 100){
        $__scle_hgh_gral_tp = AWS_EC2_BCKGRAL_XTRM;
    }elseif($__downloads_tot > 1000 || $__tasksrsp_tot > 50){
        $__scle_hgh_gral_tp = AWS_EC2_BCKGRAL_HIG;
    }else{
        $__scle_hgh_gral_tp = AWS_EC2_BCKGRAL_MDM;
    }

    if($__downloads_tot > 10000){
        $__scle_hgh_back_tp = AWS_RDS_BCK_XTRM;
    }elseif($__downloads_tot > 1000){
        $__scle_hgh_back_tp = AWS_RDS_BCK_HIG;
    }else{
        $__scle_hgh_back_tp = AWS_RDS_BCK_MDM;
    }


    echo $this->h2('Has to send '.$__send_tot.'Mailing mails');
    echo $this->h2('Has to build '.$__send_html_tot.' html mails');


    if(SUMR_TP == 'back_general' || !defined(SUMR_TP) || _Cns('SUMR_TP') == 'frnt'){

        echo $this->h2('Hour:'.date('H').' vs '.SCLE_BTWN_STR.' '.SCLE_BTWN_END);


		// Backmail Build

        if((date('H') >= SCLE_BTWN_STR || date('H') <= SCLE_BTWN_END) && ($__send_html_tot < 500) && defined('AWS_EC2_BCKMAIL_BUILD_LOW')){

            echo $this->h2('Scaling Mailing Machine at Night '.SUMR_TP);
			echo $this->li('Scaling AWS_EC2_BCKMAIL_BUILD_ID('.AWS_EC2_BCKMAIL_BUILD_ID.') to '.AWS_EC2_BCKMAIL_BUILD_LOW);

            $this->_aws->_ec2_scle([
                'id'=>AWS_EC2_BCKMAIL_BUILD_ID,
                'to'=>AWS_EC2_BCKMAIL_BUILD_LOW,
                'sclr'=>[
                    'e'=>$__e2_mail_bld->sclg,
                    'f'=>$__e2_mail_bld->fa
                ]
			]);

        }elseif(!isN($__scle_hgh_mail_bld_tp)){

            echo $this->h2('Scaling Mailing Machine at Day '.SUMR_TP);
            echo $this->li('Scaling AWS_EC2_BCKMAIL_BUILD_ID('.AWS_EC2_BCKMAIL_BUILD_ID.') to '.$__scle_hgh_mail_bld_tp);

            $this->_aws->_ec2_scle([
                'id'=>AWS_EC2_BCKMAIL_BUILD_ID,
                'to'=>$__scle_hgh_mail_bld_tp,
                'sclr'=>[
                    'e'=>$__e2_mail_bld->sclg,
                    'f'=>$__e2_mail_bld->fa
                ]
			]);

		}


		// Backmail Send

		if((date('H') >= SCLE_BTWN_STR || date('H') <= SCLE_BTWN_END) && ($__send_tot < 500) && defined('AWS_EC2_DEV_LOW')){

            echo $this->h2('Scaling Dev Machine at Night '.SUMR_TP);
			echo $this->li('Scaling AWS_EC2_DEV_ID('.AWS_EC2_DEV_ID.') to '.AWS_EC2_DEV_LOW);

            $this->_aws->_ec2_scle([
                'id'=>AWS_EC2_DEV_ID,
                'to'=>AWS_EC2_DEV_LOW,
                'sclr'=>[
                    'e'=>$__e2_dev->sclg,
                    'f'=>$__e2_dev->fa
                ]
			]);

        }elseif(defined('AWS_EC2_DEV_MDM')){

            echo $this->h2('Scaling Dev Machine at Day '.SUMR_TP);
            echo $this->li('Scaling AWS_EC2_DEV_ID('.AWS_EC2_DEV_ID.') to '.AWS_EC2_DEV_MDM);

            $this->_aws->_ec2_scle([
                'id'=>AWS_EC2_DEV_ID,
                'to'=>AWS_EC2_DEV_MDM,
                'sclr'=>[
                    'e'=>$__e2_dev->sclg,
                    'f'=>$__e2_dev->fa
                ]
			]);

		}



		// Dev Machine


		if((date('H') >= SCLE_BTWN_STR || date('H') <= SCLE_BTWN_END) && defined('AWS_EC2_BCKMAIL_SEND_LOW')){

            echo $this->h2('Scaling Mailing Machine at Night '.SUMR_TP);
			echo $this->li('Scaling AWS_EC2_BCKMAIL_SEND_ID('.AWS_EC2_BCKMAIL_SEND_ID.') to '.AWS_EC2_BCKMAIL_SEND_LOW);

            $this->_aws->_ec2_scle([
                'id'=>AWS_EC2_BCKMAIL_SEND_ID,
                'to'=>AWS_EC2_BCKMAIL_SEND_LOW,
                'sclr'=>[
                    'e'=>$__e2_mail_snd->sclg,
                    'f'=>$__e2_mail_snd->fa
                ]
			]);

        }elseif(!isN($__scle_hgh_mail_snd_tp)){

            echo $this->h2('Scaling Mailing Machine at Day '.SUMR_TP);
            echo $this->li('Scaling AWS_EC2_BCKMAIL_SEND_ID('.AWS_EC2_BCKMAIL_SEND_ID.') to '.$__scle_hgh_mail_snd_tp);

            $this->_aws->_ec2_scle([
                'id'=>AWS_EC2_BCKMAIL_SEND_ID,
                'to'=>$__scle_hgh_mail_snd_tp,
                'sclr'=>[
                    'e'=>$__e2_mail_snd->sclg,
                    'f'=>$__e2_mail_snd->fa
                ]
			]);

		}




    }

    if(SUMR_TP == 'back_general' || !defined(SUMR_TP) || _Cns('SUMR_TP') == 'frnt'){

        if(date('H') >= SCLE_BTWN_STR || date('H') <= SCLE_BTWN_END && defined('AWS_EC2_BCKGRAL_LOW')){

            echo $this->h2('Scaling General Machine at Night '.SUMR_TP);
            echo $this->li('Scaling '.AWS_EC2_BCKGRAL_ID.' to '.AWS_EC2_BCKGRAL_LOW);

            $this->_aws->_ec2_scle([
                'id'=>AWS_EC2_BCKGRAL_ID,
                'to'=>AWS_EC2_BCKGRAL_LOW,
                'sclr'=>[
                    'e'=>$__e2_gral->sclg,
                    'f'=>$__e2_gral->fa
                ]
            ]);

        }elseif(!isN($__scle_hgh_gral_tp)){

            echo $this->h2('Scaling General Machine at Day '.SUMR_TP);
            echo $this->li('Scaling '.AWS_EC2_BCKGRAL_ID.' to '.$__scle_hgh_gral_tp);

            $this->_aws->_ec2_scle([
                'id'=>AWS_EC2_BCKGRAL_ID,
                'to'=>$__scle_hgh_gral_tp,
                'sclr'=>[
                    'e'=>$__e2_gral->sclg,
                    'f'=>$__e2_gral->fa
                ]
            ]);

        }

    }

}else{

	echo $this->nallw('Global AWS Scaling Off');

}


?>