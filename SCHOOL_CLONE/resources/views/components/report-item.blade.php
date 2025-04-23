@props(['report'])
<div class="bg-gray-900 border border-gray-800 rounded-lg hover:border-blue-700 transition-all duration-200">
    <div class="p-4">
        <div class="flex justify-between items-start">
            <div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                    </svg>
                    <h4 class="font-medium text-gray-100">{{ $report->title }}</h4>
                </div>
                <p class="text-xs text-gray-400 mt-1">
                    Submitted by {{ $report->user->firstName }} on
                    {{ $report->created_at->format('M d, Y') }}
                </p>
            </div>
            <x-status-badge :status="$report->status" />
        </div>

        <p class="mt-3 text-gray-300 text-sm border-l-2 border-gray-700 pl-3">
            {{ Str::limit($report->content, 150) }}
        </p>

        <div class="mt-3 pt-2 border-t border-gray-800 flex justify-end">
            <a href="{{ route('headteacher.reports.show', $report) }}"
               class="text-xs bg-blue-900 hover:bg-blue-800 text-blue-300 px-3 py-1.5 rounded flex items-center">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                View & Comment
            </a>
        </div>
    </div>
</div>
