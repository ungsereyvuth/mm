<?php
$listname='page_controller_list';
$formkey='newpagecontrol';
$formCmd='newpagecontrol';
?>
<!-- widget grid -->
<section id="widget-grid" class="">
    <!-- row -->
    <div class="row">

	<article class="col-md-8">
        <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="<?=$listname?>_wid" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false">

                <header>
                    <h2><strong>Page Controll</strong> <i>List</i></h2>   
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
                                    <tr><th style="width:50px;" class="txtCenter">No.</th><th>Page Title</th><th style="width:70px;" class="txtCenter">Tools</th></tr>
                                </thead>
                                <tbody></tbody>
                            </table> 
                            <?php include("app/view/frontend/layout/listPagination.php");?>  
                        </div>  

                    </div>
                </div>
        </div>                


        
	</article>
    <article class="col-md-4">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="<?=$formkey?>_wid" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false">

                <header>
                    <h2><strong>New</strong> <i>Controll</i></h2>    
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
                                        <label class="label">Page Label</label>
                                        <label class="select">
                                            <select name="label_id" id="label_id">
                                            	 <?=$pageData->data->content->page_labels?>
                                            </select>
                                        </label>
                                    </section>                            
                                    <section class="col col-md-6">
                                        <label class="label">Parent</label>
                                        <label class="select">
                                            <select name="parent_id">
                                            	<?=$pageData->data->content->page_contorls?>
                                            </select>
                                        </label>
                                    </section>
                                </div>      
                                <div class="row">
                                    <section class="col col-md-6">
                                        <label class="label">Model Name</label>
                                        <label class="input">
                                            <input type="text" id="model_name" name="model" placeholder="Model Name">
                                        </label>
                                    </section>
                                    <section class="col col-md-6">
                                        <label class="label">Interited From</label>
                                        <label class="input">
                                            <input type="text" name="inherited" placeholder="Inherited from">
                                        </label>
                                    </section>
                                                           	
                                </div>  
                                <div class="row">
                                    <section class="col col-md-6">
                                        <label class="label">Ordering Number</label>
                                        <label class="input">
                                            <input type="number" name="ordering" placeholder="Ordering">
                                        </label>
                                    </section>
                                    <section class="col col-md-6">
                                        <label class="label">Inner Directory</label>
                                        <label class="select">
                                            <select name="dir">
                                                <?=$pageData->data->content->dirs?>
                                            </select>
                                        </label>
                                    </section>
                                </div>  
                                <div class="row">
                                    <section class="col col-md-6">
                                        <div class="btm_border_gray">
                                            <label class="toggle">
                                                <input type="checkbox" name="required_login">
                                                <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Login
                                            </label>
                                        </div>
                                        <div id="required_login_msg"></div>
                                    </section>
                                    <section class="col col-md-6">
                                        <div class="btm_border_gray">
                                            <label class="toggle">
                                                <input type="checkbox" name="required_logout">
                                                <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Logout
                                            </label>
                                        </div>
                                        <div id="required_logout_msg"></div>
                                    </section>
                                </div>  
                                <div class="row">
                                    <section class="col col-md-6">
                                        <div class="btm_border_gray">
                                            <label class="toggle">
                                                <input type="checkbox" name="required_layout">
                                                <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Layout
                                            </label>
                                        </div>
                                        
                                        <div id="required_layout_msg"></div>
                                    </section>
                                    <section class="col col-md-6">
                                        <div class="btm_border_gray">
                                            <label class="toggle">
                                                <input type="checkbox" name="is_menu">
                                                <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Menu
                                            </label>
                                        </div>
                                        <div id="is_menu_msg"></div>
                                    </section>
                                </div>                 	
                                <div class="row">
                                    <section class="col col-md-6">
                                        <div class="btm_border_gray">
                                            <label class="toggle">
                                                <input type="checkbox" name="is_ajax">
                                                <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Ajax
                                            </label>
                                        </div>
                                        <div id="is_ajax_msg"></div>
                                    </section>
                                    <section class="col col-md-6">
                                        <div class="btm_border_gray">
                                            <label class="toggle">
                                                <input type="checkbox" name="is_webpage">
                                                <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Webpage
                                            </label>
                                        </div>
                                        <div id="is_webpage_msg"></div>
                                    </section>
                                </div>                
                                <div class="row">
                                    <section class="col col-md-6">
                                        <div class="btm_border_gray">
                                            <label class="toggle">
                                                <input type="checkbox" name="is_backend">
                                                <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Backend
                                            </label>
                                        </div>
                                        <div id="is_backend_msg"></div>
                                    </section>
                                    <section class="col col-md-6">
                                        <div class="btm_border_gray">
                                            <label class="toggle">
                                                <input type="checkbox" name="active" checked>
                                                <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Active
                                            </label>
                                        </div>
                                        <div id="active_msg"></div>
                                    </section>
                                </div>    
                                <div class="row">
                                    <section class="col col-md-6">
                                        <div class="btm_border_gray">
                                            <label class="toggle">
                                                <input type="checkbox" name="has_shortcut">
                                                <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Shortcut
                                            </label>
                                        </div>
                                        <div id="has_shortcut_msg"></div>
                                    </section>
                                </div>    
                                <div class="row">
                                    <section class="col col-md-12">
                                        	<label class="label">Page Components</label>
                                            <div class="inline-group">
                                            	<?php
                								foreach($pageData->data->content->page_components as $key=>$value){
                									echo '<label class="checkbox"><input type="checkbox" name="components['.$value['id'].']" value="'.$value['id'].'"><i></i>'.$value['component_name'].'</label>';
                								}
                								?>
                                            </div>
                                    </section>  
                                </div>
                                
                                <div class="row">
                                    <section class="col col-md-12">
                                    	<label class="label">User Priviledge</label>
                                        <div class="inline-group">
                                        	<?php
            								foreach($pageData->data->content->user_roles as $key=>$value){
            									echo '<label class="checkbox"><input type="checkbox" name="user_roles['.$value['id'].']" value="'.$value['id'].'"><i></i>'.$value['title'].'</label>';
            								}
            								?>
                                        </div>
                                    </section>
                                </div> 
                            </fieldset>
                            <footer>
                                <input class="removable" type="hidden" name="recordid" value="" />
                                <input type="hidden" name="cmd" value="<?=$formCmd?>" />                                
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="reset" class="btn btn-default btn-sm reset_btn">Cancel</button>
                            </footer>
                            <fieldset>         
                                <div class="row">
                                    <section class="col col-md-12">
                                    	<div id="newpagecontrol_msg" data-loadtxt='<?=htmlspecialchars($pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title)?>'></div>
                                    </section>
                                </div>
                            </fieldset>
                	    </form>
	               </div>
            </div>
        </div>
    </article>	
</div>

</div>