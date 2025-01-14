@extends('sewa_buku.layouts.userBacaBuku')

@section('title')
    {{ $buku->judul_buku }}
@endsection

@section('content')
<head>
    <style>
        .custom-audio {
            background-color: #D3E9FF;
            border-radius: 16px;
            color: #1E90FF !important;
        }

        .custom-audio::-webkit-media-controls-panel {
            background-color: #D3E9FF;
        }

        .custom-audio::-webkit-media-controls-play-button {
            background-color: white;
            border-radius: 50px;
            color: #1E90FF !important;
        }

        .custom-audio::-webkit-media-controls-timeline {
            color: #1E90FF !important;
        }

        .custom-audio::-webkit-media-controls-current-time-display,
        .custom-audio::-webkit-media-controls-time-remaining-display {
            color: #1E90FF !important;
        }
    </style>
</head>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row gap-8">

            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <div class="bg-white rounded-xl p-8 shadow-md">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $buku->judul_buku }}</h1>

                    <!-- Current Chapter Title -->
                    @foreach($buku->detailBuku as $detail)
                        @if ($detail->is_free_detail || $checkLangganan)
                            <div id="bab-{{ $detail->id_detail_buku }}" class="mb-12">
                                <div class="flex items-center gap-4 mb-6">
                                    <h2 class="text-2xl font-bold text-gray-800">{{ $detail->bab }}</h2>
                                    @if ($detail->id_detail_buku == $babTerakhirDibaca)
                                        <span class="px-3 py-1 bg-green-100 text-green-600 text-sm rounded-full">Last Read</span>
                                    @endif
                                </div>

                                <!-- Audio Player -->
                                @if($detail->audio)
                                    <div class="mb-8 bg-gray-50 p-4 rounded-xl">
                                        <div class="w-full bg-white rounded-lg p-4 shadow-sm">
                                            <audio controls class="w-full custom-audio">
                                                <source src="{{ Storage::url($detail->audio) }}" type="audio/mpeg">
                                            </audio>
                                        </div>
                                    </div>
                                @endif

                                <!-- Chapter Content -->
                                <div class="prose max-w-none">
                                    <p class="text-gray-600 leading-relaxed mb-6">
                                        {{ $detail->isi }}
                                    </p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-wrap gap-4 mt-8">
                                    <a href="{{ route('user.buku.bacaBab', $detail->id_detail_buku) }}"
                                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        Read Chapter
                                    </a>

                                    @if ($detail->quiz)
                                        @if (!$quizStatus[$detail->id_detail_buku])
                                            <a href="{{ route('user.quiz.kerjakan', $detail->id_detail_buku) }}"
                                               class="inline-flex items-center px-6 py-3 bg-white border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                                                Take Quiz
                                            </a>
                                        @else
                                            <div class="flex flex-col">
                                                <a href="{{ route('user.quiz.kerjakan', $detail->id_detail_buku) }}"
                                                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                                    Retake Quiz
                                                </a>
                                                <span class="text-sm text-gray-600 mt-2">
                                                    Your Score: {{ $quizScores[$detail->id_detail_buku] }}
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-xl p-8 text-center mb-8">
                                <span class="text-gray-500">
                                    Subscribe to read this chapter
                                </span>
                            </div>
                        @endif
                    @endforeach

                    <!-- Chapter Navigation -->
                    @if($checkLangganan)
                        <div class="flex justify-between items-center mt-12 pt-6 border-t">
                            <form
                                action="{{ in_array($buku->id_detail_buku, $diselesaikan) ? route('user.delete.finished', $buku->id_buku) : route('user.mark.finished', $buku->id_buku) }}"
                                method="POST"
                                class="mt-2 w-full flex justify-between gap-4">
                                @csrf

                                @if(in_array($buku->id_buku, $diselesaikan))
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 w-full flex items-center justify-center gap-2">
                                        <i class="fas fa-trash-alt"></i> Cancel Marked as Finished
                                    </button>
                                @else
                                    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 w-full flex items-center justify-center gap-2">
                                        <i class="far fa-check-circle"></i> Mark as Finished
                                    </button>
                                @endif
                            </form>

                            <button class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Continue Reading
                            </button>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
