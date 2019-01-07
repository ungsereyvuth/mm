<?php
$listname='labelList';
$formkey1='newPageLabelTranslation';
$formCmd1='newPageLabelTranslation';
$formkey2='newPageLabel';
$formCmd2='newPageLabel';
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
                    	<a href="<?=$pageData->label->label->admin_languagemanagement->url?>" class="btn btn-xs btn-default <?=($pageData->data->content->main_id?'':'hidden')?>"><i class="fa fa-caret-left"></i> Back</a>
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
                                    <tr><th>Type</th><th>Title</th><th style="width:70px;" class="txtCenter">Tools</th></tr>
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
            <div class="jarviswidget" id="<?=$formkey1?>_wid" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false">

                <header>
                    <h2><strong>Translation</strong></h2>    
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <div class="widget-body">                        
                        <form class="ajaxfrm smart-form hidden" role="form" id="<?=$formkey1?>-form" data-func="submit_form" data-reset="1" data-removable="1" action="" method="post">
                            <fieldset>
                                <div class="row">
                                    <section class="col col-md-6">
                                        <label class="label">Language</label>
                                        <input class="removable" type="hidden" name="language_id" value="" />  
                                        <label class="select">
                                            <select name="language_title" disabled>
                                                <option value="">--- Language ---</option>
                                                <?=$pageData->data->content->language_options?>
                                            </select>
                                        </label>
                                        
                                    </section> 
                                    <section class="col col-md-6">
                                        <label class="label">Active</label>
                                        <div class="btm_border_gray">
                                            <label class="toggle">
                                                <input type="checkbox" name="active" checked="checked">
                                                <i data-swchon-text="ON" data-swchoff-text="OFF"></i>On/Off
                                            </label>
                                        </div>
                                        <div id="active_msg"></div>
                                    </section>
                                </div>               
                                <div class="row">
                                    <section class="col col-md-12">
                                        <label class="label">Main Title</label>
                                        <label class="input">
                                            <input type="text" name="main_title" class="input-sm" placeholder="Title" readonly>
                                        </label>
                                    </section>                            
                                </div>                  
                                <div class="row">
                                    <section class="col col-md-12">
                                        <label class="label">Translated Title</label>                                        
                                        <label class="input">
                                            <input type="text" name="title" placeholder="Translated Title">
                                        </label>
                                    </section>                            
                                </div>               
                            </fieldset>
                            <footer>                            	
                                <input class="removable" type="hidden" name="recordid" value="" />
                                <input type="hidden" name="cmd" value="<?=$formCmd1?>" />                                
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="reset" class="btn btn-default btn-sm reset_btn">Cancel</button>
                            </footer>
                            <fieldset>
                                <div class="row">
                                    <section class="col col-md-12">
                                            <div id="<?=$formCmd1?>_msg" data-loadtxt='<?=htmlspecialchars($pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title)?>'></div>
                                    </section>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="jarviswidget" id="<?=$formkey2?>_wid" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false">

                <header>
                    <h2><strong>New Label</strong></h2>    
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <div class="widget-body">    
                        <form class="ajaxfrm smart-form" role="form" id="<?=$formkey2?>-form" data-func="submit_form" data-reset="1" action="" method="post">
                            <fieldset>
                                <div class="row">
                                    <section class="col col-md-6">
                                        <label class="label">Label Category</label>                                        
                                        <label class="select">
                                            <select name="cate_id">
                                                <option value="">--- Select ---</option>
                                                <?=$pageData->data->content->cate_options?>
                                            </select>
                                        </label>
                                    </section>                            
                                    <section class="col col-md-6">
                                        <label class="label">Content Code</label>                                        
                                        <label class="input">
                                            <input type="text" name="content_code" placeholder="Content Code">
                                        </label>
                                    </section>
                                </div>                  
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
                                        <label class="label">URL</label>                                        
                                        <label class="input">
                                            <input type="text" name="url" placeholder="URL">
                                        </label>
                                    </section> 
                                    <section class="col col-md-6">
                                        <label class="label">Icon</label>                                        
                                        <label class="input">
                                            <input type="text" name="icon" placeholder="fontawesome/image url">
                                        </label>
                                    </section>                         
                                </div>                
                                <div class="row">
                                    <section class="col col-md-6">
                                        <label class="label">Data</label>                                        
                                        <label class="input">
                                            <input type="text" name="data" placeholder="Data">
                                        </label>
                                    </section>  
                                    <section class="col col-md-6">
                                        <label class="label">Priority Order</label>                                        
                                        <label class="input">
                                            <input type="number" name="priority" placeholder="Ordering">
                                        </label>
                                    </section>                        
                                </div>                  
                                <div class="row">
                                    <section class="col col-md-6">
                                        <div class="btm_border_gray">
                                            <label class="toggle">
                                                <input type="checkbox" name="for_page">
                                                <i data-swchon-text="ON" data-swchoff-text="OFF"></i>For Page
                                            </label>
                                        </div>
                                        <div id="for_page_msg"></div>
                                    </section>
                                    <section class="col col-md-6">
                                        <div class="btm_border_gray">
                                            <label class="toggle">
                                                <input type="checkbox" name="active" checked="checked">
                                                <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Active
                                            </label>
                                        </div>
                                        <div id="active_msg"></div>
                                    </section>
                                </div>  
                            </fieldset>
                            <footer>      
                            	<input type="hidden" name="main_id" value="<?=($pageData->data->content->main_id>0?encode($pageData->data->content->main_id):'')?>" />
                                <input class="removable" type="hidden" name="recordid" value="" />
                                <input type="hidden" name="cmd" value="<?=$formCmd2?>" />                                
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <button type="reset" class="btn btn-default btn-sm reset_btn">Cancel</button>
                            </footer>
                            <fieldset>
                                 <div class="row">
                                    <section class="col col-md-12">
                                        <div id="<?=$formCmd2?>_msg" data-loadtxt='<?=htmlspecialchars($pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title)?>'></div>
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