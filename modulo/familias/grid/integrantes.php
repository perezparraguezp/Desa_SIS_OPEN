<?php
$id_familia = $_POST['rut'];
?>

<style type="text/css">
    .cursor_cell_link {
        cursor: pointer;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        var source =
            {
                url: 'json/integrantes.php?id=<?php echo $id_familia; ?>',
                datatype: "json",
                root: 'Rows',
                datafields:
                    [
                        {name: 'rut', type: 'string'},
                        {name: 'parentesco', type: 'string'},
                        {name: 'nombre', type: 'string'},
                        {name: 'anio', type: 'number'},
                        {name: 'meses', type: 'number'},
                        {name: 'sexo', type: 'string'},
                        {name: 'nacimiento', type: 'string'},
                        {name: 'edad', type: 'string'},
                        {name: 'editar', type: 'string'},
                    ],
                cache: false,

            };

        var cellIrClass = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return "eh-open_principal white-text cursor_cell_link center";

        }
        var cellEditarPaciente = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {

            return '<i class="mdi-editor-mode-edit" ' +
                'onclick="boxEditarIntegrante(\'' + value + '\')"></i>';

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
        var cellEditarClass = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return "eh-open_principal white-text cursor_cell_link center";


        }

        var dataAdapter = new $.jqx.dataAdapter(source);

        const opciones = [
            { value: 'INDICE', label: 'INDICE' },
            { value: 'PAREJA', label: 'PAREJA' },
            { value: 'HIJO(A)', label: 'HIJO(A)' },
            { value: 'PADRE', label: 'PADRE' },
            { value: 'MADRE', label: 'MADRE' },
            { value: 'HERMANO(A)', label: 'HERMANO(A)' },
            { value: 'SOBRINO', label: 'SOBRINO' },
            { value: 'TIO-TIA', label: 'TIO-TIA' },
            { value: 'ABUELO(A)', label: 'ABUELO(A)' },
            { value: 'OTRO FAMILIAR', label: 'OTRO FAMILIAR' },
            { value: 'SIN PARENTESCO', label: 'SIN PARENTESCO' },
        ];

        // Fuente de datos para el dropdownlist
        const dropdownSource = {
            localdata: opciones,
            datatype: "array",
            datafields: [
                { name: 'value' },
                { name: 'label' }
            ]
        };
        const dropdownAdapter = new $.jqx.dataAdapter(dropdownSource);


        $("#grid_integrantes").jqxGrid(
            {
                width: '98%',
                theme: 'eh-open',
                source: dataAdapter,
                height: alto - 600,
                columnsresize: true,
                sortable: true,
                filterable: true,
                editable: true,
                autoshowfiltericon: true,
                showfilterrow: true,
                showstatusbar: true,
                statusbarheight: 30,
                showaggregates: true,
                selectionmode: 'multiplecellsextended',
                columns: [
                    {
                        text: '',
                        datafield: 'editar',
                        width: 40,
                        cellsrenderer: cellEditarPaciente,
                        cellclassname: cellEditarClass,
                        filterable: false,editable: false
                    },
                    {
                        text: 'PARENTESCO',
                        datafield: 'parentesco',
                        displayfield: 'parentesco', // Campo que se mostrará
                        columntype: 'dropdownlist',
                        width: 200,
                        createeditor: function (row, cellvalue, editor) {
                            // Configurar el editor del dropdownlist
                            editor.jqxDropDownList({
                                source: dropdownAdapter,
                                displayMember: 'label',
                                valueMember: 'value'
                            });
                        },
                        initeditor: function (row, cellvalue, editor) {
                            // Seleccionar el valor actual en el dropdownlist
                            editor.jqxDropDownList('selectItem', cellvalue);
                        },
                        geteditorvalue: function (row, cellvalue, editor) {
                            // Devolver el valor seleccionado
                            return editor.val();
                        }
                    },
                    {text: 'RUT', datafield: 'rut', width: 100, cellsalign: 'right',editable: false},
                    {text: 'NOMBRE COMPLETO', datafield: 'nombre', aggregates: ['count'],editable: false},
                    {text: 'SEXO', datafield: 'sexo', width: 80, filtertype: 'checkedlist',editable: false},
                    {text: 'AÑOS', datafield: 'anio', width: 80, filtertype: 'checkedlist',editable: false},
                    {text: 'MESES', datafield: 'meses', width: 80, filtertype: 'checkedlist',editable: false},
                    {text: 'FECHA NACIMIENTO', datafield: 'nacimiento', width: 200, cellsalign: 'left',editable: false},


                ]
            });

        $("#excelExport").jqxButton();
        $("#excelExport").click(function () {
            // $("#grid").jqxGrid('exportdata', 'xls', 'jqxGrid');
            $("#grid_integrantes").jqxGrid('exportdata', 'xls', 'Pacientes SIS Mujer', true, null, true, 'https://carahue.eh-open.com/exportar/save-file.php');
        });

        $("#grid_integrantes").on('cellendedit', function (event) {
            const args = event.args;
            const rowindex = args.rowindex;
            const datafield = args.datafield;
            const newvalue = args.value;
            const oldvalue = args.oldvalue;
            // Verificar que la columna editada sea la de opciones
            if (datafield === "parentesco" && newvalue !== oldvalue) {
                const rowdata = $("#grid_integrantes").jqxGrid('getrowdata', rowindex);

                // Realizar la llamada AJAX para actualizar en la base de datos
                $.ajax({
                    url: "db/update/actualizar_integrante.php",
                    method: "POST",
                    data: {
                        id: rowdata.id,       // ID del registro
                        rut: rowdata.rut,       // ID del registro
                        id_familia: '<?php echo $id_familia; ?>',       // ID del registro
                        valor: newvalue      // Nuevo valor de la opción
                    },
                    success: function (response) {
                        console.log("Actualización exitosa:", response);
                    },
                    error: function (xhr, status, error) {
                        console.error("Error al actualizar:", error);
                    }
                });
            }
        });

    });

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

    function boxEditarIntegrante(rut) {
        $.post('formulario/editar_integrante.php', {
            id_familia:<?php echo $id_familia; ?>,
            rut: rut,
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }

    function boxNuevoIntegrante() {
        $.post('formulario/ingreso_integrante.php', {
            id_familia:<?php echo $id_familia; ?>,
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
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
                <div class="col l12 right-align large">
                    <input type="button" class="btn eh-open_principal btn-large"
                           onclick="boxNuevoIntegrante()"
                           value="NUEVO INTEGRANTE"/>

                    <input type="button" class="btn green white-text btn-large"
                           value="Exportar a Excel" id='excelExport'/>
                </div>
            </div>
            <div class="row">
                <div class="col l12">
                    <div id="grid_integrantes"></div>
                </div>
            </div>

        </div>
    </div>
</div>

