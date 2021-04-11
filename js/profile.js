$(() => {
    let save_button = $("#save_button");
    let cancel_button = $("#cancel_button");

    let edit_buttons = $(".btn-info");

    let currentInput = null;

    edit_buttons.on("click", function () {
        currentInput= $("#" + $(this).attr("data-for"));

        show_utils();
    });

    cancel_button.on("click", () => {
        if(currentInput == null) {
            return;
        }

        get_default_values((data) => {
            for(let key in data["data"]) {
                if(data["data"].hasOwnProperty(key)) {
                    let value = data["data"][key];

                    let target = $("#" + key);
                    target.val(value);
                }
            }

            hide_utils();
        });
    });

    save_button.on("click", () => {
        if(currentInput == null) {
            return;
        }

        let data = {
            "operation": "update",
            "data": {
                "key": currentInput.attr("name"),
                "value": currentInput.val()
            }
        };

        if(currentInput.attr("id") === "password") {
            data["data"]["confirm_password"] = $("#confirm_password").val();
        }

        $.post("../api/profile.php", data, (data) => {
            console.log(data);
            data = JSON.parse(data);

            if(data["status"] === "success") {
                show_info("Erfolgreich gespeichert!");
                hide_utils();
            } else {
                console.log(data["message"]);
                show_error(data["message"]);
            }
        });
    });


    function show_error(description, header = "Error") {
        let alert = $("#alert");
        let alert_header = $("#alert_header");
        let alert_description = $("#alert_description");

        alert_header.text(header);
        alert_description.text(description);

        alert.removeClass("alert-success").addClass("alert-danger")
            .fadeIn(400).delay(1600).fadeOut(400);
    }

    function show_info(description, header = "Success") {
        let alert = $("#alert");
        let alert_header = $("#alert_header");
        let alert_description = $("#alert_description");

        alert_header.text(header);
        alert_description.text(description);

        alert.removeClass("alert-danger").addClass("alert-success")
            .fadeIn(400).delay(1600).fadeOut(400);
    }

    function get_default_values(callback) {
        $.post("../api/profile.php", {"operation": "default_values"}, (data) => {
            data = JSON.parse(data);

            callback(data);
        });
    }

    function hide_utils() {
        edit_buttons.fadeIn(250);

        currentInput.attr("readonly", true);

        save_button.fadeOut(250);
        cancel_button.fadeOut(250);

        if(currentInput.attr("id") === "password") {
            currentInput.val("XXXXXXXX");
            $("#confirm_password_group").fadeOut(250);
        }

        currentInput = null;
    }

    function show_utils() {
        edit_buttons.fadeOut(250);

        currentInput.attr("readonly", false);

        save_button.fadeIn(250);
        cancel_button.fadeIn(250);

        if(currentInput.attr("id") === "password") {
            currentInput.val("");
            $("#confirm_password_group").fadeIn(250);
        }
    }
});