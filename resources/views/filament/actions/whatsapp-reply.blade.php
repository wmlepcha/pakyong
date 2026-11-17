<div x-data="{ msg: @js($text), sent: false }" class="space-y-4">
    <div class="text-sm text-gray-600">
        To <b class="font-semibold text-gray-900">{{ $record->name }}</b> ({{ $record->phone }}). Edit the message, then send it from your own WhatsApp.
    </div>
    <textarea x-model="msg" rows="6" maxlength="1000" class="fi-input w-full border border-gray-300 bg-white p-3 text-sm" aria-label="Message"></textarea>
    <div class="flex flex-wrap items-center gap-3">
        <a :href="'https://wa.me/{{ $number }}?text=' + encodeURIComponent(msg)" target="_blank" rel="noopener"
           @click="sent = true; fetch(@js($logUrl), { method: 'POST', keepalive: true, headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content }, body: JSON.stringify({ type: @js($type), id: {{ $record->id }}, body: msg }) }).catch(() => {})"
           class="fi-btn fi-color fi-color-success inline-flex items-center gap-2 bg-[#44532e] px-4 py-2 text-sm font-semibold text-white hover:bg-[#2d3a22]">
            Send on WhatsApp
        </a>
        <span x-show="sent" x-cloak class="text-sm text-gray-600">Opened in WhatsApp and noted below. Reload to see the history.</span>
    </div>
    @if ($history->isNotEmpty())
        <div class="border-t border-gray-200 pt-3">
            <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">Earlier messages</p>
            <ul class="space-y-2 text-sm">
                @foreach ($history as $m)
                    <li class="bg-gray-50 p-2"><span class="block text-xs text-gray-500">{{ $m->created_at->format('j M Y, g:i a') }}</span>{{ $m->body }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
