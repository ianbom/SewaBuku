@extends('sewa_buku.layouts.userApp')

@section('title')
    Langganan Anda
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

 <!-- Judul Halaman -->
 <div class="flex justify-between items-center mb-12">
    <h1 class="text-3xl font-bold text-left text-[052D6E]" style="font-family: 'Libre Baskerville', serif; color: #052D6E;">Profile Anda</h1>
</div>

<h2 class="text-[18px] font-bold text-[#052D6E] mb-6 ">Informasi Profil</h2>

    <!-- Informasi Profil -->
    <div class="bg-[#D3E9FF]  rounded-[16px] p-8 mb-12">
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
        <!-- Foto Profil -->
<div class="flex items-center mb-6">
    <div class="relative w-24 h-24 mr-4">
        <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('images/foto.jpg') }}" alt="Foto Profil" class="w-full h-full rounded-full object-cover border-4 border-[#F1F8FF]">
        <!-- Icon Edit -->
        <label for="foto" class="absolute bottom-0 right-0 bg-[#052D6E] text-white p-2 rounded-full cursor-pointer hover:bg-[#1E90FF] transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2l8 8-10 10H4v-8L14 2z" />
            </svg>


        </label>
    </div>
    <div class="flex flex-col">
        <div class="relative mt-2">
            <input type="file" name="foto" id="foto" class="opacity-0 absolute inset-0 w-full h-full cursor-pointer" onchange="updateFileName()" />
            <!-- Placeholder text for file name -->
            <div class="text-sm text-[#052D6E] font-semibold mt-2 p-2 rounded border border-[#F1F8FF] bg-[#F1F8FF] text-ellipsis overflow-hidden" id="fileName">
                Ganti Foto
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


            <!-- Nama -->
            <div class="mb-6">
                <label for="nama" class="block text-sm font-semibold text-[#052D6E]">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ Auth::user()->nama }}" class="mt-2 block w-full rounded-[8px] border-none shadow-sm focus:border-[#1E90FF] focus:ring-[#1E90FF]">
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-semibold text-[#052D6E]">Email</label>
                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="mt-2 block w-full rounded-[8px] border-none shadow-sm focus:border-[#1E90FF] focus:ring-[#1E90FF]">
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold text-[#052D6E]">Password Baru</label>
                <input type="password" name="password" id="password" class="mt-2 block w-full rounded-[8px] border-none shadow-sm focus:border-[#1E90FF] focus:ring-[#1E90FF]" placeholder="Biarkan kosong jika tidak ingin mengganti">
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-[#1E90FF] text-bold text-white rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]"><strong> Simpan Perubahan </strong></button>
            </div>
        </form>
    </div>



  <h2 class="text-[18px] font-bold text-[#052D6E] mb-6 ">Paket Langganan terkahir</h2>

   @if($langganan->isEmpty())
    <!-- Pesan jika tidak ada langganan -->
    <div class="flex justify-between items-center">
        <p class="text-[#E46B61]">Anda belum memiliki paket langganan saat ini</p>
        <a href="{{ route('paket-langganan.index') }}" class="px-4 py-2 bg-[#1E90FF] text-bold text-white rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
            <strong>Lihat Paket Langganan</strong>
        </a>
    </div>

@else
    <!-- Daftar Langganan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($langganan as $item)
        <div class="bg-[#D3E9FF] rounded-[16px] p-8">
            <!-- Header Paket -->
            <div class="flex justify-between items-center mb-2">
                <div>
                    <h3 class="text-[#052D6E] font-bold text-[18px]">Nama Paket</h3>
                </div>
                <div>
                    <h3 class="text-[#979797] font-bold text-[16px]">{{ $item->paketLangganan->nama_paket }}</h3>
                </div>
            </div>
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-blue-900 font-bold text-lgtext-[#052D6E] font-bold text-[18px]">Status</h3>
                </div>
                <div>
                    @if($item->status_langganan)
                        <span class="text-[#4DAF84] font-bold">ACTIVE</span>
                    @else
                        <span class="text-[#E46B61] font-bold">INACTIVE</span>
                    @endif
                </div>
            </div>

            <!-- Informasi Langganan -->
            <div class="bg-blue-500 text-white text-[16px] rounded-lg p-4">
                <div class="flex justify-between items-center mb-2">
                    <span><strong>Mulai Langganan</strong></span>
                    <span>{{ \Carbon\Carbon::parse($item->mulai_langganan)->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span><strong> Selesai Langganan</strong></span>
                    <span>{{ \Carbon\Carbon::parse($item->akhir_langganan)->format('d M Y') }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

</div>
@endsection
