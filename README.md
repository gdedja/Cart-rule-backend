# Shopify Custom App

## Getting Started

1. Clone the Git repository and run the application:
   ```bash
   php artisan serve --port=8001

2. Start ngrok
   ```bash
   ngrok http 8001

3. On the first screen, choose Product 1, Product 2, or the Free Product. This will pull the product list from Shopify, allowing the owner to select products from the catalog.

4. Save the form to update the metaobjects in Shopify.

5. Now, on the Shopify frontend, when you add Product 1 and Product 2, the Free Product is automatically added without refreshing the page.

6. Code changes.

Laravel app

- routes/web.php
- resources/views/home.blade.php
- http/controllers/Shopifycontroller.php


Shopify

- layout/theme.liquid


At the bottom of the code, there is a part that pull the metaobjects and add the free product to the cart



Current ngrok url list
https://8740-167-88-61-148.ngrok-free.app/
