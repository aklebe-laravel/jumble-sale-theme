@php
    use Modules\Market\app\Models\Offer;

    /** @var Offer $offer */

    $urlToOffer = route('manage-data', ['modelName' => 'Offer', 'modelId' => $offer->shared_id]);
    $urlToTargetUser = route('user-profile', ['id' => $offer->addressedToUser->shared_id]);
@endphp
<html lang="de">
    <header>
        @include('notifications.emails.inc.header')
    </header>
    <body>
        @include('notifications.emails.inc.body-head')

        <h2>{{ __('Hello :name', ['name' => $offer->createdByUser->name]) }}</h2>

        <p>
            Dein <a href="{{ $urlToOffer }}">Angebot</a> an <a
                    href="{{ $urlToTargetUser }}">{{ $offer->addressedToUser->name }}</a>
            vom {{ app('system_base')->formatDate($offer->created_at) }}
            um {{ app('system_base')->formatTime($offer->created_at) }}
            wurde abgelehnt.
        </p>

        @include('notifications.emails.inc.body-foot')
    </body>
</html>