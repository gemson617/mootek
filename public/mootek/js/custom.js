(function ($) {
    "use strict";

    // ______________ Horizonatl
    $(document).ready(function () {
        $("a[data-theme]").click(function () {
            $("head link#theme").attr("href", $(this).data("theme"));
            $(this).toggleClass("active").siblings().removeClass("active");
        });
        $("a[data-effect]").click(function () {
            $("head link#effect").attr("href", $(this).data("effect"));
            $(this).toggleClass("active").siblings().removeClass("active");
        });
    });

    // ______________Full screen
    $("#fullscreen-button").on("click", function toggleFullScreen() {
        if (
            (document.fullScreenElement !== undefined &&
                document.fullScreenElement === null) ||
            (document.msFullscreenElement !== undefined &&
                document.msFullscreenElement === null) ||
            (document.mozFullScreen !== undefined && !document.mozFullScreen) ||
            (document.webkitIsFullScreen !== undefined &&
                !document.webkitIsFullScreen)
        ) {
            if (document.documentElement.requestFullScreen) {
                document.documentElement.requestFullScreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullScreen) {
                document.documentElement.webkitRequestFullScreen(
                    Element.ALLOW_KEYBOARD_INPUT
                );
            } else if (document.documentElement.msRequestFullscreen) {
                document.documentElement.msRequestFullscreen();
            }
        } else {
            if (document.cancelFullScreen) {
                document.cancelFullScreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) {
                document.webkitCancelFullScreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        }
    });

    // ______________Active Class
    $(document).ready(function () {
        $(".horizontalMenu-list li a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("active"); // add active to li of the current link
                $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
                $(this).parent().parent().prev().click(); // click the item to make it drop
            }
        });
        $(".horizontal-megamenu li a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("active"); // add active to li of the current link
                $(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .prev()
                    .addClass("active"); // add active class to an anchor
                $(this).parent().parent().prev().click(); // click the item to make it drop
            }
        });
        $(".horizontalMenu-list .sub-menu .sub-menu li a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("active"); // add active to li of the current link
                $(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .prev()
                    .addClass("active"); // add active class to an anchor
                $(this).parent().parent().prev().click(); // click the item to make it drop
            }
        });
    });

    // ______________ Page Loading
    $(window).on("load", function (e) {
        $("#global-loader").fadeOut("slow");
    });

    // ______________Back to top Button
    $(window).on("scroll", function (e) {
        if ($(this).scrollTop() > 0) {
            $("#back-to-top").fadeIn("slow");
        } else {
            $("#back-to-top").fadeOut("slow");
        }
    });
    $("#back-to-top").on("click", function (e) {
        $("html, body").animate(
            {
                scrollTop: 0,
            },
            600
        );
        return false;
    });

    // ______________ StarRating
    var ratingOptions = {
        selectors: {
            starsSelector: ".rating-stars",
            starSelector: ".rating-star",
            starActiveClass: "is--active",
            starHoverClass: "is--hover",
            starNoHoverClass: "is--no-hover",
            targetFormElementSelector: ".rating-value",
        },
    };
    $(".rating-stars").ratingStars(ratingOptions);

    // ______________ Chart-circle
    if ($(".chart-circle").length) {
        $(".chart-circle").each(function () {
            let $this = $(this);

            $this.circleProgress({
                fill: {
                    color: $this.attr("data-color"),
                },
                size: $this.height(),
                startAngle: (-Math.PI / 4) * 2,
                emptyFill: "#e5e9f2",
                lineCap: "round",
            });
        });
    }

    // ______________ Global Search
    $(document).on("click", "[data-toggle='search']", function (e) {
        var body = $("body");

        if (body.hasClass("search-gone")) {
            body.addClass("search-gone");
            body.removeClass("search-show");
        } else {
            body.removeClass("search-gone");
            body.addClass("search-show");
        }
    });
    var toggleSidebar = function () {
        var w = $(window);
        if (w.outerWidth() <= 1024) {
            $("body").addClass("sidebar-gone");
            $(document)
                .off("click", "body")
                .on("click", "body", function (e) {
                    if (
                        $(e.target).hasClass("sidebar-show") ||
                        $(e.target).hasClass("search-show")
                    ) {
                        $("body").removeClass("sidebar-show");
                        $("body").addClass("sidebar-gone");
                        $("body").removeClass("search-show");
                    }
                });
        } else {
            $("body").removeClass("sidebar-gone");
        }
    };
    toggleSidebar();
    $(window).resize(toggleSidebar);

    const DIV_CARD = "div.card";
    // ______________ Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // ______________ Popover
    $('[data-toggle="popover"]').popover({
        html: true,
    });

    // ______________ Card Remove
    $(document).on("click", '[data-toggle="card-remove"]', function (e) {
        let $card = $(this).closest(DIV_CARD);
        $card.remove();
        e.preventDefault();
        return false;
    });

    // ______________ Card Collapse
    $(document).on("click", '[data-toggle="card-collapse"]', function (e) {
        let $card = $(this).closest(DIV_CARD);
        $card.toggleClass("card-collapsed");
        e.preventDefault();
        return false;
    });

    // ______________ Card Fullscreen
    $(document).on("click", '[data-toggle="card-fullscreen"]', function (e) {
        let $card = $(this).closest(DIV_CARD);
        $card.toggleClass("card-fullscreen").removeClass("card-collapsed");
        e.preventDefault();
        return false;
    });

    // sparkline1
    $(".sparkline_bar").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4], {
        height: 20,
        type: "bar",
        colorMap: {
            7: "#a1a1a1",
        },
        barColor: "#f72d66",
    });

    // sparkline2
    $(".sparkline_bar1").sparkline([3, 4, 3, 4, 5, 4, 5, 6, 4, 6], {
        height: 20,
        type: "bar",
        colorMap: {
            7: "#a1a1a1",
        },
        barColor: "#2d66f7",
    });

    // ______________Skins

    $("#myonoffswitch1").click(function () {
        if (this.checked) {
            $("body").addClass("light-mode");
            $("body").removeClass("dark-mode");
            localStorage.setItem("light-mode", "True");
        } else {
            $("body").removeClass("light-mode");
            localStorage.setItem("light-mode", "false");
        }
    });
    $("#myonoffswitch2").click(function () {
        if (this.checked) {
            $("body").addClass("dark-mode");
            $("body").removeClass("light-mode");
            localStorage.setItem("dark-mode", "True");
        } else {
            $("body").removeClass("dark-mode");
            localStorage.setItem("dark-mode", "false");
        }
    });

    // Scan Bottle validation





    // CreateLead form validation

    $('#lead-form').validate({
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            phone_number: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            contactable_date:{
                required:true,
            }


        },
        messages: {
            first_name: {
                required: "Please Enter Firstname",
            },
            last_name: {
                required: "Please Enter Lastname",
            },
            phone_number: {
                required: "Please Enter phoneNumber",
            },
            email: {
                required: "Please Enter Email",
            },
            contactable_date:{
                required:"Please Select Contactable Date"
            }

        },
    })

    // Lead followup validation

    $("#followup-form").validate({
        ignore: [],
        rules: {
            assign_user: {
                required: true,
            },
            status: {
                required: true,
            },
            contactable_date: {
                required: true,
            },
            comments: {
                required: true,
            },
            subject:{
                required:"#act:checked",
            },
            body:{
                required:"#act:checked",
            }

        },
        messages: {
            assign_user: {
                required: "Please Select User",
            },
            status: {
                required: "Please Select Status",
            },
            contactable_date: {
                required: "Please Enter Contactable date",
            },
            comments: {
                required: "Please Enter Comments",
            },
            subject: {
                required: "Please Enter Subject",
            },
            body: {
                required: "Please Enter Body",
            },

        },
    });

    $("select[name='same_delivery']").on('change',function(){
        var same=$("select[name='same_delivery']").val();
        if(same==='Yes'){
            $('#send_docket_to').val(1)
        }else{
            $('#send_docket_to').val('');
        }

    })

    // Create Customer Validation

    $(document).ready(function () {
        $("#submitFormData").click(function () {
            $('form[id="customerFormData"]').validate({
                rules: {
                    first_name: "required",
                    last_name: "required",
                    email: {
                        required: true,
                        email: true,
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                    }

                },
                messages: {
                    first_name: "First Name field is required",
                    last_name: "Last Name field is required",
                    user_email: "Enter a valid email",
                    mobile: {
                        minlength: "Mobile number must be 10 digit long",
                    },

                },
                submitHandler: function (form) {
                    form.submit();
                },
            });
        });
    });
})(jQuery);
// allow only decimel numbers 10.00
function isNumber_decimal(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
//  allow numbers only
function isNumberKey(evt)
       {
         var charCode = (evt.which) ? evt.which : event.keyCode;
         if ((charCode < 48 || charCode > 57))
             return false;

         return true;
       }

  //validate email
function validateEmail(emailField)
  {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailField))
    {
      return (true)
    }
      alert("You have entered an invalid email address!")
      return (false)
  }







   //Block some keyboard strings (numeric and special charcters)
   $('.txt').keydown(function (e)
   {
     if (e.altKey)
     {
       e.preventDefault();
     }
     else
     {
       var key = e.keyCode;
       if (!((key == 116) || (key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90)))
       {
         e.preventDefault();
       }
     }
   });
   // Accept only alpha numerics, no special characters
$('.txt-num').keydown(function(e){

    if (!e.key.match(/[a-zA-Z0-9, ]/) || (e.key == ',' && value[value.length-1] == ',')) {
        e.preventDefault();
      }

})

function select_account_type(type){
 //   var type=$('#account_type').val();
    if(type==2){
        $('#commercial_form').css("display","flex");
        $('#commercial_not_required').hide();
        $('#comm_cost_price').show();
        $('#comm_act_price').show();
        $('#comm_rent_price').show();
        $('#res_cost_price').hide();
        $('#res_act_price').hide();
        $('#res_rent_price').hide();
        $('#span_comm_cost').show();
        $('#span_comm_act').show();
        $('#span_comm_rent').show();
        $('#span_res_cost').hide();
        $('#span_res_act').hide();
        $('#span_res_rent').hide();
        $('#rental_period0').val(3);
        $('#rental_period1').val(3);
        $('#rental_period2').val(3);
        $('#rental_period3').val(3);
        $('#rental_period4').val(3);
        $('#rental_period5').val(3);
        $('#rental_period6').val(3);
        $('#rental_period7').val(3);
        $('#rental_period8').val(3);
        $('#rental_period9').val(3);
        $('#rental_period10').val(3);
    }else{
        $('#commercial_form').css("display","none");
        $('#commercial_not_required').show()
        $('#comm_cost_price').hide();
        $('#comm_act_price').hide();
        $('#comm_rent_price').hide();
        $('#res_cost_price').show();
        $('#res_act_price').show();
        $('#res_rent_price').show();
        $('#span_comm_cost').hide();
        $('#span_comm_act').hide();
        $('#span_comm_rent').hide();
        $('#span_res_cost').show();
        $('#span_res_act').show();
        $('#span_res_rent').show();
        $('#rental_period0').val(6);
        $('#rental_period1').val(6);
        $('#rental_period2').val(6);
        $('#rental_period3').val(6);
        $('#rental_period4').val(6);
        $('#rental_period5').val(6);
        $('#rental_period6').val(6);
        $('#rental_period7').val(6);
        $('#rental_period8').val(6);
        $('#rental_period9').val(6);
        $('#rental_period10').val(6);
    }
}
//Customer Details Setting contact same as billing

$('select[name="same_delivery"]').on('change', function() {
    var selected=$(this).val();
    if(selected == 'Yes'){
        var first_name=$('input[name="first_name"]').val();
        var last_name=$('input[name="last_name"]').val();
        var mobile=$('input[name="mobile"]').val();
        var email=$('input[name="email"]').val();

        var cbuild_no=$('input[name="cbuild_no"]').val();
        var cbuild_type=$('select[name="cbuild_type"]').val();
        var cbuild_name=$('input[name="cbuild_name"]').val();
        var cstreet_no=$('input[name="cstreet_no"]').val();
        var cstreet_name=$('input[name="cstreet_name"]').val();
        var cstreet_suffix=$('select[name="cstreet_suffix"]').val();
        var csrch_post_code=$('input[name="csrch_post_code"]').val();
        var csrch_suburb=$('input[name="csrch_suburb"]').val();

        var contact_home_phone=$('input[name="contact_home_phone"]').val();
        var contact_work_phone=$('input[name="contact_work_phone"]').val();

        var contact_suburb_id = $('input[name="srch_subid"]').val();

        var first_name_deliv=$('input[name="first_name_deliv"]').val(first_name);
        var last_name_deliv=$('input[name="last_name_deliv"]').val(last_name);
        var deliv_email=$('input[name="deliv_email"]').val(email);
        var deliv_mobile=$('input[name="deliv_mobile"]').val(mobile);

        var build_type_deliv=$('select[name="build_type1"]').val(cbuild_type);
        var bname_deliv=$('input[name="build_name1"]').val(cbuild_name);
        var streetno_deliv=$('input[name="street_no1"]').val(cstreet_no);
        var streetname_deliv=$('input[name="street_name1"]').val(cstreet_name);
        var streetsuffix_deliv=$('select[name="street_suffix1"]').val(cstreet_suffix);

        //var work_deliv=$('input[name="deliv_work_phone"]').val(phone_work);

        var deliv_home_phone=$('input[name="deliv_home_phone"]').val(contact_home_phone);
        var deliv_work_phone=$('input[name="deliv_work_phone"]').val(contact_work_phone);
        var deliv_suburb_id=$('input[name="srch_subid2"]').val(contact_suburb_id);

        ///////////////////////// Edit form ////////////////////////////////////
        var c_edit_build_no=$('input[name="build_no"]').val();
        var buildno_deliv=$('input[name="build_no1"]').val(c_edit_build_no);
        var c_edit_srch_post_code=$('input[name="srch_post_code"]').val();
        var postcode_deliv=$('input[name="srch_post_code2"]').val(c_edit_srch_post_code);
        var c_edit_srch_suburb=$('input[name="srch_suburb"]').val();
        var suburb_deliv=$('input[name="srch_suburb2"]').val(c_edit_srch_suburb);
        var c_edit_srch_subid=$('input[name="srch_subid"]').val();
        var srch_subid_deliv=$('input[name="srch_subid2"]').val(c_edit_srch_subid);

        //////////////////////////////////////////////////////////////////////////////

        var buildno_deliv=$('.build_no1').val(cbuild_no);


    }else{

        var first_name_deliv=$('input[name="first_name_deliv"]').val("");
        var last_name_deliv=$('input[name="last_name_deliv"]').val("");
        var deliv_email=$('input[name="deliv_email"]').val("");
        var deliv_mobile=$('input[name="deliv_mobile"]').val("");
        var buildno_deliv=$('input[name="build_no1"]').val("");
        var build_type_deliv=$('select[name="build_type1"]').val("");
        var bname_deliv=$('input[name="build_name1"]').val("");
        var streetno_deliv=$('input[name="street_no1"]').val("");
        var streetname_deliv=$('input[name="street_name1"]').val("");
        var streetsuffix_deliv=$('select[name="street_suffix1"]').val("");
        var postcode_deliv=$('input[name="srch_post_code2"]').val("");
        var suburb_deliv=$('input[name="srch_suburb2"]').val("");
        var work_deliv=$('input[name="deliv_work_phone"]').val("");

    }
});






