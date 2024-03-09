<?php

namespace App\Console\Commands;

use App\Models\Admin\Doctor;
use Illuminate\Console\Command;

class ClearExpiredSponsorships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-expired-sponsorships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    { // Get doctors with expired sponsorships
        $doctors = Doctor::whereHas('sponsorships', function ($query) {
            $query->where('doctor_sponsorship.end_date', '<=', now());
        })->get();

        foreach ($doctors as $doctor) {
            // Detach the expired sponsorships
            $doctor->sponsorships()->detach();
        }

        $this->info('Expired sponsorships cleared successfully.');
    }
}
