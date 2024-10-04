@extends('../layout/' . $layout)

@section('subhead')
    <title>Choose Products</title>
@endsection

@section('subcontent')
    <form id="productForm" action="{{ route('save-metaobject') }}" method="POST">
        @csrf
        <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-slate-200/60 dark:border-darkmode-400 flex">
            <div class="w-1/2 pl-10 grid gap-4">
                <div class="font-medium text-base mb-5">Choose Products</div>
                
                <!-- Hidden Input for Metaobject ID -->
                <input type="hidden" name="metaobject_id" value="70063358103">

                <!-- Product 1 -->
                <div class="flex w-full">
                    <div class="mr-4 w-full" data-tw-placement="bottom"> 
                        <div class="w-full grid">
                            <label>Product 1</label>
                            <select name="product_1_handle" class="product-1">
                                @foreach ($products as $product)
                                    <option value="{{ $product->handle }}">{{ $product->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                
                </div>
                
                <!-- Product 2 -->
                <div class="flex w-full">
                    <div class="mr-4 w-full" data-tw-placement="bottom"> 
                        <div class="w-full grid">
                            <label>Product 2</label>
                            <select name="product_2_handle" class="product-2">
                                @foreach ($products as $product)
                                    <option value="{{ $product->handle }}">{{ $product->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                
                </div>
                
                <!-- Free Product -->
                <div class="flex w-full">
                    <div class="mr-4 w-full" data-tw-placement="bottom"> 
                        <div class="w-full grid">
                            <label>Free Product</label>
                            <select name="free_product_handle" class="free-product" id="freeProductSelect">
                                @foreach ($products as $product)
                                    <option value="{{ $product->handle }}" data-id="{{ $product->id }}">{{ $product->title }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="free_product_id" id="freeProductId" value="{{ $products[0]->id }}">
                        </div>
                    </div>               
                </div>

                <!-- Times limit -->
                <div class="flex w-full">
                    <div class="mr-4 w-full" data-tw-placement="bottom"> 
                        <div class="w-full grid">
                            <label>Limit of times</label>
                            <input type="number" name="limit" class="limit" value="1">
                        </div>
                    </div>                
                </div>

                <button type="submit" id="vendor_add" class="btn btn-primary w-24">
                    <i class="w-4 h-4 mr-2" data-lucide="save"></i> Save
                </button>

                <!-- Section to display the results -->
                <div id="result" class="mt-10"></div>
            </div>        
        </div>
    </form>

    <script>
        document.getElementById('productForm').addEventListener('submit', function(event) {
            event.preventDefault(); 

            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('result');

                // Clear previous results
                resultDiv.innerHTML = '';

                if (data.errors) {
                    // Display errors
                    data.errors.forEach(error => {
                        const errorElement = document.createElement('div');
                        errorElement.className = 'text-red-500';
                        errorElement.textContent = error.message;
                        resultDiv.appendChild(errorElement);
                    });
                } else {
                    // Display success message or data
                    const successElement = document.createElement('div');
                    successElement.className = 'text-green-500';
                    successElement.textContent = 'Metaobject updated successfully!';
                    resultDiv.appendChild(successElement);

                    console.log(data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        document.getElementById('freeProductSelect').addEventListener('change', function() {
            // Get the selected option element
            var selectedOption = this.options[this.selectedIndex];

            // Get the product ID from the selected option's data-id attribute
            var productId = selectedOption.getAttribute('data-id');

            // Set the value of the hidden input
            document.getElementById('freeProductId').value = productId;
        });
    </script>
@endsection
