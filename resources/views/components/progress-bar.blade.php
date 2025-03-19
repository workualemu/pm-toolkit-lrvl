@props(['progress' => 0, 'status' => 'in-progress', 'end_date' => null])

@php
    $today = now()->format('Y-m-d');
    $color = '#2D9CDB'; // Default Blue

    if ($progress >= 1) {
        $color = '#27AE60'; // Green for completed
    } elseif ($end_date && $end_date < $today && $progress < 1) {
        $color = '#E74C3C'; // Red if past due date and not completed
    }
@endphp

<div class="w-full bg-gray-200 h-4 dark:bg-gray-700 overflow-hidden">
    <div class="h-full text-center text-xs text-white font-bold leading-4 transition-all duration-500"
        style="width: {{ $progress * 100}}%; background-color: {{ $color }};">
        {{ $progress * 100}}%
    </div>
</div>
