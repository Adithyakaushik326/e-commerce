function open_login_modal() {
    $('#login-modal').modal('show');
}

function open_sign_up_modal() {
    $('#signup-modal').modal('show');
}
function check_signup(first_name, last_name, email_id, password, re_password, phone_no, address) {
    var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    var phonenoformat = /^\d{10}$/;
    if (first_name == "") {
        alert("Please enter Firstname");
        return false;
    }
    if (last_name == "") {
        alert("Please enter Lastname");
        return false;
    }
    if(email_id == ""){
        alert("Please enter Email ID");
        return false;
    }
    if (!email_id.match(mailformat)) {
        alert("Please enter valid Email ID");
        return false;
    }
    if(password == ""){
        alert("Please enter Password");
        return false;
    }
    if (password != re_password) {
        alert("Passwords entered don't match");
        return false;
    }
    if (phone_no == "") {
        alert("Please enter Phone Number");
        return false;
    }
    if (phone_no.match(phonenoformat)) {
        alert("Enter phone number in proper format");
        return false;
    }
    if(address == ""){
        alert('Please enter proper address');
        return false;
    }
    return true;
}

function signup_user() {
    first_name = $('#signup-user-firstname').val();
    last_name = $('#signup-user-lastname').val();
    email_id = $('#signup-email-id').val();
    password = $('#signup-password').val();
    re_password = $('#signup-re-password').val();
    phone_no = $('#signup-phone-no').val();
    address = $('#signup-address').val();
    check_signup_flag = check_signup(first_name, last_name, email_id, password, re_password, phone_no, address);
    console.log(check_signup_flag);
    if(check_signup_flag == true){
        $.ajax({
            url: 'endpoints/post_signup.php',
            type: "POST",
            data:{
                'first_name':  first_name,
                'last_name': last_name,
                'email_id': email_id,
                'password': password,
                'phone_no': phone_no,
                'address': address
            },
            success: function(obj){
                if(obj == "200"){
                    $('.logged-in-user').text(first_name + " " + last_name);
                    $('.logged-in-container').removeClass('display-none');
                    $('.log-in-container').addClass('display-none');
                    $('#signup-modal').modal('hide');
                    // $('#signup-modal').modal('hide');
                    // $('#login-modal').modal('show');
                }
                else{
                    alert(obj);
                }
            },
            error: function(err){
                console.log("Error"+err);
                alert(err);
            }
        });
    }
}
