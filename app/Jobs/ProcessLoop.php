<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessLoop implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $limit;
    /**
     * Create a new job instance.
     */
    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $count = 0;
        for ($i = 0; $i < $this->limit; $i++) {
            $count++;
        };
        $this->writeToFile($count);
    }

    public function writeToFile($content)
    {
        $myfile = fopen("./storage/textfile/newfile.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $content);
        fclose($myfile);
    }
}
