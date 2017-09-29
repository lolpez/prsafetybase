<?php
$this->assign('title','PrSafetyBase WEB | Home');
$this->assign('nav','notification');
$this->display('_Header.tpl.php');
$this->display('_Menu.tpl.php');
?>
<div id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Notificaciones</h5>
                <ol class="breadcrumbs">
                    <li><a href="./">Inicio</a></li>
                    <li class="active">Notificaciones</li>
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
    <div class="section">
        <div class="row">

        </div>
    </div>
    <div class="fixed-action-btn tooltipped" style="bottom: 50px; right: 19px;" data-position="left" data-delay="50" data-tooltip="Registrar nuevo reporte">
        <a id="btnOpenModal" class="btn-floating btn-large modal-trigger black" href="#mdlNotification">
            <i class="mdi-content-add"></i>
        </a>
    </div>
</div>
<div id="mdlNotification" class="modal modal-fixed-footer">
    <form id="submit_notification" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <h4 class="header2">Nueva notificación</h4>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s6">
                    <input id="id_firebase" type="text">
                    <label for="id_firebase">Firebase ID</label>
                </div>
                <div class="input-field col s12 m6">
                    <textarea id="description" class="materialize-textarea"></textarea>
                    <label for="description">Mensaje</label>
                </div>

            </div>


        </div>
        <div class="modal-footer">
            <button type="submit" class="waves-effect green darken-3 white-text waves-green btn-flat modal-action">
                Aceptar <i class="mdi-content-send right"></i>
            </button>
            <a href="javascript:void(0)" class="waves-effect waves-red btn-flat modal-action modal-close">Cancelar</a>
        </div>
    </form>
</div>
<?php
$this->display('_Footer.tpl.php');
?>

<script>
$(document).ready(function () {
    var app = {
        saveUrl: './notification',
        formReport: $('#submit_notification'),
        modal: $("#mdlNotification"),
        btnOpenModal: $("#btnOpenModal")

    };
    /*****************************************************************************
     *
     * Event listeners for UI elements
     *
     ****************************************************************************/
    app.formReport.on('submit', function (e) {
        e.preventDefault();

        var data = JSON.stringify({
            'id_firebase': $('input#id_firebase').val(),
            'description': $('textarea#description').val()
        });


        $.ajax({
            url: app.saveUrl,
            type: "post",
            data: data
        }).done(function (response) {
            console.log(response)
            response = JSON.parse(response);
            if (response.success){
                Materialize.toast(response.message, 4000);
            }else{
                alert(response.message);
            }
            app.modal.closeModal()
        })
    });
    app.btnOpenModal.click(function () {
        app.clearForm();
    });
    app.clearForm = function(){
        $('textarea#description').val("");
        $('input#id_firebase').val("");
    };

});
</script>