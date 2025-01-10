@extends('sewa_buku.layouts.userApp')

@section('title')
    Your Subscription
@endsection

@section('content')
<head>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<div class="container mx-auto mt-10 p-10">
    <!-- Page Title -->
    <div class="flex justify-between items-center mb-12">
        <h1 class="text-3xl font-bold text-left text-[052D6E]" style="font-family: 'Libre Baskerville', serif; color: #052D6E;">Your Profile</h1>
    </div>

    <div class="flex flex-col md:flex-row gap-5">
        <!-- Profile Information (Left Card) -->
        <div class="flex-1 md:flex-none mb-4 md:w-2/3">
            <div class="bg-[#D3E9FF] rounded-[16px] p-8">
                <h2 class="text-[16px] sm:text-[18px] font-bold text-[#052D6E] mb-6">Profile Information</h2>
                <form action="{{ route('user.langganan.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Profile Picture -->
                    <div class="d-flex align-items-center mb-6">
                        <div class="relative w-24 h-24 mr-4">
                            <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('images/foto.jpg') }}" alt="Profile Picture" class="w-full h-full rounded-full object-cover border-4 border-[#F1F8FF]">
                            <label for="foto" class="absolute bottom-0 right-0 bg-[#052D6E] text-white p-2 rounded-full cursor-pointer hover:bg-[#1E90FF] transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2l8 8-10 10H4v-8L14 2z" />
                                </svg>
                            </label>
                        </div>
                        <div class="flex flex-col">
                            <div class="relative mt-2">
                                <input type="file" name="foto" id="foto" class="opacity-0 absolute inset-0 w-full h-full cursor-pointer" onchange="updateFileName()" />
                                <div class="text-sm text-[#052D6E] font-semibold mt-2 p-2 rounded border border-[#F1F8FF] bg-[#F1F8FF] text-ellipsis overflow-hidden" id="fileName">
                                    Change Photo
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function updateFileName() {
                            const fileInput = document.getElementById('foto');
                            const fileNameDisplay = document.getElementById('fileName');

                            if (fileInput.files.length > 0) {
                                fileNameDisplay.textContent = fileInput.files[0].name;
                            }
                        }
                    </script>

                    <!-- Name -->
                    <div class="mb-6">
                        <label for="nama" class="block text-sm font-semibold text-[#052D6E]">Name</label>
                        <input type="text" name="nama" id="nama" value="{{ Auth::user()->name }}" class="mt-2 block w-full rounded-[8px] border-none shadow-sm focus:border-[#1E90FF] focus:ring-[#1E90FF]">
                    </div>

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-semibold text-[#052D6E]">Email</label>
                        <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="mt-2 block w-full rounded-[8px] border-none shadow-sm focus:border-[#1E90FF] focus:ring-[#1E90FF]">
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-[#052D6E]">New Password</label>
                        <input type="password" name="password" id="password" class="mt-2 block w-full rounded-[8px] border-none shadow-sm focus:border-[#1E90FF] focus:ring-[#1E90FF]" placeholder="Leave empty if you don't want to change">
                    </div>

                    <!-- Save Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-[#1E90FF] text-bold text-white rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF] text-xs sm:text-sm md:text-base"><strong> Save Changes </strong></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Latest Subscription Package (Right Card) -->
        <div class="flex-1 md:flex-none mb-4 md:w-1/3">
            <div class="bg-[#F1F8FF] rounded-[16px] p-8">
                <h2 class="text-[16px] sm:text-[18px] font-bold text-[#052D6E] mb-6">Latest Subscription Package</h2>

                @if($langganan->isEmpty())
                <!-- Message if no subscription -->
                <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center gap-4">
                    <p class="text-[#E46B61] text-xs sm:text-sm">You currently do not have any subscription packages</p>
                </div>
                @else
                <!-- Subscription List -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-6">
                    @foreach($langganan as $item)
                    <div class="bg-[#D3E9FF] rounded-[16px] p-8">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-[#052D6E] font-bold text-[14px] sm:text-[16px]">Package Name</h3>
                            <h3 class="text-[#979797] font-bold text-[12px] sm:text-[14px]">{{ $item->paketLangganan->nama_paket }}</h3>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-[#052D6E] font-bold text-[14px] sm:text-[16px]">Status</h3>
                            @if($item->status_langganan)
                                <span class="text-[#4DAF84] font-bold text-[12px] sm:text-[14px]">ACTIVE</span>
                            @else
                                <span class="text-[#E46B61] font-bold text-[12px] sm:text-[14px]">INACTIVE</span>
                            @endif
                        </div>

                        <!-- Subscription Information -->
                        <div class="bg-blue-500 text-white text-[12px] sm:text-[14px] rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span><strong>Start Date</strong></span>
                                <span>{{ \Carbon\Carbon::parse($item->mulai_langganan)->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span><strong> End Date</strong></span>
                                <span>{{ \Carbon\Carbon::parse($item->akhir_langganan)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- "View Your Subscription" Button -->
                @if($langganan->isEmpty())
                <div class="mt-6 text-center">
                    <a href="{{ route('paket-langganan.index') }}" class="block w-full sm:w-auto px-3 py-3 bg-[#1E90FF] text-white font-bold text-xs sm:text-sm md:text-base rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
                        <strong>View Your Package</strong>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
