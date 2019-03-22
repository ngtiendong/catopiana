/**
 * Initial when load page
 */

var list_test_finished = []
var testing_data

if (localStorage.getItem('testing')) {
    // localStorage.removeItem('testing')
    var testing = localStorage.getItem('testing');
    testing_data = JSON.parse(testing);
    var test_level = testing_data.level

    //List test finish
    testing_data.question.forEach(function(value, index) {
        list_test_finished.push(parseInt(value.type))
    })
}

$(function(){
    console.log("data", testing_data);
    if (list_test_finished.length > 0) {
        $('a.test-item').each(function(index){
            var this_type = $(this).data('type')
            // console.log (this_type, list_test_finished)
            if (list_test_finished.indexOf(this_type) > -1){
                $(this).css('opacity',0.4)
            }
        })
    }

    // displayTestUnFinishedAfterSubmit()
});

/**
 * Event to click button add to cart
 * @param product_id
 * @param product_name
 * @param quantity
 * @param price
 * @param image
 * @returns {boolean}
 */
function addToCart(product_id, product_name, quantity, price ,image) {
    //Check ho tro storage
    if (typeof(Storage) !== "undefined") {
        var html = "";
        var list_product = [];
        var new_product = {};
        var cart = {};
        quantity = parseInt(quantity);
        price = parseFloat(price);

        //Check cart existed
        if (typeof localStorage.cart !== 'undefined') {
            var cart_data = localStorage.getItem('cart');

            cart = JSON.parse(cart_data);
            list_product = cart.products;


            //Check exist of product, If existed, flag == 1: existed
            var flag = 0;
            for (var i = 1; i <= list_product.length; i++) {
                if(list_product[i-1]['id'] === product_id) {
                    flag = i;
                }
            }
            //If existed
            if (flag !== 0) {
                //Edit html
                html = ProductInCard(product_id,product_name,parseInt(list_product[flag-1].quantity) + quantity,price,image);
                list_product[flag-1].html = html;

                //Edit array product
                list_product[flag-1].quantity += quantity;
                list_product[flag-1].price = parseInt(list_product[flag-1].quantity) * price;


            }
            //If not existed
            else {
                // Edit html
                html = ProductInCard(product_id, product_name, quantity, price, image);
                // Edit array product
                new_product = {
                    'id' : product_id,
                    'name': product_name,
                    'image': image,
                    'quantity': quantity,
                    'original_price': price,
                    'price': ((price) * (quantity)),
                    'html': html
                };

                list_product.push(new_product);
            }



        }
        // If not existed => create cart
        else {
            //Html
            html = ProductInCard(product_id, product_name, quantity, price, image);

            //Products
            new_product = {
                'id' : product_id,
                'name': product_name,
                'image': image,
                'original_price': price,
                'price': ((price) * (quantity)),
                'quantity': quantity,
                'html': html
            };

            list_product.push(new_product);

        }



        if ($(window).width() > 1024) {
            var notify = "Bạn đã thêm "+quantity+" sản phẩm "+product_name+" vào giỏ hàng ";

        } else {
            var notify = "Thêm sản phẩm thành công";

        }
        $.notify(notify,{
            className: "success",
            globalPosition: "bottom center",
        });

        var left = ($(window).width()-$('.notifyjs-corner').width())/2;
        console.log(left);
        $('.notifyjs-corner').css('left',left);

        //All html to append front-end
        saveData(list_product,cart);

        return false;


    } else {
        document.write('Trình duyệt của bạn không hỗ trợ local storage');
    }
}

/**
 * HTML of each product row in cart
 * @param product_id
 * @param product_name
 * @param quantity
 * @param price
 * @param image
 * @returns {string}
 * @constructor
 */
function ProductInCard(product_id,product_name,quantity, price,image)
{
    var html = '<li class="list-product-in-cart">' +
        '<div class="edgtf-item-image-holder">' +
        '<a itemprop="url" href="#">'+
        '<img width="180" height="180" src="'+ image +'" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="m">' +
        '</a></div>' +

        '<div class="edgtf-item-info-holder">' +
        '<p itemprop="name" class="edgtf-product-title">' +
        '<a href="/product/detail/'+product_id+'" class="name-product-in-cart">'+product_name+'</a>' +
        '</p>' +
        '<span class="edgtf-quantity">'+quantity+' x  </span>' +
        '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span>&nbsp'+  price.toLocaleString()+'</span>' +
        '<a href="" title="Remove this item" class="remove" onclick="return deleteProduct(this,'+product_id+')"><span>x</span></a>' +
        '</div>' +

        '</li>';


    return html;
}

/**
 * HTML footer of cart
 * @param total_money
 * @returns {string}
 */
function inforCart(total_money) {
    var html = '<li class="edgtf-cart-bottom">' +
        '<div class="edgtf-subtotal-holder clearfix" style="margin: 0 0 10px">' +
        '<span class="edgtf-total">Tổng: </span>' +
        '<span class="edgtf-total-amount">' +
        '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span>'+total_money.toLocaleString()+'</span></span>' +
        '</div>' +
        '<div class="edgtf-subtotal-holder clearfix" style="margin: 10px 0px 0;padding: 5px 24px;">' +
        '<div><a href="/cart" style="font-size: 11px" class="edgtf-view-cart" data-title="VIEW CART">CHI TIẾT GIỎ HÀNG' +
        '</a></div>' +
        '<div style="float: right"><a href="/checkout" style="font-size: 11px; " class="edgtf-checkout" data-title="CHECKOUT">THANH TOÁN' +
        '</a></div>' +
        '</div>' +
        '</li>'
    // '</ul>';

    return html;
}


/**
 * Delete row in card
 * @param _this
 * @param product_id
 * @returns {boolean}
 */
function deleteProduct(_this,product_id) {
    if(confirm('Bạn có muốn xoá sản phẩm này?')) {
        //Delete front end
        // $(_this).closest('.list-product-in-cart').remove();

        //Delete in local storage
        var cart_data = localStorage.getItem('cart');
        var cart = JSON.parse(cart_data);
        var list_product = cart.products;

        var flag = -1;
        for (var i=0; i<list_product.length; i++) {
            if(list_product[i].id == product_id) {
                flag = i;
                break;
            }
        }

        list_product.splice(i,1);
        saveData(list_product,cart);

        //Cart page change html
        drawInCartPage(list_product,cart);

    }


    return false;
}

/**
 * Save to local storage and change html of cart
 * @param list_product
 * @param cart
 */
function saveData(list_product,cart) {
    var total_html = "";
    var total_money = 0;
    for(var j = 0; j < list_product.length; j++) {
        total_html += list_product[j].html;
        total_money += list_product[j].price;
    }

    total_html += inforCart(total_money);

    cart.products = list_product;
    cart.html = total_html;
    cart.money = total_money;


    localStorage.setItem('cart', JSON.stringify(cart));

    $('#number-product-in-card').text(list_product.length);
    $('#cart-information').replaceWith('<ul id="cart-information">'+total_html+'</ul>');



}

function drawInCartPage(list_product,cart){

    var html = "";

    $.each(list_product,function(index,val){

        html += '<tr class="woocommerce-cart-form__cart-item cart_item">' +
            '<td class="product-remove">' +
            '<a href="" class="remove" onclick="return deleteProduct(this,'+val.id+')">×</a>' +
            '</td>' +
            '<td class="product-thumbnail">' +
            '<a href="/product/detail/'+val.id+'">' +
            '<img width="180" height="180" src="'+val.image+'" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image"></a>' +
            '</td>' +
            '<td class="product-name" data-title="Product">' +
            '<a href="/product/detail/'+val.id+'">'+val.name+'</a>' +
            '</td>' +
            '<td class="product-price" data-title="Price">' +
            '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span>'+val.original_price.toLocaleString()+'</span>' +
            '</td>' +
            '<td class="product-quantity" data-title="Quantity">' +
            '<div class="edgtf-quantity-buttons quantity">' +
            '<label class="edgtf-quantity-label" for="quantity_5a7a5bf4601dd">Số lượng</label>' +
            '<span class="edgtf-quantity-minus ion-arrow-left-b"></span>' +
            '<input type="text" data-step="1" data-min="1" data-max="" value="'+val.quantity+'" title="Qty" class="input-text qty text edgtf-quantity-input" size="4" pattern="[0-9]*" inputmode="numeric" onchange="return changeQuantityInCart(this,'+val.id+',\''+val.name+'\','+val.original_price+','+val.quantity+',\''+val.image+'\')">' +
            '<span class="edgtf-quantity-plus ion-arrow-right-b"></span>' +
            '</div>' +
            '</td>' +
            '<td class="product-subtotal" data-title="Total">' +
            '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span>'+val.price.toLocaleString()+'</span>' +
            '</td>' +
            '</tr>'
    } )

    $('#cart-total-amount').text(cart.money.toLocaleString());
    $('#cart-table').replaceWith('<tbody id="cart-table">'+html+' </tbody>');

}

function drawInCheckout(list_product,cart) {
    var html = "";

    $.each(list_product,function(index,val){
        html += '<tr class="cart_item">' +
            '<td class="product">'+val.name +
            '<strong class="product-quantity">&nbsp;× '+val.quantity+'</strong>' +
            '</td>' +
            '<td class="total">' +
            '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span>'+val.price.toLocaleString()+'</span>' +
            '</td>' +
            '</tr>'+
            '<input name="id[]" class="product_id" value="'+val.id+'" type="hidden">'+
            '<input name="quantity[]" class="product_quantity" value="'+val.quantity+'" type="hidden">'
        ;
    } )

    $('#drawInCheckout').replaceWith('<tbody id="drawInCheckout">'+html+' </tbody>');
    $('#total-checkout').text(cart.money.toLocaleString());
}

function changeQuantityInCart (_this,product_id,product_name,product_original_price,product_quantity,product_image) {

    var cart_data = localStorage.getItem('cart');
    var cart = JSON.parse(cart_data);
    var list_product = cart.products;

    var tr = $(_this).closest('.cart_item');
    var newQuantity = $(_this).val();
    var newTotalPrice = parseInt(newQuantity)*parseFloat(product_original_price);

    //Change html

    $($(tr).find('.product-subtotal > span.woocommerce-Price-amount')).text(newTotalPrice.toLocaleString());

    //Change localstorage and cart header html
    for (var i=0; i<list_product.length; i++) {
        if(list_product[i].id == product_id) {
            list_product[i].quantity = parseInt(newQuantity);
            list_product[i].price = newTotalPrice;

            html = ProductInCard(product_id,product_name,newQuantity,product_original_price,product_image);
            list_product[i].html = html;
            break;
        }
    }

    saveData(list_product,cart);
    var cart_data_update = localStorage.getItem('cart');
    var cart_update = JSON.parse(cart_data_update);
    $('#cart-total-amount').text(cart_update.money.toLocaleString());

}

$(document).ready(function(){
    $('div.edgtf-btn-holders-final').css('position','relative')
})
