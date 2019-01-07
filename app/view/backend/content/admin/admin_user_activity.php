<?php
$listname='admin_user_activity';
$logByType='';$logByType_table = '';
foreach($pageData->data->content->logByType as $key=>$value){
	$value=(object)$value; $rndbg=substr(md5(rand()), 0, 6);
	$logByType.=",['$value->cmdName', $value->totalByType, '$rndbg', '".$value->totalByType."']";
	$logByType_table .= '<tr>
							<td class="txtCenter">'.($key+1).'</td>
							<td>'.$value->cmdName.'</td>
							<td class="txtCenter">'.$value->totalByType.'</td>
						</tr>';
}

?>

<div class="page_content">
<div class="clearfix">
    <div class="col-md-12">
        <div class="v_mgn10 pad10 bg-white overflow-hidden">
            <div id="chart_div"></div>
        </div>
    </div>
</div>
<div class="clearfix">		
	<div class="col-md-8">   
    	<div class="margin-bottom-20"> 	
            <div class="datalist txtLeft pad10 bg-blacklight" id="<?=$listname?>">
                <?=$pageData->data->content->search_inputs?>
                <?php include("app/view/frontend/layout/pagination_info.php"); ?>
                <table width="100%" class="mytable" >
                    <thead>
                        <tr><th style="width:50px;" class="txtCenter">No.</th><th>User</th><th>Activity</th><th>Data</th><th>IP/ISP</th><th>Device/OS</th><th>Date</th></tr>
                    </thead>
                    <tbody></tbody>
                </table> 
                <?php include("app/view/frontend/layout/listPagination.php");?>  
            </div> 	
        </div>
	</div>
    <div class="col-md-4">   
    	<div class="bg-white overflow-hidden h_pad5">
            <div class="headline"><h4 class="fs16">Last 2 months activity count<h4></div> 	
            <div class="tab-v2">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#chart-tab" data-toggle="tab">Chart</a></li>
                    <li><a href="#table-tab" data-toggle="tab">Table</a></li>
                </ul>
                <div class="tab-content pad0">
                    <div class="tab-pane fade in active" id="chart-tab">
                        <div id="barchart"></div>
                    </div>
                    <div class="tab-pane fade in" id="table-tab"> 	
                    	<div class="pad10">
                            <table class="mytable fs12">
                                <thead>
                                    <tr>
                                        <th class="txtCenter">No.</th>
                                        <th>CMD</th>
                                        <th class="txtCenter">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?=$logByType_table?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </h4>
    </div>
</div>
</div>

<?php
//booking summary
// get last 10 days
$graph_data_str=array();
foreach($pageData->data->content->graph_data as $key=>$value){//in js, 0=jan (php, 1=jan)
	$time = strtotime($value['traffic_date']);
	if($time>time()){$totalByDay='null';}else{$totalByDay=$value['totalByDay'];}
	$graph_data_str[]="[{v: new Date(".date('Y',$time).','.(date('m',$time)-1).','.date('d',$time)."), f: '".date('d/m/y',$time)."'},$totalByDay]";
}

$late_script_file = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';


$late_script = "google.charts.load('current', {'packages':['line','corechart', 'bar']});
			      google.charts.setOnLoadCallback(drawChart);
				  google.charts.setOnLoadCallback(drawBarChart);
			
				function drawChart() {
					  var data = new google.visualization.DataTable();
					  data.addColumn('date', 'Day');
					  data.addColumn('number', 'Count');

				
					  data.addRows([
					  	".implode(',',$graph_data_str)."
					  ]);
				
					  var options = {
						chart: {
						  title: 'Daily Activity Traffic (Last 2 months)',
						  subtitle: 'For Period: ".$pageData->data->content->dateBetween."'
						},
						hAxis: {
						  title: 'Day',
						  format: 'dd/MMM'
						},
						vAxis: {
						  title: 'Frequency'
						},
						height: 250
					  };
	
					  var chart = new google.charts.Line(document.getElementById('chart_div'));
	
					  chart.draw(data, google.charts.Line.convertOptions(options));

					}
				";

				
$late_script .= "function drawBarChart() {

					  var data = google.visualization.arrayToDataTable([
						['Activity', 'Total', { role: 'style' }, { role: 'annotation' }] $logByType
					  ]);
				
					  var options = {
						title: 'Last 2 months activity count',
						chartArea: {width: '50%'},
						'height':500,
						bar: {groupWidth:  '95%'},
        				legend: { position: 'none' },
						hAxis: {
						  title: 'Total Count',
						  minValue: 0
						},
						vAxis: {
						  title: 'Activity'
						}
					  };
				
					  var chart = new google.visualization.BarChart(document.getElementById('barchart'));
				
					  chart.draw(data, options);
					}					
					
					";
					
?>

