@props(['announcement'])
<div class="border rounded-lg overflow-hidden">
    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
        <h3 class="font-medium text-lg">{{ $announcement->title }}</h3>
        <span class="text-sm text-gray-500">
            {{ $announcement->publish_date->format('M d, Y') }}
        </span>
    </div>
    
    <div class="p-4">
        <p class="text-gray-700 mb-4">{{ Str::limit($announcement->content, 200) }}</p>
        
        @if($announcement->attachment_path)
            <div class="mt-3">
                <a href="{{ Storage::url($announcement->attachment_path) }}" target="_blank" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Download Attachment
                </a>
            </div>
        @endif
        
        <div class="mt-4 flex justify-between items-center">
            <span class="text-sm text-gray-500">
                Audience: {{ ucfirst($announcement->audience) }}
            </span>
            @if($announcement->expiry_date)
                <span class="text-sm {{ $announcement->expiry_date->isPast() ? 'text-red-500' : 'text-green-500' }}">
                    {{ $announcement->expiry_date->isPast() ? 'Expired' : 'Expires' }}: 
                    {{ $announcement->expiry_date->format('M d, Y') }}
                </span>
            @endif
        </div>
    </div>
</div>