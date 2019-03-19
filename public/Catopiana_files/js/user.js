// var requestUrl = "http://localhost/cat/wp-json/acf/v3/cat_user";
var requestUrl = "http://catopiana.com/wp-json/acf/v3/cat_user";

var user = [];

fetch(requestUrl).then(response => {
    return response.json();
}).then(data => {
// Work with JSON data here
    data.forEach(u => {
        let us = {};
        us['username'] = u.acf.username;
        us['userpass'] = u.acf.userpass;
        user.push(us);
    });
}).catch(err => {
// Do something for an error here

});
console.log(user);
$(document).on('click', '#submitLog', function() {
    for(let i=0; i<user.length; i++) {
        if ($('.logname').val() == user[i].username) {
            if ($('.logpass').val() == user[i].userpass) {
                $('body').removeClass('overlay');
                $('#signin').removeClass('active');
                localStorage.setItem('username', user[i].username);
                
                location.reload();
            }
            else {
                $('.warning').css('opacity', '1');
                localStorage.removeItem('username');
            }
        }
    }
});

$(document).ready(function() {
    // $("a[href*='#']:not([href='#])").click(function() {
    //     let target = $(this).attr("href");
    //     $('html,body').stop().animate({
    //         scrollTop: $(target).offset().top
    //     }, 1000);
    //     event.preventDefault();
    // });
});