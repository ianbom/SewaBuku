@extends('sewa_buku.layouts.app')
@section('content')
<div class="container mx-auto mt-10">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-4">Daftar Pengguna</h1>

            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border-b text-left text-sm font-semibold">#</th>
                        <th class="py-2 px-4 border-b text-left text-sm font-semibold">Nama</th>
                        <th class="py-2 px-4 border-b text-left text-sm font-semibold">Email</th>
                        <th class="py-2 px-4 border-b text-left text-sm font-semibold">No. HP</th>
                        <th class="py-2 px-4 border-b text-left text-sm font-semibold">Tanggal Lahir</th>
                        <th class="py-2 px-4 border-b text-left text-sm font-semibold">Role</th>
                        <th class="py-2 px-4 border-b text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user as $index => $u)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 border-b">{{ $u->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $u->email }}</td>
                            <td class="py-2 px-4 border-b">
                                {{ $u->no_hp ?? 'N/A' }}
                            </td>
                            <td class="py-2 px-4 border-b">
                                {{ $u->tanggal_lahir ?? 'N/A' }}
                            </td>
                            <td class="py-2 px-4 border-b">
                                @if($u->is_admin)
                                    <span class="text-green-500 font-semibold">Admin</span>
                                @else
                                    <span class="text-gray-500">Pengguna</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b">
                                <a href="#" class="text-blue-500 hover:underline">Detail</a> |

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
