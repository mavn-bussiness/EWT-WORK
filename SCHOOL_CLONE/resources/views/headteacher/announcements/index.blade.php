<x-app-layout title="Circular Management">
    <x-card>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Upload New Circular</h2>
            </div>
        </x-slot>
        
        <form action="{{ route('headteacher.announcements.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <x-input-group label="Title" name="title" required />
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-select-group label="Audience" name="audience" required>
                        <option value="all">All Staff & Students</option>
                        <option value="teachers">Teachers Only</option>
                        <option value="students">Students Only</option>
                        <option value="parents">Parents Only</option>
                    </x-select-group>
                    
                    <x-input-group label="Publish Date" name="publish_date" type="date" required />
                    <x-input-group label="Expiry Date" name="expiry_date" type="date" />
                </div>
                
                <x-textarea-group label="Content" name="content" rows="5" required />
                
                <x-file-input-group label="Attachment (PDF/DOC)" name="attachment" />
                
                <div class="flex justify-end">
                    <x-button type="submit">
                        Publish Circular
                    </x-button>
                </div>
            </div>
        </form>
    </x-card>

    <x-card class="mt-6">
        <x-slot name="header">
            <h2 class="text-xl font-semibold">Recent Circulars</h2>
        </x-slot>
        
        <div class="space-y-4">
            @foreach($announcements as $announcement)
                <x-announcement-item :announcement="$announcement" />
            @endforeach
            
            <div class="mt-4">
                {{ $announcements->links() }}
            </div>
        </div>
    </x-card>
</x-app-layout>