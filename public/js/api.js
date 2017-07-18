/**
 * Created by Zver on 16.07.2017.
 */

/*login */
function login(data) {
    $.post('/login',
        {
            login:data.login ,
            password:data.password
        },success_login, 'json');
}

function success_login(data) {
    localStorage.setItem('login', data.login);
    $('.in').empty().html( '<a>'+data.login+'</a>');
    close_modal('login');
}

$(document).ready(()=>{
    $('.login').submit((e)=>{
        e.preventDefault();
        let data = {
            login: e.target[0].value,
            password: e.target[1].value
        };
        login(data);
    });
});

/*login end*/

function setProfile(data) {
    $.post('/setProfile',
        {
            login:data.login ,
            password:data.password,
            phone: data.phone,
            i_accept_the_rules: data.i_accept_the_rules
        },success_setProfile, 'json');
}

function success_setProfile(data) {
    localStorage.setItem('id', data.id);
    $('.in').empty().html( '<a>'+data.login+'</a>');
    close_modal('setProfile');
}

$(document).ready(()=>{
    $('.setProfile').submit((e)=>{
        e.preventDefault();
        let data = {
            phone: e.target[0].value,
            login: e.target[1].value,
            password: e.target[2].value,
            i_accept_the_rules:e.target[3].value
        };
        setProfile(data);
    });
});


function get_reviews(id) {
    $.post('/get',
        {
            _cookie: $.cookie('_PHPSESSID'),
            id:id
        },(data)=>{success(data,id);}
        , 'json');
}
var reviews_empty = true;

function success(data,id) {
    let class_elem = '.reviews_content'+id;
    if(data && reviews_empty){
        var str_reviews = '';
        data.reviews.forEach(function(item) {
            str_reviews +='<br><li><b>'+item.user.login+'</b> <i>'+item.added_date+'</i><br>'+item.response+'</li>';
        });
        $(class_elem).prepend(str_reviews).appendTo(class_elem);
        reviews_empty = false;
    }

}