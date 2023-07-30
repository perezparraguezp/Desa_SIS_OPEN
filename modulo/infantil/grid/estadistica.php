<style type="text/css">
    .cursor_cell_link {
        cursor: pointer;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        load_pacientes__estadistica();
    });

    function load_pacientes__estadistica() {
        var id_centro = $("#id_centro_interno").val();
        var source =
            {
                url: 'json/estadistica.php',
                datatype: "json",
                root: 'Rows',
                datafields:
                    [
                        {name: 'rut', type: 'string'},
                        {name: 'nombre', type: 'string'},
                        {name: 'sexo', type: 'string'},
                        {name: 'anios', type: 'number'},
                        {name: 'meses', type: 'number'},
                        {name: 'dias', type: 'number'},
                        {name: 'sector', type: 'string'},
                        {name: 'sector_comunal', type: 'string'},
                        {name: 'establecimiento', type: 'string'},
                        {name: 'sector_interno', type: 'string'},

                        {name: 'PE', type: 'string'},
                        {name: 'PT', type: 'string'},
                        {name: 'TE', type: 'string'},
                        {name: 'DNI', type: 'string'},
                        {name: 'PCINT', type: 'string'},
                        {name: 'IMCE', type: 'string'},
                        {name: 'LME', type: 'string'},
                        {name: 'RIMALN', type: 'string'},
                        {name: 'SCORE_IRA', type: 'string'},
                        {name: 'presion_arterial', type: 'string'},
                        {name: 'perimetro_craneal', type: 'string'},
                        {name: 'agudeza_visual', type: 'string'},
                        {name: 'evaluacion_auditiva', type: 'string'},
                        {name: 'atencion_secundaria', type: 'string'},

                        {name: 'ev_neurosensorial', type: 'string'},
                        {name: 'rx_pelvis', type: 'string'},
                        {name: 'eedp', type: 'string'},
                        {name: 'tepsi', type: 'string'},
                        {name: 'tepsi', type: 'string'},
                        {name: 'pauta_breve', type: 'string'},
                        {name: 'mchat', type: 'string'},
                        {name: 'otra_vulnerabilidad', type: 'string'},

                        {name: '2m', type: 'string'},
                        {name: '4m', type: 'string'},
                        {name: '6m', type: 'string'},
                        {name: '12m', type: 'string'},
                        {name: '18m', type: 'string'},
                        {name: '3anios', type: 'string'},
                        {name: '5anios', type: 'string'},


                    ],
                cache: false
            };

        var cellLinkRegistroTarjetero = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return '<i onclick="loadMenu_CardioVascular(\'menu_1\',\'registro_atencion\',\'' + value + '\')"  ' +
                'style="color: white;" class="mdi-hardware-keyboard-return"></i> IR';
        }
        var cellIrClass = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return "eh-open_principal white-text cursor_cell_link center";

        }
        var cellEditarPaciente = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {

            return '<i class="mdi-editor-mode-edit" ' +
                'onclick="boxEditarPaciente_PSCV(\'' + value + '\')"></i>';

        }
        var cellEdadAnios = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            var anios = parseInt(value / 12);
            var meses = value % 12;
            if (anios === 0) {
                return "<div style='padding-left: 10px;'>" + meses + " Meses</div>";
            } else {
                if (anios > 20) {
                    return "<div style='padding-left: 10px;'>" + anios + " Años</div>";
                } else {
                    return "<div style='padding-left: 10px;'>" + anios + " Años " + meses + " Meses</div>";
                }

            }

        }
        var cellSexo = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            if (value == 'M') {
                return "light-blue lighten-1";
            } else {
                return "pink lighten-1 white-text";
            }

        }


        var dataAdapter = new $.jqx.dataAdapter(source);


        $("#grid_paciente").jqxGrid(
            {
                width: '98%',
                theme: 'eh-open',
                source: dataAdapter,
                height: 400,
                columnsresize: true,
                sortable: true,
                filterable: true,
                autoshowfiltericon: true,
                showfilterrow: true,
                showstatusbar: true,
                statusbarheight: 30,
                showaggregates: true,
                selectionmode: 'multiplecellsextended',
                columns: [
                    {
                        text: '', datafield: 'link', width: 60,
                        cellclassname: cellIrClass,
                        cellsrenderer: cellLinkRegistroTarjetero, filterable: false
                    },
                    {text: 'RUT', datafield: 'rut', width: 100, cellsalign: 'right'},
                    {
                        text: 'Nombre Completo', datafield: 'nombre', width: 280,
                        aggregates: ['count'],
                        aggregatesrenderer: function (aggregates, column, element, summaryData) {
                            var renderstring = "<div  style='float: left; width: 100%; height: 100%;'>";
                            $.each(aggregates, function (key, value) {
                                var name = 'Total Pacientes';
                                renderstring += '<div style="; position: relative; margin: 6px; text-align: right; overflow: hidden;">' + name + ': ' + value + '</div>';
                            });
                            renderstring += "</div>";
                            return renderstring;
                        }
                    },
                    {
                        text: 'SEXO',
                        datafield: 'sexo',
                        width: 80,
                        filtertype: 'checkedlist',
                        cellsalign: 'center',
                        cellclassname: cellSexo
                    },
                    {text: 'AÑOS', datafield: 'anios', width: 80, cellsalign: 'center', filtertype: 'checkedlist'},
                    {text: 'MESES', datafield: 'meses', width: 80, cellsalign: 'center', filtertype: 'checkedlist'},
                    {text: 'DIAS', datafield: 'dias', width: 80, cellsalign: 'center', filtertype: 'checkedlist'},
                    {text: 'SECTOR COMUNAL', datafield: 'sector_comunal', width: 150, filtertype: 'checkedlist'},
                    {text: 'ESTABLECIMIENTO', datafield: 'establecimiento', width: 300, filtertype: 'checkedlist'},
                    {text: 'SECTOR INTERNO', datafield: 'sector_interno', width: 150, filtertype: 'checkedlist'},

                    {text: 'PE', datafield: 'PE', width: 80, filtertype: 'checkedlist'},
                    {text: 'PT', datafield: 'PT', width: 50, filtertype: 'checkedlist'},
                    {text: 'TE', datafield: 'TE', width: 50, filtertype: 'checkedlist'},

                    {text: 'DNI', datafield: 'DNI', width: 50, filtertype: 'checkedlist'},
                    {text: 'PCINT', datafield: 'PCINT', width: 80, filtertype: 'checkedlist'},
                    {text: 'IMCE', datafield: 'IMCE', width: 80, filtertype: 'checkedlist'},
                    {text: 'LME', datafield: 'LME', width: 100, filtertype: 'checkedlist'},
                    {text: 'RIMALN', datafield: 'RIMALN', width: 100, filtertype: 'checkedlist'},
                    {text: 'SCORE_IRA', datafield: 'SCORE_IRA', width: 100, filtertype: 'checkedlist'},
                    {text: 'PA', datafield: 'presion_arterial', width: 100, filtertype: 'checkedlist'},
                    {text: 'PERIMETRO CRANEAL', datafield: 'perimetro_craneal', width: 100, filtertype: 'checkedlist'},
                    {text: 'AGUDEZA VISUAL', datafield: 'agudeza_visual', width: 100, filtertype: 'checkedlist'},
                    {
                        text: 'EVALUACION AUDITIVA',
                        datafield: 'evaluacion_auditiva',
                        width: 100,
                        filtertype: 'checkedlist'
                    },
                    {
                        text: 'ATENCION SECUNDARIA',
                        datafield: 'atencion_secundaria',
                        width: 100,
                        filtertype: 'checkedlist'
                    },
                    {text: 'EV NEUROSENSORIAL', datafield: 'ev_neurosensorial', width: 100, filtertype: 'checkedlist'},
                    {text: 'RX PELVIS', datafield: 'rx_pelvis', width: 100, filtertype: 'checkedlist'},
                    {text: 'EEDP', datafield: 'eedp', width: 100, filtertype: 'checkedlist'},
                    {text: 'TEPSI', datafield: 'tepsi', width: 100, filtertype: 'checkedlist'},
                    {text: 'PAUTA BREVE', datafield: 'pauta_breve', width: 100, filtertype: 'checkedlist'},
                    {text: 'MCHAT', datafield: 'mchat', width: 100, filtertype: 'checkedlist'},
                    {text: 'OTRA VULNERABILIDAD', datafield: 'otra_vulnerabilidad', width: 100, filtertype: 'checkedlist'},

                    {text: '2 MESES', datafield: '2m', width: 100, filtertype: 'checkedlist'},
                    {text: '4 MESES', datafield: '4m', width: 100, filtertype: 'checkedlist'},
                    {text: '6 MESES', datafield: '6m', width: 100, filtertype: 'checkedlist'},
                    {text: '12 MESESL', datafield: '12m', width: 100, filtertype: 'checkedlist'},
                    {text: '18 MESES', datafield: '18m', width: 100, filtertype: 'checkedlist'},
                    {text: '3 AÑOS', datafield: '3anios', width: 100, filtertype: 'checkedlist'},
                    {text: '5 AÑOS', datafield: '5anios', width: 100, filtertype: 'checkedlist'},


                ]
            });
        $("#excelExport_estadistica").jqxButton();
        $("#excelExport_estadistica").click(function () {
            alertaLateral('EXPORTANDO INFORMACION');
            // $("#grid").jqxGrid('exportdata', 'xls', 'jqxGrid');
            $("#grid_paciente").jqxGrid('exportdata', 'xls', 'Pacientes INFANTIL', true, null, true, 'https://carahue.eh-open.com/exportar/save-file.php');
            // $("#grid_paciente").jqxGrid('exportdata', 'xls', 'Pacientes PSCV - DETALLE');
        });
    }

    function boxInfoEstablecimiento(id) {
        $.post('php/modal/establecimiento/informacion.php', {
            id: id
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                document.getElementById("btn-modal").click();
            }
        });
    }

    function cargarListado() {
        // prepare the data

    }
</script>
<div class="row center-align">
    <div class="col l12">
        <div class="card-panel">
            <div class="row">
                <div class="col l4 m6 s6">
                    <button class="btn right-align eh-open_principal" id="excelExport_estadistica">
                        <i class="mdi-action-open-in-new left"></i>
                        EXPORTAR
                    </button>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col l12">
                    <div id="grid_paciente"></div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <i class="mdi-hardware-keyboard-return"></i>PERMITE PODER INGRESAR LA FICHA CORRESPONDIENTE AL
                    USUARIO SELECCIONADO
                </div>
                <div class="col l12 m12 s12">
                    <i class="mdi-editor-mode-edit"></i>PERMITE EDITAR AL PACIENTE, PARA MODIFICAR SUS DATOS PERSONALES
                    Y ADEMAS CAMBIARLO DE ESTABLECIMIENTO.
                </div>
            </div>
        </div>
    </div>
</div>

