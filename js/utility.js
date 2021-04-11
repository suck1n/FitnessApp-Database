function showError(fields) {
    fields = (typeof fields !== "object") ? [fields] : fields;

    for(let field of fields) {
        switch (field) {
            case "unexpected":
                console.error("An unexpected error occurred");
                break
            default:
                showWrongInput(getFieldByName(field));
        }
    }
}

function showWrongInput(input) {
    let thisAlert = $(input).parent();

    $(thisAlert).addClass('alert-wrong-input');
}

function showValidate(input) {
    let thisAlert = $(input).parent();

    $(thisAlert).addClass('alert-validate');
}

function hideAlert(input) {
    let thisAlert = $(input).parent();

    $(thisAlert).removeClass('alert-validate');
    $(thisAlert).removeClass('alert-wrong-input');
}

function getFieldByName(name) {
    let field = $("[name=" + name + "]");
    if(field.length === 0) {
        return $("#" + name);
    }
    return field;
}

function debugObject(obj, depth = 2, prefix = "") {
    if(depth === 0) {
        console.log(prefix + "Depth Limit reached!")
        return;
    }

    let information = ""

    for(let key in obj) {
        if(obj.hasOwnProperty(key)) {
            information += prefix + key + ":" + "\n";
            let val = obj[key];
            if(typeof(val) === "object") {
                debugObject(val, depth - 1, prefix + "\t");
            } else {
                information += prefix + "\t -> " + obj[key] + "\n";
            }
        }
    }

    console.log(information)
}