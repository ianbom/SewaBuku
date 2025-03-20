@extends('sewa_buku.layouts.userApp')

@section('title')
    Order Details
@endsection

@section('content')
    <div class="container mx-auto mt-10 p-10">
        <!-- Page Title -->
        <div class="flex justify-between items-center mb-12">
            <h1 class="text-3xl font-bold text-left text-[052D6E]"
                style="font-family: 'Libre Baskerville', serif; color: #052D6E;">Order Details</h1>
        </div>

        <!-- Order Detail Card -->
        <div class="bg-white rounded-3xl p-6 border-2 border-[#1E90FF]" style="font-family: 'Libre Baskerville' , serif;">
            <!-- Back Button Icon -->
            <div class="flex items-center mb-5 mt-2">
                <!-- Back Button Icon -->
                <a href="{{ url()->previous() }}" class="text-[#052D6E] hover:text-[#1E90FF] mr-4">
                    <i class="fa fa-angle-left text-xl"></i> <!-- Back Arrow Icon -->
                </a>

                <!-- Title -->
                <h1 class="text-xl font-bold text-left text-[#052D6E]" style="font-family: 'Inter', sans-serif;">Order Details</h1>
            </div>

            <!-- Order Details Section -->
            <div class="bg-[#D3E9FF] p-6 rounded-2xl mb-6" style="font-family: 'Inter', sans-serif;">
                <div class="grid grid-cols-1 gap-3">
                    <!-- Order ID -->
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-bold text-[#052D6E]">No. {{ $order->id_order }}</h2>
                    </div>

                    <!-- Divider -->
                    <hr class="my-1 border-t-2 border-[#052D6E]">

                    <!-- Package Name -->
                    <div class="flex flex-col sm:flex-row justify-start sm:justify-between items-start sm:items-center">
                        <p class="text-[#052D6E] font-bold">Package Name</p>
                        <p class="text-[#979797] font-semibold">{{ $order->nama_paket }}</p>
                    </div>

                    <!-- Buyer -->
                    <div class="flex flex-col sm:flex-row justify-start sm:justify-between items-start sm:items-center">
                        <p class="text-[#052D6E] font-bold">Buyer's Name</p>
                        <p class="text-[#979797] font-semibold">{{ $order->user->name }}</p>
                    </div>

                    <!-- Order Date -->
                    <div class="flex flex-col sm:flex-row justify-start sm:justify-between items-start sm:items-center">
                        <p class="text-[#052D6E] font-bold">Order Date</p>
                        <p class="text-[#979797] font-semibold">
                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</p>
                    </div>

                    {{-- Total Amount --}}
                    <!-- Total Amount -->
                    <div class="flex flex-col sm:flex-row justify-start sm:justify-between items-start sm:items-center">
                        <p class="text-[#052D6E] font-bold">Total Amount</p>
                        <p class="text-[#979797] font-semibold">Rp{{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                    </div>

                    <!-- Divider -->
                    <hr class="my-1 border-t-2 border-[#052D6E]">

                    <!-- Order Status -->
                    <div class="flex flex-col sm:flex-row justify-start sm:justify-between items-start sm:items-center">
                        <p class="text-[#052D6E] font-bold mb-2">Order Status</p>
                        @if ($order->status_order === 'Proses')
                            <span class="py-1 px-2 rounded font-bold text-[#1E90FF] bg-[#98b8d4]" style="text-transform: uppercase;">
                                {{ $order->status_order }}
                            </span>
                        @elseif($order->status_order === 'Selesai')
                            <span class="py-1 px-2 rounded font-bold text-[#DC3545] bg-[#98b8d4]" style="text-transform: uppercase;">
                                {{ $order->status_order }}
                            </span>
                        @else
                            <span class="py-1 px-2 rounded font-bold text-[#4DAF84] bg-[#98b8d4]" style="text-transform: uppercase;">
                                {{ $order->status_order }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap lg:justify-end lg:gap-6 gap-3 justify-center mt-6" style="font-family: 'Inter', sans-serif;">

                <!-- Cancel Order Button -->
                @if ($order->status_order == 'Proses')
                    <form action="{{ route('user.order.batal', $order->id_order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="px-4 text-bold py-2 bg-[#FFCFC2] text-[#E46B61] rounded-[12px] hover:bg-[#E46B61] hover:text-white">
                            <strong>Cancel Order</strong>
                        </button>
                    </form>
                @endif

                <!-- Pay Now Button -->
                @if ($order->status_order == 'Proses')
                    <form action="{{ route('user.payment.store', $order->id_order) }}" method="POST" id="payment_form">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-[#1E90FF] text-bold text-white rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
                            <strong> Pay Now </strong>
                        </button>
                    </form>
                @endif
            </div>

            <!-- Rating Section -->
            @if ($order->status_order === 'Selesai')
                <div class="mt-10 border-t pt-6">
                    <h3 class="text-xl font-bold mb-4">Give a Rating for This Order:</h3>
                    @if ($rating)
                        <!-- Display Rating If Available -->
                        <div class="mb-4">
                            <p class="text-gray-700 font-semibold">Rating:</p>
                            <p class="text-yellow-500">{{ $rating->rating }} / 5</p>
                        </div>
                        @if ($rating->komentar)
                            <div>
                                <p class="text-gray-700 font-semibold">Comment:</p>
                                <p class="text-gray-900">{{ $rating->komentar }}</p>
                            </div>
                        @endif
                    @else
                        <!-- Form to Give Rating -->
                        <form action="{{ route('user.rating.store', $order->id_order) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">Rating (1-5):</label>
                                <select name="rating"
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">Comment:</label>
                                <textarea name="komentar" rows="3"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"></textarea>
                            </div>
                            <button type="submit"
                                class="bg-green-500 text-white py-2 px-4 rounded shadow-md hover:bg-green-600">
                                Submit Rating
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Function to handle payment
            function handlePayment(event, url) {
                const grossAmount = "{{ $order->total_bayar }}"; // Get the total bill amount
                const customerName = "{{ $order->nama_paket }}"; // Customer name
                const customerEmail = "{{ auth()->user()->email }}"; // Customer email

                // Call backend to get Snap token
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            gross_amount: grossAmount,
                            customer_name: customerName,
                            customer_email: customerEmail
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.status) {
                            if (data.data.status == 'settlement') {
                                Swal.fire({
                                    title: 'Payment Successful',
                                    text: "Welcome aboard!",
                                    icon: 'success',
                                    confirmButtonColor: '#198754',
                                    confirmButtonText: 'OK',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload()
                                    }
                                });
                            } else {
                                snap.pay(data.data.snap_token, {
                                    onSuccess: function(result) {
                                        Swal.fire({
                                            title: 'Payment Successful',
                                            text: "Welcome aboard!",
                                            icon: 'success',
                                            confirmButtonColor: '#198754',
                                            confirmButtonText: 'OK',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.reload()
                                            }
                                        });
                                    },
                                    onPending: function(result) {
                                        Swal.fire({
                                            title: 'Payment Pending',
                                            text: "Your payment is pending confirmation.",
                                            icon: 'warning',
                                            confirmButtonText: 'OK',
                                        });
                                    },
                                    onError: function(result) {
                                        Swal.fire({
                                            title: 'Payment Failed',
                                            text: "Something went wrong with your payment. Please try again.",
                                            icon: 'error',
                                            confirmButtonText: 'OK',
                                        });
                                    },
                                    onClose: function() {
                                        Swal.fire({
                                            title: 'Payment Canceled',
                                            text: "You closed the payment window without completing the payment.",
                                            icon: 'info',
                                            confirmButtonText: 'OK',
                                        });
                                    }
                                });
                            }
                        } else {
                            alert('Failed to create transaction');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred');
                    });
            }

            $('#payment_form').submit(function(e) {
                e.preventDefault();
                let url = $(this).attr('action');
                console.log(url)
                handlePayment(e, url)
            })
        });
    </script>
@endpush
