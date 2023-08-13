<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class hapusTempLampiran extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hapus-temp-lampiran';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus temp data lampiran';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $storage = Storage::disk('public');
        foreach($storage->files('temp/', false) as $file) {
            $storage->delete($file);
        }
    }
}
