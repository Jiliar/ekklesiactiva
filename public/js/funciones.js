function getFields(){

    var data = new Object();
    let flag = false;
    let view  = $('#hdnView').val();

    var fields = document.forms[view].getElementsByTagName("input");
    for(i = 0; i< fields.length; i++){
        let str = fields[i].id;
        if(str != '' && str != undefined && ! str.includes("select-focus-trigger")){
            data[fields[i].id] = fields[i].value;
        }
    }

    var fields2 = document.forms[view].getElementsByTagName("select");
    for(i = 0; i< fields2.length; i++){
        let str = fields2[i].id;
        if(str != '' && str != undefined && ! str.includes("select-focus-trigger")){
            valor = $('#'+str).val();
            data[fields2[i].id] = valor.toString();
            /*if(fields2[i].id == 'lstTipo_doc' && valor =='#'){
                data[fields2[i].id] = '0';
            }*/
            if(valor =='#'){
               flag = true;
            }
        }
    }

    var fields3 = document.forms[view].getElementsByTagName("textarea");
    for(i = 0; i< fields3.length; i++){
        let str = fields3[i].id;
        if(str != '' && str != undefined && ! str.includes("select-focus-trigger")){
            if(fields3[i].id == 'ckeContenido'){
                data[fields3[i].id] = CKEDITOR.instances.ckeContenido.getData();
            }else if(fields3[i].id == 'ckeCuerpoMensaje'){
                data[fields3[i].id] = CKEDITOR.instances.ckeCuerpoMensaje.getData();
            }else{
                data[fields3[i].id] = fields3[i].value;
            }
        }
    }
    if(!flag){
        object = JSON.stringify(data);
    }else{
        object = null;
    }

    return object;
}

function validateFields(){

    var ids = new Array();
    var values = new Array();
    var cant = 0;

    let view  = $('#hdnView').val();

    var fields = document.forms[view].getElementsByTagName("input");
    console.log(fields);
    for(i = 0; i< fields.length; i++){
        console.log(fields[i].id);
        if( fields[i] != undefined && fields[i].id != "" && fields[i].id != undefined){
            if($('#'+fields[i].id).prop('required')){
                ids[cant] = fields[i].id;
                values[cant] = fields[i].value;
                cant++;
            }
        }
    }

    var fields2 = document.forms[view].getElementsByTagName("select");
    console.log(fields2);
    for(i = 0; i< fields2.length; i++){
        if( fields2[i] != undefined && fields2[i].id != "" && fields2[i].id != undefined  ){
            if($('#'+fields2[i].id).prop('required')){
                ids[cant] = fields2[i].id;
                values[cant] = fields2[i].value;
                cant++;
            }
        }
    }

    var fields3 = document.forms[view].getElementsByTagName("textarea");
    console.log(fields3);
    for(i = 0; i< fields3.length; i++){
        if( fields3[i] != undefined && fields3[i].id != "" && fields3[i].id != undefined  ){
            if($('#'+fields3[i].id).prop('required')){
                ids[cant] = fields3[i].id;
                values[cant] = fields3[i].value;
                cant++;
            }
        }
    }

    return [ids, values, cant];
}


function sendDataForm(){
    data = validateFields();


    ids = data[0];
    values = data[1];

    var pos = 0;
    for(var i=0; i <ids.length; i++){
        if(values[i] == ""){
            pos++;
        }
    }
    console.log("cantidad  "+pos);
    if(pos == 0){
        var url = $('#hdnView').val();
        if(url.indexOf('logic_cv_') > -1 ){
            let usuario_cv = $('#hdnUsuario').val();
            $('#hdnUsuario_cv').val(usuario_cv);
        }
        registerDataForm(getFields(),url, 'save');
    }else{
        ids = data[0];
        values = data[1];
        for(var i=0; i <ids.length; i++){
            id = '#'+ids[i];
            if(values[i] == "" || values[i] =="#"){
                $(id).parent()[0].style = 'border-color: red !important';
            }else{
                $(id).parent()[0].style = '';
            }
        }
        let msg = '¡Tenga en cuenta que los campos requeridos deben estar diligenciados!';
        let title = 'Validación de Datos'
        let type = 'warning';
        showMsgMetro(msg, type, title, 2000, 400);
    }
}

function cleanDataForm(){
    let obj = JSON.parse(getFields());
    let componentes = Object.keys(obj);
    for(var i=0; i <componentes.length; i++){
        if(componentes[i].indexOf("token") == -1){
            if(componentes[i].indexOf("txt") > -1 || componentes[i].indexOf("hdn") > -1 || componentes[i].indexOf("dtp") > -1){
                if(componentes[i].indexOf('hdnView') == -1 && componentes[i].indexOf('txtAnio') == -1){
                    $('#'+componentes[i]).val('');
                }
            }
            if(componentes[i].indexOf("lst") > -1){
                var lst=Metro.getPlugin("#"+componentes[i], "select");
                if(componentes[i].indexOf('lstInactivar') == -1 &&
                    componentes[i].indexOf('lstPeriodo') == -1 &&
                    componentes[i].indexOf('lstId_usuario') == -1){
                    lst.val("0");
                }else{
                    lst.val("#")
                }
            }
        }
    }
}

function updateDataForm(){
    data = validateFields();
    ids = data[0];
    values = data[1];
    var pos = 0;
    for(var i=0; i <ids.length; i++){
        if(values[i] == ""){
            pos++;
        }
    }
    console.log(data);
    console.log("cantidad  "+pos);
    if(pos == 0){
        var url = $('#hdnView').val();
        registerDataForm(getFields(),url, 'update');
    }else{
        ids = data[0];
        values = data[1];
        for(var i=0; i <ids.length; i++){
            id = '#'+ids[i];
            if(values[i] == "" || values[i] =="#"){
                $(id).parent()[0].style = 'border-color: red !important';
            }else{
                $(id).parent()[0].style = '';
            }
        }

        let msg = '¡Tenga en cuenta que los campos requeridos deben estar diligenciados!';
        let title = 'Validación de Datos'
        let type = 'warning';
        showMsgMetro(msg, type, title, 2000, 400);
    }
}

function deleteDataForm(){
    var token = $('#_token').val();
    var view = $('#hdnView').val();
    var id = $('#hdnId').val();
}

function registerDataForm(info, url, method){

    var token = $('#_token').val();
    var formData = new FormData();
    formData.append('_token',token);
    formData.append('method', method);
    formData.append('data', info);

    if($('input[type=file]').length){
        let files = $('input[type=file]')[0].files;
        if( typeof files !== "undefined"){
            jQuery.each($('input[type=file]')[0].files, function(i, file) {
                formData.append('file-'+i, file);
            });
        }else{
            formData.append('file', null);
        }
    }

    if(info != null){
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data:formData,
            cache:false,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.reg_btn_forms').attr('disabled',true);
                $('.update_btn_forms').attr('disabled',true);
            }
        })
        .done(function(respuesta) {
            var json = JSON.stringify(respuesta['output']);
            var data = JSON.parse(json);
            if (!respuesta.error) {
                successMsgFormSweet();
                if(url != 'inf_ministerios' &&
                url != 'inf_asistencias' &&
                url != 'inf_actividades' &&
                url != 'logic_restaurar_password'  ){
                    getTable();
                }
                if($('input[type=file]').length){
                    $('.avatar').attr('src', data['imagen']);
                }
                cleanDataForm();
            } else {
                errorMsgFormSweet2(data)
            }
        })

        .fail(function(resp) {
            errorMsgFormMetro();
        })

        .always(function() {
            $('.reg_btn_forms').attr('disabled',false);
            $('.update_btn_forms').attr('disabled',false);
            console.log("complete");
        });
    }else{
        let msg = '¡Error al intentar de realizar la operación! <br/> Hay datos no seleccionados en el formulario';
        let title = 'Alerta'
        let type = 'alert';
        showMsgMetro(msg, type, title, 2000, 250);
    }

 }

function sortButtons(){
    $('.buttons-container div').html($('.container-button').clone());
    let buttons = $('.container-button');
    for(i = 0; i < buttons.length/2; i++){
        buttons[i].remove();
    }
}

function getTable(){
    let view = $('#hdnView').val();
    console.log(view);
    if(view !== undefined){
        let componente = view.substring(5);
        if(componente != 'logic_restaurar_password'){
            var request = $.ajax({
                url: view,
                type: 'GET',
                contentType: "text/html; charset=UTF-8",
                data: { uri: componente},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#container-detalles').html("<img src='images/icons/loading.gif' alt='loading'/><span style=\"font-family: 'Monserrat Regular';\">Cargando información, por favor espere...</span>");
                 }
            });

            request.done(function(respuesta) {
                var json = JSON.stringify(respuesta['output']);
                var data = JSON.parse(json);
                if (!respuesta.error) {
                    $('#container-detalles').html('');
                    $('#container-detalles').html(data);
                } else {
                    Swal.fire(
                        '¡Atención!',
                        'Existio un problema al intentar generar la tabla de detalles',
                        'error'
                    )
                }
            });

            request.fail(function(jqXHR, textStatus, errorThrown) {
                let error = "";
                if (jqXHR.status === 0) {
                    error = 'Not connect: Verify Network.';
                } else if (jqXHR.status == 404) {
                    error = 'Requested page not found [404]';
                } else if (jqXHR.status == 500) {
                    error = 'Internal Server Error [500].';
                } else if (textStatus === 'parsererror') {
                    error = 'Requested JSON parse failed. '+errorThrown;
                } else if (textStatus === 'timeout') {
                    error = 'Time out error.';
                } else if (textStatus === 'abort') {
                    error = 'Ajax request aborted.';
                } else {
                    error = 'Uncaught Error: ' + jqXHR.responseText;
                }
                showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
            });
        }
    }
}

$(document).ready(function(){
    $(document).on("click", "input[type=radio]", function(e){
        let view = $('#hdnView').val();
        let id = this.value;
        let componente = view.substring(5);
        if(view == 'form_logic_validacion_inscripciones'){
            ids = id.split(".");
            $('#hdnIdConvocatoria').val(ids[1]);
            $('#hdnIdUsuario').val(ids[0]);
            $('#hdnIdInscripcion').val(ids[2]);
        }else{
            searchForEdit(id, componente, view);
        }

    });
});

function searchForEdit(id, componente, view){

    var request = $.ajax({
        url: view+'_one',
        type: 'GET',
        contentType: "text/html; charset=UTF-8",
        data: {componente: componente, id: id},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
    });

    request.done(function(respuesta) {
        var json = JSON.parse(respuesta['output']);
        if (!respuesta.error) {
            let data = Object.entries(json);
            for(i = 0; i< data.length; i++){
                if(data[i][0].indexOf("txt") > -1 ||
                    data[i][0].indexOf("hdn") > -1 ||
                    data[i][0].indexOf("dtp") > -1){
                    $("#"+data[i][0]).val(data[i][1]);
                }
                if(data[i][0].indexOf("cke") > -1){
                    CKEDITOR.instances.ckeContenido.setData(data[i][1])
                }
                if(data[i][0].indexOf("lst") > -1){

                    if(data[i][0] == 'lstTipo_doc' && data[i][1] == "#"){
                        var lst=Metro.getPlugin("#"+data[i][0], "select");
                        $('#lstTipo_doc').attr('disabled',true);
                        lst.val("#");
                    }else{
                        if(data[i][0] == 'lstTipo_doc' && data[i][1] != 0){
                            var lst=Metro.getPlugin("#"+data[i][0], "select");
                            $('#lstTipo_doc').attr('disabled',false);
                            lst.val(data[i][1]);
                        }else{
                            if(data[i][0] != 'lstTipo_doc'){
                                var lst=Metro.getPlugin("#"+data[i][0], "select");
                                if(lst !== undefined){
                                    lst.val(data[i][1]);
                                }
                            }
                        }
                    }
                }
            }
        } else {
            Swal.fire(
                '¡Atención!',
                'Existio un problema al intentar buscar el registro',
                'error'
              )
        }
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });
}

/*-----------------------------------------------------------*/
/*Metodos Mensajes*/
/* Metro UI */
function showMsgMetro(msg, type, title, duration, width){
    var notify = Metro.notify;
    notify.setup({
        width: width,
        duration: duration,
        animation: 'easeOutBounce'
    });
    notify.create(msg, title, {
        cls: type
    });
}

function successMsgFormMetro(){
    let msg = '¡Se ha registrado la información exitosamente!';
    let title = 'Operación Realizada'
    let type = 'success';
    showMsgMetro(msg, type, title, 2000, 250);
}

function errorMsgFormMetro(){
    let msg = '¡Error al intentar de realizar la operación!';
    let title = 'Alerta'
    let type = 'alert';
    showMsgMetro(msg, type, title, 2000, 250);
}

/* Sweet Alert */

function showMsgSweet(title, msg, icon){
    Swal.fire(title, msg, icon);
}

function successMsgFormSweet(){
    let msg = '¡Se ha registrado la información exitosamente!';
    let title = 'Operación Realizada'
    let icon = 'success';
    showMsgSweet(title, msg, icon);
}

function successEmailSweet(texto = ''){
    let msg = 'Se ha(n) enviado notificacion(es) via correo electronico\n'+texto;
    let title = 'Notificacion Enviada'
    let icon = 'success';
    showMsgSweet(title, msg, icon);
}

function errorEmailSweet(texto = ''){
    let msg = 'La notificacion no fue enviada, ocurrio un error en la transaccion\n'+texto;
    let title = 'Error de Notificacion'
    let icon = 'warning';
    showMsgSweet(title, msg, icon);
}

function errorMsgFormSweet(){
    let msg = '¡Error al intentar de realizar la operación!';
    let title = 'Alerta'
    let icon = 'warning';
    showMsgSweet(title, msg, icon);
}

function errorMsgFormSweet2(msg){
    let title = '¡Error al intentar de realizar la operación!'
    let icon = 'warning';
    showMsgSweet(title, msg, icon);
}

function dialogMsgSweet(title, msg, icon, confirmButtonText, denyButtonText, titleConfirmed='', titleDenied='', msgConfirmed = '', msgDenied= '', method){

    Swal.fire({
        title: title,
        icon: icon,
        showDenyButton: true,
        text: msg,
        confirmButtonText: confirmButtonText,
        denyButtonText: denyButtonText,
      }).then((result) => {
        if (result.isConfirmed) {
            if(method != '' && method != null){
                fnDialog(method);
                bandera = new Boolean($('#hdnFlag').val());
                if(bandera){
                    showMsgSweet(titleConfirmed, msgConfirmed, 'success')
                }else{
                    showMsgSweet('Operación no realizada', 'la solicitud no pudo ser procesada', 'info')
                }
            }else{
                showMsgSweet('Operación no realizada', 'la solicitud no pudo ser procesada', 'info')
            }
        } else if (result.isDenied) {
            showMsgSweet(titleDenied, msgDenied, 'info')
        }
      })

}

/*------------------------------------------------------------*/


function getDataForm(componente){

    var query = "";
    var flag = false;
    var dontShow = null;
    var suffix = "";

    switch(componente){
        case "logic_cv_informacion":
            flag = true;
            query = "auth_usuarios";
            suffix = "_inf";
            dontShow = ['txtLinkedin', 'txtFacebook','txtTwitter','txtPagina','txtResumen', 'lstInactivar'];
            break;
    }

    if(flag){
        var view = 'form_'+componente+"_get";
        var request = $.ajax({
            url: view,
            type: 'GET',
            contentType: "text/html; charset=UTF-8",
            data:{uri:query},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: 'json'
        });

        request.done(function(respuesta) {
            var data = JSON.parse(respuesta['output']);
            var component = respuesta['componente'];
            let keys;
            if (!respuesta.error) {
                switch(componente){
                    case 'logic_cv_informacion':
                        switch(component){
                            case 'auth_usuarios':
                                let obj = JSON.parse(getFields());
                                keys = Object.keys(obj);
                                for(var i = 0; i < keys.length; i++){
                                    let key = keys[i].split("_")[0];
                                    if(key != '' && !dontShow.includes(key) && data[key] !== undefined){
                                        if(key.indexOf("txt") > -1 || key.indexOf("hdn") > -1 || key.indexOf("dtp") > -1){
                                                $('#'+key+suffix).val(data[key]);
                                        }
                                    }
                                }
                            break;
                            case 'logic_cv_informacion':
                                keys = Object.keys(data);
                                let values = Object.values(data);
                                for(var i = 0; i < keys.length; i++){
                                    $('#'+keys[i]).val(values[i]);
                                }
                            break;
                        }
                    break;
                }
            } else {
                Swal.fire(
                    '¡Atención!',
                    'Existio un problema al intentar generar la tabla de detalles',
                    'error'
                )
            }
        });

        request.fail(function(jqXHR, textStatus, errorThrown) {
            let error = "";
            if (jqXHR.status === 0) {
                error = 'Not connect: Verify Network.';
            } else if (jqXHR.status == 404) {
                error = 'Requested page not found [404]';
            } else if (jqXHR.status == 500) {
                error = 'Internal Server Error [500].';
            } else if (textStatus === 'parsererror') {
                error = 'Requested JSON parse failed. '+errorThrown;
            } else if (textStatus === 'timeout') {
                error = 'Time out error.';
            } else if (textStatus === 'abort') {
                error = 'Ajax request aborted.';
            } else {
                error = 'Uncaught Error: ' + jqXHR.responseText;
            }
            showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
        });
    }
}


function getPDF(id) {
    $(id).printThis({
        debug: false,               // show the iframe for debugging
        importCSS: true,            // import parent page css
        importStyle: true,         // import style tags
        canvas: false,              // copy canvas content
        removeInline: true,        // remove inline styles from print elements
        removeInlineSelector: '*',  // custom selectors to filter inline styles. removeInline must be true
        printDelay: 1500,            // variable print delay
        printContainer: true       // print outer container/$.selector
    });
}

function applyConvocatoria(id_convocatoria, id_usuario, tipo_convocatoria){
    var formData = new FormData();
    formData.append('id_usuario',id_usuario);
    formData.append('id_convocatoria', id_convocatoria);
    formData.append('tipo_convocatoria', tipo_convocatoria);


    $.ajax({
        url: 'form_logic_inscripciones_user',
        type: 'POST',
        dataType: 'json',
        data:formData,
        cache:false,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        beforeSend: function() {
           $('#btnSucessApply').attr('disabled',true);
           $('#btnCloseApply').attr('disabled',true);
        }
    })
    .done(function(respuesta) {
        if (!respuesta.error) {
            Swal.fire(
                '¡Muy Bien!',
                '¡Ya se encuentra registrado en la convocatoria!, <br/> Tenga en cuenta atender a todos los requisitos planteados para ser promovido.',
                'success'
              )
        } else {
            Swal.fire(
                '¡Atención!',
                respuesta.output,
                'error'
              )
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    })
    .always(function(){
        $('#btnSucessApply').attr('disabled',false);
        $('#btnCloseApply').attr('disabled',false);
    })
}


function searchConvocatorias(){

    let fecha_inicial = $('#dtpFechaInicial').val();
    let fecha_final = $('#dtpFechaFinal').val();
    let convocatoria = $('#lstConvocatoria').val();

    if( (fecha_inicial != '' && fecha_final != '') || convocatoria != '#'){
        var request = $.ajax({
            url: 'form_logic_validacion_inscripciones',
            type: 'GET',
            contentType: "text/html; charset=UTF-8",
            data: {fecha_inicial: fecha_inicial, fecha_final: fecha_final, convocatoria:convocatoria},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        request.done(function(respuesta) {
            var json = JSON.stringify(respuesta['output']);
            var data = JSON.parse(json);
            if (!respuesta.error) {
                $('#container-detalles').html('');
                $('#container-detalles').html(data);
                $('#btnValidarAspirantes').attr('disabled',false);
                $('#btnDetallesAspirantes').attr('disabled',false);
            } else {
                $('#container-detalles').html('');
                Swal.fire(
                    '¡Atención!',
                    data,
                    'error'
                )
            }
        });

        request.fail(function(jqXHR, textStatus, errorThrown) {
            let error = "";
            if (jqXHR.status === 0) {
                error = 'Not connect: Verify Network.';
            } else if (jqXHR.status == 404) {
                error = 'Requested page not found [404]';
            } else if (jqXHR.status == 500) {
                error = 'Internal Server Error [500].';
            } else if (textStatus === 'parsererror') {
                error = 'Requested JSON parse failed. '+errorThrown;
            } else if (textStatus === 'timeout') {
                error = 'Time out error.';
            } else if (textStatus === 'abort') {
                error = 'Ajax request aborted.';
            } else {
                error = 'Uncaught Error: ' + jqXHR.responseText;
            }
            showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
        });
    }else{
        let msg = '¡Error al intentar de realizar la operación! <br/> Seleccione información para desarrollar la operación';
        let title = 'Alerta'
        let type = 'alert';
        showMsgMetro(msg, type, title, 2000, 250);
    }
}


function validateAspirantes(){
    let convocatoria = $('#hdnIdConvocatoria').val();
    let usuario = $('#hdnIdUsuario').val();
    let inscripcion = $('#hdnIdInscripcion').val();
    if(convocatoria != '' && usuario != '' && inscripcion != ''){
        getValidateAspirantes(convocatoria, usuario, inscripcion)
    }else{
        let msg = '¡Error al intentar de realizar la operación! <br/> Seleccione Usuario';
        let title = 'Alerta'
        let type = 'alert';
        showMsgMetro(msg, type, title, 2000, 250);
    }
}

function getValidateAspirantes(convocatoria, usuario, inscripcion){

    var request = $.ajax({
        url: 'form_logic_validacion_inscripciones_validate',
        type: 'GET',
        contentType: "text/html; charset=UTF-8",
        data: {convocatoria: convocatoria, usuario: usuario, inscripcion:inscripcion},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
    });

    request.done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {
            $('.dialog-content-details').html(data)
            $('.dialog-content').attr('style','overflow-y: scroll !important;');
            Metro.dialog.open("#dialog-details")
        } else {
            $('#container-detalles').html('');
            Swal.fire(
                '¡Atención!',
                data,
                'error'
            )
        }
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });
}

function detailsAspirantes(){
    let convocatoria = $('#hdnIdConvocatoria').val();
    let usuario = $('#hdnIdUsuario').val();
    let inscripcion = $('#hdnIdInscripcion').val();
    if(convocatoria != '' && usuario != '' && inscripcion != ''){
        getDetailsAspirantes(convocatoria, usuario, inscripcion)
    }else{
        let msg = '¡Error al intentar de realizar la operación! <br/> Seleccione Usuario';
        let title = 'Alerta'
        let type = 'alert';
        showMsgMetro(msg, type, title, 2000, 250);
    }
}


function getDetailsAspirantes(convocatoria, usuario, inscripcion){

    var request = $.ajax({
        url: 'form_logic_validacion_inscripciones_aspirantes',
        type: 'GET',
        contentType: "text/html; charset=UTF-8",
        data: {convocatoria: convocatoria, usuario: usuario, inscripcion:inscripcion},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
    });

    request.done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {
            $('.dialog-content-details').html(data);
            $('.dialog-content').attr('style','overflow-y: scroll !important;');
            Metro.dialog.open("#dialog-details");
        } else {
            $('#container-detalles').html('');
            Swal.fire(
                '¡Atención!',
                data,
                'error'
            )
        }
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });
}

function dataChange(el){
    switch(this.id){
        case 'lstNecesita_adjunto':
            if(el[0] == 'NO'){
                var lst=Metro.getPlugin("#lstTipo_doc", "select");
                lst.val("#");
                $('#lstTipo_doc').attr('disabled',true);
            }
            break;
        case 'lstTipoUsuario':
            getOptionsUsuarios(el[0]);
            break;
        case 'lstTipoUsuarioNotificacion':
            getTableUsuariosByType(el[0]);
            break;
        case 'lstEmpresa':
            getUsuariosByEmpresa(el[0]);
            break;
        case 'lstPais':
            vista = $('#hdnView').val();
            getRegionByPais(el[0], vista);
            break;
        case 'lstRegion':
            vista = $('#hdnView').val();
            getCiudadByRegion(el[0], vista);
            break;
    }
}

function getUsuariosByEmpresa(val){


    var request = $.ajax({
        url: 'form_auth_usuarios_empresas',
        type: 'GET',
        contentType: "text/html; charset=UTF-8",
        data: {empresa: val},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
    });

    request.done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {

            var select = Metro.getPlugin("#lstId_usuario", 'select');
            let dato = "{";
            $.each( data, function( key, value ) {
                dato += ("\""+value[0]+"\":\""+value[1]+"\",")
             });
             dato = dato.substring(0, dato.length - 1)+"}";
             select.data(JSON.parse(dato));
             select.val('#');
        } else {
            $('#container-detalles').html('');
            Swal.fire(
                '¡Atención!',
                data,
                'error'
            )
        }
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });


}

function getTableUsuariosByType(val){
    console.log(val)
}

function getTableUsuariosByConvocatoria(val){
    console.log(val)
}

jQuery(document).on('submit', '#form_logic_envia_notificaciones', function(event) {

    event.preventDefault();
    jQuery.ajax({
        url: 'form_send_mail',
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        beforeSend: function() {
            $('#btnEnviar').attr('disabled', true)
        }
    })
        .done(function(respuesta) {
            var json = JSON.stringify(respuesta['output']);
            var data = JSON.parse(json);
            if (!respuesta.error) {
                var msgs = data.split("*")
                var title = '¡Envio de notificación exitoso!'
                var type = 'success';
                for(var i = 0; i < msgs.length; i++) {
                    let msg = msgs[i].trim();
                    showMsgMetro(msg, type, title, 2000, 400);
                }
            } else {
                var msgs = data.split("*")
                var title = '¡Envio de correos exitoso!'
                var type = 'success';
                for(var i = 0; i < msgs.length; i++) {
                    if(msgs[i].includes('Error')) {
                        type = 'alert';
                        title = '¡Error al intentar enviar notificación!'
                    }
                    let msg = msgs[i].trim();
                    showMsgMetro(msg, type, title, 2000, 400);
                }
            }
        })
        .fail(function(resp) {
            $('.error').slideDown('slow');
            setTimeout(function() {
                $('.error').slideUp('slow');
            }, 3000);
            $('#btnRegistrarArea').val('Registrar');
        })
        .always(function() {
            $('#btnEnviar').attr('disabled', false)
            console.log("complete");
        });
});


function hoy(){
    var d = new Date,
    dformat = [d.getFullYear(),
                format_date(d.getMonth()+1),
                format_date(d.getDate()),
               ].join('-')+' '+
              [d.getHours(),
               d.getMinutes(),
               d.getSeconds()].join(':');
    return dformat;
}

function format_date(str){
    var num;
    if(str.toString().length == 1){
        num = '0'+str;
    }else{
        num = str;
    }
    return num;
}

function processValidate(){

    var fields = $('.validate_fields');
    let convocatoria = $('#hdnIdConvocatoria').val();
    let usuario = $('#hdnIdUsuario').val();
    let inscripcion = $('#hdnIdInscripcion').val();

    let faltantes = "{'requisitos': [";
    let aprobados = "{'requisitos': [";

    let ids = new Array();
    let flag1 = false;
    let flag2 = false;
    for(var i = 0; i < fields.length; i++){
        id = fields[i].id;
        if(!ids.includes(id)){
            ids.push(id);
            value = $('#'+id).val();
            key = id.split('_')[1];
            if(value == '#'){
                flag1 = true;
                faltantes += ("{'"+key+"':'"+value+"'},")
            }else{
                 flag2 = true;
                aprobados += ("{'"+key+"':'"+value+"'},")
            }
        }
    }


    if(flag1){ faltantes = faltantes.substring(0, faltantes.length - 1);}

    if(flag2){ aprobados = aprobados.substring(0, aprobados.length - 1);}

    faltantes += "],";
    aprobados += "],";

    faltantes += "'usuario':'"+usuario+"',";
    aprobados += "'usuario':'"+usuario+"',";

    faltantes += "'fecha_validacion':'"+hoy()+"'";
    aprobados += "'fecha_validacion':'"+hoy()+"'";

    faltantes +="}";
    aprobados +="}";

    var obj = new FormData();
    console.log(aprobados);
    console.log(faltantes);
    obj.append('requisitos_aprobados', aprobados);
    obj.append('requisitos_faltantes', faltantes);
    obj.append('id', inscripcion);
    obj.append('id_usuario', usuario);
    obj.append('id_convocatoria', convocatoria);

    console.log(obj);

    $.ajax({
        url: 'form_logic_validacion_inscripciones_process',
        type: 'POST',
        dataType: 'json',
        data:obj,
        cache:false,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
    })

    .done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {
            $('.dialog-content-details').html(data)
            $('.dialog-content').attr('style','overflow-y: scroll !important;');
            Metro.dialog.open("#dialog-details")
        } else {
            $('#container-detalles').html('');
            Swal.fire(
                '¡Atención!',
                data,
                'error'
            )
        }
    })

    .fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });

}

function generateReportActividades(){

    let fecha_inicial = $('#dtpFechaInicial').val();
    let fecha_final = $('#dtpFechaFinal').val();
    let usuario = $('#lstId_usuario').val();
    let view = $('#hdnView').val();

    var request = $.ajax({
        url: view,
        type: 'GET',
        contentType: "text/html; charset=UTF-8",
        data: { fecha_inicial: fecha_inicial, fecha_final: fecha_final, usuario: usuario},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    request.done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        console.log(data);
        if (!respuesta.error) {
                $('#container-grafico-1').html('');
                $('#container-tabla-1').html('');
                $('#container-grafico-1').html(data['grafico_report1']);
                $('#container-tabla-1').html(data['tabla_report1']);

        } else {
            Swal.fire(
                '¡Atención!',
                 data,
                'error'
            )
        }
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });

}

function generateGraphicReport(){

    let anio = $('#lstAnio').val();
    let periodo = $('#lstPeriodo').val();
    let usuario = $('#lstId_usuario').val();
    let view = $('#hdnView').val();

    var request = $.ajax({
        url: view,
        type: 'GET',
        contentType: "text/html; charset=UTF-8",
        data: { anio: anio, periodo: periodo, usuario: usuario},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    request.done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {

                $('#container-grafico-1').html('');
                $('#container-tabla-1').html('');
                $('#container-grafico-1').html(data['grafico_report1']);
                $('#container-tabla-1').html(data['tabla_report1']);

                $('#container-grafico-2').html('');
                $('#container-tabla-2').html('');
                $('#container-grafico-2').html(data['grafico_report2']);
                $('#container-tabla-2').html(data['tabla_report2']);

                $('#container-grafico-3').html('');
                $('#container-tabla-3').html('');
                $('#container-grafico-3').html(data['grafico_report3']);
                $('#container-tabla-3').html(data['tabla_report3']);

                $('#container-grafico-4').html('');
                $('#container-tabla-4').html('');
                $('#container-grafico-4').html(data['grafico_report4']);
                $('#container-tabla-4').html(data['tabla_report4']);

        } else {
            $('#container-grafico-1').html('');
            $('#container-tabla-1').html('');
            $('#container-grafico-2').html('');
            $('#container-tabla-2').html('');
            $('#container-grafico-3').html('');
            $('#container-tabla-3').html('');
            $('#container-grafico-4').html('');
            $('#container-tabla-4').html('');
            Swal.fire(
                '¡Atención!',
                data,
                'error'
            )
        }
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });

}


function generateGraphicReportIngles(){

    let anio = $('#lstAnio').val();
    let periodo = $('#lstPeriodo').val();
    let usuario = $('#lstId_usuario').val();
    let view = $('#hdnView').val();

    var request = $.ajax({
        url: view,
        type: 'GET',
        contentType: "text/html; charset=UTF-8",
        data: { anio: anio, periodo: periodo, usuario: usuario},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    request.done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {

            $('#container-grafico-1').html('');
            $('#container-tabla-1').html('');
            $('#container-grafico-1').html(data['grafico_report1']);
            $('#container-tabla-1').html(data['tabla_report1']);

            $('#container-grafico-2').html('');
            $('#container-tabla-2').html('');
            $('#container-grafico-2').html(data['grafico_report2']);
            $('#container-tabla-2').html(data['tabla_report2']);

            $('#container-grafico-3').html('');
            $('#container-tabla-3').html('');
            $('#container-grafico-3').html(data['grafico_report3']);
            $('#container-tabla-3').html(data['tabla_report3']);

            $('#container-grafico-4').html('');
            $('#container-tabla-4').html('');
            $('#container-grafico-4').html(data['grafico_report4']);
            $('#container-tabla-4').html(data['tabla_report4']);

        } else {
            $('#container-grafico-1').html('');
            $('#container-tabla-1').html('');
            $('#container-grafico-2').html('');
            $('#container-tabla-2').html('');
            $('#container-grafico-3').html('');
            $('#container-tabla-3').html('');
            $('#container-grafico-4').html('');
            $('#container-tabla-4').html('');
            Swal.fire(
                '¡Atención!',
                data,
                'error'
            )
        }
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });

}


function getOptionsUsuarios(tipo_usuario){

    let view = $('#hdnView').val();
    if(view !== undefined){

    var request = $.ajax({
        url: view+'_data',
        type: 'GET',
        contentType: "application/json; charset=UTF-8",
        data: { tipo_usuario: tipo_usuario},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    request.done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {
            var lst=Metro.getPlugin("#lstUsuario", "select");
            if(lst !== undefined){
                lst.data(data);
            }
        } else {
            Swal.fire(
                '¡Atención!',
                'Existio un problema al intentar generar la tabla de detalles',
                'error'
            )
        }

    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });

    }
}


function generateEvaluacion(){
    let usuario = $('#lstUsuario').val()
    let tipo_usuario = $('#lstTipoUsuario').val()
    let evaluacion = $('#lstEvaluacion').val()
    if((tipo_usuario != '' && tipo_usuario != '#' && tipo_usuario !== undefined) &&
        (evaluacion != '' && evaluacion != '#' && evaluacion !== undefined)){
            let view = $('#hdnView').val();
            if(view !== undefined){

                var request = $.ajax({
                    url: view,
                    type: 'GET',
                    contentType: "application/json; charset=UTF-8",
                    data: { usuario: usuario, evaluacion:evaluacion, tipo_usuario:tipo_usuario},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                request.done(function(respuesta) {
                    var json = JSON.stringify(respuesta['output']);
                    var data = JSON.parse(json);
                    if (!respuesta.error) {
                        $('#info_evaluacion').html('');
                        $('#form_evaluacion').html('');
                        $('#info_evaluacion').html(data['info_evaluacion']);
                        $('#form_evaluacion').html(data['form_evaluacion']);
                    } else {
                        Swal.fire(
                            '¡Atención!',
                            'Existio un problema al intentar generar la tabla de detalles',
                            'error'
                        )
                    }

                });

                request.fail(function(jqXHR, textStatus, errorThrown) {
                    let error = "";
                    if (jqXHR.status === 0) {
                        error = 'Not connect: Verify Network.';
                    } else if (jqXHR.status == 404) {
                        error = 'Requested page not found [404]';
                    } else if (jqXHR.status == 500) {
                        error = 'Internal Server Error [500].';
                    } else if (textStatus === 'parsererror') {
                        error = 'Requested JSON parse failed. '+errorThrown;
                    } else if (textStatus === 'timeout') {
                        error = 'Time out error.';
                    } else if (textStatus === 'abort') {
                        error = 'Ajax request aborted.';
                    } else {
                        error = 'Uncaught Error: ' + jqXHR.responseText;
                    }
                    showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
                });
        }
    }else{
        let error = 'Por favor asegurese de seleccionar datos consistentes en los filtros';
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    }
}

function evaluateCriteria(json){

    let respuesta = "";
    let puntaje = "";
    let key1 = "#txtAnswer_"+json.usuario+"_"+json.criterio+"_"+json.evaluacion;
    let key2 = "#txtPonderacion_"+json.usuario+"_"+json.criterio+"_"+json.evaluacion;

    if(json.requiere_puntaje == 'SI'){
        respuesta = $(key1).val();
        puntaje = $(key2).val();
    }else{
        respuesta = $(key1).val();
        puntaje = "N/A";
    }
    console.log(json)
    regRespuestaEvaluacion(json.usuario, json.evaluacion, json.criterio, respuesta, puntaje, json.requiere_puntaje, json.ponderacion)
}

function regRespuestaEvaluacion(usuario, evaluacion, criterio, respuesta, puntaje, requiere_puntaje, ponderacion){

    if(respuesta !== ''){
        if((requiere_puntaje == 'SI' && puntaje != '') || (requiere_puntaje == 'NO' && puntaje == 'N/A')){
            let view = $('#hdnView').val();

            var formData = new FormData();
            formData.append('usuarioevaluado',usuario);
            formData.append('evaluacion_realizada', evaluacion);
            formData.append('criterio_evaluado', criterio);
            formData.append('respuesta', respuesta);
            formData.append('puntaje', puntaje);
            formData.append('requiere_puntaje', requiere_puntaje);
            formData.append('ponderacion', ponderacion);
            formData.append('inactivo', '0');


            var request = $.ajax({
                url: view+'_answers',
                type: 'POST',
                dataType: 'json',
                data:formData,
                cache:false,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                beforeSend: function() {
                   $('#btnRegistrar').attr('disabled',true);
                }
            })

            request.done(function(respuesta) {
                var json = JSON.stringify(respuesta['output']);
                var data = JSON.parse(json);
                if (!respuesta.error) {
                    let key1 = "#txtAnswer_"+usuario+"_"+criterio+"_"+evaluacion;
                    let key2 = "#txtPonderacion_"+usuario+"_"+criterio+"_"+evaluacion;
                    $(key1).val('');
                    $(key2).val('');
                    successMsgFormMetro();
                } else {
                    Swal.fire(
                        '¡Atención!',
                        'Existio un problema al intentar registrar la respuesta',
                        'error'
                    )
                }

            });

            request.fail(function(jqXHR, textStatus, errorThrown) {
                let error = "";
                if (jqXHR.status === 0) {
                    error = 'Not connect: Verify Network.';
                } else if (jqXHR.status == 404) {
                    error = 'Requested page not found [404]';
                } else if (jqXHR.status == 500) {
                    error = 'Internal Server Error [500].';
                } else if (textStatus === 'parsererror') {
                    error = 'Requested JSON parse failed. '+errorThrown;
                } else if (textStatus === 'timeout') {
                    error = 'Time out error.';
                } else if (textStatus === 'abort') {
                    error = 'Ajax request aborted.';
                } else {
                    error = 'Uncaught Error: ' + jqXHR.responseText;
                }
                showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
            });

            request.always(function(){
                $('#btnRegistrar').attr('disabled',false);
            })

        }else{
            let msg = '¡Para poder proceder guardando esta información, digite puntaje!';
            let title = 'Validación de Datos'
            let type = 'warning';
            showMsgMetro(msg, type, title, 2000, 400);
        }
    }else{
        let msg = '¡Para poder proceder guardando esta información, digite una respuesta consistente!';
        let title = 'Validación de Datos'
        let type = 'warning';
        showMsgMetro(msg, type, title, 2000, 400);
    }

}


function repUsuarios(tipo){
	let reporte = $('#hdnView').val();
	let fecha_ini = $('#dtpFechaInicial').val();
	let fecha_fin = $('#dtpFechaFinal').val();
	let tipo_usuario = $('#lstTipoUsuarioRep').val();
	var data = [reporte, tipo, fecha_ini, fecha_fin, tipo_usuario];
	getInforme(data)
}


function repInscritosConv(tipo){
	let reporte = $('#hdnView').val();
	let fecha_ini = $('#dtpFechaInicial').val();
	let fecha_fin = $('#dtpFechaFinal').val();
	let convocatoria = $('#lstConvocatoria').val();
	var data = [reporte, tipo, fecha_ini, fecha_fin, convocatoria];
	getInforme(data)
}

function repSeleccionadosConv(tipo){
	let reporte = $('#hdnView').val();
	let fecha_ini = $('#dtpFechaInicial').val();
	let fecha_fin = $('#dtpFechaFinal').val();
	let convocatoria = $('#lstConvocatorias').val();
	var data = [reporte, tipo, fecha_ini, fecha_fin, convocatoria];
	getInforme(data)
}

function repEvaluaciones(tipo){
	let reporte = $('#hdnView').val();
	let fecha_ini = $('#dtpFechaInicial').val();
	let fecha_fin = $('#dtpFechaFinal').val();
	let evaluacion = $('#lstEvaluacion').val();
	let usuario = $('#lstUsuario').val();
	var data = [reporte, tipo, fecha_ini, fecha_fin, evaluacion, usuario];
	getInforme(data)
}

function repUsuariosComplementario(tipo){
	let reporte = $('#hdnView').val();
	let usuario = $('#lstIdusuarioComplementario').val();
	let convocatoria = $('#lstConvocatoriaComplementario').val();
	var data = [reporte, tipo, usuario, convocatoria];
	getInforme(data)
}


function getInforme(input){

	var request = $.ajax({
        url: 'form_rep_informes',
        type: 'GET',
        contentType: "application/json; charset=UTF-8",
        data: {data: input},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
    });

    request.done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {
            if(input[1] == 'excel'){
                window.open(data, "_blank");
                deleteFile(data);
                Swal.fire(
                    '¡Muy Bien!',
                    '¡El archivo ha sido generado exitosamente!',
                    'success'
                )
            }else{
                $('#container-detalles').html('');
                $('#container-detalles').html(data);
            }
        } else {
            Swal.fire(
                '¡Atención!',
                data,
                'error'
            )
        }
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });

}


function deleteFile(url){
    var token = $('#_token').val();
    var data = url.split('/');
    jQuery.ajax({
        url: "form_rep_informes_delete",
        type: 'DELETE',
        dataType: 'json',
        data: {
            file: data[data.length-1],
            _token: token,
        }
    })
    .done(function(respuesta) {
        console.log('¡Archivo '+url+' Eliminado Exitosamente!');
    })
    .fail(function(resp) {
        console.log('¡Error al intentar Eliminar el archivo '+url+' !');
    })
    .always(function() {
        console.log("complete");
    });

}

function getTableNotificaciones(){

    let view = $('#hdnView').val();
    let tipo_usuario = $('#lstTipoUsuarioNotificacion').val();
    let convocatoria = $('#lstConvocatoriaNotificacion').val();

    if(tipo_usuario != '#' || convocatoria != '#') {
        var request = $.ajax({
            url: view + '_table',
            type: 'GET',
            contentType: "application/json; charset=UTF-8",
            data: {tipo_usuario: tipo_usuario, convocatoria: convocatoria},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        request.done(function (respuesta) {
            var json = JSON.stringify(respuesta['output']);
            var data = JSON.parse(json);
            if (!respuesta.error) {
                $('#container-detalles').html('');
                $('#container-detalles').html(data);
            } else {
                Swal.fire(
                    '¡Atención!',
                    data,
                    'error'
                )
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            let error = "";
            if (jqXHR.status === 0) {
                error = 'Not connect: Verify Network.';
            } else if (jqXHR.status == 404) {
                error = 'Requested page not found [404]';
            } else if (jqXHR.status == 500) {
                error = 'Internal Server Error [500].';
            } else if (textStatus === 'parsererror') {
                error = 'Requested JSON parse failed. ' + errorThrown;
            } else if (textStatus === 'timeout') {
                error = 'Time out error.';
            } else if (textStatus === 'abort') {
                error = 'Ajax request aborted.';
            } else {
                error = 'Uncaught Error: ' + jqXHR.responseText;
            }
            showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
        });
    }else{
        var title = "¡Ha ocurrido un problema!";
        var msg = "¡Por favor seleccione convocatoria o tipo de usuario valido!";
        var type = "alert";
        showMsgMetro(msg, type, title, 2000, 400);
    }
}


function generateCVReport(){
    let vista = $('#hdnView').val();
    let usuario = $('#hdnUsuario').val();
    let perfil = $('#hdnPerfil').val();
    let empresa = $('#lstEmpresa').val();

    var request = $.ajax({
        url: vista + '_table',
        type: 'GET',
        contentType: "application/json; charset=UTF-8",
        data: {usuario: usuario, perfil: perfil, empresa:empresa},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    request.done(function (respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {
            $('#container-detalle-cv').html('');
            $('#container-detalle-cv').html(data);
        } else {
            Swal.fire(
                '¡Atención!',
                data,
                'error'
            )
        }
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. ' + errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });
}



$().ready(function() {

    // validate signup form on keyup and submit
    $("#form_auth_usuarios_complementarios").validate({
        rules: {
            txtResultado_icfes: "required",
        },
        messages: {
            txtResultado_icfes: "Prueba",
        }
    });
});

function saveInfoComplementaria(){


    let view = $('#hdnView').val();
    let departamento_nac = $('#lstDepartamento_nac').val();
    let ciudad_nac = $('#lstCiudad_nac').val();
    let orientacion_sexual = $('#lstOrientacion_sexual').val();
    let estado_civil = $('#lstEstado_civil').val();
    let hijos = $('#lstHijos').val();
    let estrato = $('#lstEstrato').val();
    let sisben = $('#lstSisben').val();
    let programa_estudiar = $('#lstPrograma_estudiar').val();
    let grado_escolaridad = $('#lstGrado_escolaridad').val();
    let anio_culminado_o_porculminar = $('#dtpAnio_culminado_o_porculminar').val();
    let anio_prueba_icfes = $('#dtpAnio_prueba_icfes').val();
    let resultado_icfes = $('#txtResultado_icfes').val();
    let programa_beca = $('#txtPrograma_beca').val();
    let ganador_boo = $('#txtGanador_boo').val();
    let conectividad = $('#lstConectividad').val();
    let equipos_tecnologicos = $('#lstEquipos_tecnologicos').val();
    let plan_emergencia_social = $('#lstPlan_emergencia_social').val();
    let deportista = $('#txtDeportista').val();
    let este_programa = $('#txtEste_programa').val();
    let tipo_institucion = $('#lstTipo_institucion').val();
    let actualmente_estudia = $('#lstActualmente_estudia').val();
    let pertenece_programa = $('#lstPertenece_programa').val();
    let acciones_sociales = $('#lstAcciones_sociales').val();
    let documentos_a_recibir = $('#uplDocumentos_a_recibir').val();
    let id_usuario = $('#hdnUsuario').val();


    var formData = new FormData();

    formData.append('id_usuario',id_usuario);
    formData.append('departamento_nac',departamento_nac);
    formData.append('ciudad_nac',ciudad_nac);
    formData.append('orientacion_sexual',orientacion_sexual);
    formData.append('estado_civil',estado_civil);
    formData.append('hijos',hijos);
    formData.append('estrato',estrato);
    formData.append('sisben',sisben);
    formData.append('programa_estudiar',programa_estudiar);
    formData.append('grado_escolaridad',grado_escolaridad);
    formData.append('anio_culminado_o_porculminar',anio_culminado_o_porculminar);
    formData.append('anio_prueba_icfes',anio_prueba_icfes);
    formData.append('resultado_icfes',resultado_icfes);
    formData.append('programa_beca',programa_beca);
    formData.append('ganador_boo',ganador_boo);
    formData.append('conectividad',conectividad);
    formData.append('equipos_tecnologicos',equipos_tecnologicos);
    formData.append('plan_emergencia_social',plan_emergencia_social);
    formData.append('deportista',deportista);
    formData.append('este_programa',este_programa);
    formData.append('tipo_institucion',tipo_institucion);
    formData.append('actualmente_estudia',actualmente_estudia);
    formData.append('pertenece_programa',pertenece_programa);
    formData.append('acciones_sociales',acciones_sociales);
    formData.append('documentos_a_recibir',documentos_a_recibir);


    var request = $.ajax({
        url: view,
        type: 'POST',
        dataType: 'json',
        data:formData,
        cache:false,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        beforeSend: function() {
           $('#btnRegistrar').attr('disabled',true);
        }
    })

    request.done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {
            successMsgFormMetro();
        } else {
            Swal.fire(
                '¡Atención!',
                'Existio un problema al intentar registrar la respuesta',
                'error'
            )
        }

    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });

    request.always(function(){
        $('#btnRegistrar').attr('disabled',false);
    })

}


function getInformeComplementaria() {

	let reporte = $('#hdnView').val();
	let usuario = $('#lstIdusuario').val();
    let convocatoria = $('#lstIdconvocatoria').val();

    var request = $.ajax({
        url: 'form_rep_info_complementaria',
        type: 'GET',
        contentType: "text/html; charset=UTF-8",
        data: {reporte: reporte, usuario:usuario, convocatoria:convocatoria},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    request.done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {
            $('#container-detalles').html('');
            $('#container-detalles').html(data);
        } else {
            Swal.fire(
                '¡Atención!',
                'Existio un problema al intentar registrar la respuesta',
                'error'
            )
        }

    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });

    request.always(function(){
        $('#btnConsultar').attr('disabled',false);
    })

}

function getConvocatoriasByTipo(tipo, vista){


    var request = $.ajax({
        url: 'form_logic_convocatorias_tipo',
        type: 'GET',
        contentType: "text/html; charset=UTF-8",
        data: {tipo: tipo},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
    });

    request.done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {
            let select = null;
            switch(vista){
                case 'rep_info_complementaria':
                    select = Metro.getPlugin("#lstConvocatoriaComplementario", 'select');
                    break;
                case 'logic_seleccion':
                    select = Metro.getPlugin("#lstId_convocatoria", 'select');
                    break;
                case 'rep_prueba_psicotecnica_masiva':
                case 'rep_prueba_conocimiento_masivo':
                    select = Metro.getPlugin("#lstConvocatoria", 'select');
                    break;
            }

            let dato = "{";
            $.each( data, function( key, value ) {
                dato += ("\""+value[0]+"\":\""+value[1]+"\",")
             });
             dato = dato.substring(0, dato.length - 1)+"}";
             console.log(dato);
             console.log(select);
             select.data(JSON.parse(dato));

        } else {
            $('#container-detalles').html('');
            console.log(data);
        }
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });


}


function getRegionByPais(pais, vista){


    var request = $.ajax({
        url: 'form_geo_state_list',
        type: 'GET',
        contentType: "text/html; charset=UTF-8",
        data: {pais: pais},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
    });

    request.done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {
            let select = null;
            switch(vista){
                case 'form_buy_proveedores':
                case 'form_auth_usuarios':
                case 'form_auth_empresas':
                    select = Metro.getPlugin("#lstRegion", 'select');
                    break;
            }
            let dato = "{";
            $.each( data, function( key, value ) {
                dato += ("\""+value+"\":\""+key+"\",")
             });
             dato = dato.substring(0, dato.length - 1)+"}";
             var cast = JSON.parse(dato);
             console.log(cast);
             select.data(cast);

        } else {
            console.log(data);
        }
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });


}


function getCiudadByRegion(region, vista){


    var request = $.ajax({
        url: 'form_geo_cities_list',
        type: 'GET',
        contentType: "text/html; charset=UTF-8",
        data: {region: region},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
    });

    request.done(function(respuesta) {
        var json = JSON.stringify(respuesta['output']);
        var data = JSON.parse(json);
        if (!respuesta.error) {
            let select = null;
            switch(vista){
                case 'form_buy_proveedores':
                case 'form_auth_usuarios':
                case 'form_auth_empresas':
                    select = Metro.getPlugin("#lstCiudad", 'select');
                    break;
            }
            let dato = "{";
            //console.log(dato);
            $.each( data, function( key, value ) {
                dato += ("\""+value+"\":\""+key+"\",")
             });
             dato = dato.substring(0, dato.length - 1)+"}";
             console.log(dato);
             select.data(JSON.parse(dato));

        } else {
            console.log(data);
        }
    });

    request.fail(function(jqXHR, textStatus, errorThrown) {
        let error = "";
        if (jqXHR.status === 0) {
            error = 'Not connect: Verify Network.';
        } else if (jqXHR.status == 404) {
            error = 'Requested page not found [404]';
        } else if (jqXHR.status == 500) {
            error = 'Internal Server Error [500].';
        } else if (textStatus === 'parsererror') {
            error = 'Requested JSON parse failed. '+errorThrown;
        } else if (textStatus === 'timeout') {
            error = 'Time out error.';
        } else if (textStatus === 'abort') {
            error = 'Ajax request aborted.';
        } else {
            error = 'Uncaught Error: ' + jqXHR.responseText;
        }
        showMsgSweet('¡Ha ocurrido un problema!', error, 'error');
    });


}


function uploadFileSeleccion(){

    var token = $('#_token').val();
    var archivo_cargue = $('#lstArchivoCargue').val();
    var url = $('#hdnView').val();

    var formData = new FormData();
    formData.append('_token',token);
    formData.append('archivo_cargue', archivo_cargue);

    if(archivo_cargue != ''){
        if($('input[type=file]').length){
            let files = $('input[type=file]')[0].files;
            if( typeof files !== "undefined"){
                jQuery.each($('input[type=file]')[0].files, function(i, file) {
                    formData.append('file-'+i, file);
                });
            }else{
                formData.append('file', null);
            }

            let msg = '¿Desea cargar la información seleccionada?';
            let title = 'Alerta'
            let icon = 'warning';
            let confirmButtonText = '!Si, estoy listo¡'
            let denyButtonText = '!No, dejame revisar¡'

            Swal.fire({
                title: title,
                icon: icon,
                showDenyButton: true,
                text: msg,
                confirmButtonText: confirmButtonText,
                denyButtonText: denyButtonText,
            }).then((result) => {
                if (result.isConfirmed) {
                        cargaArchivos(url, formData)
                } else if (result.isDenied) {
                    showMsgSweet(titleDenied, msgDenied, 'info')
                }
            })

        }else{
            let msg = '¡No hay archivo seleccionado!';
            let title = 'Validación de Datos'
            let type = 'alert';
            showMsgMetro(msg, type, title, 2000, 400);
        }
    }else{
        let msg = '¡Por favor digite un nombre para el archivo valido para el archivo a cargar!';
        let title = 'Validación de Datos'
        let type = 'alert';
        showMsgMetro(msg, type, title, 2000, 400);
    }

 }


 function cargaArchivos(url, formData){
    console.log(url);
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data:formData,
        cache:false,
        processData: false,
        contentType: false,
        beforeSend: function() {
           $('.reg_btn_forms').attr('disabled',true);
           $('.update_btn_forms').attr('disabled',true);
        }
    })
    .done(function(respuesta) {
       var json = JSON.stringify(respuesta['output']);
       var data = JSON.parse(json);
        if (!respuesta.error) {
           successMsgFormSweet();
        } else {
           errorMsgFormSweet2(data)
        }
    })

    .fail(function(resp) {
        errorMsgFormMetro();
    })

    .always(function() {
        $('.reg_btn_forms').attr('disabled',false);
        $('.update_btn_forms').attr('disabled',false);
        $('#container-upload .drop-zone .files').text('0 archivos(s) seleccionados');
        var lst=Metro.getPlugin('#lstArchivoCargue', "select");
        lst.val('#');
        console.log("complete");
    });
 }


