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
                        <li><a href="index.html">Dashboard</a></li>
                        <li><a href="#">Pages</a></li>
                        <li class="active">Blank Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="section">
            <p class="caption">We gotta skome some shit nigguh.</p>
            <div class="divider"></div>
        </div>
        <div class="fixed-action-btn" style="bottom: 50px; right: 19px;">
            <a id="btnOpenModal" class="btn-floating btn-large modal-trigger black" href="#reportMdl">
                <i class="mdi-content-add"></i>
            </a>
        </div>
    </div>
    <div id="reportMdl" class="modal modal-fixed-footer">
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <h4 class="header2">Nuevo reporte</h4>
                </div>
            </div>
            <div class="row">
                <div class="input-field col m6 s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <select id="report_type">
                                <option value="" disabled selected>Seleccione un tipo de reporte</option>
                                <option value="1">Reporte</option>
                                <option value="2">Concientización</option>
                            </select>
                            <label for="report_type">Tipo de reporte</label>
                        </div>
                        <div class="input-field col s12">
                            <textarea id="description" class="materialize-textarea"></textarea>
                            <label for="description">Descripción</label>
                        </div>
                        <div class="file-field input-field col s12">
                            <input class="file-path validate col m8 s6" type="text"/>
                            <div class="btn indigo col m4 s6">
                                <span>Imagen</span>
                                <input type="file"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-field col m6 s12">
                    <div id='googleMap' style='width:100%;height:400px;margin: auto'></div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <h4 class="header2">Seleccione a los trabajadores que desea mostrar este reporte</h4>
                </div>
            </div>
            <div class="row">
                <?php foreach ($this->departments as $r){ ?>
                    <div class="input-field col m4 s12">
                        <select id="cmbWorker<?php echo $r->id ?>" class="worker" multiple>
                            <option value="" disabled selected>Seleccione trabajadores</option>
                            <option value="1">Trabajador de <?php echo $r->name ?> 1</option>
                            <option value="2">Trabajador de <?php echo $r->name ?> 2</option>
                            <option value="3">Trabajador de <?php echo $r->name ?> 3</option>
                        </select>
                        <label for="cmbWorker<?php echo $r->id ?>"><?php echo $r->name ?></label>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="modal-footer">
            <a id="btnSave" href="javascript:void(0)" class="waves-effect green darken-3 white-text waves-green btn-flat modal-action">
                Aceptar <i class="mdi-content-send right"></i>
            </a>
            <a href="javascript:void(0)" class="waves-effect waves-red btn-flat modal-action modal-close">Cancelar</a>
        </div>
    </div>
<?php
$this->display('_Footer.tpl.php');
?>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAIO6udUgHwuiAnL-I_Tk5Jp_A6wHh1U84"></script>
<script>
$(document).ready(function () {
    var app = {
        saveUrl: './api/safreport',
        btnSave: $("#btnSave"),
        btnOpenModal: $("#btnOpenModal")
    };
    /*****************************************************************************
     *
     * Event listeners for UI elements
     *
     ****************************************************************************/
    app.btnSave.click(function () {
        var workers = [];
        $("select.worker").each(function (index, ele) {
            workers = workers.concat($(ele).val());
        });
        var data={
            'description': $('textarea#description').val(),
            'reportType': $('select#report_type').val(),
            'latitude': $('input#latitude').val(),
            'longitude': $('input#longitude').val(),
            'workers': workers
        };
        app.save(data, function(response){
            response = JSON.parse(response);
            if (response.success){
                alert(response.message);
            }else{
                alert(response.message);
            }
        })
    });
    app.btnOpenModal.click(function () {
        app.clearForm();
    });
    app.clearForm = function(){
        app.initializeGoogleMaps(-17.7860198, -63.1786445);
        $('textarea#description').val("");
        $('select#report_type').val("");
    };
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
            draggable:true
        });
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });
        google.maps.event.addListener(marker,'dragend',function(){
            app.setLatLong(infowindow,map,marker,marker.getPosition().lat(), marker.getPosition().lng());
        });
        app.setLatLong(infowindow,map,marker,marker.getPosition().lat(), marker.getPosition().lng());
    };
    app.setLatLong = function(infowindow, map, marker, lat, lon){
        infowindow.setContent('Latitud: ' + lat + '<br>Longitud: ' + lon);
        infowindow.open(map,marker);
        $("input#latitude").attr("value", lat);
        $("input#longitude").attr("value", lon);
    };
    app.save = function (data, callback) {
        $.ajax({
            method: 'POST',
            url: app.saveUrl,
            data: JSON.stringify(data),
            async: true
        }).done(function (response) {
            callback(response);
        }).fail(function() {
            callback({success:false, errorCode:2});
        });
    };
});
</script>