@extends('sewa_buku.layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Detail Quiz</h1>

        <!-- Informasi Quiz -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-lg font-semibold">Nama Quiz:</h2>
                <p class="text-gray-700">{{ $quiz->nama_quiz ?? 'null' }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold">Deskripsi:</h2>
                <p class="text-gray-700">{{ $quiz->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            </div>
            @if ($quiz->file)
            <div>
                <h2 class="text-lg font-semibold">File Quiz:</h2>
                <a href="{{ asset('storage/' . $quiz->file) }}" target="_blank" class="text-blue-500 underline">
                    Download File
                </a>
            </div>
            @endif
            <div>
                <h2 class="text-lg font-semibold">Tanggal Dibuat:</h2>
                <p class="text-gray-700">{{ $quiz->created_at->format('d M Y H:i') }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold">Terakhir Diperbarui:</h2>
                <p class="text-gray-700">{{ $quiz->updated_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <!-- Daftar Soal -->
        <div class="mb-6">
            <h2 class="text-xl font-bold mb-4">Daftar Soal:</h2>
            @if ($soal->isNotEmpty())
                <div class="space-y-6">
                    @foreach ($soal as $item)
                        <div class="border rounded-lg p-6 shadow-sm bg-gray-50">
                            <h3 class="text-lg font-semibold">Soal:</h3>
                            <p class="text-gray-700 mb-4">{{ $item->soal }}</p>
                            @if ($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="Gambar Soal" class="w-64 h-auto mb-4 rounded-lg">
                            @endif
                            <a href="{{ route('soal.edit', $item->id_soal) }}" class='text-blue-500'>Edit soal</a>
                            <form action="{{ route('soal.destroy', $item->id_soal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Soal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                    Hapus soal
                                </button>
                            </form>

                            <!-- Opsi -->
                            <h3 class="text-md font-semibold mb-2">Opsi:</h3>
                            @if ($item->opsi->isNotEmpty())
                                <ol class="list-decimal pl-6" style="list-style-type: upper-alpha;">
                                    @foreach ($item->opsi as $opsi)
                                        <li class="mb-3">
                                            <p class="text-gray-700">{{ $opsi->opsi }}</p>
                                            @if ($opsi->image)
                                                <img src="{{ asset('storage/' . $opsi->image) }}" alt="Gambar Opsi" class="w-24 h-auto rounded-lg">
                                            @endif
                                            <p><strong>Benar:</strong> {{ $opsi->is_correct ? 'Ya' : 'Tidak' }}</p>
                                        </li>
                                        <a href="{{ route('opsi.edit', $opsi->id_opsi) }}" class='text-blue-500'>Edit Opsi</a>
                                        <form action="{{ route('opsi.destroy', $opsi->id_opsi) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus opsi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                                Hapus opsi
                                            </button>
                                        </form>
                                    @endforeach
                                </ol>
                            @else
                                <p class="text-gray-500">Belum ada opsi untuk soal ini.</p>
                            @endif

                            <!-- Tombol Buat Opsi -->
                            <a href="{{ route('opsi.create', $item->id_soal) }}" class="inline-block mt-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                Buat Opsi
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Belum ada soal untuk quiz ini.</p>
            @endif
        </div>

        <!-- Tombol Aksi -->
        <div class="flex flex-wrap justify-center space-x-4 mt-6">
            <a href="{{ route('quiz.edit', $quiz->id_quiz) }}"
               class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Edit Quiz
            </a>

            <a href="{{ route('soal.create', $quiz->id_quiz) }}"
               class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                Buat Soal
            </a>

            <form action="{{ route('quiz.destroy', $quiz->id_quiz) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus quiz ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    Hapus Quiz
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
