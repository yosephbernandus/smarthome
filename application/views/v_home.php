<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 style="text-align: center;">Sistem Saklar On / Off Menggunakan</h2>
<h2 style="text-align: center;">Mikrokontroler WeMos D1 Berbasis Website</h2>
<!-- <h2 style="text-align: center;">Welcome, <?php echo $this->session->userdata("name"); ?></h2> -->
<br>
<div style="text-align: center;">
    <h3><span id="device" class="label label-danger" data-toggle="tooltip" data-placement="bottom" title="Device Status">OFFLINE</span></h3>
</div>
<hr>
<div style="text-align: center;">
    <h3><span id="led" class="label label-primary" data-toggle="tooltip" data-placement="bottom" title="LED Status">LED : OFF</span></h3>
</div>
<br>
<div style="text-align: center;">
    <button id="1" class="btn btn-success digital-on" data-toggle="tooltip" data-placement="bottom" title="LED ON">ON</button>
    <button id="0" class="btn btn-warning digital-off" data-toggle="tooltip" data-placement="bottom" title="LED OFF">OFF</button>
</div>
<hr>
<div style="text-align: center;">
    <h3><span id="fan" class="label label-primary" data-toggle="tooltip" data-placement="bottom" title="FAN Status">FAN : OFF</span></h3>
</div>
<br>
<div style="text-align: center;">
    <button id="f1" class="btn btn-success digital-on" data-toggle="tooltip" data-placement="bottom" title="FAN ON">ON</button>
    <button id="f0" class="btn btn-warning digital-off" data-toggle="tooltip" data-placement="bottom" title="FAN OFF">OFF</button>
</div>
<hr>
<div style="text-align: center;">
    <a class="btn btn-primary" data-toggle="tooltip" data-placement="botton" title="Exit to login page" href="<?php echo base_url('login/logout'); ?>" role="button">Logout</a>
</div>
<br>
<br>
<div style="text-align: center;">
    <h5>&copy; 2017</h5>
</div>

<script>
    var ledValue;
    var fanValue;
    // start get device & status on or off - auto refresh //
    var refresh = function() {
        $.ajax({
            url: "https://cloud.arest.io/150996",
            cache: false,
            dataType: "text",
            timeout: 2000
        })
        .done(function(data) {
            // debug only //
            // console.log(data);
            var json = $.parseJSON(data);
            var vdevice;
            var vled;
            var vfan;
            if (json.connected === true) {
                vdevice = 'ONLINE';
                if(typeof json.message !== "undefined") {
                  if (json.message === 'Pin D6 set to 1') {
                    vled = 'LED : OFF';
                  }
                  if (json.message === 'Pin D6 set to 0') {
                    vled = 'LED : ON';
                  }
                  if (json.message === 'Pin D7 set to 1') {
                    vfan = 'FAN : OFF';
                  }
                  if (json.message === 'Pin D7 set to 0') {
                    vfan = 'FAN : ON';
                  }
                } else {
                  if (json.variables.led === 1) {
                    vled = 'LED : OFF';
                  }
                  if (json.variables.led === 0) {
                    vled = 'LED : ON';
                  }
                  if (json.variables.fan === 1) {
                    vfan = 'FAN : OFF';
                  }
                  if (json.variables.fan === 0) {
                    vfan = 'FAN : ON';
                  }
                }
            }
            $('#device').html(vdevice);
            ledValue = vled;
            fanValue = vfan;
            $('#led').html(vled);
            $('#fan').html(vfan);
            $("#0").removeAttr("disabled");    // enable button off
            $("#1").removeAttr("disabled");    // enable button on
            $("#f0").removeAttr("disabled");    // enable fan button off
            $("#f1").removeAttr("disabled");    // enable fan button on
            // debug only //
            // console.log(ledValue);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            // debug only //
            // console.log('readyState: ' + jqXHR.readyState + ' responseText: ' + jqXHR.responseText + ' status: ' + jqXHR.status + ' statusText: ' + jqXHR.statusText);
            // console.log('Timeout!');
            vdevice = 'TIMEOUT';
            $('#device').html(vdevice);
        })
        .always(function() {
            // debug only //
            // console.log("complete");
            setTimeout(refresh, 2000);
        });
    }

    $(function() {
        refresh();
    });
    // end get device & status on or off - auto refresh //

    // start turn on led //
    $(document).ready(function() {
        $("#1").click(function(e) {
            e.preventDefault();
            $("#1").attr("disabled", "disabled");   // disable button on
            var deviceSpan = $("#device").text();
            var ledSpan = $("#led").text();
            if (deviceSpan === 'OFFLINE') {
                console.log('Device Offline!');
                swal(
                    'Oops...',
                    'Device Offline!',
                    'warning'
                )
                return false;
            } else if (ledSpan === 'LED : ON') {
                console.log('LED Already ON!');
                swal(
                    'Oops...',
                    'LED Already On!',
                    'warning'
                )
                return false;
            } else {
                ledValue = 'LED : ON';
                $('#led').html(ledValue);
                // debug only //
                // console.log(ledValue);
                $.get( "https://cloud.arest.io/150996/digital/5/1", function(data) {
                    console.log('LED ON');
                    // console.log(data);
                });
            }
        });
    });
    // end turn on led //

    // start turn off led //
    $(document).ready(function() {
        $("#0").click(function(e) {
            e.preventDefault();
            $("#0").attr("disabled", "disabled");   // disable button off
            var deviceSpan = $("#device").text();
            var ledSpan = $("#led").text();
            if (deviceSpan === 'OFFLINE') {
                console.log('Device Offline!');
                swal(
                    'Oops...',
                    'Device Offline!',
                    'warning'
                )
                return false;
            } else if (ledSpan === 'LED : OFF') {
                console.log('LED Already OFF!');
                swal(
                    'Oops...',
                    'LED Already Off!',
                    'warning'
                )
                return false;
            } else {
                ledValue = 'LED : OFF';
                $('#led').html(ledValue);
                // debug only //
                // console.log(ledValue);
                $.get( "https://cloud.arest.io/150996/digital/5/0", function(data) {
                    console.log('LED OFF');
                    // console.log(data);
                });
            }
        });
    });
    // start turn off led //

    // start turn on fan //
    $(document).ready(function() {
        $("#f1").click(function(e) {
            e.preventDefault();
            $("#f1").attr("disabled", "disabled");   // disable button on
            var deviceSpan = $("#device").text();
            var fanSpan = $("#fan").text();
            if (deviceSpan === 'OFFLINE') {
                console.log('Device Offline!');
                swal(
                    'Oops...',
                    'Device Offline!',
                    'warning'
                )
                return false;
            } else if (fanSpan === 'FAN : ON') {
                console.log('FAN Already ON!');
                swal(
                    'Oops...',
                    'FAN Already On!',
                    'warning'
                )
                return false;
            } else {
                fanValue = 'FAN : ON';
                $('#fan').html(fanValue);
                // debug only //
                // console.log(ledValue);
                $.get( "https://cloud.arest.io/150996/digital/7/0", function(data) {
                    console.log('FAN ON');
                    // console.log(data);
                });
            }
        });
    });
    // end turn on fan //

    // start turn off fan //
    $(document).ready(function() {
        $("#f0").click(function(e) {
            e.preventDefault();
            $("#f0").attr("disabled", "disabled");   // disable button off
            var deviceSpan = $("#device").text();
            var fanSpan = $("#fan").text();
            if (deviceSpan === 'OFFLINE') {
                console.log('Device Offline!');
                swal(
                    'Oops...',
                    'Device Offline!',
                    'warning'
                )
                return false;
            } else if (fanSpan === 'FAN : OFF') {
                console.log('FAN Already OFF!');
                swal(
                    'Oops...',
                    'FAN Already Off!',
                    'warning'
                )
                return false;
            } else {
                fanValue = 'FAN : OFF';
                $('#fan').html(fanValue);
                // debug only //
                // console.log(ledValue);
                $.get( "https://cloud.arest.io/150996/digital/7/1", function(data) {
                    console.log('FAN OFF');
                    // console.log(data);
                });
            }
        });
    });
    // start turn off fan //
</script>
