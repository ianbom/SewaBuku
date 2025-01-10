@extends('sewa_buku.layouts.user')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@php
    // Array gambar yang tersedia
    $images = [
        asset('images/paket1.png'),
        asset('images/paket2.png'),
        asset('images/paket3.png'),
    ];
@endphp
<section id="about" class="hero-section bg-white py-20 mt-20 px-4 sm:px-6 md:px-8">
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <!-- Left section (Text and buttons) -->
            <div class="flex-1 pr-0 md:pr-4">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-semibold text-[#052D6E] mb-6" style="font-family: 'Libre Baskerville', serif; line-height: 1.2;">
                    The more that you <span class="text-[#1E90FF]">read</span>, the more <span class="text-[#1E90FF]">things</span> that you will know.
                </h1>

                <div class="flex space-x-4 mt-12">
                    <a href="#subscription"
                       class="bg-gradient-to-r from-[#1E90FF] to-[#052D6E] text-white px-6 py-2 rounded-[16px] hover:bg-[#1E90FF] font-semibold flex items-center space-x-2">
                        Subscribe
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent border-2 border-[#1E90FF] text-[#1E90FF] py-2 px-6 rounded-[16px] hover:bg-[#D3E9FF] transition duration-300">
                        Login
                    </a>
                </div>
            </div>

            <!-- Right section (Image) - hidden on mobile -->
            <div class="flex-1 text-center md:block hidden">
                <img src="images/hero.png" alt="Hero Image" class="max-w-2/3 mx-auto">
            </div>
        </div>
    </div>
</section>

<!--section FEATURE-->

<section id="features"  class="features bg-white py-16">
        <!-- Title -->
        <h2 class="text-[#052D6E] text-center font-semibold text-2xl mb-4" style="font-family: 'Libre Baskerville', serif;">Features</h2>
        <!-- Description -->
        <p class="text-center text-[#052D6E] text-4xl font-semibold  mb-12" style="font-family: 'Libre Baskerville', serif;">
            <span class="text-[#1E90FF]">Bacaan</span> Insightful, <span class="text-[#1E90FF]">Hidup</span> Meaningful
        </p>
        <div class="flex justify-center">
        <!-- Cards Section -->
        <div class="flex justify-center">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 bg-[#F1F8FF] p-6 rounded-[16px]  w-full max-w-6xl">
                <div class=" p-6 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <img src="images/audio.png" class="w-3/5 rounded-lg">
                        </div>
                        <!-- Right Column - Text and Button -->
                        <div class="flex flex-col justify-center">
                            <h3 class="text-[#1E90FF] font-semibold text-xl mb-2" style="font-family: 'Libre Baskerville', serif;">Audio Book</h3>
                            <p class="text-[#484848] mb-2">Enjoy Your Favorite Books Anytime, Anywhere</p>
                        </div>
                    </div>
                </div>
                <div class=" p-6 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <img src="images/highlight.png" class="w-3/5 rounded-lg">
                        </div>
                        <!-- Right Column - Text and Button -->
                        <div class="flex flex-col justify-center">
                            <h3 class="text-[#1E90FF] font-semibold text-xl mb-2" style="font-family: 'Libre Baskerville', serif;">Highlight</h3>
                            <p class="text-[#484848] mb-2">Save Your Favorite Texts with Ease</p>
                            <a href="#" class="bg-[#1E90FF] text-white py-1 px-6 rounded-[16px] text-center  w-[60%] self-start cursor-not-allowed pointer-events-none">
                                PREMIUM
                            </a>
                        </div>
                    </div>
                </div>
                <div class=" p-6 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <img src="images/quiz.png" class="w-3/5 rounded-lg">
                        </div>
                        <!-- Right Column - Text and Button -->
                        <div class="flex flex-col justify-center">
                            <h3 class="text-[#1E90FF] font-semibold text-xl mb-2" style="font-family: 'Libre Baskerville', serif;">Quiz</h3>
                            <p class="text-[#484848] mb-2">est Your Knowledge with Interactive Quizzes</p>
                        </div>
                    </div>
                </div>
                <div class=" p-6 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 ">
                        <div>
                            <img src="images/save.png" class="w-3/5 rounded-lg">
                        </div>
                        <!-- Right Column - Text and Button -->
                        <div class="flex flex-col justify-center">
                            <h3 class="text-[#1E90FF] font-semibold text-xl mb-2" style="font-family: 'Libre Baskerville', serif;">Library collection</h3>
                            <p class="text-[#484848] mb-2">Your Personal Library, Always Within Reach</p>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>

<!--section why chosen...-->
<div class="flex justify-center py-12 ">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 w-full max-w-6xl p-6">
        <div class="flex justify-center items-center">
            <img src="images/book.png" alt="Why Choose Us" class="w-4/5 rounded-lg">
        </div>

        <!-- Right Column - Text and Icon List -->
        <div class="flex flex-col justify-center">
            <h2 class="text-[#1E90FF]  font-semibold text-2xl mb-3" style="font-family: 'Libre Baskerville', serif;">Why Choose Us</h2>
            <p class="text-[#052D6E] mb-2 font-semibold text-3xl mb-8" style="font-family: 'Libre Baskerville', serif;">Your Ultimate Companion for Learning, Growth, and Enjoyment</p>

            <ul>
                <li class="flex items-start mb-4">
                    <div class="bg-[#1E90FF] text-white rounded-[8px] pl-4 pr-4 pt-2 pb-2 mr-4">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h3 class="text-[#052D6E] font-semibold" style="font-family: 'Libre Baskerville', serif;">Personalisasi Terbaik</h3>
                        <p class="text-[#979797]">Shae Life menyesuaikan diri dengan kebiasaan membaca Anda, memberikan rekomendasi yang sesuai dengan minat dan tujuan Anda.</p>
                    </div>
                </li>
                <li class="flex items-start mb-4">
                    <div class="bg-[#1E90FF] text-white rounded-[8px] pl-4 pr-4 pt-2 pb-2 mr-4">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h3 class="text-[#052D6E]  font-semibold" style="font-family: 'Libre Baskerville', serif;">Features Multifungsi</h3>
                        <p class="text-[#979797]">Shae Life menggabungkan berbagai alat bantu belajar dan konten interaktif dalam satu platform yang mudah diakses.

                        </p>
                    </div>
                </li>
                <li class="flex items-start mb-4">
                    <div class="bg-[#1E90FF] text-white rounded-[8px] pl-4 pr-4 pt-2 pb-2 mr-4">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h3 class="text-[#052D6E] font-semibold" style="font-family: 'Libre Baskerville', serif;">Belajar Kapan Saja, di Mana Saja</h3>
                        <p class="text-[#979797]">Shae Life menyesuaikan diri dengan kebiasaan membaca Anda, memberikan rekomendasi yang sesuai dengan minat dan tujuan Anda.</p>
                    </div>
                </li>
                <li class="flex items-start mb-4">
                    <div class="bg-[#1E90FF] text-white rounded-[8px] pl-4 pr-4 pt-2 pb-2 mr-4">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h3 class="text-[#052D6E] font-semibold" style="font-family: 'Libre Baskerville', serif;">Tetap Termotivasi dan Terlibat</h3>
                        <p class="text-[#979797]">Shae Life menyesuaikan diri dengan kebiasaan membaca Anda, memberikan rekomendasi yang sesuai dengan minat dan tujuan Anda.</p>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>

<!-- Section Categories -->
<section id="categories" class="features bg-[#F1F8FF] py-24 px-4 sm:px-6 md:px-8">
    <!-- Title -->
    <h2 class="text-[#1E90FF] text-center font-semibold text-2xl mb-4" style="font-family: 'Libre Baskerville', serif;">
        Categories and Topics List
    </h2>

    <!-- Description -->
    <p class="text-center text-[#052D6E] text-4xl font-semibold mb-12" style="font-family: 'Libre Baskerville', serif;">
        Explore <span class="text-[#1E90FF]">Categories</span> and <span class="text-[#1E90FF]">Topics</span> That Match Your Interests
    </p>

    <div class="flex justify-center">
        <!-- Cards Section Category -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 p-6 rounded-[16px] w-full max-w-6xl">

            @foreach ($parentTags as $item)

            <!-- Category Card 1 -->
            <div class="p-6 rounded-[16px]" style="background-image: url('images/kategori.png'); background-size: cover; background-position: center;">
                <h3 class="text-white font-semibold text-xl mb-2" style="font-family: 'Libre Baskerville', serif;">{{ $item->nama_tags }}</h3>
                <div class="flex flex-col justify-center bg-white rounded-[16px] p-4">
                    <ul>
                        @foreach ($item->child as $child)


                        <li class="flex items-start mb-4">
                            <div class="bg-[#1E90FF] text-white rounded-[8px] p-2 mr-2 flex items-center justify-center w-6 h-6">
                                <i class="fas fa-folder text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-[#052D6E] font-semibold">{{ $child->nama_tags }}</h3>
                            </div>
                        </li>

                        @endforeach
                    </ul>
                </div>
            </div>

            @endforeach

            <!-- Category Card 2 -->


            <!-- Category Card 3 -->


        </div>
    </div>
</section>



<!--section STEPS-->
<div class="flex justify-center items-center min-h-screen bg-white px-6 sm:px-8 md:px-12">
    <section class="flex flex-col md:flex-row items-start md:items-center bg-white w-full rounded-lg py-24 max-w-6xl mx-auto">
        <!-- Bagian Kiri -->
        <div class="md:w-1/2 mb-6 md:mb-0">
            <p class="text-[#052D6E] text-4xl font-semibold mb-6" style="font-family: 'Libre Baskerville', serif;"> Find Your
            </p>
            <p class="text-[#1E90FF] text-4xl font-semibold" style="font-family: 'Libre Baskerville', serif;"> Favorite Book
            </p>
        </div>

        <!-- Bagian Kanan -->
        <div class="md:w-1/2">
            <ul class="space-y-4">
                <li class="flex items-center bg-[#052D6E] text-white rounded-[16px] p-4">
                    <div class="w-8 h-8 flex items-center justify-center bg-white text-[#052D6E] font-semibold rounded-full mr-4">
                        1
                    </div>
                    <span>Read or Listen with Ease</span>
                </li>
                <li class="flex items-center bg-[#385688] text-white rounded-[16px] p-4">
                    <div class="w-8 h-8 flex items-center justify-center bg-white text-[#385688] font-semibold rounded-full mr-4">
                        2
                    </div>
                    <span>Learning Methods</span>
                </li>
                <li class="flex items-center bg-[#526E9C] text-white rounded-[16px] p-4">
                    <div class="w-8 h-8 flex items-center justify-center bg-white text-[#526E9C] font-semibold rounded-full mr-4">
                        3
                    </div>
                    <span>Take Notes and Highlight Key Points</span>
                </li>
                <li class="flex items-center bg-[#8DA0BF] text-white rounded-[16px] p-4">
                    <div class="w-8 h-8 flex items-center justify-center bg-white text-[#8DA0BF] font-semibold rounded-full mr-4">
                        4
                    </div>
                    <span>Test Your Understanding</span>
                </li>
                <li class="flex items-center bg-[#A8B6CD] text-white rounded-[16px] p-4">
                    <div class="w-8 h-8 flex items-center justify-center bg-white text-[#A8B6CD] font-semibold rounded-full mr-4">
                        5
                    </div>
                    <span>Save to Your Personal Library</span>
                </li>
            </ul>
        </div>
    </section>
</div>


<!--section TESTIMONI-->
<section id="testimonial"  class="features bg-[#F1F8FF] py-24">
    <!-- Title -->
    <h2 class="text-[#1E90FF] text-center font-semibold text-2xl mb-4" style="font-family: 'Libre Baskerville', serif;">Testimonial
    </h2>

    <!-- Description -->
    <p class="text-center text-[#052D6E] text-4xl font-semibold  mb-12" style="font-family: 'Libre Baskerville', serif;"> What do
        <span class="text-[#1E90FF]">They Say </span> about <span class="text-[#1E90FF]">Shae Insight?</span>
    </p>
  <div class="flex justify-center">
    <!-- Cards Section Category-->
    <div class="flex justify-center">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 p-6 rounded-[16px]  w-full max-w-6xl">


            <!--TESTIMONI 1-->
            <div class="p-6 rounded-[50px_0_50px_0] border-2 border-[#052D6E] bg-white max-w-sm mx-auto">
                    <!-- Foto -->
                    <div class="flex justify-center mb-4">
                    <img src="images/foto2.png" alt="Profile Picture" class="w-16 h-16 rounded-full border-none" />
                    </div>
                    <!-- Nama -->
                    <h3 class="text-[#052D6E] font-semibold text-lg text-center">Lana Cook</h3>
                    <!-- Pekerjaan -->
                    <p class="text-[#979797] text-sm text-center">Marketing Director</p>
                    <!-- Bintang -->
                    <div class="flex justify-center items-center my-4">
                    <i class="fas fa-star text-[#052D6E]"></i>
                    <i class="fas fa-star text-[#052D6E]"></i>
                    <i class="fas fa-star text-[#052D6E]"></i>
                    <i class="fas fa-star text-[#052D6E]"></i>
                    <i class="fas fa-star text-[#74A9DD]"></i>
                    </div>
                    <!-- Testimoni -->
                    <p class="text-[#052D6E] text-sm text-center">
                       "The experience with Shae Insight has been amazing. The insights have boosted my confidence and effectiveness."
                    </p>
              </div>

               <!--TESTIMONI 2-->
              <div class="p-6 rounded-[50px_0_50px_0] border-2 border-[#052D6E] bg-white max-w-sm mx-auto">
                <!-- Foto -->
                <div class="flex justify-center mb-4">
                <img src="images/foto1.png" alt="Profile Picture" class="w-16 h-16 rounded-full border-none" />
                </div>
                <!-- Nama -->
                <h3 class="text-[#052D6E] font-semibold text-lg text-center">Maxin Will</h3>
                <!-- Pekerjaan -->
                <p class="text-[#979797] text-sm text-center">Product Manager</p>
                <!-- Bintang -->
                <div class="flex justify-center items-center my-4">
                <i class="fas fa-star text-[#052D6E]"></i>
                <i class="fas fa-star text-[#052D6E]"></i>
                <i class="fas fa-star text-[#052D6E]"></i>
                <i class="fas fa-star text-[#052D6E]"></i>
                <i class="fas fa-star text-[#74A9DD]"></i>
                </div>
                <!-- Testimoni -->
                <p class="text-[#052D6E] text-sm text-center">
                "Shae Insight has greatly helped me grow both personally and professionally. Highly recommend it!"
                </p>
          </div>

           <!--TESTIMONI 3-->
          <div class="p-6 rounded-[50px_0_50px_0] border-2 border-[#052D6E] bg-white max-w-sm mx-auto">
            <!-- Foto -->
            <div class="flex justify-center mb-4">
            <img src="images/foto1.png" alt="Profile Picture" class="w-16 h-16 rounded-full border-none" />
            </div>
            <!-- Nama -->
            <h3 class="text-[#052D6E] font-semibold text-lg text-center">Emily Johnson</h3>
            <!-- Pekerjaan -->
            <p class="text-[#979797] text-sm text-center">Content Strategist</p>
            <!-- Bintang -->
            <div class="flex justify-center items-center my-4">
            <i class="fas fa-star text-[#052D6E]"></i>
            <i class="fas fa-star text-[#052D6E]"></i>
            <i class="fas fa-star text-[#052D6E]"></i>
            <i class="fas fa-star text-[#052D6E]"></i>
            <i class="fas fa-star text-[#74A9DD]"></i>
            </div>
            <!-- Testimoni -->
            <p class="text-[#052D6E] text-sm text-center">
                "I love how Shae Insight provides clear guidance on personal and career development. It has been a game changer for me!"
            </p>
      </div>



            </div>
    </div>
</div>
</section>


<!--section BERLANGGAN-->
<div id="subscription" class="flex justify-center items-center min-h-screen bg-white px-6 sm:px-8 md:px-12">
    <section class="features py-24 max-w-6xl mx-auto">
        <!-- Title -->
        <h2 class="text-[#1E90FF] text-center font-semibold text-2xl mb-4" style="font-family: 'Libre Baskerville', serif;">Choose Your Subscription Plan</h2>

        <!-- Description -->
        <p class="text-center text-[#052D6E] text-4xl font-semibold mb-12" style="font-family: 'Libre Baskerville', serif;">
            Discover the <span class="text-[#1E90FF]">Subscription Plan</span> that Best Fits Your <span class="text-[#1E90FF]">Needs</span> and Goals
        </p>

        <div class="flex justify-center max-w-6xl mx-auto">
            <!-- Package Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($paketLangganan as $paket)


                @php
                    // Pilih gambar secara acak
                    $randomImage = $images[array_rand($images)];
                @endphp
                <div class="bg-[#1E90FF] rounded-[16px] p-6 text-white">
                    <!-- Gambar Acak -->
                    <div class="mb-4">
                        <img src="{{ $randomImage }}" alt="Package Image" class="rounded-lg w-full h-50 object-cover">
                    </div>

                    <h3 class="text-[16px] font-bold mb-2">{{ $paket->nama_paket }}</h3>
                    <p class="mb-6 text-[14px] text-white">{{ $paket->deskripsi }}</p>

                    <!-- Time and Price -->
                    <div class="flex justify-between items-center mb-6 p-3 border rounded-[8px]">
                        <div class="flex items-center space-x-2">
                            <span class="text-[14px]">{{ $paket->masa_waktu }} Hari</span>
                        </div>
                        <div class="text-[16px] font-bold">
                            <span>{{ formatToIndonesianCurrency($paket->harga)  }}</span>
                        </div>
                    </div>

                    <button type="button"
                            class="w-full bg-[#D3E9FF] text-[#1E90FF] py-4 rounded-[12px] font-bold hover:bg-white transition"
                            onclick="window.location.href='{{ route('login') }}'">
                        Subscribe Now
                    </button>
                </div>
                @endforeach
            </div>

        </div>
    </section>
</div>



<!-- SECTION BUKU -->
<div id="books" class="flex justify-center items-center min-h-screen bg-[#F1F8FF] px-6 sm:px-8 md:px-12">
    <section class="features py-24 max-w-6xl mx-auto">
        <!-- Title -->
        <h2 class="text-[#052D6E] text-center font-semibold text-4xl mb-12" style="font-family: 'Libre Baskerville', serif;">
            Explore Available Books
        </h2>

        <!-- Book Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach ($buku as $book)
                <div class="bg-[#F1F8FF] rounded-[16px] overflow-hidden border-2 border-transparent hover:border-[#D3E9FF] transition-all">
                    <a href="{{ route('login') }}">
                        @if ($book->coverBuku && $book->coverBuku->first())
                            <img src="{{ asset('storage/' . $book->coverBuku->first()->file_image) }}" alt="Cover Buku" class="w-full h-128 object-cover rounded-[16px]">
                        @else
                            <img src="https://via.placeholder.com/150" alt="Cover Placeholder" class="w-full h-64 object-cover">
                     @endif
                    </a>

                    <div class="p-4">
                        <h3 class="text-[#052D6E] text-[14px] font-semibold mb-2" style="font-family: 'Inter', sans-serif;">{{ $book->judul_buku }}</h3>
                        <p class="text-[#979797] font-medium text-[14px]" style="font-family: 'Inter', sans-serif;">{{ $book->penulis }}</p>

                        <div class="flex justify-between items-center text-[#979797] text-sm mt-4">
                            <div class="flex items-center">
                                <i class="fa fa-clock mr-2 p-2 rounded-[8px] text-[12px]" style="background-color: #D3E9FF; color: #1E90FF;"></i>
                                <span class="font-inter font-medium text-[12px]" style="color: #979797; font-family: 'Inter', sans-serif;">{{ floor($book->totalWaktu / 60) }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-star mr-2 p-2 rounded-[8px] text-[12px]" style="background-color: #FAFAD8; color: #B79F54;"></i>
                                <span class="font-inter font-medium text-[12px]" style="color: #979797; font-family: 'Inter', sans-serif;">{{ number_format($book->ratingRerata, 1) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Explore More Button -->
        <div class="text-center mt-16">
            <a href="{{ route('login') }}" class="bg-[#F1F8FF] text-[#1E90FF] py-2 px-6 rounded-full border-2 border-[#1E90FF] hover:bg-[#1E90FF] hover:text-white transition duration-300">
                Explore More
            </a>
        </div>
    </section>
</div>



    <!-- SECTION FAQ -->
<section id="faq" class="features py-24 max-w-6xl mx-auto px-6 sm:px-4">
    <h2 class="text-3xl font-semibold text-center mb-12 text-[#052D6E]" style="font-family: 'Libre Baskerville', serif;">FAQ</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- FAQ 1 -->
        <div class="bg-[#D3E9FF] p-6 rounded-lg" id="faq-1">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-[#1E90FF]">What is a subscription package?</h3>
                <button class="text-[#1E90FF]" onclick="toggleAnswer(1)">
                    <span id="toggle-icon-1">+</span>
                </button>
            </div>
            <p id="answer-1" class="text-[#979797] hidden mt-4">A subscription package is a paid service that gives access to exclusive content for a certain period of time.</p>
        </div>
        <!-- FAQ 2 -->
        <div class="bg-[#D3E9FF] p-6 rounded-lg" id="faq-2">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-[#1E90FF]">How do I subscribe?</h3>
                <button class="text-[#1E90FF]" onclick="toggleAnswer(2)">
                    <span id="toggle-icon-2">+</span>
                </button>
            </div>
            <p id="answer-2" class="text-[#979797] hidden mt-4">You can subscribe by selecting the desired package and following the provided payment procedure.</p>
        </div>
        <!-- FAQ 3 -->
        <div class="bg-[#D3E9FF] p-6 rounded-lg" id="faq-3">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-[#1E90FF]">Can I cancel my subscription?</h3>
                <button class="text-[#1E90FF]" onclick="toggleAnswer(3)">
                    <span id="toggle-icon-3">+</span>
                </button>
            </div>
            <p id="answer-3" class="text-[#979797] hidden mt-4">Yes, you can cancel your subscription at any time according to the applicable policy.</p>
        </div>
        <!-- FAQ 4 -->
        <div class="bg-[#D3E9FF] p-6 rounded-lg" id="faq-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-[#1E90FF]">Are there any discounts for new customers?</h3>
                <button class="text-[#1E90FF]" onclick="toggleAnswer(4)">
                    <span id="toggle-icon-4">+</span>
                </button>
            </div>
            <p id="answer-4" class="text-[#979797] hidden mt-4">We offer special discounts for new customers. Check out our promotions page for more details.</p>
        </div>
    </div>
</section>


<script>
    function toggleAnswer(faqNumber) {
        const answer = document.getElementById('answer-' + faqNumber);
        const icon = document.getElementById('toggle-icon-' + faqNumber);
        const faqSection = document.getElementById('faq-' + faqNumber);

        if (answer.classList.contains('hidden')) {
            answer.classList.remove('hidden');
            icon.textContent = '-';
            faqSection.style.backgroundColor = '#F1F8FF';  // Change background color when answer is visible
        } else {
            answer.classList.add('hidden');
            icon.textContent = '+';
            faqSection.style.backgroundColor = '#D3E9FF';  // Revert to original color when answer is hidden
        }
    }
</script>


<!-- Footer Section -->
<footer class="bg-[#1E90FF] text-white pt-12">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <!-- Deskripsi Website -->
            <div class=" sm:text-left mb-6 sm:mb-0 max-w-xs sm:max-w-sm">
                <p class="font-semibold text-lg">Shae Insight</p>
                <p class="text-sm mt-2">Empowering your personal growth with insights that drive lasting change and deepen understanding in just 1 minute.</p>
            </div>

            <!-- Quick Links -->
            <div class="flex flex-col sm:flex-row justify-between gap-8 w-full sm:w-auto">
                <!-- Company Section -->
                <div class="sm:w-1/2">
                    <h4 class="font-semibold text-white mb-3">Company</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#about" class="hover:text-[#052D6E]">About Us</a></li>
                        <li><a href="#features" class="hover:text-[#052D6E]">Features</a></li>
                        <li><a href="#testimonial" class="hover:text-[#052D6E]">Testimonial</a></li>
                        <li><a href="#faq" class="hover:text-[#052D6E]">FAQ</a></li>
                    </ul>
                </div>

                <!-- Explore Section -->
                <div class="sm:w-1/2">
                    <h4 class="font-semibold text-white mb-3">Explore</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#categories" class="hover:text-[#052D6E]">Categories & Topics List</a></li>
                        <li><a href="#subscription" class="hover:text-[#052D6E]">Subscription</a></li>
                        <li><a href="#books" class="hover:text-[#052D6E]">Books</a></li>
                    </ul>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="mt-6 sm:mt-0">
                <h4 class="font-semibold text-white mb-3">Follow Us</h4>
                <ul class="flex space-x-6 justify-center sm:justify-start">
                    <li>
                        <a href="https://facebook.com" target="_blank" class="hover:text-[#052D6E]">
                            <i class="fab fa-facebook-f text-2xl"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com" target="_blank" class="hover:text-[#052D6E]">
                            <i class="fab fa-twitter text-2xl"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://linkedin.com" target="_blank" class="hover:text-[#052D6E]">
                            <i class="fab fa-linkedin-in text-2xl"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://instagram.com" target="_blank" class="hover:text-[#052D6E]">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Copyright Section -->
    <div class="bg-[#D3E9FF]  text-[#1E90FF] text-center py-4 text-sm mt-10">
        <p>&copy; 2025 Shae Insight. All Rights Reserved.</p>
    </div>
</footer>



<!-- Font Awesome CDN for Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>



@endsection
