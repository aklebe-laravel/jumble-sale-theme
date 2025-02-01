@php
    use Modules\Market\app\Services\SystemInfoService;

    /** @var SystemInfoService $systemInfoService */
    $systemInfoService = app(SystemInfoService::class);
    $tableData = $systemInfoService->getSystemInfo();
@endphp

{{--telegram HTML mode supports: <b></b>, <i></i>, <s></s>, <u></u>--}}
@include('market::telegram.system-info')
