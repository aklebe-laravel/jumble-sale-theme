<html lang="de">
    <header>
        @include('notifications.emails.inc.header')
    </header>
    <body>
        @include('notifications.emails.inc.body-head')

        <h2>{{ __('Hello :name', ['name' => $user->name]) }}</h2>

        <p>
            {{ __('Your import was completed. :current/:total rows were imported.', ['current' => $results->getData('import_rows_success' , '?'), 'total' => $results->getData('import_rows_requested' , '?')]) }}
        </p>

        @include('notifications.emails.inc.body-foot')
    </body>
</html>