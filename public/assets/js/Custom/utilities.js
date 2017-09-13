/**
 * Created by Nico on 20/10/2015.
 */



$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

(function () {

    this.Utilities = this.Utilities || {};
    Date.now = Date.now || function () { return +new Date(); };


// Array Remove - By John Resig (MIT Licensed)
    Array.prototype.remove = function (from, to) {
        var rest = this.slice((to || from) + 1 || this.length);
        this.length = from < 0 ? this.length + from : from;
        return this.push.apply(this, rest);
    };

    String.prototype.startsWith = function(needle)
    {
        return(this.indexOf(needle) == 0);
    };
}());

Utilities.block = function(){
    $.blockUI({ message: '<div><img src="../assets/images/loading.gif" style="width: 30px" /> Espere por favor...</div>' });
};


//$(document).ajaxStart(Utilities.block).ajaxStop($.unblockUI);

/*$(document).ajaxError(function(event, jqxhr, settings, thrownError)
{
   var error = jqxhr.error();

});*/

/*
 Descripción: Busca el elemento del array de Objetos y lo eliminar en base a valor de una propiedad del objeto
 Parámetros:
 @Array array: Array sobre el cuál se busca el elemento a eliminar
 @string property: Propiedad del Objeto a comparar para identificar el objeto
 @var value: Valor de la propiedad del objeta que se busca y se desea eliminar
 Retorno:
 Bool : False si no se encontró y True si se encontró y se eliminó.
 */
Utilities.findAndRemoveList = function (array, property, value) {
    var res = false;
    $.each(array, function (index, result) {
            if (res == false) {
                if (result[property] == value) {
                    array.splice(index, 1);
                    res = true;
                }
            }
        }
    );
    return res;
};

/*
 Descripción: Busca el elemento del array de Objetos y lo remplace con el objeto enviado como parámetro
 Parámetros:
 @Array array: Array de Objetos sobre el cuál se busca el elemento a remplazar
 @string property: Propiedad del Objeto a comparar para identificar el objeto
 @var value: Valor de la propiedad del objeta que se busca y se desea reemplazar
 Retorno:
 Bool : False si no se encontró y True si se encontró y se remplazó.
 */
Utilities.findAndReplaceList = function (array, property, value, newObj) {
    var res = false;
    var i;
    $.each(array, function (index, result) {
            if (result[property] == value) {
                i = index;
                res = true;
            }
        }
    );

    if (res == true) {
        array[i] = newObj;
    }

    return res;
};

/*
 Descripción: Busca el elemento del array de Objetos y base al valor de una propiedad determinada
 Parámetros:
 @Array array: Array de Objetos sobre el cuál se busca el elemento
 @string property: Propiedad del Objeto a comparar para identificar el objeto
 @var value: Valor de la propiedad del objeta que se busca
 Retorno:
 Bool : False si no se encontró y True si se encontró.
 */
Utilities.findInList = function (array, property, value) {
    var res = false;
    $.each(array, function (index, result) {
            if (result[property] == value) {
                res = true;
            }
        }
    );
    return res;
};


/*
 Descripción: Busca el elemento del array de Objetos y base al valor de una propiedad determinada y lo retorna si lo encuentra
 Parámetros:
 @Array array: Array de Objetos sobre el cuál se busca el elemento
 @string property: Propiedad del Objeto a comparar para identificar el objeto
 @var value: Valor de la propiedad del objeta que se busca
 Retorno:
 Object : null si no se encontró o el objeto si se encontró.
 */
Utilities.findandGetInList = function (array, property, value) {
    var res = null;
    $.each(array, function (index, result) {
            if (result[property] == value) {
                res = result;
            }
        }
    );
    return res;
};

/*
 Descripción: Función para construir una grilla en base un array de Objetos e indicando
 el nombre de la grilla(Tag table HTML) que se debe cargar con dicho objeto
 Parámetros:
 @Array objJson: Array de Objetos en base al cuál se carga la grilla. Cada atributo de cada objeto
 se cargan en el orde en que se encuentran dentro del mismo.
 @string GrillaNombre: Nombre de la grilla que se desea construir(Tag table HTML)
 @Bool idVisible: Indica si se debe mostrar los campos Id (nombre del atributo que empiece con Id)

 Se puenden enviar además dentro del Objeto atributos atributos especiales con los siguientes formatos para que se
 determinados elementos dentro de la grilla:
 Atributo(array de links) "links": [{name:"nombre del link",
 value:"valor si debe guardar un valor",
 callback:"referencia a una función que llamará en el evento click"}]
 Atributo "checkbox":{"checked": true or false para indicar si debe estar checkeado o no
 callback:"referencia a una función que llamará en el evento click"}
 Atributo "textbox":{"visible": true or false para indicar si debe estar visible o no
 callback:"referencia a una función que llamará en el evento click"}

 */
Utilities.ConstruirGrillaGenerica = function (objJson, GrillaNombre, idVisible, textSinValores) {
    $(".L-" + GrillaNombre).unbind("click");
    $(".cb-" + GrillaNombre).unbind("click");
    $(".tb-" + GrillaNombre).unbind("click");
    $("#" + GrillaNombre + " > tbody").find("tr").remove();

    var entro = false;
    if (idVisible == undefined || idVisible == null)
        idVisible = true;

    if(!textSinValores)
        textSinValores = 'No se han cargado valores';


    if (objJson != null && objJson.length) {
        for (i = 0; i < objJson.length; i++) {
            var eventos = [];
            var dataCombos = [];
            var tr = $('<tr>');
            for (var key in objJson[i]) {

                if ((idVisible || key.toLowerCase().indexOf("id") != 0) && !(objJson[i][key] instanceof Array && key.toLocaleString().indexOf("links") != 0)) {
                    if ((objJson[i][key] == null || objJson[i][key].toString() == "NaN"))
                        tr.append("<td></td>")
                    else
                    if (key.toLowerCase().indexOf("checkbox") == 0) {
                        var check = "";

                        if (objJson[i].checkbox.checked) {
                            check = "checked";
                        }

                        var desabled = "";
                        if (objJson[i].checkbox.desabled) {
                            desabled = 'disabled="disabled"';
                        }

                        tr.append("<td class='centerTd'><input type='checkbox' " + check + " id='id" + key + "-" + i + "-" + GrillaNombre + "' class='cb-" + GrillaNombre + "' " + desabled + " /></td>");

                        if (objJson[i][key].callback) {
                            var ev = {
                                id: '#' + 'id' + key + '-' + i + '-' + GrillaNombre,
                                evento: 'click',
                                callback: objJson[i][key].callback

                            };

                            eventos.push(ev);
                        }

                    }
                    else if (key.toLowerCase().indexOf("textbox") == 0) {
                        var visible = "";

                        if (!objJson[i][key].visible) {
                            visible = "style = 'display: none;'";
                        }

                        tr.append("<td>" +
                        "<div style='display:block'>" +
                        "<input type='input' " + visible + " id='idTb-" + i + "-" + GrillaNombre + "' class='tb-" + GrillaNombre + "' value='" + objJson[i][key].value + "'/>" +
                        "</div></td>");



                    }
                    else if (key.toLowerCase().indexOf("combobox") == 0) {
                        var desabled = "";

                        if (objJson[i][key].desabled) {
                            desabled = "disabled='disabled'";
                        }

                        tr.append("<td>" +
                        "<div style='display:block'>" +
                        "<select style='width:100%' " + desabled + " id='idcmbox-" + i + "-" + objJson[i][key].value + "-" + GrillaNombre + "' class='cmbox-" + GrillaNombre + "' ></select>" +
                        "</div></td>");

                        var cmbox = { nombre: "idcmbox-" + i + "-" + objJson[i][key].value + "-" + GrillaNombre };

                        if (objJson[i][key].valores) {
                            cmbox.data = objJson[i][key].valores;
                        }
                        else {
                            cmbox.data = [];
                        }

                        if (objJson[i][key].seleccion) {
                            cmbox.select = objJson[i][key].seleccion;
                        }
                        else {
                            cmbox.select = "-1";
                        }

                        dataCombos.push(cmbox);


                    }
                    else if (key.toLocaleString().indexOf("links") == 0) {
                        var tdlinks = "<td class='alignCenter'>";
                        for (var j = 0; j < objJson[i][key].length; j++) {
                            if (j != 0) {
                                tdlinks = tdlinks + "&nbsp;|&nbsp;";
                            }

                            tdlinks = tdlinks + "<a  id='id" + objJson[i][key][j].name + "_" + GrillaNombre + "-" + i + "' class='L-" + GrillaNombre + "' >" + objJson[i][key][j].name + "</a>";

                            var ev = {
                                id: '#' + 'id' + objJson[i][key][j].name + '_' + GrillaNombre + '-' + i,
                                evento: 'click',
                                callback: objJson[i][key][j].callback

                            };

                            eventos.push(ev);

                            if (objJson[i][key][j].value) {

                                tdlinks = tdlinks + "<input type='hidden' value='" + objJson[i][key][j].value + "' id='hid" + GrillaNombre + "_" + objJson[i][key][j].name + "-" + i + "' />";
                            }

                        }
                        tdlinks = tdlinks + "</td>";
                        tr.append(tdlinks);
                    }

                    else {
                        if ((typeof objJson[i][key]) == 'boolean')
                        {
                            var checked = '';
                            if (objJson[i][key]) {
                                checked = "checked";
                            }
                            tr.append("<td class='centerTd'><input type='checkbox' " + checked + " id='idCheckInfo" + key + "-" + i + "-" + GrillaNombre + "' disabled='disabled' /></td>");
                            // tr.append("<td>" + objJson[i][key].toString() + "</td>");
                        }
                        else
                        if (!(objJson[i][key] instanceof Object))
                            tr.append("<td>" + objJson[i][key].toString() + "</td>");
                    }

                }
            }

            $("#" + GrillaNombre + " > tbody").append(tr);

            if (dataCombos && dataCombos.length > 0) {
                for (var l = 0; l < dataCombos.length; l++) {
                    Utilities.populateDropdownSelect($('#' + dataCombos[l].nombre), dataCombos[l].data, dataCombos[l].select);
                }

            }


            for (var k = 0; k < eventos.length; k++) {
                $(eventos[k].id).on(eventos[k].evento, eventos[k].callback);

            }

        }
    } else {

        $("#" + GrillaNombre + " > tbody").append("<tr><td colspan='100%' style='width: 100%; text-align: center;'>"+ textSinValores+"</td></tr>");
    }

    $("#" + GrillaNombre + " > tbody tr:odd").addClass("odd");
    $("#" + GrillaNombre + " > tbody tr:even").addClass("even");

};

/*
 Descripción: Función para limpiar una grilla genérica creada con el ConstruirGrillaGenerica.
 Parámetros:
 @String nombreGrilla: nombre de la grilla que se desea limpiar
 */
Utilities.limpiarGrillaGenerica = function (nombreGrilla, text) {
    if(!text)
        text = 'No se han agregado valores';

    $(".L-" + nombreGrilla).unbind("click");
    $(".cb-" + nombreGrilla).unbind("click");
    $(".tb-" + nombreGrilla).unbind("click");
    $("#" + nombreGrilla + " > tbody").find("tr").remove();
    $("#" + nombreGrilla + " > tbody").find("tr").remove();
    $("#" + nombreGrilla + " > tbody").append("<tr><td colspan='7' style='width: 100%; text-align: center;'>"+text+"</td></tr>");
    $("#" + nombreGrilla + " > tbody tr:odd").addClass("odd");
    $("#" + nombreGrilla + " > tbody tr:even").addClass("even");
};

Utilities.isDate = function (obj) {

    return Object.prototype.toString.call(obj) === '[object Date]';
};

Utilities.isValidDate = function (obj) {

    return Utilities.isDate(obj) && !isNaN(obj.getTime());
};

Utilities.parseDateJsonString = function (dat) {
    var date = Date.parse(dat);
    var fec, fin, dt2;

    if (Utilities.isValidDate(dat)) {
        return $.datepicker.formatDate('dd/mm/yy', dat);
    }

    if (dat.indexOf("/Date(") == 0) {
        var milli = (dat.replace(/\/Date\((-?\d+)\)\//, '$1'));
        var d = new Date(parseInt(milli));
        return $.datepicker.formatDate('dd/mm/yy', d);
    }
    else {
        if (dat.indexOf("/") > 0) {
            fec = dat.substring(0, 10);
            fin = fec.split("/");
            dt2 = new Date(fin[0], fin[1] - 1, fin[2]);

            return $.datepicker.formatDate('dd/mm/yy', dt2);
        } else {
            fec = dat.substring(0, 10);
            fin = fec.split("-");
            dt2 = new Date(fin[0], fin[1] - 1, fin[2]);

            return $.datepicker.formatDate('dd/mm/yy', dt2);
        }
    }
};

Utilities.parseTimeJsonString = function (dat) {

    if (dat) {

        var dateDesde = new Date(parseInt(dat));
        if(!Utilities.isValidDate(dateDesde))
            dateDesde = new Date(parseInt(dat.substr(6)));

        var horas = dateDesde.getHours() < 10 ?
        "0" + String(dateDesde.getHours()) : String(dateDesde.getHours());
        var minutos = dateDesde.getMinutes() < 10 ?
        "0" + String(dateDesde.getMinutes()) : String(dateDesde.getMinutes());
        return horas + ":" + minutos;
    }
    else {
        return null;
    }
};

Utilities.getFormattedDate = function (date) {
    var year = date.getFullYear();
    var month = (1 + date.getMonth()).toString();
    month = month.length > 1 ? month : '0' + month;
    var day = date.getDate().toString();
    day = day.length > 1 ? day : '0' + day;
    return day + '/' + month + '/' + year;
};


/*
 Descripción: Retorna el path de la aplicación
 */
Utilities.getAppPath = function () {
    var pathArray = location.pathname.split('/');
    var appPath = "/";
    for (var i = 1; i < pathArray.length - 2; i++) {
        appPath += pathArray[i] + "/";
    }
    return appPath;
};


Utilities.cloneObject = function (obj) {
    // Handle the 3 simple types, and null or undefined
    if (null == obj || "object" != typeof obj) return obj;

    var copy;

    // Handle Date
    if (obj instanceof Date) {
        copy = new Date();
        copy.setTime(obj.getTime());
        return copy;
    }

    // Handle Array
    if (obj instanceof Array) {
        copy = [];
        for (var i = 0, len = obj.length; i < len; i++) {
            copy[i] = Utilities.cloneObject(obj[i]);
        }
        return copy;
    }

    // Handle Object
    if (obj instanceof Object) {
        copy = {};
        for (var attr in obj) {
            if (obj.hasOwnProperty(attr)) copy[attr] = Utilities.cloneObject(obj[attr]);
        }
        return copy;
    }

    throw new Error("Unable to copy obj! Its type isn't supported.");
};

Utilities.populateDropdownSelect = function (select, data, sel) {
    select.html('');
    select.append($('<option></option>').val("-1").html("--Seleccione--"));
    $.each(data, function (id, option) {
        select.append($('<option></option>').val(option.Value).html(option.Text));
    });

    select.val(sel);
};




Utilities.GrillaSimple = function (nombreGrilla, lista, idVisible, validarIdDuplicado,textSinValores) {
    this.idGrilla = nombreGrilla;
    this.objJson = lista;
    this.idVisible = idVisible;
    this.validaciones = [];
    this.validacionIdDuplicado = validarIdDuplicado;
    this.textSinValores = textSinValores;


    this.cargarGrilla();
};

Utilities.GrillaSimple.prototype.setTextSinValores= function(msg)
{
    this.textSinValores = msg;
}

Utilities.GrillaSimple.prototype.set = function (lista) {

    this.objJson = lista ? lista : [];
    this.cargarGrilla();
};

Utilities.GrillaSimple.prototype.get = function () {
    return this.objJson;
};

Utilities.GrillaSimple.prototype.cargarGrilla = function () {
    var listaView = Utilities.cloneObject(this.objJson);

    var thisObj = this;

    for (var i = 0; i < listaView.length; i++) {

        listaView[i].links = [{
            name: "Eliminar",
            value: listaView[i].id,
            callback: function () {
                thisObj.eliminarItem.call(thisObj, this);
            }
        }];

    }
    Utilities.ConstruirGrillaGenerica(listaView, this.idGrilla, this.idVisible, this.textSinValores);
};

Utilities.GrillaSimple.prototype.limpiarGrilla = function () {
    this.objJson = [];
    Utilities.limpiarGrillaGenerica(this.idGrilla, this.textSinValores);

};

Utilities.GrillaSimple.prototype.eliminarItem = function (link) {
    var index = link.id.split('-')[1];
    var link = link;
    var id = $('#hid' + this.idGrilla + '_Eliminar-' + index).val();


    if (Utilities.findAndRemoveList(this.objJson, "id", id))
        $(link).closest('tr').remove();

    if (this.objJson.length == 0) {
        this.limpiarGrilla();
    }
};

Utilities.GrillaSimple.prototype.agregarItem = function (item) {
    if (this.validacionIdDuplicado)
        if (!this.validarDuplicidad(item)) {
            alert("El valor que desea agregar ya existe");
            return;
        }

    if (this.validaciones) {
        for (var i = 0; i < this.validaciones.length; i++) {
            if (!this.validaciones[i]())
                return;
        }
    }

    this.objJson.push(item);
    this.cargarGrilla();
};

Utilities.GrillaSimple.prototype.validarDuplicidad = function (item) {
    var result = false;
    if (item.id) {
        result = !Utilities.findInList(this.objJson, "id", item.id);
    }
    return result;
};


/*
 ** Recibe un string con el json
 */
Utilities.GetJson = function (pJson) {
    var objJson = jQuery.parseJSON(pJson);
    var listaAux = objJson == null || objJson == "" ? [] : objJson;
    return listaAux;
};


Utilities.trimLeft = function (str, charlist) {
    if (charlist === undefined)
        charlist = "\s";

    return str.replace(new RegExp("^[" + charlist + "]+"), "");
};

Utilities.trimRight = function (str, charlist) {
    if (charlist === undefined)
        charlist = "\s";

    return str.replace(new RegExp("[" + charlist + "]+$"), "");
};

Utilities.trim = function (str, charlist) {
    return this.trimRight(this.trimLeft(str, charlist),charlist);
};

Utilities.Autocomplete = function (inputNameParam, methodAddParam, callBackEventAdding, callBackEventAdded)
{
    var input = $('#'+inputNameParam);

    input.data('methodadd',methodAddParam);

    input.autocomplete({

        source: function (request, response)
        {
            var listValues = this.element.data('listvalues');
            response(listValues.filter(function(entry){
                return entry.value.toUpperCase().indexOf(request.term.toUpperCase()) >=0;
            }));

        },

        change: function (event, ui) {


            var flag =  this.value.trim() != "" && !ui.item;
            if(!flag) {
                $(this).data('idSelected', ui.item.id);
            }
            $('#add'+this.id).toggle(flag);
            if(callBackEventAdding)
                callBackEventAdding(this.value, ui, event, this);
        }
    });

    $('#add'+inputNameParam).on("click", function () {
        var control = this;
        var input = $('#'+this.id.substring(3));
        var newValue = input.val().trim();
        $.post(input.data('methodadd'),{"newValue":newValue},
            function(data){
                if(data.status =='Ok')
                {
                    var item ={
                        id :data.data.id,
                        value : newValue,
                        label : newValue
                    };
                    var listValues =  input.data('listvalues');
                    listValues.push(item);
                    input.data('listvalues', listValues);
                    $(control).hide();
                    if(callBackEventAdded)
                        callBackEventAdded();
                }
                else
                {
                    alert(data.message);
                }
            }).fail(function(){
                alert('No se pudo guardar el nuevo valor.Error');
            });

    });


};

Utilities.AutocompleteSimple = function (inputNameParam)
{
    var input = $('#'+inputNameParam);

    input.autocomplete({

        source: function (request, response)
        {
            var listValues = this.element.data('listvalues');
            response(listValues.filter(function(entry){
                return entry.value.toUpperCase().indexOf(request.term.toUpperCase()) >=0;
            }));

        },
        change: function (event, ui) {


            var flag =  this.value.trim() != "" && !ui.item;
            if(!flag) {
                $(this).data('idSelected', ui.item.id);
            }
        }
    });

};

Utilities.ShowSuccesMessage=function(message)
{
    this.ShowMessage(message, 'Satisfactorio');
};

Utilities.ShowError =function(message)
{
    this.ShowMessage(message,'Error');
};

Utilities.ShowMessage = function(message, title)
{
    var html = '<div>  \
                   <p> '+ message +'</p>         \
                </div>';

    $(html).dialog(
        {
            resizable:false,
            modal: false,
            title: title,
            width:500,
            closeOnEscape:true,
            show: { effect: "blind", duration: 200 },
            hide: { effect: "blind", duration: 200 },
            dialogClass: 'dialog-style no-close',
            /*close: { function()
            {
                $(this).dialog('destroy');
                $(this).remove();
                return;
            },*/
            buttons:[
                { text:'Aceptar',
                    click : function()
                {
                    $(this).dialog('destroy');
                    $(this).remove();
                    return;
                }, class :'btn btn-sm btn-primary'}
            ]

        }
    )


};

Utilities.ImageExists = function(image_url){

    var http = new XMLHttpRequest();

    http.open('HEAD', image_url, false);
    http.send();

    return http.status != 404;

};

Utilities.CreateLocationObj = function(location)
{
    var loc = location.split(',');

    return {lat: parseFloat(loc[0]), lng: parseFloat(loc[1])};
};


Utilities.ConfirmDialog = function(msg, callback,callbackparam)
{
    var html = '<div>  \
                   <p>'+msg+'</p> \
                </div>';

    $(html).dialog(
        {
            resizable:false,
            modal: false,
            title: 'Confirma',
            width:500,
            closeOnEscape:true,
            show: { effect: "blind", duration: 200 },
            hide: { effect: "blind", duration: 200 },
            dialogClass: 'dialog-style no-close',
            buttons:[
                { text:'Aceptar',
                    click : function()
                    {
                        if(callbackparam)
                            callback(callbackparam);
                        else
                            callback();
                        $(this).dialog('destroy');
                        $(this).remove();
                        return;
                    }, class :'btn btn-sm btn-primary'},
                { text:'Cancelar',
                    click : function()
                    {
                        $(this).dialog('destroy');
                        $(this).remove();
                        return;
                    }, class :'btn btn-sm btn-primary'}
            ]

        }
    );
};

