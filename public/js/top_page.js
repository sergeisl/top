/**
 * Created by Zver on 13.07.2017.
 */
var router = new HashRouter();

function open_modal(id) {
    let modals = document.getElementById(id);
    if(modals != undefined){
        document.body.style.overflowY = 'hidden';
        modals.classList.add('modal_visible');
    }
    return false;
}
function close_modal(id) {
    history.replaceState(3, "Title 2", "/");
    document.body.style.overflowY = 'auto';
    let modals = document.getElementById(id);
    modals.classList.remove('modal_visible');
}

router.add('m', function (params) {
    open_modal(params.id);
});

function page(page, cur) {
    $('.load_page').css({'display':'inline-flex'});
    $('#next_page_but').remove();
    $('#prev_page_but').remove();
    $.ajax({
        url: 'https://sp2all.ru/api/getSuppliers/?&page='+page+'&format=json',
        type: 'get',
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(data){
            console.log(data)
            if(data){
                var str = '';
                data.items.forEach(function(item){
                    var imgs1 = '';
                    item.imgs.forEach(function(img) {
                        console.log(img);
                        if (img[0] != "/images/noimg.gif") {
                            imgs1 += '<li><img src="https://sp2all.ru/' + img[0] + '"></li>';
                        }
                    });
                    var slider = '';
                    if(imgs1 != ''){
                        slider = '<ul class="bxslider">'+imgs1+'</ul>'
                    }
            str += '  ' +
                '<div class="row__col row__col_xs_12 row__col_sm_6 row__col_lg_3">' +
                    '<div class="item">  ' +
                        '<a href="'+page+'#m?id='+item.id+'" data-id="'+item.id+'" class="noLink">'+item.title+'</a>' +
                        '<br><br>' +
                        '<div>' +
                            '<img src="https://sp2all.ru/'+item.imgs[0][0]+'" class="imgs">' +
                        '</div>' +
                        '<div class="modal modal_theme_grey " id="'+item.id+'">'+
                            '<div class="modal__wrapper">'+
                                '<div class="modal__dialog">' +
                                    '<div class="modal__close" onclick="return close_modal('+item.id+');"></div>'+slider+

                                    ' <p style="">'+item.desc+'</p>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>' +
                '</div>'

                });
                if(cur){
                    $('.row').append(str).appendTo('.row');
                } else {
                    $('.row').prepend(str).appendTo('.row');
                }
            }
            $('.load_page').css({'display':'none'});

            $('.next_page')
                .append('<a href="'+(pagen+1)+'" onclick="pagen++;page(pagen, true);return false;" id="next_page_but">Ещё</a>')
                .appendTo('.next_page');

            if( parseInt(pagep)>=2 ) {
                $('.prev_page')
                    .append('<a href="'+(pagep-1)+'" onclick="pagep--;page(pagep, false);return false;" id="prev_page_but">Ещё</a>')
                    .appendTo('.prev_page');
            }
            $('.bxslider').bxSlider({
                minSlides: 1,
                maxSlides: 4,
                slideWidth: 200,
                slideMargin: 10
            });
        }
    });

}
function success(data) {
    console.log(data);
}
function get_reviews(id) {

    $.post('http://top.local/get',
        {
            _cookie: $.cookie('_PHPSESSID'),
            id:id
        }
        ,success, 'json');
}
$('body').on('click','.noLink',(e)=>{
    e.preventDefault();
    history.replaceState(3, "Title", e.target.href);
    open_modal($(e.target).data('id'));
});

$('body').on('click','.reviews',(e)=>{
    e.preventDefault();
    get_reviews($(e.target).data('id'));
});