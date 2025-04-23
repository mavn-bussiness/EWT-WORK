<div class="bg-slate-800 rounded-lg shadow-md overflow-hidden border border-slate-700">
    @isset($header)
        <div class="px-6 py-4 border-b border-slate-700 bg-slate-900 flex items-center justify-between">
            {{ $header }}
        </div>
    @endisset

    <div class="p-6">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="px-6 py-4 border-t border-slate-700 bg-slate-900 flex items-center justify-between">
            {{ $footer }}
        </div>
    @endisset
</div>
