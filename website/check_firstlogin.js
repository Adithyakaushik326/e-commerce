$(document).ready(function(){
    if (localStorage.getItem("user") === null) {
        window.location.href = 'index.html';
        }
       
    $.ajax({
        type:'GET',
        url:'endpoints/check_firstlogin.php',
        data:{},
        success:function(obj)
        {
            obj= JSON.parse(obj);
            console.log(obj)
            if(obj['data']=="1")
            {
               
                $('#exampleModal').modal("show");
            }
        }
    })
})
function saveaddress()
        {
            var address = $('#address').val();
            var phone = $('#phone').val();
            if(address=='')
            {
                alert('address required');
            }
            else if(phone=='')
            {
                alert('phone required');
            }
            if(address!='' && phone !='')
            {        
                $.ajax({
                    type:"POST",
                    url : "endpoints/update_address.php",
                    data:{'address':address,'phone':phone},
                    success:function(obj)
                    {
                        
                        obj = JSON.parse(obj);
                        console.log(obj);
                        if(obj['status_code']==200)
                        {
                            console.log('hello');   
                            $('#exampleModal').modal("hide");
                        }
                    }

                })
            }
        }