<x-layout title="Add product">
    <h2>Add a Product</h2>

    <form action="/create" method="POST">
        @csrf

        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required  value="{{old('name')}}">

        <br><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" min="0" required value="{{old('price')}}">

        <br><br>
        @if($errors->any())
            @foreach($errors->all() as $error)
                <li>
                    {{$error}}
                </li>
            @endforeach

        @endif
        <button type="submit">Add Product</button>
    </form>
</x-layout>
