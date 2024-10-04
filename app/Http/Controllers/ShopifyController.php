<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\Shopify;

class ShopifyController extends Controller
{
    protected $shopifyDomain;
    protected $accessToken;

    public function __construct()
    { 
        $this->shopify = new Shopify(
            env('SHOPIFY_API_KEY'),
            env('SHOPIFY_API_PASSWORD'),
            env('SHOPIFY_DOMAIN'),
            env('SHOPIFY_API_VERSION')
        );   

        $this->shopifyDomain = env('SHOPIFY_DOMAIN');
        $this->accessToken = env('SHOPIFY_API_PASSWORD');
    }

    public function updateMetaobject(Request $request)
    {
        // Retrieve the values from the request
        $metaobjectId = 'gid://shopify/Metaobject/' . $request->input('metaobject_id'); // New field to identify the metaobject
        $product1Handle = $request->input('product_1_handle');
        $product2Handle = $request->input('product_2_handle');
        $freeProductHandle = $request->input('free_product_handle');
        $freeProductId = $request->input('free_product_id');

        // Set the product free
        $this->updatePriceToZero($freeProductId);

        // Check if the values are properly received
        if (is_null($metaobjectId) || is_null($product1Handle) || is_null($product2Handle) || is_null($freeProductHandle)) {
            return response()->json(['error' => 'All fields must be provided'], 400);
        }

        // Define the metaobject update mutation
        $mutation = '
            mutation UpdateMetaobject($id: ID!, $fields: [MetaobjectFieldInput!]!) {
                metaobjectUpdate(id: $id, metaobject: { fields: $fields }) {
                    metaobject {
                        id
                        fields {
                            key
                            value
                        }
                    }
                    userErrors {
                        field
                        message
                    }
                }
            }
        ';

        // Set the variables for the metaobject mutation
        $variables = [
            'id' => $metaobjectId, // ID of the metaobject to update
            'fields' => [
                [
                    'key' => 'product_1',
                    'value' => $product1Handle, // Field for product 1
                ],
                [
                    'key' => 'product_2',
                    'value' => $product2Handle, // Field for product 2
                ],
                [
                    'key' => 'free_product',
                    'value' => $freeProductHandle, // Field for free product
                ]
            ]
        ];

        // Send the GraphQL request to Shopify to update the metaobject
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->accessToken,
            'Content-Type' => 'application/json',
        ])->post("https://{$this->shopifyDomain}/admin/api/2023-04/graphql.json", [
            'query' => $mutation,
            'variables' => $variables
        ]);

        // Process the response for metaobject update
        $data = $response->json();
        if (isset($data['errors'])) {
            return response()->json(['errors' => $data['errors']], 400);
        }

        return response()->json(['data' => $data]);
    }

    public function updatePriceToZero($productId)
    {
        // Fetch the product details first to get its variants
        $apiGetEndpoint = "https://{$this->shopifyDomain}/admin/api/" . env('SHOPIFY_API_VERSION') . "/products/{$productId}.json";
        $response = $this->shopify->get($apiGetEndpoint, [
            'X-Shopify-Access-Token' => $this->accessToken
        ]);
    
        if (!$response->successful()) {
            return response()->json([
                'message' => 'Failed to fetch product details',
                'error' => $response->body()
            ], $response->status());
        }
    
        $product = $response->json('product');
    
        // Prepare an array to hold the updated variant data
        $variants = [];
        foreach ($product['variants'] as $variant) {
            $variants[] = [
                'id' => $variant['id'],  // Keep the variant ID
                'price' => '0.00'        // Update only the price
            ];
        }
    
        // Shopify API endpoint for updating a product's variants price
        $apiPutEndpoint = "https://{$this->shopifyDomain}/admin/api/" . env('SHOPIFY_API_VERSION') . "/products/{$productId}.json";
    
        // Payload with price set to 0 for each variant
        $payload = [
            'product' => [
                'id' => $productId,  // Ensure we are updating the correct product
                'variants' => $variants // Only updating the price of each variant
            ]
        ];
    
        // Make the PUT request to update the product price
        $response = $this->shopify->put($apiPutEndpoint, $payload, [
            'X-Shopify-Access-Token' => $this->accessToken
        ]);
    
        // Handle response
        if ($response->successful()) {
            return response()->json([
                'message' => 'Product price updated to 0 successfully',
                'productId' => $productId
            ]);
        }
    
        return response()->json([
            'message' => 'Failed to update product price',
            'error' => $response->body()
        ], $response->status());
    }
    

    // Load products to display in the form
    public function choose_product()
    {
        $last_updated_time = "2024-09-01T00:00:43+01:00";
        $products = $this->shopify->getProducts(['limit' => 150, 'updated_at_min' => $last_updated_time]);
        return view('home', ['products' => $products]);
    }

    public function getMetaobjects()
    {
        // Define the query
        $query = '
            {
                metaobjects(first: 10, type: "product_bundle_rule") {
                    edges {
                        node {
                            id
                            fields {
                                key
                                value
                            }
                        }
                    }
                }
            }
        ';

        // Send the GraphQL request to Shopify
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => env('SHOPIFY_API_PASSWORD'),
            'Content-Type' => 'application/json',
        ])->post("https://{$this->shopifyDomain}/admin/api/2023-04/graphql.json", [
            'query' => $query,
        ]);

        // Process the response
        $data = $response->json();
        if (isset($data['errors'])) {
            return response()->json(['errors' => $data['errors']], 400);
        }

        return response()->json(['data' => $data['data']['metaobjects']]);
    }

}
