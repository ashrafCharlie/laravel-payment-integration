<x-layout title="check-out">
    <h1>Checkout</h1>
    <form action="{{route('payment.checkout')}}" method="POST">
        @csrf

        <div>
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        <br>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <br>
        <div>
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" required>
        </div>

        <p>Amount: ৳100</p>

        @if($errors->any())
            @foreach($errors as $error)
                <ul>
                    <li>
                        {{$error}}
                    </li>
                </ul>
            @endforeach
        @endif

        <button type="submit">Proceed to Payment</button>
    </form>
</x-layout>
