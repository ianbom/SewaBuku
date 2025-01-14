<head>
    <style>
        /* General table styling */
        .responsive-table {
            width: 100%;
            border-collapse: collapse;
        }

        .responsive-table th,
        .responsive-table td {
            text-align: left;
            padding: 1rem;
            border: 1px solid #ddd;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            /* Hide all columns except Order ID, Package Name, and Action */
            .responsive-table th:nth-child(3),
            .responsive-table td:nth-child(3),
            .responsive-table th:nth-child(4),
            .responsive-table td:nth-child(4),
            .responsive-table th:nth-child(5),
            .responsive-table td:nth-child(5) {
                display: none;
            }

            /* Add dropdown for additional details */
            .dropdown-details {
                display: block;
                background-color: #f9f9f9;
                margin: 0.5rem 0;
                padding: 1rem;
                border-radius: 0.5rem;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            }

            .dropdown-details span {
                display: block;
                margin-bottom: 0.5rem;
                font-size: 0.875rem;
                color: #555;
            }
        }
    </style>
</head>

<table class="table table-striped bg-white responsive-table">
    <thead>
        <tr class="bg-[#1E90FF] text-white uppercase text-sm font-semibold">
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
                <span class="badge py-1 px-2 rounded font-semibold" style="background-color: #c6dbf2; color: #1E90FF; text-transform: uppercase;">
                    {{ $o->status_order }}
                </span>
                @elseif($o->status_order === 'Selesai')
                <span class="badge py-1 px-2 rounded font-semibold" style="background-color: #f0ccd0; color: #DC3545; text-transform: uppercase;">
                    {{ $o->status_order }}
                </span>
                @else
                <span class="badge py-1 px-2 rounded font-semibold" style="background-color: #cbe2d8; color: #4DAF84; text-transform: uppercase;">
                    {{ $o->status_order }}
                </span>
                @endif
            </td>
            <td class="py-6 px-4 hidden md:table-cell">
                {{ \Carbon\Carbon::parse($o->created_at)->translatedFormat('d F Y') }}
            </td>
            <!-- Action -->
            <td class="py-3 px-4">
                <a href="{{ route('user.order.show', $o->id_order) }}" class="btn text-[#1E90FF] font-semibold bg-[#D3E9FF] py-2 px-4 rounded hover:bg-[#B1D4FF] hover:text-[#052D6E] transition">
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
</div>
@endif
