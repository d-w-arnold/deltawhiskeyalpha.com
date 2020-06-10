$(function () {
    $.validator.setDefaults({
        errorClass: 'error'
    });

    $("#contact-form").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            message: {
                maxlength: 1000
            }
        },
        messages: {
            name: {
                required: "Please enter your name.",
                minlength: "At least 2 characters please."
            },
            email: {
                required: "Please enter a valid email address."
            },
            message: "Please enter no more than 1000 characters."
        }
    });
});
