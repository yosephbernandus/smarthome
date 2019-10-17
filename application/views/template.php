<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Smart Home</title>
  <!-- Favicon-->
  <link rel="icon" href="<?php echo base_url(); ?>adminBSB/favicon.ico" type="image/x-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
  
  <!-- Bootstrap Core Css -->
  <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.css');?>" rel="stylesheet">

  <!-- Waves Effect Css -->
  <link href="<?php echo base_url('assets/plugins/node-waves/waves.css');?>" rel="stylesheet" />

  <!-- Animation Css -->
  <link href="<?php echo base_url('assets/plugins/animate-css/animate.css');?>" rel="stylesheet" />
  
  <!-- JQuery DataTable Css -->
  <link href="<?php echo base_url('assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css');?>" rel="stylesheet">

  <!-- Custom Css -->
  <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">

  <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
  <link href="<?php echo base_url('assets/css/themes/all-themes.css');?>" rel="stylesheet" />

  <!-- Paho Script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>

  <!-- sweet alert -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.10/sweetalert2.min.css"/>

  <!-- Jquery Core Js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>


</head>

<body class="theme-red">
  <!-- Page Loader -->
  <div class="page-loader-wrapper">
    <div class="loader">
      <div class="preloader">
        <div class="spinner-layer pl-red">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>
      <p>Please wait...</p>
    </div>
  </div>
  <!-- #END# Page Loader -->
  <!-- Overlay For Sidebars -->
  <div class="overlay"></div>
  <!-- #END# Overlay For Sidebars -->
  <!-- Search Bar -->
  <div class="search-bar">
    <div class="search-icon">
      <i class="material-icons">search</i>
    </div>
    <input type="text" placeholder="START TYPING...">
    <div class="close-search">
      <i class="material-icons">close</i>
    </div>
  </div>
  <!-- #END# Search Bar -->
  <!-- Top Bar -->
  <nav class="navbar">
    <?php echo $_header;?>            
  </nav>
  <!-- #Top Bar -->
  <section>
    <!-- Left Sidebar -->
    <?php echo $_sidebar;?>
    <!-- #END# Left Sidebar -->
  </section>

  <section class="content">
    <?php echo $_content;?>
  </section>
  <!-- form validation -->

<!-- MQTT Script -->
  <script type="text/javascript">
  // parameters
  var deviceState = "";
  var hostname = "ip_public_address";
  var port = 'port';
  var client_id = "client_id";

  // create a client instance
  var client = new Paho.MQTT.Client(hostname, Number(port), client_id);

  client.onConnectionLost = onConnectionLost;
  client.onMessageArrived = onMessageArrived;

  client.connect({
    onSuccess: onConnect,
  });

  function onConnect(){
    console.log("Connect");
    client.subscribe("deviceState");
    client.subscribe("ledState");
    client.subscribe("fanState");
    client.subscribe("ledStatus2");
    client.subscribe("fanStatus2");
    client.subscribe("sensorSuhu");
    client.subscribe("sensorLampu");
  }

  //called when the client loses its connection
  function onConnectionLost(responseObject){
    if (responseObject.errorCode !== 0) {
      console.log("onConnectionLost:" + responseObject.errorMessage);
    }
  }

  setInterval(function(){
    var suhu = $('.sensorSuhu').text();
    $.ajax({
      url:"<?php echo site_url('ac/suhu_proses');?>",
      type:"POST",
      data: "suhu="+suhu,
      cache:false,
      success:function(data){
        console.log(data);
      }
    })
  },60 * 1000)

  // called when a message arrived
  function onMessageArrived(message){

    // console.log(message.payloadString);
    if (message.destinationName == 'sensorSuhu') {
      $('.sensorSuhu').html(message.payloadString + ' C'); 
    }

    if (message.destinationName == 'sensorLampu') {
      if (message.payloadString <= '500') {
        $('#sensorLampu').text('BRIGHT');
      } else {
        $('#sensorLampu').text('DARK');
      }

    }

    if (message.destinationName == 'deviceState') {
      $('.deviceState').html(message.payloadString);
    }

    if (message.payloadString != isNaN) {
      devUptime = message.payloadString;
    }

    if (message.payloadString == "LED ON") {
      $('.led').html("ON");
    }

    if (message.payloadString == "LED OFF") {
      $('.led').html("OFF");
    }

    if (message.payloadString == "FAN ON") {
      $('.fan').html("ON");
    }

    if (message.payloadString == "FAN OFF") {
      $('.fan').html("OFF");
    }
  }

  function ledON(){
    if (!client) {
      return;
    }
    var ledStat = $(".led").text();
    var deviceState = $(".deviceState").text();
    if (deviceState === "OFFLINE") {
      swal(
        'Oops...',
        'Device Offline',
        'error'
        )
    } else if(ledStat === "ON"){
      swal(
        'Oops...',
        'LAMP Already ON!',
        'warning'
        )
    } else {
      var message = new Paho.MQTT.Message("1");
      message.destinationName = "ledStatus";
      client.send(message);
    }
  }

  function ledOFF() {
    if (!client) {
      return;
    }
    var ledStat = $(".led").text();
    var deviceState = $(".deviceState").text();
    if (deviceState === "OFFLINE") {
      swal(
        'Oops...',
        'Device Offline!',
        'error'
        )
    } else if (ledStat === "OFF") {
      swal(
        'Oops...',
        'LAMP Already OFF!',
        'warning'
        )
    } else {
      var message = new Paho.MQTT.Message("0");
      message.destinationName = "ledStatus";
      client.send(message);
    }
  }

  function fanON(){
    if (!client) {
      return;
    }
    var ledStat = $(".fan").text();
    var deviceState = $(".deviceState").text();
    if (deviceState === "OFFLINE") {
    swal(
      'Oops...',
      'Device Offline',
      'error'
    )
    } else if(ledStat === "ON"){
    swal(
      'Oops...',
      'LED Already ON!',
      'warning'
    )
    } else {
      var message = new Paho.MQTT.Message("1");
      message.destinationName = "fanStatus";
      client.send(message);
    }
  }

  function fanOFF() {
    if (!client) {
      return;
    }
    var ledStat = $(".fan").text();
    var deviceState = $(".deviceState").text();
    if (deviceState === "OFFLINE") {
      swal(
        'Oops...',
        'Device Offline!',
        'error'
      )
    } else if (ledStat === "OFF") {
      swal(
        'Oops...',
        'LED Already OFF!',
        'warning'
      )
    } else {
      var message = new Paho.MQTT.Message("0");
      message.destinationName = "fanStatus";
      client.send(message);
    }
  }
</script>

<span style="display: none;" class="sensorSuhu"></span>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.0/jquery.dataTables.js"></script>

<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.js"></script>

<script src="<?php echo base_url(); ?>assets/js/pages/forms/form-validation.js"></script>

<!-- Bootstrap Core Js -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.js"></script>

<!-- sweet alert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.10/sweetalert2.min.js"></script>

<!-- Select Plugin Js -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>

<!-- Slimscroll Plugin Js -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="<?php echo base_url(); ?>assets/plugins/node-waves/waves.js"></script>

<!-- Jquery CountTo Plugin Js -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-countto/jquery.countTo.js"></script>

<!-- Custom Js -->
<script src="<?php echo base_url(); ?>assets/js/admin.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pages/index.js"></script>

</body>
</html>