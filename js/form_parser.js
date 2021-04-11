$(() => {
    let input = $('.input100');

    $('.validate-form').on("submit", function(e) {
        if(e.result) {
            let url = $(this).attr("action");
            let dest = $(this).attr("destination");
            let data = {}

            input.each((index, field) => {
                let name = $(field).attr("name");
                data[name] = $(field).val();
            })

            $.post(url, data, (data) => {
                console.log(data);
                data = JSON.parse(data);
                console.log(data);

                if(data["status"] === "success") {
                    window.location.replace(dest);
                } else if(data["status"] === "error") {
                    showError(data["type"])
                }
            });
        }

        return false;
    });
});