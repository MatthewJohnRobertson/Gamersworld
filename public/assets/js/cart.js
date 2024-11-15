document.querySelectorAll('.add-to-cart').forEach(button =>
{
    button.addEventListener('click', function ()
    {
        const productId = this.dataset.productId;
        const quantityInput = document.querySelector('input[name="quantity"]');
        const quantity = quantityInput ? quantityInput.value : 1;

        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Create the payload
        const payload = {
            product_id: productId,
            quantity: parseInt(quantity)
        };

        // Use the absolute URL
        fetch('/5ewd/GAMERSWORLD/public/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
            .then(response =>
            {
                if (!response.ok)
                {
                    return response.text().then(text =>
                    {
                        throw new Error(text || `HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data =>
            {
                if (data.success)
                {
                    alert('Product added to cart successfully!');
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount)
                    {
                        cartCount.textContent = data.cartCount;
                    }
                } else
                {
                    throw new Error(data.message || 'Error adding to cart');
                }
            })
            .catch(error =>
            {
                console.error('Error:', error);
                alert(error.message || 'Error adding product to cart');
            })
            .finally(() =>
            {
                this.textContent = 'Add To Cart';
            });
    });
});