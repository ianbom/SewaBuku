<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Table</title>
    <style>
        /* General table styling */
        .responsive-table {
            width: 100%;
            border-collapse: collapse; /* Menghilangkan gap antar border */
            border-spacing: 0; /* Menghilangkan jarak antar sel */
            background-color: white;
        }

        .responsive-table th,
        .responsive-table td {
            text-align: center; /* Membuat konten rata tengah */
            padding: 1rem; /* Menambah jarak di dalam sel */
            border: none; /* Menghilangkan border antar sel */
        }

        .responsive-table th {
            background-color: #1E90FF;
            color: #fff;
            text-transform: uppercase;
            font-size: 0.875rem;
            font-weight: bold;
        }

        .responsive-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .responsive-table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .badge {
            display: inline-block;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .btn {
            display: inline-block;
            text-align: center;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #B1D4FF;
            color: #052D6E;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .responsive-table th,
            .responsive-table td {
                padding: 0.75rem; /* Mengurangi padding untuk layar kecil */
            }

            /* Menghilangkan border dan gap pada sel di layar kecil */
            .responsive-table th,
            .responsive-table td {
                border: none;
            }

            /* Menyembunyikan beberapa kolom pada layar kecil */
            .responsive-table th:nth-child(3),
            .responsive-table td:nth-child(3),
            .responsive-table th:nth-child(4),
            .responsive-table td:nth-child(4),
            .responsive-table th:nth-child(5),
            .responsive-table td:nth-child(5) {
                display: none;
            }
        }
    </style>
</head>

<body>
    <table class="responsive-table" style="border: 2px solid #1E90FF; border-radius: 16px; border-collapse: separate; overflow: hidden;">
        <thead>
            <tr>
                <th class="py-5 px-6">Order ID</th>
                <th class="py-5 px-4">Package Name</th>
                <th class="py-5 px-4">Total Payment</th>
                <th class="py-5 px-4">Status</th>
                <th class="py-5 px-4">Created Date</th>
                <th class="py-5 px-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($order as $o)
                <tr class="hover:bg-gray-50 transition-colors text-[#979797] font-medium">
                    <td class="py-6 px-6">{{ $o->id_order }}</td>
                    <td class="py-6 px-4">{{ $o->paketLangganan->nama_paket ?? '-' }}</td>
                    <td class="py-6 px-4 hidden md:table-cell">Rp{{ number_format($o->total_bayar, 0, ',', '.') }}</td>
                    <td class="py-6 px-4 hidden md:table-cell">
                        @if($o->status_order === 'Proses')
                            <span class="badge py-1 px-2 rounded font-semibold" style="background-color: #c6dbf2; color: #1E90FF;">
                                {{ $o->status_order }}
                            </span>
                        @elseif($o->status_order === 'Selesai')
                            <span class="badge py-1 px-2 rounded font-semibold" style="background-color: #f0ccd0; color: #DC3545;">
                                {{ $o->status_order }}
                            </span>
                        @else
                            <span class="badge py-1 px-2 rounded font-semibold" style="background-color: #cbe2d8; color: #4DAF84;">
                                {{ $o->status_order }}
                            </span>
                        @endif
                    </td>
                    <td class="py-6 px-4 hidden md:table-cell">
                        {{ \Carbon\Carbon::parse($o->created_at)->translatedFormat('d F Y') }}
                    </td>
                    <!-- Action -->
                    <td class="py-3 px-4">
                        <a href="{{ route('user.order.show', $o->id_order) }}"
                           class="btn text-[#1E90FF] font-semibold bg-[#D3E9FF] py-2 px-4 rounded hover:bg-[#B1D4FF] hover:text-[#052D6E] transition">
                            Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-6 text-center text-gray-500">No data found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($order->isNotEmpty())
        <div class="mt-4">
            {{ $order->links() }}
        </div>
    @endif
</body>

</html>
