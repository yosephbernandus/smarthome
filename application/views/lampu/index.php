<div class="container-fluid">

    <div class="block-header">
        <h2>
            LAMP MENU
        </h2>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ON / OFF LAMP
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="demo-color-box bg-light-green hover-expand-effect">
                        <div class="color-name">WEMOS D1</div>
                        <div class="color-class-name"><b><h4><span class="deviceState">OFFLINE</span></h4></b></div>
                    </div>

                    <div class="demo-color-box bg-pink">
                        <div class="color-name"><i class="material-icons">power</i></div>
                        <div class="color-class-name"><b><h4><span class="led">OFF</span></h4></b></div>
                    </div>

                    <div class="demo-button">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <button onclick="ledON()" type="button" class="btn btn-block btn-lg btn-primary waves-effect"> 
                                <i class="material-icons">power_settings_new</i>
                                <span>ON</span>
                            </button>
                        </div>
                        
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <button onclick="ledOFF()" type="button" class="btn btn-block btn-lg btn-danger waves-effect"> 
                                <i class="material-icons">power_settings_new</i>
                                <span>OFF</span>
                            </button>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>