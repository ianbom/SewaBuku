@extends('sewa_buku.layouts.userBacaBuku')

@section('title')
    'Kerjakan Quiz'
@endsection

@section('content')
<div class="container mx-auto p-10 bg-white">

    <!-- Judul Halaman -->
    <div class="flex justify-between items-center mb-4 mt-10">
        <h1 class="text-3xl font-bold text-left text-[#052D6E]" style="font-family: 'Libre Baskerville', serif; color: #052D6E;"> Quiz: {{ $quiz->nama_quiz }}</h1>
    </div>

    <h2 class="font-bold text-[#979797] mb-4 italic" style="font-family: 'Libre Baskerville', serif;">
        " {{ $quiz->deskripsi }} "
    </h2>

    <!-- Quiz Content -->
    <div class="bg-[#F1F8FF] rounded-[16px] mt-10">
        <form id="quizForm" action="{{ route('user.quiz.submit', $quiz->id_quiz) }}" method="POST">
            @csrf

            <!-- Question Section -->
            @foreach ($soal as $key => $item)
                <!-- Question -->
                <div class="bg-[#D3E9FF] rounded-t-[16px] rounded-b-none">
                    <p class="text-sm text-[#052D6E] p-4 text-center">
                        {{ $key + 1 }}. {{ $item->pertanyaan }}
                    </p>
                </div>

                <!-- Options -->
                <div class="bg-[#F1F8FF] p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($item->opsi as $opsi)
                            <label class="flex items-center rounded-lg">
                                <input
                                    type="radio"
                                    name="jawaban[{{ $item->id_soal }}]"
                                    value="{{ $opsi->id_opsi }}"
                                    class="w-5 h-5 text-[#052D6E] border-white focus:ring-[#052D6E]"
                                    required
                                >
                                <span class="ml-5 text-[#979797]">{{ $opsi->opsi }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </form>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end mt-10">
        <button
            id="submitQuizButton"
            type="button"
            class="flex items-center gap-2 px-12 py-3 text-white bg-[#1E90FF] rounded-[12px] hover:bg-[#D3E9FF] hover:text-[#1E90FF]">
            <strong>SUBMIT</strong>
        </button>
    </div>
</div>

<script>
    // JavaScript to handle form submission
    document.getElementById('submitQuizButton').addEventListener('click', function () {
        document.getElementById('quizForm').submit();
    });
</script>
@endsection
