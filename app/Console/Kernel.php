<!-- For synchronyse all the new change in Excel File -->

protected function schedule(Schedule $schedule)
{
$schedule->command('excel:sync')->everySecond(30);
}