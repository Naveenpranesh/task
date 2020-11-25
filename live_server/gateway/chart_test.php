<!-- Javascript SVG parser and renderer on Canvas, used to convert SVG tag to Canvas -->
<script src="<?php echo APPLICATION_URL.'resources/js/jquery.min.js'; ?>"></script>
		<script src="<?php echo APPLICATION_URL.'resources/js/jquery.cookie.min.js'; ?>"></script>
		<script src="<?php echo APPLICATION_URL.'resources/js/select2.full.min.js'; ?>"></script>
		<script src="<?php echo APPLICATION_URL.'resources/js/bootstrap.min.js'; ?>"></script>
		<script src="<?php echo APPLICATION_URL.'resources/js/app.min.js'; ?>"></script>
		<script src="<?php echo APPLICATION_URL.'resources/js/moment.min.js'; ?>"></script>
		<script src="<?php echo APPLICATION_URL.'resources/js/daterangepicker.js'; ?>"></script>
		<script src="<?php echo APPLICATION_URL.'resources/js/jquery.serializejson.min.js'; ?>"></script>
		 <script src="<?php echo APPLICATION_URL.'resources/js/highstock.js'; ?>"></script>
		<script src="<?php echo APPLICATION_URL.'resources/js/exporting.js'; ?>"></script> 
		<script src="<?php echo APPLICATION_URL.'resources/js/rgbcolor.js'; ?>"></script>
		<script src="<?php echo APPLICATION_URL.'resources/js/canvg.js'; ?>"></script>
		<script src="<?php echo APPLICATION_URL.'resources/js/jquery.serializejson.min.js'; ?>"></script>
		<script src="<?php echo APPLICATION_URL.'resources/js/scripts.js'; ?>"></script>
 
<!-- Highchart container -->
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
 
<!-- canvas tag to convert SVG -->
<canvas id="canvas"></canvas>
 
<!-- Save chart as image on the server -->
<input type="button" id="save_img" value="saveImage"/>
 
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () { 
 var myChart1 = Highcharts.chart('container', {
					chart: {
								type: 'bar'
							},
							title: {
								text: 'Fruit Consumption'
							},
							xAxis: {
								categories: ['Apples', 'Bananas', 'Oranges']
							},
							yAxis: {
								title: {
									text: 'Fruit eaten'
								}
							},
							series: [{
								name: 'Jane',
								data: [1, 0, 4]
							}, {
								name: 'John',
								data: [5, 7, 3]
							}]
});
});
 
$("#save_img").click(function(){
var svg = document.getElementById('container').children[0].innerHTML;
canvg(document.getElementById('canvas'),svg);
var img = canvas.toDataURL("image/png"); //img is data:image/png;base64
img = img.replace('data:image/png;base64,', '');
var data = "bin_data=" + img;
$.ajax({
type: "POST",
url: savecharts.php,
data: data,
success: function(data){
alert(data);
}
});
});
</script>