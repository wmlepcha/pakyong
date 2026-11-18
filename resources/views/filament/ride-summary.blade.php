@php($ride = $getRecord())
@include('filament.partials-summary-styles')
<div class="rs">
    <div class="rs-body">
        <div class="rs-road" aria-hidden="true">
            <span class="rs-arch"></span>
            <span class="rs-car"><x-glyph name="car" class="size-5"/></span>
            <span class="rs-car-name">{{ $ride->car_type }}</span>
            <span class="rs-pin rs-from"><i></i></span>
            <span class="rs-pin rs-to"><i></i></span>
        </div>
        <div class="rs-ends">
            <div>
                <p class="rs-label">Pickup</p>
                <p class="rs-place">{{ $ride->pickup_location }}</p>
            </div>
            <div style="text-align: right">
                <p class="rs-label">Drop</p>
                <p class="rs-place">{{ $ride->drop_location }}</p>
            </div>
        </div>
        <div class="rs-strip">
            <div>
                <p class="rs-label">Pickup date</p>
                <p class="rs-date">{{ $ride->pickup_date->format('j M Y') }}</p>
            </div>
        </div>
    </div>
    <div class="rs-who">
        <div><p class="rs-label">Name</p><strong>{{ $ride->name }}</strong></div>
        <div><p class="rs-label">WhatsApp</p><strong>{{ $ride->phone }}</strong></div>
        <div><p class="rs-label">Received</p><strong>{{ $ride->created_at->format('j M Y, g:i a') }}</strong></div>
        <p class="rs-district">District: <strong>{{ $ride->pickup_district }}</strong></p>
    </div>
</div>
