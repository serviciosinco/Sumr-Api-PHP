<?php
    $__awsacc = GtClAwsAccLs([ 'cl'=>DB_CL_ENC ]);

    if(!isN($__awsacc) && $__awsacc->tot > 0){  
?>
<div class="dashboard_aws_monitor">
    <div class="col col1">
        <ul class="ec2">
            <?php foreach($__awsacc->ls as $__acc_k=>$__acc_v){ ?>
                <?php 
                    $_aws = new API_CRM_Aws([ 'key'=>$__acc_v->key, 'scrt'=>$__acc_v->scrt ]);
                    $__instances = $_aws->_ec2_list();
                ?>
                <?php foreach($__instances as $__ins_k=>$__ins_v){ ?>
                    <?php 
                        foreach($__ins_v->Instances[0]->Tags as $_tags_k=>$_tags_v){
                            $__tags_s[$_tags_v->Key] = $_tags_v->Value;
                        }
                    ?>
                    <li id="ec2_<?php echo $__ins_v->Instances[0]->InstanceId; ?>" class="<?php echo $__ins_v->Instances[0]->State->Name; ?>">  
                        <h2><?php echo $__tags_s['Name'].Spn($__ins_v->Instances[0]->InstanceId, 'ok'); ?></h2>
                        <div class="wrp">
                            <h3><?php echo $__ins_v->Instances[0]->InstanceType; ?></h3>
                            <h4><?php echo $__ins_v->Instances[0]->State->Name; ?></h4>
                            <div class="opt-btn">
                                <button inst-id="<?php echo $__ins_v->Instances[0]->InstanceId; ?>" acc-id="<?php echo $__acc_v->enc; ?>" class="_anm _start">Iniciar</button>
                                <button inst-id="<?php echo $__ins_v->Instances[0]->InstanceId; ?>" acc-id="<?php echo $__acc_v->enc; ?>" class="_anm _stop">Parar</button>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>    
    </div>
    <div class="col col2">
        <?php if(DB_CL_ID == 21){ ?>
            <iframe src="https://monitor.massivespace.rocks/?_r=<?php echo Gn_Rnd(); ?>" width="100%" height="10000" frameBorder="0" class="msv_frme"></iframe>
        <?php } ?>
    </div>
</div>
<?php } ?>
<style>

    .dashboard_aws_monitor{ display:flex; }
    .dashboard_aws_monitor .col{  }
    .dashboard_aws_monitor .col.col1{ width:20%; }
    .dashboard_aws_monitor .col.col2{ width:80%; }

    .dashboard_aws_monitor .msv_frme{ width:100%; }
    
    .dashboard_aws_monitor .ec2{ list-style:none; padding:0; margin:0; }
    .dashboard_aws_monitor .ec2 li{ text-align:center; border:1px dashed #dedede; padding:4px; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; margin-bottom:10px; }
    .dashboard_aws_monitor .ec2 li h2{ font-family:Economica; font-size:18px; text-transform:uppercase; font-weight:300; margin:0 10px 0 0; padding:10px 15px; width:100%; text-align:center; background-color:#f5f5f5; border-radius: 10px 10px 0px 0px;
-moz-border-radius: 10px 10px 0px 0px; -webkit-border-radius: 10px 10px 0px 0px; }
    .dashboard_aws_monitor .ec2 li h2 span{ color:#999; font-size:0.8em; }

    .dashboard_aws_monitor .ec2 li .wrp{ padding: 10px 90px 10px 20px; position:relative; }
    .dashboard_aws_monitor .ec2 li .wrp h3{ margin:0; padding:0; font-family:Economica; font-size:16px; font-weight:300; }
    .dashboard_aws_monitor .ec2 li .wrp h4{ margin:10px 0; padding:0; font-family:Roboto; font-weight:300; font-size:13px; }
    .dashboard_aws_monitor .ec2 li .wrp h4::before{ display:inline-block; width:12px; height:12px; background-color:#ccc; border-radius:200px; -moz-border-radius:200px; -webkit-border-radius:200px; margin-right:5px; }


    .dashboard_aws_monitor .ec2 li .opt-btn{ margin-top:10px; text-align:right; width:100%; position:absolute; right:0; top:0; }
    .dashboard_aws_monitor .ec2 li .opt-btn button{ background-color:#f5f5f5; border:none; border-radius:7px; -moz-border-radius:7px; -webkit-border-radius:7px; font-family:Roboto; font-weight:300; font-size:11px; padding: 4px 8px; text-transform:lowercase; }
    .dashboard_aws_monitor .ec2 li .opt-btn button:hover{ font-size:10px; }
    .dashboard_aws_monitor .ec2 li .opt-btn button._start{ color:#2db137; }
    .dashboard_aws_monitor .ec2 li .opt-btn button._stop{ color:#880808; }

    .dashboard_aws_monitor .ec2 li.stopped button._stop,
    .dashboard_aws_monitor .ec2 li.stopping button._stop,
    .dashboard_aws_monitor .ec2 li.running button._start,
    .dashboard_aws_monitor .ec2 li.pending button._start{ display:none; } 
    

    .dashboard_aws_monitor .ec2 li._ld{ animation: _blnk_ldr 0.8s cubic-bezier(.5, 0, 1, 1) infinite alternate; background-image: url('<?php echo DMN_IMG_ESTR_SVG ?>mail_stup_plug.svg'); pointer-events:none; }
    

    .dashboard_aws_monitor .ec2 li.stopped .wrp h4{ color:#880808; }
    .dashboard_aws_monitor .ec2 li.stopped .wrp h4::before{ background-color:#880808; }
    .dashboard_aws_monitor .ec2 li.running .wrp h4{ color:#2db137; }
    .dashboard_aws_monitor .ec2 li.running .wrp h4::before{ background-color:#2db137; }
    .dashboard_aws_monitor .ec2 li.pending .wrp h4{ color:#d67804; }
    .dashboard_aws_monitor .ec2 li.pending .wrp h4::before{ background-color:#d67804; }
    .dashboard_aws_monitor .ec2 li.stopping .wrp h4{ color:#d67804; }
    .dashboard_aws_monitor .ec2 li.stopping .wrp h4::before{ background-color:#d67804; }

    
    
</style>

<?php
		             
    $CntWb .= "
        
        $('.dashboard_aws_monitor button._start, .dashboard_aws_monitor button._stop').off('click').click(function(e) {
            
            e.preventDefault();
								
            if(e.target != this){    
                e.stopPropagation(); return false;  
            }else{

                var _id = $(this).attr('inst-id');
                var _acc = $(this).attr('acc-id');
                var _ins = $('#ec2_'+_id);
                var _ins_h4 = $('#ec2_'+_id+' h4');
                var _obtn = $('#ec2_'+_id+' .opt-btn');
                var _this = $(this);

                if( _this.hasClass('_start')){ var _act='start'; }else if( _this.hasClass('_stop')){ var _act='stop'; }
                
                if(!isN(_id)){
                    _Rqu({ 
                        t:'aws',  
                        t2:'turn_ec2',
                        id:_id,
                        acc:_acc,
                        act:_act,
                        _bs:function(){ _ins.addClass('_ld'); },
                        _cm:function(){ _ins.removeClass('_ld'); },
                        _cl:function(_r){ 
                            if(!isN(_r)){
                                if(!isN(_r.e) && _r.e == 'ok'){
                                    if(!isN(_r.nwcls)){
                                        _ins.removeClass().addClass(_r.nwcls);
                                        _ins_h4.html( _r.nwcls );
                                    }
                                }
                            }
                        } 
                    });
                }

            }

        });
        
    ";

?>