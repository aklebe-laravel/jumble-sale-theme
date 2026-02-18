@php
    use Modules\Market\app\Models\Offer;

    /** @var Offer $offer */

    $urlToOffer = route('manage-data', ['modelName' => 'Offer', 'modelId' => $offer->shared_id]);
    $urlToCreator = $offer->createdByUser->getUserProfileLink();
@endphp
<html lang="de">
    <header>
        @include('notifications.emails.inc.header')
    </header>
    <body>
        @include('notifications.emails.inc.body-head')

        <h2>{{ __('Hello :name', ['name' => $offer->addressedToUser->name]) }}</h2>

        <p>
            Am {{ app('system_base')->formatDate($offer->updated_at) }}
            um {{ app('system_base')->formatTime($offer->updated_at) }} ist ein
            <a href="{{ $urlToOffer }}">Angebot für dich</a> von
            <a href="{{ $urlToCreator }}">{{ $offer->createdByUser->name }}</a> eingegangen.
        </p>

        @include('notifications.emails.inc.body-foot')
    </body>
</html>