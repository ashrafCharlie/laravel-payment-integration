<x-layout title="Product">
    <h1>My Products</h1>
    @forelse($products as $product )
        <ol >
            <a href="/products/{{$product->id}}"><p>Product name:{{$product->name}}, Price: {{$product->price}}</p></a>
        </ol>
    @empty
        <p>no product found...</p>
    @endforelse

    <div>
        <a  href="/create">
            Add product
        </a>
    </div>
</x-layout>
