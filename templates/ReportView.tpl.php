<?php
$this->assign('title','PrSafetyBase WEB | Home');
$this->assign('nav','report');
$this->display('_Header.tpl.php');
$this->display('_Menu.tpl.php');
?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title">Reportes</h5>
                    <ol class="breadcrumbs">
                        <li><a href="./">Dashboard</a></li>
                        <li><a href="./report">Reportes</a></li>
                        <li class="active">Reporte ID: <?php echo $this->report->Id ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="section">
            <p class="caption">Reporte realizado por: <?php echo $this->human->Name ?></p>
            <div class="divider"></div>
        </div>
        <div class="section">
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <div id='googleMap' style='width:100%;height:400px;margin: auto'></div>
                </div>
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 m6">
                            <ul id="profile-page-about-details" class="collection z-depth-1">
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s5 grey-text darken-1"><i class="mdi-action-accessibility"></i> Trabajador:</div>
                                        <div class="col s7 grey-text text-darken-4 right-align"><?php echo $this->human->Name ?></div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s5 grey-text darken-1"><i class="mdi-action-today"></i> Fecha:</div>
                                        <div class="col s7 grey-text text-darken-4 right-align"><?php echo $this->report->Date ?></div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s5 grey-text darken-1"><i class="mdi-action-query-builder"></i> Hora:</div>
                                        <div class="col s7 grey-text text-darken-4 right-align"><?php echo $this->report->Time ?></div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s5 grey-text darken-1"><i class="mdi-action-assignment"></i> Tipo de reporte:</div>
                                        <div class="col s7 grey-text text-darken-4 right-align">
                                            <?php if ($this->report->ReportType == 1){ ?>Reporte<?php } ?>
                                            <?php if ($this->report->ReportType == 2){ ?>Concientización<?php } ?>
                                        </div>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="row">
                                        <div class="col s5 grey-text darken-1"><i class="mdi-action-perm-media"></i> Fotos o imágenes:</div>
                                        <div class="col s7 grey-text text-darken-4 right-align"><?php echo count($this->images) ?></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col s12 m6">
                            <div class="card light-blue">
                                <div class="card-content white-text">
                                    <span class="card-title">Descripción</span>
                                    <p><?php echo $this->report->Description ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <p class="caption">Fotos e imágenes:</p>
                        </div>
                    </div>
                    <div class="row">
                        <?php foreach ($this->images as $r){ ?>
                            <div class="col s6">
                                <img src="<?php echo $r ?>" alt="<?php echo $this->human->Name ?>" title="Foto o imagen subida por: <?php echo $this->human->Name ?>">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->display('_Footer.tpl.php');
?>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAIO6udUgHwuiAnL-I_Tk5Jp_A6wHh1U84"></script>
<script>
$(document).ready(function () {
    var app = {};

    /*****************************************************************************
     *
     * Logic
     *
     ****************************************************************************/
    app.initializeGoogleMaps = function(lat, lon){
        var infowindow = new google.maps.InfoWindow();
        var mapProp = {
            center:new google.maps.LatLng(lat,lon),
            zoom:12,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
        var marker = new google.maps.Marker({
            position:{lat: lat, lng: lon},
            map:map,
            draggable:false
        });
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });
        app.setLatLong(infowindow,map,marker,marker.getPosition().lat(), marker.getPosition().lng());
    };
    app.setLatLong = function(infowindow, map, marker, lat, lon){
        infowindow.setContent('Latitud: ' + lat + '<br>Longitud: ' + lon);
        infowindow.open(map,marker);
    };
    app.initializeGoogleMaps(<?php echo $this->report->Latitude ?>, <?php echo $this->report->Longitude ?>);
});
</script>