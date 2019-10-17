<!DOCTYPE html>
<html>
<head>
	<title>Chart</title>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/chartjs/utils.js');?>"></script>
	<style type="text/css">
		.container {
			width: 50%;
			margin: 15px;
		}
	</style>
</head>
<body>
	<div class="container">
		<canvas id="canvas" width="100" height="100"></canvas>
	</div>
	<script type="text/javascript">

        var config = {
            type: 'line',
            data: {
                labels: [<?php foreach ($bulan as $row) {echo '"' . $row->bulan . '",';}?>],
                datasets: [{
                    label: "Sensor Suhu LM35DZ",
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: [
                        <?php foreach ($hasil_penjualan as $row) {echo '"' . $row->hasil_penjualan . '",';}?>
                    ],
                    fill: false,
                }, {
                	label: "My Second dataset",
                    fill: false,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor()
                    ],
                }]
            },
            options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Sensor Suhu LM35DZ'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx, config);
        };
	</script>
</body>
</html>