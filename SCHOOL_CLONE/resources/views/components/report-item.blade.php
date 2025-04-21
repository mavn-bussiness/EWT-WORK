@props(['report'])
<div class="border rounded-lg p-4 hover:bg-gray-50 transition">
    <div class="flex justify-between items-start">
        <div>
            <h4 class="font-medium">{{ $report->title }}</h4>
            <p class="text-sm text-gray-500 mt-1">
                Submitted by {{ $report->user->firstName }} on 
                {{ $report->created_at->format('M d, Y') }}
            </p>
        </div>
        <x-status-badge :status="$report->status" />
    </div>
    
    <p class="mt-2 text-gray-700 text-sm">
        {{ Str::limit($report->content, 150) }}
    </p>
    
    <div class="mt-3 flex justify-end">
        <a href="{{ route('headteacher.reports.show', $report) }}" 
           class="text-sm text-blue-600 hover:underline">
            View & Comment
        </a>
    </div>
</div>