@php
    use Modules\SystemBase\app\Services\LivewireService;
    $livewireKey = LivewireService::getKey('market::form.product-rating');
@endphp
<div>

    @livewire('market::form.product-rating', [
        'isFormOpen' => true,
        // 'autoXData' => true,
        'formObjectId' => $formObjectId,

    ], key($livewireKey))

</div>
