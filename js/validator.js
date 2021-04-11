$(() => {
    'use strict';

    let input = $('.alert-input .input100');

    $('.validate-form').on("submit", () => {
        let check = true;

        input.each((index, field) => {
            if(validate(field) === false) {
                showValidate(field);
                check = false;
            }
        })

        return check;
    });


    $('.validate-form .input100').each((index, field) => {
        $(field).focus(() => {
           hideAlert($(field));
        });
    });

    function validate (input) {
        let type = $(input).attr("type");
        let name = $(input).attr("name");
        let val = $(input).val().trim();

        let emailMatcher = /^([a-zA-Z0-9_\-.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(]?)$/

        if(type === 'email' || name === 'email') {
            return val.match(emailMatcher) != null;
        } else {
            return val !== '';
        }
    }
});