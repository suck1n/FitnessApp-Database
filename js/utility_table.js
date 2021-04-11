function prepare_table() {
    let table = $("#table");
    let table_name = table.data("name");
    let table_columns = $("#columns").children();

    let fields = [];
    let columns = [];

    for(let table_column of table_columns) {
        let name = table_name + "." + $(table_column).data("name");
        let label = $(table_column).text();
        let column = $(table_column).data("column") === undefined ? name : $(table_column).data("column");
        let field = $(table_column).data()

        field["name"] = name;
        field["label"] = label;

        if (!field["tableOnly"]) {
            fields.push(field);
        }
        columns.push({ data: column })
    }

    let button_data = table.data("button");
    if(button_data) {
        let button_extends = button_data.split(", ");
        let buttons = []

        for(let button_extend of button_extends) {
            buttons.push({ extend: button_extend });
        }

        load_table(table_name, fields, buttons, columns);
    } else {
        load_table(table_name, fields, null, columns);
    }

}

function load_table(tableName, fields, buttons, columns) {
    let id = "#table";
    let table = $(id);
    let url = '../api/database/' + tableName.toLowerCase() + '.php'

    let editor = new $.fn.dataTable.Editor({
        ajax:  url,
        table: id,
        fields: fields
    });

    for(let field of fields) {
        if(field["type"] === "readonly") {
           editor.field(field["name"]).disable();
        }
    }

    if(buttons != null) {
        for(let button of buttons) {
            button["editor"] = editor;
        }

        table.DataTable({
            ajax: url,
            dom: 'Bfrtip',
            pageLength: 10,
            columns: columns,
            select: true,
            buttons: buttons
        });
    } else {
        table.DataTable({
            ajax: url,
            dom: 'frtip',
            pageLength: 10,
            columns: columns,
            select: true
        });
    }
}