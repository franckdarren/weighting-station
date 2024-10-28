<!-- For synchronyse all the new change in Excel File -->

<?php

protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        app(ExcelWatcherService::class)->watchExcelFile();
    })->everySecond(5);
}
