
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container">
    @if ($products->isEmpty())
        <div class="col-md-12 text-center">
            <p>No result found.</p>
        </div>
    @else
        @foreach ($products as $product)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    
                </div>
            </div>
        @endforeach
        {{ $products->links() }}
    @endif
</div>

</body>
</html>
