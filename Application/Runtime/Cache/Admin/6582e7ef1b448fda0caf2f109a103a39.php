<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Highcharts Example</title>

		<style type="text/css">

		</style>
	</head>
	<body>
<script src="/Public/Admin/Highcharts/code/highcharts.js"></script>
<script src="/Public/Admin/Highcharts/code/modules/exporting.js"></script>
<script src="/Public/Admin/Highcharts/code/modules/export-data.js"></script>

<div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>



		<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: '部门人数统计明细'
    },
    subtitle: {
        text: '来源: <a href="javascript:void(0)">人事部</a>'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: '人数 (个)'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: '截止当前: <b>{point.y:.0f} 人</b>'
    },
    series: [{
        name: 'Population',
        data: [ <?php echo ($str); ?> ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.0f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
		</script>
	</body>
</html>