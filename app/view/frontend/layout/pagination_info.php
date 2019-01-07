									<div>
										<div style="float:right;">
                                            <?=isset($sm_input)?$sm_input:''?>
                                            <label>
                                                <div class="inline-block fs12"><?=$pageData->label->label->row_per_page->title?></div>
                                                <div class="inline-block fs12">
                                                    <?php $item_per_page = array(array(5,0),array(10,1),array(20,0),array(30,0),array(50,0)); ?>
                                                    <select class="form-control input-sm nav_rowsPerPage">
                                                        <?php
                                                        foreach($item_per_page as $value){
                                                            echo '<option value="'.$value[0].'" '.($value[1]?'selected':'').'>'.enNum_khNum(str_pad($value[0], 2, '0', STR_PAD_LEFT)).'</option>';
                                                        }																			
                                                        ?>
                                                    </select>
                                                </div>
                                             </label>
										</div>
                                        <div style="float:left; padding-top:10px;">
                                            <label>
                                                <span class="nav_info fs12" data-loadtxt='<?=$pageData->label->label->processing->icon.'&nbsp;'.$pageData->label->label->processing->title?>'></span>
                                             </label>
                                        </div>
									</div>
									<div style="clear:both; padding:2px 0;"></div>  