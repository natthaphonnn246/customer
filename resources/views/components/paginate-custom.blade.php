@if ($paginator->hasPages())
<div class="flex justify-start gap-2 mt-2 mb-8">

    {{-- Prev --}}
    @if ($paginator->onFirstPage())
        <span class="px-3 py-1 bg-gray-300 rounded">Prev</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="px-3 py-1 bg-blue-500 text-white rounded">Prev</a>
    @endif

    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
    @endphp

    {{-- แสดง 3 ปุ่มรอบ current --}}
    @for ($i = max(1, $current - 1); $i <= min($last, $current + 1); $i++)
        <a href="{{ $paginator->url($i) }}"
           class="px-3 py-1 rounded 
           {{ $i == $current ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
            {{ $i }}
        </a>
    @endfor

    {{-- ถ้ามีมากกว่า 5 หน้า ให้โชว์ ... และ 2 หน้าสุดท้าย --}}
    @if ($last > 5 && $current + 1 < $last - 1)
        <span class="px-2">...</span>

        @for ($i = $last - 1; $i <= $last; $i++)
            <a href="{{ $paginator->url($i) }}"
               class="px-3 py-1 bg-gray-200 rounded">
                {{ $i }}
            </a>
        @endfor
    @endif

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="px-3 py-1 bg-blue-500 text-white rounded">Next</a>
    @else
        <span class="px-3 py-1 bg-gray-300 rounded">Next</span>
    @endif

</div>
@endif
