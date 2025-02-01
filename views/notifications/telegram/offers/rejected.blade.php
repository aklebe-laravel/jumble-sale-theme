@php
    use Modules\Market\app\Models\Offer;

    /** @var Offer $offer */

    $urlToOffer = route('manage-data', ['modelName' => 'Offer', 'modelId' => $offer->shared_id]);
    $urlToTargetUser = route('user-profile', ['id' => $offer->addressedToUser->shared_id]);
@endphp
{{--telegram HTML mode supports: <b></b>, <i></i>, <s></s>, <u></u>--}}
<b>{{ __('Hello :name', ['name' => $offer->createdByUser->name]) }}</b>

Dein Angebot an {{ $offer->addressedToUser->name }}
vom {{ app('system_base')->formatDate($offer->created_at) }}
um {{ app('system_base')->formatTime($offer->created_at) }}
wurde abgelehnt.

{{ $urlToOffer }}

