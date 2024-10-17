@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-4">Profil Admin</h1>


            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <p class="mt-1 text-lg font-semibold">{{ $user->name }}</p>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <p class="mt-1 text-lg font-semibold">{{ $user->email }}</p>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">No. HP</label>
                    <p class="mt-1 text-lg font-semibold">{{ $user->no_hp ?? 'Belum diisi' }}</p>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <p class="mt-1 text-lg font-semibold">{{ $user->tanggal_lahir ?? 'Belum diisi' }}</p>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Edit Profil</a>
            </div>
        </div>
    </div>
</div>
@endsection
