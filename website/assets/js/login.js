$(document).ready(function(){
    check_client_session();
})
function check_client_session() {
    $.ajax({
        url: '../../website/endpoints/client_logged_in.php',
        type: "GET",
        success: function (ret_obj) {
            ret_obj = JSON.parse(ret_obj);
            if (ret_obj['status_code'] != 200) {
                window.location.href='index.html';
            }
        }
    });
}