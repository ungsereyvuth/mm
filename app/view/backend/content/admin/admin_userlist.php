<?php
$listname='admin_userlist';
$formkey='newUser';
$formCmd='newUser';
?>
<!-- widget grid -->
<section id="widget-grid" class="">
    <!-- row -->
    <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-md-8">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="<?=$listname?>_wid" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false">

                <header>
                    <h2><strong>Users</strong> <i>List</i></h2>   
                    <div class="widget-toolbar">
                        <div class="btn-group">
                            <button class="btn btn-xs btn-default switch_list_filters" data-list="<?=$listname?>">
                               <i class="fa fa-search"></i> Filter
                            </button>                            
                        </div>
                    </div>
 
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <div class="widget-body">
                        <div class="datalist txtLeft" id="<?=$listname?>">
                            <div class="list_filters hidden">
							<?=$pageData->data->content->search_inputs?>
                            </div>
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
            </div>

        </article>
        <!-- WIDGET END -->

        <!-- NEW WIDGET START -->
        <article class="col-md-4">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="<?=$formkey?>_wid" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false">

                <header>
                    <h2><strong>New</strong> <i>user</i></h2>    
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <div class="widget-body">

                    	<form class="ajaxfrm smart-form" role="form" id="<?=$formkey?>-form" data-func="submit_form" data-reset="1" action="" method="post">
                			<fieldset>
                            	<div class="row">
                                    <section class="col col-md-6">
                                        <label class="label">User Role</label>
                                        <label class="select">
                                            <select name="role_id" class="input-sm">
                                                <option value="">--- Select ---</option>
                                                <?=$pageData->data->content->role_options?>
                                            </select>
                                        </label>
                                    </section>
                                    <section class="col col-md-6">
                                        <label class="label">Photo</label>                                        
                                        <div class="input input-file">
											<span class="button"><input type="file" name="photo" class="input-sm" onchange="this.parentNode.nextSibling.value = this.value">Browse</span><input type="text" placeholder="add photo" class="input-sm" readonly>
										</div>
                                    </section>
                                </div>
                                <div class="row">
                                    <section class="col col-md-6">
                                        <label class="label">Fullname (KH)</label>
                                        <label class="input">
                                            <input type="text" name="fullname_kh" class="input-sm" placeholder="Fullname (KH)">
                                        </label>
                                    </section>
                                     <section class="col col-md-6">
                                        <label class="label">Fullname (EN)</label>
                                        <label class="input">
                                            <input type="text" name="fullname_en" class="input-sm" placeholder="Fullname (EN)">
                                        </label>
                                    </section>
                                </div>
                                <div class="row">
                                    <section class="col col-md-6">
                                        <label class="label">Gender</label>
                                        <label class="select">
                                             <select name="gender" class="input-sm">
                                                <option value="">--- Select ---</option>
                                                <option value="m">Male</option>
                                                <option value="f">Female</option>
                                            </select>
                                        </label>
                                    </section>
                                    <section class="col col-md-6">
                                        <label class="label">Email</label>
                                        <label class="input">
                                            <input type="email" name="email" class="input-sm" placeholder="Email">
                                        </label>
                                    </section>
                                </div>
                                <div class="row">
                                    <section class="col col-md-12">
                                        <label class="label">Username</label>
                                        <label class="input">
                                            <input type="text" name="username" class="input-sm" placeholder="Username">
                                        </label>
                                    </section>  
                                </div>
                                <div class="row">                                  
                                    <section class="col col-md-6">
                                        <label class="label">Password</label>
                                        <label class="input">
                                            <input type="password" name="pwd" class="input-sm" placeholder="Password">
                                        </label>
                                    </section>
                                    <section class="col col-md-6">
                                        <label class="label">Retype Password</label>
                                        <label class="input">
                                            <input type="password" name="rpwd" class="input-sm" placeholder="Retype Password">
                                        </label>
                                    </section>
                                </div>
                                <div class="row">
                                    <section class="col col-md-6">
                                        <label class="toggle">
                                            <input type="checkbox" name="notif" checked="checked">
                                            <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Notification
                                        </label>
                                        <div id="notif_msg"></div>
                                    </section>
                                    <section class="col col-md-6">
                                        <label class="toggle">
                                            <input type="checkbox" name="active" checked="checked">
                                            <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Active
                                        </label>
                                        <div id="notif_msg"></div>
                                    </section>
                                </div>
                            </fieldset>
                            
                            <footer>
                            	<input class="removable" type="hidden" name="recordid" value="" />
                                <input type="hidden" name="cmd" value="<?=$formCmd?>" />                                
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="reset" class="btn btn-default btn-sm reset_btn">Cancel</button>
                            </footer>
                            </fieldset>
                                <section class="col col-md-12">
                                    <div id="<?=$formkey?>_msg" data-loadtxt='<?=htmlspecialchars($pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title)?>'></div>
                                </section>
                            </fieldset>
                	    </form>
                    </div>
                </div>
            </div>
        </article>
        <!-- WIDGET END -->
    </div>
</div>