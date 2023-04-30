document.addEventListener('DOMContentLoaded', function() {
    const productArticleInput = document.getElementById('product-article');
    const productNameElement = document.getElementById('product-name');
    const productPriceElement = document.getElementById('product-price');
    const prodWrapperElement = document.querySelector('.js-prod-wrapper');
    const addToCartButton = document.getElementById('add-to-basket');
    const quantityInput = document.getElementById('product-quantity');

    productArticleInput.addEventListener('input', function() {
        let productArticle = productArticleInput.value;
        BX.ajax.runComponentAction(
            'OM:product-by-article',
            'getProduct',
            {
                mode: 'class',
                data: {
                    article: productArticle
                }
            }
        ).then(function(response) {
            if (response.data !== 'null') {
                let product = JSON.parse(response.data);
                productNameElement.textContent = product.NAME;
                productNameElement.setAttribute('data-prod-id', product.ID);
                productPriceElement.textContent = product.PRICE;
                prodWrapperElement.style.display = 'block';
            } else {
                productNameElement.textContent = '';
                productNameElement.setAttribute('data-prod-id', '');
                productPriceElement.textContent = '';
                prodWrapperElement.style.display = 'none';
            }
        });
    });
    addToCartButton.addEventListener('click', function() {
        BX.ajax.runComponentAction(
            'OM:product-by-article',
            'addToBasket',
            {
                mode: 'class',
                data: {
                    productId: productNameElement.getAttribute('data-prod-id'),
                    quantity: quantityInput.value,
                }
            }
        ).then(function() {
            BX.onCustomEvent('OnBasketChange');
        });
    });
});
