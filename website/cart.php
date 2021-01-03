<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>A-Store</title>
    <!-- Favicon-->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Plugins Core Css -->
    <link href="assets/css/app.min.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- You can choose a theme from css/styles instead of get all themes -->
    <link href="assets/css/styles/all-themes.css" rel="stylesheet" />
    <script src="assets/js/jquery.min.js"></script>
    <!-- <script src="assets/js/login.js"></script>  -->
    <script>
        $(document).ready(function()
        {
            $.ajax({
                type:"GET",
                url:'endpoints/get_cart.php',
                data:{},
                success:function(obj)
                {   
                    obj = JSON.parse(obj);
                    console.log(obj);
                    var total = 0;
                    var carts = `<div class="ibox-title">
                                                <span class="pull-right">(<strong>`+obj['data'].length+`</strong>) items</span>
                                                <h5>Items in your cart</h5>
                                            </div>`;
                    for(i=0;i<obj['data'].length;i++)
                    {
                        var price = parseInt(obj['data'][i]['price']);
                        var quantity = parseInt(obj['data'][i]['quantity']);
                        carts += `<div class="ibox-content">
                                                <div class="table-responsive">
                                                    <table class="table shoping-cart-table">
                                                        <tbody id="cart_table">
                                                            <tr>
                                                                <td>
                                                                    <div class="cart-product-imitation">
                                                                        <img src="assets/images/`+obj['data'][i]['image']+`"
                                                                            alt="">
                                                                    </div>
                                                                </td>
                                                                <td class="desc">
                                                                    <h3>
                                                                        <div class="text-navy">`+obj['data'][i]['name']+`</div>
                                                                    </h3>
                                                                   
                                                                   
                                                                    <div class="m-b-none">
                                                                        <p>Guarenteed one-day delivery | Free</p>
                                                                    </div>
                                                                    <div class="m-t-sm">
                                                                       
                                                                        <span class="text-muted" onclick="remove(`+obj['data'][i]['product_id']+`)" ><i
                                                                                class="fa fa-trash"></i>
                                                                            Remove item</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    ₹`+price+`.00
                                                                    <span
                                                                        class="small text-muted text-price">₹`+(price*1.15).toFixed(2)+`</span>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="`+quantity+`">
                                                                </td>
                                                                <td>
                                                                    <h4>
                                                                        ₹`+price*quantity+`.00
                                                                    </h4>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>`
                                            total+=price*quantity;
                    }
                    carts+=`<div class="ibox-content">
                                                <button type="button" onclick="check_address(`+total+`)"
                                                    class="btn btn-info btn-border-radius waves-effect pull-right"><i
                                                        class="fa fa fa-shopping-cart"></i> Checkout</button>
                                                <button type="button" onclick="(window.location.href='home.html')"
                                                    class="btn btn-danger btn-border-radius waves-effect"><i
                                                        class="fa fa-arrow-left"></i> Continue Shopping</button>
                                            </div>`;
                    var checkout1 =` <button type="button" onclick="check_address(`+total+`)"
                                    class="btn btn-info btn-border-radius waves-effect pull-right"><i
                                        class="fa fa fa-shopping-cart"></i> Checkout</button>` 
                    $('#cart-container').html(carts);
                    $('#checkout1').html(checkout1);
                    $('#cart_total').html('₹'+total+'.00');
                }
            })
            
        })
        function remove(product_id)
        {
            $.ajax({
                type:'POST',
                url:"endpoints/remove.php",
                data:{'product_id':product_id},
                success:function(obj)
                {
                    console.log(obj);
                    window.location.reload();   
                }
            })
        }
        function check_address(total)
        {
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
                else{
                    $('#form_price').val(parseFloat(total));
                    $('#payment-form').submit();
                }
            }
            })
        }
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
                            swal(
                                {
                                  title: "Address updates",
                                  text: "",
                                  type: "success ",
                                  showCancelButton: false,
                                  confirmButtonColor: "#DD6B55",
                                  confirmButtonText: "Yes, delete it!",
                                  closeOnConfirm: false
                                },
                                function() {
                                  window.location.reload();
                                }
                              );
                        }
                    }

                })
            }
        }
    </script>

</head>

<body>
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="../../assets/images/loading.png" alt="admin">
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#" onClick="return false;" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="#" onClick="return false;" class="bars"></a>
                <a class="navbar-brand" href="../../index.html">
                    <img src="../../assets/images/logo.png" alt="" />
                    <span class="logo-name">A-Store</span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="#" onClick="return false;" class="sidemenu-collapse">
                            <i data-feather="align-justify"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <!-- Full Screen Button -->
                    <li class="fullscreen">
                        <a href="javascript:;" class="fullscreen-btn">
                            <i data-feather="maximize"></i>
                        </a>
                    </li>
                    <!-- #END# Full Screen Button -->
                    <!-- #START# Notifications-->
                    <li class="dropdown">
                        <a href="#" onClick="return false;" class="dropdown-toggle" data-toggle="dropdown"
                            role="button">
                            <i data-feather="bell"></i>
                            <span class="notify"></span>
                            <span class="heartbeat"></span>
                        </a>
                        <ul class="dropdown-menu pullDown">
                            <li class="header">Orders</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="#" onClick="return false;">
                                            <span class="table-img msg-user">
                                                <img src="assets/images/user/user1.jpg" alt="">
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">Apple Iphone</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> 14 mins ago
                                                </span>

                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onClick="return false;">
                                            <span class="table-img msg-user">
                                                <img src="assets/images/user/user1.jpg" alt="">
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">Apple Iphone</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> 14 mins ago
                                                </span>

                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onClick="return false;">
                                            <span class="table-img msg-user">
                                                <img src="assets/images/user/user3.jpg" alt="">
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">Apple Iphone</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onClick="return false;">
                                            <span class="table-img msg-user">
                                                <img src="assets/images/user/user4.jpg" alt="">
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">Apple Iphone</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> 2 hours ago
                                                </span>

                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onClick="return false;">
                                            <span class="table-img msg-user">
                                                <img src="assets/images/user/user5.jpg" alt="">
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">Apple Iphone</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> 4 hours ago
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onClick="return false;">
                                            <span class="table-img msg-user">
                                                <img src="assets/images/user/user6.jpg" alt="">
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">Apple Iphone</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onClick="return false;">
                                            <span class="table-img msg-user">
                                                <img src="assets/images/user/user7.jpg" alt="">
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">Apple Iphone</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> Yesterday
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#" onClick="return false;">View All Orders</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Notifications-->

                    <!-- #END# Tasks -->
                    <li class="user_profile">
                        <a href="#" onClick="return false;" class="js-right-sidebar" data-close="true">
                            <i data-feather="settings"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <div>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">

            <div class="menu">
                <ul class="list">
                    <li class="header active"></li>
                 


                </ul>
            </div>

        </aside>

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style">
                            <li>
                                <h4 class="page-title">Cart</h4>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-body ">
                            <div class="wrapper wrapper-content">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="ibox" id="cart-container">
                                            <div class="ibox-title">
                                                <span class="pull-right">(<strong>3</strong>) items</span>
                                                <h5>Items in your cart</h5>
                                            </div>
                                            
                                            <div class="ibox-content">
                                                <button type="button"
                                                    class="btn btn-info btn-border-radius waves-effect pull-right"><i
                                                        class="fa fa fa-shopping-cart"></i> Checkout</button>
                                                <button type="button"
                                                    class="btn btn-danger btn-border-radius waves-effect"><i
                                                        class="fa fa-arrow-left"></i> Continue Shopping</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="ibox">
                                            <div class="ibox-title">
                                                <h5>Cart Summary</h5>
                                            </div>
                                            <div class="ibox-content">
                                                <span>
                                                    Total
                                                </span>
                                                <h2 class="font-bold" id="cart_total">
                                                   
                                                </h2>
                                                <hr>
                                                <div class="m-t-sm">
                                                    <div class="pull-left m-r-10" id="checkout1">
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ibox">
                                            <div class="ibox-title">
                                                <h5>Support</h5>
                                            </div>
                                            <div class="ibox-content text-center">
                                                <h3><i class="fa fa-phone"></i> 9999999999</h3>
                                                <span class="small">
                                                    Please contact with us if you have any questions. We are available
                                                    24h.
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <label for="email_address1">Address</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" id="address"
                                class="form-control"
                                placeholder="Enter your address">
                        </div>
                    </div>
                    <label for="password">phone number</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" id="phone"
                                class="form-control"
                                placeholder="Enter your phone no">
                        </div>
                    </div>
                  
                    <br>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-info waves-effect" onclick="saveaddress()">Save</button>
                
            </div>
        </div>
    </div>
</div>
<form id="payment-form" method="post" action="transaction.php">
    <input type="hidden" name="price" id="form_price" value="">
    <!-- <input type="hidden" name="uname" value=""> -->
    <!-- <input type="hidden" name="uemail" value=">"> -->
</form>
    <script src="assets/js/app.min.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/admin.js"></script>
</body>

</html>