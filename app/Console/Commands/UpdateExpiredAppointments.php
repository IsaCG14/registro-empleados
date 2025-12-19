<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateExpiredAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-expired-appointments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update appointments that have expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now('America/Caracas');

        $expiredAppointments = \App\Models\Cita::whereIn('status', ['Pendiente', 'Reagendada'])
            ->whereRaw("CONCAT(fecha_cita, ' ', hora_cita) < ?", [$now->format('Y-m-d H:i:s')])
            ->get();

        foreach ($expiredAppointments as $appointment) {
            $appointment->status = 'Retrasada';
            $appointment->save();
        }

        $this->info('Expired appointments updated successfully.');
    }
}