function goto(site,title)
{
   var msg = confirm(title)
   if (msg) {window.location.href = site}
   else (null)
}
               
               
$(document).ready(function(){
    $('#select_1').on('click',function(){
        if(this.checked){
            $('.checkbox_1').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox_1').each(function(){
                this.checked = false;
            });
        }
    });
    
               
    $('.checkbox_1').on('click',function(){
        if($('.checkbox_1:checked').length == $('.checkbox').length){
            $('#select_1').prop('checked',true);
        }else{
            $('#select_1').prop('checked',false);
        }
    });

               
    $('#select_2').on('click',function(){
        if(this.checked){
            $('.checkbox_2').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox_2').each(function(){
                this.checked = false;
            });
        }
    });
    

    $('.checkbox_2').on('click',function(){
        if($('.checkbox_2:checked').length == $('.checkbox').length){
            $('#select_2').prop('checked',true);
        }else{
            $('#select_2').prop('checked',false);
        }
    });
});
