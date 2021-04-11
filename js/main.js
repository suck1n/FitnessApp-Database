$(() => {
    let dropdown = $(".dropdown span")
    let tables = $("[data-column]");

    $(dropdown).on("click", function() {
        let menu = $(this).siblings().first();
        if(menu.css("display") === 'none') {
            menu.slideDown(350);
        } else {
            menu.slideUp(350);
        }
    });

    /* Table Click Event -> Load Table with DataTables*/
    $(tables).each((_, newItem) => {
        $(newItem).on("click", () => {
            let currentItem = $("li.active");
            let col = $(newItem).data("column").toLowerCase();

            if(currentItem.data("column") === col) {
                return;
            }

            load_table(col, () => {
                currentItem.removeClass("active");
                $(newItem).addClass("active");
            });
        });
    })

    function load_table(col, callback = null) {
        let url = "database/" + col + "_db.php"

        $.get(url, (data) => {
            let content = $("#content");
            content.html(data);

            if(callback != null && typeof callback === 'function') {
                callback();
            }

            prepare_table();
        });
    }

    load_table($("li.active").data("column").toLowerCase())
});

