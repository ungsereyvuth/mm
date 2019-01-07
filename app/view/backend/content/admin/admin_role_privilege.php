<?php
$listname='rolelist';
$formkey='newRole';
?>

<div class="page_content">
<div class="clearfix">	
	<div class="col-sm-6 col-md-7">
    	<div class="panel panel-grey equal-height-column" style="">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> User Role List</h3>
            </div>
            <div class="panel-body">
                <div class="datalist txtLeft pad10" id="<?=$listname?>">
                    <?=$pageData->data->content->search_inputs?>
                    <?php include("app/view/frontend/layout/pagination_info.php"); ?>
                    <table width="100%" class="mytable" >
                        <thead>
                            <tr><th style="width:50px;" class="txtCenter">No.</th><th>Name</th><th style="width:70px;" class="txtCenter">Tools</th></tr>
                        </thead>
                        <tbody></tbody>
                    </table> 
                    <?php include("app/view/frontend/layout/listPagination.php");?>  
                </div> 	
            </div>
        </div>        
        <div>
        	<form class="ajaxfrm sky-form" role="form" id="<?=$formkey?>-form" data-func="submit_form" data-reset="1" action="" method="post">
                <div class="panel panel-grey equal-height-column" style="">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-user-plus"></i> New Role</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="label">Role Code</label>
                                    <input type="text" name="code" class="form-control" placeholder="Role Code">
                                </div>
                                <div class="col-md-3">
                                    <label class="label">Role Name</label>
                                    <input type="text" class="form-control" name="title" placeholder="Role Name">
                                </div>
                                <div class="col-md-3">
                                    <label class="label">Authentication</label>
                                    <input type="number" name="auth_level" class="form-control" placeholder="Authentication Level">
                                </div>
                                <div class="col-md-3">
                                    <label class="label">Homepage</label>
                                    <input type="text" name="homepage" class="form-control" placeholder="Homepage URL">
                                </div>
                            </div>                 	
                        </div>  
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="btm_border_gray"><label class="toggle label" style="width: 150px;"><input type="checkbox" name="active" checked><i></i>Active</label></div>
                                    <div id="active_msg"></div>
                                </div>
                            </div>                 	
                        </div>          	
                        <div class="form-group">
                            <input class="removable" type="hidden" name="recordid" value="" />
                            <input type="hidden" name="cmd" value="<?=$formkey?>" />
                            <button class="btn-u btn-u-sea-shop margin-bottom-10" type="submit">Save</button>
                            <button class="btn-u btn-u-default margin-bottom-10 reset_btn" type="reset">Cancel</button>
                        </div>	
                        <div class="form-group">
                            <div id="<?=$formkey?>_msg" data-loadtxt='<?=htmlspecialchars($pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title)?>'></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
	</div>
    <div class="col-sm-6 col-md-5">
    	<div class="panel panel-red equal-height-column" style="">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-cogs"></i> Role Privilege <?=$pageData->data->content->edit_title?></h3>
            </div>
            <div class="panel-body">
            	<?php
				if(count($pageData->data->content->roleinfo) and count($pageData->data->content->role_code)==2){
					$userPrivilege = explode(',',$pageData->data->content->roleinfo->privileges);
					$recordid = encodeString(implode('_',$pageData->data->content->role_code),$encryptKey);
				?>
            	<form class="ajaxfrm sky-form" role="form" id="updatePrivilege-form" data-func="submit_form" data-reset="0" action="" method="post">
                    <div class="tab-v2">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#webPage" data-toggle="tab">Webpage</a></li>
                            <li><a href="#ajaxRequest" data-toggle="tab">Aajx Request</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="webPage">
                                <?php
                                    foreach($pageData->data->content->webpage_control as $key=>$value){
                                        if(isset($value['child']) and is_array($value['child']) and count($value['child'])){$has_child=true;}else{$has_child=false;}
                                        echo '<div class="btm_border_gray v_mgn5 v_pad5 hover_bold_blue clearfix">
                                                    <span class="tooltips" title="Privilege ID: '.$value['id'].'"><i class="fa fa-angle-'.($has_child?'down':'right').'"></i> '.$value['title'].' ('.$value['model'].')</span>
                                                    <span class="pull-right"><label class="toggle label"><input type="checkbox" name="privilege_'.$value['id'].'" '.(in_array($value['id'],$userPrivilege)?'checked':'').' value="'.$value['id'].'"><i></i></label></span>
                                            </div>';
                                        if($has_child){
                                            foreach($value['child'] as $skey=>$svalue){
												echo '<div class="btm_border_gray v_mgn0 v_pad5 hover_bold_blue clearfix" style="margin-left:15px;">
															<span class="tooltips" title="Privilege ID: '.$svalue['id'].'"><i class="fa fa-caret-right"></i> '.$svalue['title'].' ('.$svalue['model'].')</span>
															<span class="pull-right"><label class="toggle label"><input type="checkbox" name="privilege_'.$svalue['id'].'" '.(in_array($svalue['id'],$userPrivilege)?'checked':'').' value="'.$svalue['id'].'"><i></i></label></span>
													</div>';
                                            }
                                        }
                                    }								
                                ?>
                            </div>
                            <div class="tab-pane fade in" id="ajaxRequest">
                                <?php
                                    foreach($pageData->data->content->ajax_control as $key=>$value){
                                        if(isset($value['child']) and is_array($value['child']) and count($value['child'])){$has_child=true;}else{$has_child=false;}
                                        echo '<div class="btm_border_gray v_mgn5 v_pad5 hover_bold_blue clearfix">
                                                    <span class="tooltips" title="Privilege ID: '.$value['id'].'"><i class="fa fa-angle-'.($has_child?'down':'right').'"></i> '.$value['model'].'</span>
                                                    <span class="pull-right"><label class="toggle label"><input type="checkbox" name="privilege_'.$value['id'].'" '.(in_array($value['id'],$userPrivilege)?'checked':'').' value="'.$value['id'].'"><i></i></label></span>
                                            </div>';
                                        if($has_child){
                                            foreach($value['child'] as $skey=>$svalue){
												echo '<div class="btm_border_gray v_mgn0 v_pad5 hover_bold_blue clearfix" style="margin-left:15px;">
															<span class="tooltips" title="Privilege ID: '.$svalue['id'].'"><i class="fa fa-caret-right"></i> '.$svalue['model'].'</span>
															<span class="pull-right"><label class="toggle label"><input type="checkbox" name="privilege_'.$svalue['id'].'" '.(in_array($svalue['id'],$userPrivilege)?'checked':'').' value="'.$svalue['id'].'"><i></i></label></span>
													</div>';
                                            }
                                        }
                                    }								
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="pad10">
                        <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="label">Password <i class="fa fa-info-circle tooltips" title="You need to use your account password to save this data."></i></label>
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                </div>
                         </div>
                         <div class="form-group">
                            <input type="hidden" name="recordid" value="<?=$recordid?>" />
                            <input type="hidden" name="cmd" value="updatePrivilege" />
                            <button class="btn-u btn-u-sea-shop margin-bottom-10" type="submit"><i class="fa fa-floppy-o"></i> Save <?=$pageData->data->content->edit_title?></button>
                        </div>	
                        <div class="form-group">
                            <div id="updatePrivilege_msg" data-loadtxt='<?=htmlspecialchars($pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title)?>'></div>
                        </div>
                    </div>
                </form>
                <?php
				}else{
					echo '<div class="alert alert-info"><i class="fa fa-info-circle"></i> To edit privilege, please click Privilege button in the User Role List!</div>';
				}
				?>
            </div>
        </div>     
    </div>
</div>
</div>