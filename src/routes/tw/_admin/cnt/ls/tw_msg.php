<?php 
	if((isset($_GET['_max']))&&($_GET['_max']!='')){ $_fn = $_GET['_max']; $_mx = 'ok'; }
	if((isset($_GET['_min']))&&($_GET['_min']!='')){ $_fn = $_GET['_min']; $_min = 'ok'; }
	
	$decode = GtDtTw($_fn, $_min, $_mx);
	$_n = 0; 
?> 

<?php if(is_array($decode->statuses) && ($decode->statuses != '') && (!empty($decode->statuses)) && ($decode->statuses)){ ?>
<ul class="msghsh"> 
					<?php foreach($decode->statuses as $result){  ?>
									  <?php if(ChckIdQus(array('id'=>$result->id, 'tp'=>'1'))){ $_clsitm = 'item_qus'; }elseif(ChckIdMsj($result->id)){ $_clsitm = 'item_ok'; }else{ $_clsitm = 'item'; }?>
									  
									  <?php $__i = $result->id; if($_n == 0){ $__n = $__i;} $_n++;?>
									  
												  <li id="Li_<?php echo $result->id ?>">
                                                  
                                                  		<?php $__imgprf_big = str_replace('_normal.jpeg', '.jpeg', $result->user->profile_image_url); ?>
                                                  
														<a href="<?php echo $__imgprf_big ?>" class="__clrbx"><img src="<?php echo $result->user->profile_image_url ?>" class="_prf _prf_tw"></a>
														<div class="<?php echo $_clsitm ?>" id="Dv_<?php echo $result->id ?>">
															<div class="ldr"></div>
															
															<?php $__media = $result->entities->media[0]->media_url; if($__media != NULL && $__media!=''){ ?>
                                                            
                                                                <a href="<?php echo $__media ?>" class="__clrbx">
                                                                		<img src="<?php echo $__media ?>" class="_r">
                                                                </a>
                                                                
                                                            <?php } ?>
                                                            
                                                            <h2><?php echo $result->user->name.' <span>@'.$result->user->screen_name.'</span>'/*.' ('.$__i.')'*/ ?></h2>
															<?php echo $result->text ?>
															<div class="btn">  
																	<div class="aprb">	
																		  <form name="FmMsgTw_<?php echo $result->id ?>" id="FmMsgTw_<?php echo $result->id ?>" method="post" action="<?php echo PRC_HSH ?>">
																				<input type='submit' name='aprob<?php echo $result->id ?>' id='aprob<?php echo $result->id ?>' value='<?php if(isMobile()){ echo 'Ok';}else{echo 'Aprobar';} ?>'>    
																				<input name='hshmsg_createdat' type='hidden' id='hshmsg_createdat' value='<?php echo $result->created_at ?>' />
																				<input name='hshmsg_idstr' type='hidden' id='hshmsg_idstr' value='<?php echo $result->id_str ?>' />
																				<input name='hshmsg_id' type='hidden' id='hshmsg_id' value='<?php echo $result->id ?>' />
																				<input name='hshmsg_us' type='hidden' id='hshmsg_us' value='<?php echo $result->user->id ?>' />
																				<input name='hshmsg_profileimageurl' type='hidden' id='hshmsg_profileimageurl' value='<?php echo $result->user->profile_image_url ?>' />
																				<input name='hshmsg_source' type='hidden' id='hshmsg_source' value='<?php echo $result->source ?>' />
																				<input name='hshmsg_fromusername' type='hidden' id='hshmsg_fromusername' value='<?php echo $result->user->name ?>' />
																				<input name='hshmsg_fromuser' type='hidden' id='hshmsg_fromuser' value='<?php echo $result->user->screen_name ?>' />
																				<input name='hshmsg_text' type='hidden' id='hshmsg_text' value='<?php echo $result->text ?>' />
																				<input name='hshmsg_hsh' type='hidden' id='hshmsg_hsh' value='<?php echo $_hshtg_svid ?>' />
                                                                                <input name='hshmsg_media' type='hidden' id='hshmsg_media' value='<?php echo $result->entities->media[0]->media_url ?>' />
                                                                                
                                                                                
                                                                                <input name='hshmsg_media_array' type='hidden' id='hshmsg_media_array' value='<?php print_r($result->entities->media) ?>' />



                                                                                <input name='hshmsg_tp' type='hidden' id='hshmsg_tp' value='1' />
																				<input name='MM_insert' type='hidden' id='MM_insert' value='EdTwMsg' /> 
																		  </form>
																	</div>
																	<div class="qus">    
																		  <form name="FmMsgQus_<?php echo $result->id ?>" id="FmMsgQus_<?php echo $result->id ?>" method="post" action="<?php echo PRC_QUS ?>">
																				<input type='submit' name='pregu<?php echo $result->id ?>' id='pregu<?php echo $result->id ?>' value='<?php if(isMobile()){ echo '¿?';}else{echo 'Pregunta';} ?>'>    
																				<input name='hshmsg_id' type='hidden' id='hshmsg_id' value='<?php echo $result->id ?>' />   
																				<input name='MM_insert' type='hidden' id='MM_insert' value='EdTwQus' /> 
																		  </form> 
																	</div>      
																		  <?php 
																		  
																			  $_phpjq .= "$('#FmMsgTw_". $result->id ."').validate();
																					$('#FmMsgTw_". $result->id ."').ajaxForm({
																							dataType:'json', 
																							beforeSubmit: function(){ TwMsj_InLd('". $result->id ."'); },
																							success: function(data){ TwMsj_RslLd('". $result->id ."', data); }
																					});"; 
																			  
																			  $_phpjq .= "$('#FmMsgQus_". $result->id ."').validate();
																					$('#FmMsgQus_". $result->id ."').ajaxForm({
																							dataType:'json', 
																							beforeSubmit: function(){ TwMsj_InLd('". $result->id ."', 'qus'); },
																							success: function(data){ TwMsj_RslLd('". $result->id ."', data, 'qus'); }
																					});";
																			
																		  ?>
																				
																				
														   
															</div>
														</div>
												  </li>
		<?php } ?>    
  </ul>          
	<script type="text/javascript">
		$(document).ready(function(){
			<?php echo $_phpjq; ?>
			<?php if($__n != ''){ ?>$('#Tw_Frs').val("<?php echo $__n ?>");<?php } ?>
			<?php if($__i != ''){ ?>$('#Tw_Lst').val("<?php echo $__i ?>");<?php } ?>
			
			
			$(".__clrbx").colorbox();
		});	
	</script>
   <?php } ?>              