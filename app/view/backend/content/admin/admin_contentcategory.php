<?php
$listname='admin_contentcategory';
$formkey='newContentCategory';
?>

<section id="widget-grid" class="">
    <!-- row -->
    <div class="row">
    	<article class="col-sm-6 col-lg-7">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="<?=$listname?>_wid" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false">
                <header>
                    <h2 class="khmerNormal"><?=$pageData->label->label->admin_contentlist->title?></h2>   
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
                        <div class="datalist txtLeft pad10" id="<?=$listname?>">
							<div class="list_filters hidden">
                            <?=$pageData->data->content->search_inputs?>
                            </div>
                            <?php include("app/view/frontend/layout/pagination_info.php"); ?>
                            <table width="100%" class="mytable" >
                                <thead>
                                    <tr><th style="width:50px;" class="txtCenter">No.</th><th>Title</th><th style="width:70px;" class="txtCenter">Tools</th></tr>
                                </thead>
                                <tbody></tbody>
                            </table> 
                            <?php include("app/view/frontend/layout/listPagination.php");?>  
                        </div> 	
                    </div>
                </div>
            </div>
        </article>
        <article class="col-sm-6 col-lg-5">
        	<div class="jarviswidget" id="<?=$formkey?>_wid" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false">
                <header>
                    <h2><i class="fa fa-user-plus"></i> New/Update Category</h2>   
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <div class="widget-body">
                    	  <form class="ajaxfrm smart-form" role="form" id="<?=$formkey?>-form" data-func="submit_form" data-reset="1" data-removable="1" action="" method="post">
                            	<fieldset>
                                    <div class="row">
                                        <section class="col col-md-6">
                                        	<label class="label">Title</label>                                        
                                            <label class="input">
                                                <input type="text" name="title" placeholder="Title">
                                            </label>
                                        </section>
                                        <section class="col col-md-6">
                                            <label class="label">Code</label>                                        
                                            <label class="input">
                                                <input type="text" name="code" placeholder="Code">
                                            </label>
                                        </section>
                                    </div>               
                                    <div class="row">
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
                               </fieldset>      
                               <footer>      
                                    <input class="removable" type="hidden" name="recordid" value="" />
                        			<input type="hidden" name="cmd" value="<?=$formkey?>" />
                                    <button class="btn btn-primary btn-sm" type="submit">Save</button>
                                    <button class="btn btn-default btn-sm reset_btn" type="reset">Cancel</button>
                                </footer>
                                <fieldset>
                                     <div class="row">
                                        <section class="col col-md-12">
                                            <div id="<?=$formkey?>_msg" data-loadtxt='<?=htmlspecialchars($pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title)?>'></div>
                                        </section>
                                    </div>
                                </fieldset> 
                        </form>
                    </div>
                </div>
            </div> 
        </article>
    </div>
</section>