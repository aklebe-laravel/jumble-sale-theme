{{--telegram HTML mode supports: <b></b>, <i></i>, <s></s>, <u></u>--}}
<b>{{ __('Hello :name', ['name' => $user->name]) }}</b>

{{ __('Your import was completed. :current/:total rows were imported.', ['current' => $results->getData('import_rows_success' , '?'), 'total' => $results->getData('import_rows_requested' , '?')]) }}
