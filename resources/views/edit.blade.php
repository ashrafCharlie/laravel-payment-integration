<x-layout title="Update product">
    <h2>Update  Product</h2>

    <form action="/products/{{$product->id}}" method="POST">
        @csrf
        @method('PATCH')
        <label for="name">Product Name:</label>
        <div>
            <input type="text" id="name" name="name" required value="{{$product->name}}">
        </div>

        <br><br>

        <label for="price">Price:</label>
        <div>
            <input type="number" id="price" name="price" step="0.01" min="0" required value="{{$product->price}}">
        </div>
        @if($errors->any())
            @foreach($errors->all() as $error)
                <li>
                    <p>{{$error}}</p>
                </li>

            @endforeach
        @endif
        <br>
        <button type="submit">Update Product</button>
    </form>
    <br>
    <form method="POST" action="/products/{{$product->id}}/delete">
        @csrf
        @method('DELETE')
        <button style="background-color: red"  type="submit">Delete Product</button>
    </form>

</x-layout>
