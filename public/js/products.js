$(document).ready(function () {
        var apiUrlNew = "/v1/category/11/products";
        var apiUrlSale = "/v1/category/27/products";
        var newProductContainer = $('.new-slider');
        var saleProductContainer = $('.sale-slider');
        var langCodeFromUrl = window.location.pathname.split('/')[1];

        $.ajax({
            type: "GET",
            headers: {'X-Store-Code': langCodeFromUrl},
            contentType: "application/json",
            dataType: "json",
            url: apiUrlNew
        })
            .done(function (response) {
                var productData = response.data.products.data;

                var newSliderColumnBlock = '';
                $.each(productData, function (ni, newitem) {
                    var newImagePath = newitem.small_image ? newitem.small_image : '/placeholder/default/small_image.jpg';
                    newSliderColumnBlock = '' +
                        '<div class="column column-block">' +
                        '<div class="row">' +
                        '<div class="small-2 large-5 columns">' +
                        '<a href="/' + langCodeFromUrl + '/' + newitem.url_key + '" class="product photo product-item-photo" tabindex="-1">' +
                        '<span class="product-image-container" style="width:220px;">' +
                        '<span class="product-image-wrapper" style="padding-bottom: 100%;">' +
                        '<img class="product-image-photo" src="/images' + newImagePath + '" width="220" height="220" alt="' + newitem.small_image_label + '" />' +
                        '</span>' +
                        '</span>' +
                        '<div class="sale-sticker-wrap"></div> ' +
                        '</a>' +
                        '</div>' +
                        '<div class="small-2 large-7 columns">' +
                        '<div class="product details product-item-details">' +
                        '<h2 class="product name product-item-name">' + newitem.name + '</h2>' +
                        '<div class="product-item-inner">' +
                        '<div class="product description product-item-description">' +
                        '<p>' + newitem.description + '</p>' +
                        '</div>' +
                        '</div>' +
                        '<a href="/' + langCodeFromUrl + '/' + newitem.url_key + '"  class="action more primary">Mehr erfahren</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    newProductContainer.append(newSliderColumnBlock);
                });

            })
            .fail(function (jqXHR, textStatus) {
                //alert("error" + textStatus);
            })
            .always(function () {
                //alert("complete");
            });

        $.ajax({
            type: "GET",
            headers: {'X-Store-Code': langCodeFromUrl},
            contentType: "application/json",
            dataType: "json",
            url: apiUrlSale
        })
            .done(function (response) {
                var productData = response.data.products.data;

                var saleSliderColumnBlock = '';
                $.each(productData, function (si, saleitem) {
                    var saleImagePath = saleitem.small_image ? saleitem.small_image : '/placeholder/default/small_image.jpg';
                    saleSliderColumnBlock = '<div class="column column-block">' +
                        '<div class="item product product-item">' +
                        '<div class="product-item-info" data-container="product-grid">' +
                        '<a href="/' + langCodeFromUrl + '/' + saleitem.url_key + '" class="product photo product-item-photo" tabindex="-1">' +
                        '<span class="product-image-container" style="width:220px;">' +
                        '<span class="product-image-wrapper" style="padding-bottom: 100%;">' +
                        '<img class="product-image-photo" src="/images' + saleImagePath + '" width="220" height="220" alt="' + saleitem.small_image_label + '">' +
                        '</span>' +
                        '</span>' +
                        '<div class="sale-sticker-wrap"></div>    ' +
                        '</a>' +
                        '<div class="product details product-item-details">' +
                        '<h2 class="product name product-item-name">' + saleitem.name + '</h2>' +
                        '<div class="product-item-inner">' +
                        '</div>' +
                        '<div class="price-box price-final_price" data-role="priceBox" data-product-id="2868">' +
                        '<div class="price-box" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">' +
                        '<p class="minimal-price">' +
                        '<span class="price-label">ab </span>' +
                        '<span class="price-container tax weee">' +
                        '<span data-price-amount="' + saleitem.price.toFixed(2) + '" data-price-type="" class="price-wrapper ">' +
                        '<span class="price">CHF&nbsp;' + saleitem.price.toFixed(2) + '</span>' +
                        '</span>' +
                        '</span>' +
                        '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    saleProductContainer.append(saleSliderColumnBlock);
                });

            })
            .fail(function (jqXHR, textStatus) {
                //alert("error" + textStatus);
            })
            .always(function () {
                //alert("complete");
            });

    }
);