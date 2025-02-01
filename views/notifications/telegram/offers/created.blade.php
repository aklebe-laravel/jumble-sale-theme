@php
    use Modules\Market\app\Models\Offer;

    /** @var Offer $offer */

    $urlToOffer = route('manage-data', ['modelName' => 'Offer', 'modelId' => $offer->shared_id]);
    $urlToCreator = route('user-profile', ['id' => $offer->createdByUser->shared_id]);
@endphp
{{--telegram HTML mode supports: <b></b>, <i></i>, <s></s>, <u></u>--}}
<b>{{ __('Hello :name', ['name' => $offer->addressedToUser->name]) }}</b>

Am {{ app('system_base')->formatDate($offer->updated_at) }}
um {{ app('system_base')->formatTime($offer->updated_at) }} ist ein
Angebot für dich von {{ $offer->createdByUser->name }} eingegangen.

{{ $urlToOffer }}

