$(document).ready(function(){
    $.ajax({
        type:'GET',
        url:'endpoints/get_aside.php',
        data:{},
        success:function(obj)
        {
            obj=JSON.parse(obj);
            console.log(obj);
            var aside = ` <li class="header active"></li>`;
            for(i=0;i<obj['data'].length;i++)
            {
                aside+=`<li>
                <a href="#" onClick="return false;" class="menu-toggle">
                    <i class="
                    fas fa-ambulance"></i>
                    <span onclick="cat(`+obj['data'][i]['cat_id']+`)">`+obj['data'][i]['name']+`</span>
                </a><ul class="ml-menu">`;
                for(j=0;j<obj['data'][i]['sub'].length;j++)
                {
                    aside+=`<li>
                    <a href="#" onclick="sub(`+obj['data'][i]['sub'][j]['sub_id']+`)">`+obj['data'][i]['sub'][j]['name']+`</a>
                </li>`
                }
                aside+=`
                </ul>
            </li>`;
            }
            $('#aside_list').html(aside);
            $.MyAdmin.leftSideBar.activate();
        }
    
    });
           
})

function cat(cat_id)
        {
            localStorage.removeItem('cat_id');
            localStorage.setItem('cat_id',cat_id);
            localStorage.removeItem('sub_id');
            window.location.href='home.html';

        }
function sub(sub_id)
{
    localStorage.removeItem('sub_id');
    localStorage.removeItem('cat_id');
    localStorage.setItem('sub_id',sub_id);
    window.location.href='home.html';
}