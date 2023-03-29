

if (document.querySelector('#log_link').value=='')
{
    document.querySelector('#btn_registration').style.opacity=1;
}
else
{
    document.querySelector('#btn_registration').style.opacity=0;
}

function btn_get_reset_email()
{
    let input_email = $('#input_email').val()
    if (jQuery.trim(input_email).length > 0)
    {
        var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            if (testEmail.test(input_email))
            {
                $('#lbl_vld_email').css('display', 'none');
                $('#lbl_vld_invalid_email').css('display', 'none');


                $('.waitmeDiv').waitMe({
                    effect : 'progressBar',
                    text : '',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    onClose : function() {}
                    });

                let base_url = "https://techub.dost.gov.ph/resetpassword_email";

                $.ajax({
                    url: base_url,
                    type: "POST",
                    data: 
                    {
                        input_email : input_email
                    },
                    success: function(data)
                    {
                        if (data==0)
                        {
                            $(".waitmeDiv").waitMe("hide");
                            $('#lbl_vld_email').css('display', 'none');
                            $('#lbl_vld_invalid_email').css('display', 'none');
                            $('#lbl_vld_no_record_email').css('display', 'block');
                        }
                        else
                        {
                            $(".waitmeDiv").waitMe("hide");
                            Swal.fire({
                                // icon: 'warning',
                                // title: 'Error',
                                width: 650,
                                text: 'The link to reset your password has been sent to your email address.',
                                showConfirmButton: true,
                                customClass: {
                                    confirmButton: 'my-confirm-button-class'
                                },
                            }).then(function() {
                                        window.location.replace("https://techub.dost.gov.ph/login");
                                        });  
                        } 
                    }
                });
            }
            else
            {
                $('#lbl_vld_invalid_email').css('display', 'block');
                $('#lbl_vld_email').css('display', 'none');
            }
    }
    else
    {
        $('#lbl_vld_invalid_email').css('display', 'none');
        $('#lbl_vld_email').css('display', 'block');
    }
}


function open_forgot_password_modal()
{
    $('#forgot_password_modal').modal('show');
}

$("#login_form").submit(() => {

let base_url = "https://techub.dost.gov.ph/login_ci";
var form= $("#login_form");
var log_link= $("#log_link").val();

$.ajax({
    url: base_url,
    type: "POST",
    // dataType: "json",
    data: form.serialize(),
    success: function(data)
    {
            Swal.fire({
            icon: 'success',
            title: 'Done',
            text: 'Login successfully!',
            showConfirmButton: false,
            timer: 1800
            }).then(function() {
                if (log_link=='')
                {
                    window.location.replace("https://techub.dost.gov.ph/");   
                }
                else
                {
                    window.location.replace("https://techub.dost.gov.ph/details/"+log_link);
                }
                });   
        
    }

});

});

    function nextpage()
    {
        
        $("#reg_form1").fadeOut(500, function() {
            $(this).html($('#reg_form2').html()).fadeIn(500);
        });

        console.log($('#reg_form2').html());
    }