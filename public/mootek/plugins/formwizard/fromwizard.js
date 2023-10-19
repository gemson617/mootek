(function ($) {
    "use strict";

    // Toolbar extra buttons
    var btnFinish = $('<button type="submit"></button>')
        .text("Save")
        .addClass("btn btn-primary finish d-none")
        .on("click", function () {
            //alert("Finish Clicked");
        });
    var btnCancel = $("<button type='button'></button>")
        .text("Cancel")
        .addClass("btn btn-secondary finish d-none")
        .on("click", function () {
            $("#smartwizard").smartWizard("reset");
        });

    // Smart Wizard
    $("#smartwizard").smartWizard({
        selected: 0,
        theme: "default",
        transitionEffect: "fade",
        showStepURLhash: true,
        toolbarSettings: {
            toolbarButtonPosition: "end",
            toolbarExtraButtons: [btnFinish, btnCancel],
        },
    });

    // Arrows Smart Wizard 1
    $("#smartwizard-1").smartWizard({
        selected: 0,
        theme: "arrows",
        transitionEffect: "fade",
        showStepURLhash: false,
        toolbarSettings: {
            toolbarExtraButtons: [btnFinish, btnCancel],
        },
    });

    // Circles Smart Wizard 1
    $("#smartwizard-2").smartWizard({
        selected: 0,
        theme: "circles",
        transitionEffect: "fade",
        showStepURLhash: false,
        toolbarSettings: {
            toolbarExtraButtons: [btnFinish, btnCancel],
        },
    });

    // Dots Smart Wizard 1
    var wizard = $("#smartwizard-3").smartWizard({
        selected: 0,
        theme: "dots",
        transitionEffect: "fade",
        showStepURLhash: false,
        toolbarSettings: {
            toolbarExtraButtons: [btnFinish],
        },
    });

    $("#customerFormData").validate({
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            mobile: {
                required: true,
            },
            email: {
                required: true,
            },
            company_name:{
                required:true
            },
            alias:{
                required:true
            },
            trading_as:{
                required:true
            },
            terms:{
                required:true
            },
            credit_limit:{
                required:true
            },
            abn:{
                required:true
            },
            first_name_bill: {
                required: true,
            },
            last_name_bill: {
                required: true,
            },
            billing_email: {
                required: true,
            },
            mobile_bill: {
                required: true,
            },
            send_invoice:{
                required:true,
            },
            first_name_deliv: {
                required: true,
            },
            last_name_deliv: {
                required: true,
            },
            deliv_email: {
                required: true,
            },
            deliv_mobile: {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: "Please Enter First Name",
            },
            last_name: {
                required: "Please Enter Last Name",
            },
            mobile: {
                required: "Please Enter Mobile",
            },
            email: {
                required: "Please Enter Email",
            },
            company_name:"Company Name fields is required",
            alias:" Alias fields is required",
            trading_as:"Trading as fields is required",
            terms:"Terms fields is required",
            credit_limit:"Credit Limit fields is required",
            abn:"ABN fields is required",
            first_name_bill: {
                required: "Please Enter First Name",
            },
            last_name_bill: {
                required: "Please Enter Last Name",
            },
            billing_email: {
                required: "Please Enter Email",
            },
            mobile_bill: {
                required: "Please Enter Mobile",
            },
            send_invoice:'Please Select Send Invoice',
            first_name_deliv: {
                required: "Please Enter First Name",
            },
            last_name_deliv: {
                required: "Please Enter Last Name",
            },
            deliv_email: {
                required: "Please Enter Email",
            },
            deliv_mobile: {
                required: "Please Enter Mobile",
            },
        },
    });

    $(wizard).on(
        "leaveStep",
        function (e, anchorObject, stepNumber, stepDirection) {
            console.log(stepDirection);
            if ($("#customerFormData").valid()) {
                if (stepNumber == "3" && stepDirection == "forward") {
                    //here is the final step: Note: 0,1,2
                    $(".finish").removeClass("d-none");
                } else {
                    $(".finish").addClass("d-none");
                }
                return true;
            } else {
                return false;
            }
        }
    );
})(jQuery);
