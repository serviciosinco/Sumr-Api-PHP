<?php

$_g_alw = $this->tallw([ 't'=>'key', 'id'=>'snd_ec_cmpg_cron' ]);
$_aws_iid = file_get_contents("http://instance-data/latest/meta-data/instance-id");
$_bash_fldr = dirname(__FILE__,4).'/__bsh/_crond/';

if( $_g_alw->est == 'ok' ){

	if(class_exists('CRM_Cnx')){

		$this->_RTme([ 'start'=>'ok' ]);

		echo $this->h1('ENVIO CAMPAÑAS EMAIL TO CRON', '_cmpg');

        //-------------------- AUTO TIME CHECK - START --------------------//

            $_AUTOP_d = $this->RquDt([ 't'=>'ec_cmpg_cron', 'cl'=>$_cl_v->id, 'm'=>3 ]);
			echo $this->h2($_cl_v->nm.' lock? '.$_AUTOP_d->lck, '', '_check');
			$_AUTOP_d->e = 'ok';
			$_AUTOP_d->hb = 'ok';

        //-------------------- AUTO TIME CHECK - END --------------------//

        if(($_AUTOP_d->e == 'ok' && $_AUTOP_d->lck != 'ok') || $_AUTOP_d->m_lck > 15){


            $__cnx->c_p->autocommit(FALSE);
            $__tot_not_cron_html = GtEcCmpgOutCronTot([ 't'=>'html', 'inst'=>$_aws_iid ]);
            $__tot_not_cron_send = GtEcCmpgOutCronTot([ 't'=>'snd', 'inst'=>$_aws_iid ]);
            $__tot_not_cron_queu = GtEcCmpgOutCronTot([ 't'=>'que', 'inst'=>$_aws_iid ]);


            try {

                if($__tot_not_cron_html->tot > 0 || $__tot_not_cron_send->tot > 0 || $__tot_not_cron_queu->tot > 0){

                    $__ls_not_cron_html = GtEcCmpgOutCronLs([ 't'=>'html', 'inst'=>$_aws_iid ]);
                    $__ls_not_cron_send = GtEcCmpgOutCronLs([ 't'=>'snd', 'inst'=>$_aws_iid ]);
                    $__ls_not_cron_queu = GtEcCmpgOutCronLs([ 't'=>'que', 'inst'=>$_aws_iid ]);

                    $__add_cron = '#--------------------- HELP CAMPAIGNS ---------------------#'.PHP_EOL.PHP_EOL;

                    $__add_cron .= 'declare -A HST_CMPG_BLD_HLP'.PHP_EOL;

                    foreach($__ls_not_cron_html->ls as $_html_k=>$_html_v){

                        $__add_cron .= 'HST_CMPG_BLD_HLP["'.$_html_v->enc.'"]=""'.PHP_EOL;

                        if($_html_v->exst == 0){

                            $sql_in = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMPG_CRON." (eccmpgcron_enc, eccmpgcron_tp, eccmpgcron_cmpg, eccmpgcron_instance) VALUES (%s, %s, %s, %s)",
			                       GtSQLVlStr(Enc_Rnd($_html_v->enc.'html'), "text"),
								   GtSQLVlStr('html', "text"),
								   GtSQLVlStr($_html_v->id, "text"),
								   GtSQLVlStr($_aws_iid, "text"));

                            $__cnx->_prc($sql_in);

                        }

                    }

                    $__add_cron .= PHP_EOL.PHP_EOL;
                    $__add_cron .= 'declare -A HST_CMPG_SND_HLP'.PHP_EOL;

                    foreach($__ls_not_cron_send->ls as $_send_k=>$_send_v){

                        $__add_cron .= 'HST_CMPG_SND_HLP["'.$_send_v->enc.'"]=""'.PHP_EOL;

                        if($_send_v->exst == 0){

                            $sql_in = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMPG_CRON." (eccmpgcron_enc, eccmpgcron_tp, eccmpgcron_cmpg, eccmpgcron_instance) VALUES (%s, %s, %s, %s)",
			                       GtSQLVlStr(Enc_Rnd($_html_v->enc.'html'), "text"),
								   GtSQLVlStr('snd', "text"),
								   GtSQLVlStr($_send_v->id, "text"),
								   GtSQLVlStr($_aws_iid, "text"));

                            $__cnx->_prc($sql_in);

                        }

                    }


                    $__add_cron .= PHP_EOL.PHP_EOL;
                    $__add_cron .= 'declare -A HST_CMPG_QUE_HLP'.PHP_EOL;

                    foreach($__ls_not_cron_queu->ls as $_queue_k=>$_queue_v){

                        $__add_cron .= 'HST_CMPG_QUE_HLP["'.$_queue_v->enc.'"]=""'.PHP_EOL;

                        if($_queue_v->exst == 0){

                            $sql_in = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMPG_CRON." (eccmpgcron_enc, eccmpgcron_tp, eccmpgcron_cmpg, eccmpgcron_instance) VALUES (%s, %s, %s, %s)",
			                       GtSQLVlStr(Enc_Rnd($_queue_v->enc.'html'), "text"),
								   GtSQLVlStr('que', "text"),
								   GtSQLVlStr($_send_v->id, "text"),
								   GtSQLVlStr($_aws_iid, "text"));

                            $__cnx->_prc($sql_in);

                        }

					}


                    file_put_contents($_bash_fldr.'prd/data/mailing_campaigns.sh', $__add_cron);

                    /*if( shell_exec('/bin/bash '.$_bash_fldr.'prd/back_mailing.sh') ){

                        if($__cnx->c_p->commit()){
                            echo $this->scss('Added cronjobs success');
                        }

                    }else{
                        $__cnx->c_p->rollback();
                    }*/

                }else{

                    echo $this->scss('ALL is on cronjobs');

                }

                $___lck = $this->Rqu([ 't'=>'ec_cmpg_cron', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

            } catch (Exception $e) {

                $___lck = $this->Rqu([ 't'=>'ec_cmpg_cron', 'cl'=>$_cl_v->id, 'lck'=>2 ]);

                echo $this->err($e->getMessage());
                $__cnx->c_p->autocommit(TRUE);

            }

            $__cnx->c_p->autocommit(TRUE);

        }

	}else{

		echo $this->err('AUTO_CMPG_EC:off');

	}

}else{

	echo $this->nallw('Global Envios Masivos - Campañas - CronJob - Off');

}


?>