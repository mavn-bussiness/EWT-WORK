@props(['announcement'])
<div class="bg-gray-900 border border-gray-800 rounded-lg overflow-hidden hover:border-blue-700 transition-all duration-200">
    <div class="bg-gray-800 px-4 py-3 border-b border-gray-700 flex justify-between items-center">
        <div class="flex items-center">
            <svg class="w-4 h-4 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z"/>
            </svg>
            <h3 class="font-medium text-gray-100">{{ $announcement->title }}</h3>
        </div>
        <span class="text-xs text-gray-400 bg-gray-700 py-1 px-2 rounded">
            {{ $announcement->publish_date->format('M d, Y') }}
        </span>
    </div>

    <div class="p-4">
        <p class="text-gray-300 text-sm mb-4">{{ Str::limit($announcement->content, 200) }}</p>

        @if($announcement->attachment_path)
            <div class="mt-3 border-t border-gray-800 pt-3">
                <a href="{{ Storage::url($announcement->attachment_path) }}" target="_blank"
                   class="inline-flex items-center px-3 py-1.5 bg-gray-800 border border-gray-700 text-blue-400 hover:text-blue-300 rounded text-xs">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Download Attachment
                </a>
            </div>
        @endif

        <div class="mt-4 flex justify-between items-center pt-2 border-t border-gray-800">
            <span class="text-xs bg-gray-800 text-gray-400 py-1 px-2 rounded">
                Audience: {{ ucfirst($announcement->audience) }}
            </span>
            @if($announcement->expiry_date)
                <span class="text-xs py-1 px-2 rounded {{ $announcement->expiry_date->isPast() ? 'bg-red-900 text-red-300' : 'bg-green-900 text-green-300' }}">
                    {{ $announcement->expiry_date->isPast() ? 'Expired' : 'Expires' }}:
                    {{ $announcement->expiry_date->format('M d, Y') }}
                </span>
            @endif
        </div>
    </div>
</div>
