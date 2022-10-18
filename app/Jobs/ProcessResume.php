<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Resume;
use File;
use Illuminate\Http\Request;
use Mail;
use Exception;

class ProcessResume implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $resumeData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($resumeData)
    {
        $this->resumeData = $resumeData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            foreach ($this->resumeData as $resume) {
                $name = $resume['name'];
                $filename = $resume['filename'];
                $content = File::get(public_path('resumes'). '/' . $filename);
    
                $resume = new Resume;
                $resume->name = $name;
                $resume->filename = $filename;
                $resume->path = 'resumes';
                $resume->content = $content;
                $resume->save();
    
                preg_match_all('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/i', $content, $emails);
                $emails = $emails[0];
                $data = ['name'=> $name];
       
                Mail::send(['mail'], $data, function($message) use ($emails) {
                    $message->to($emails)->subject
                        ('Resume uploded');
                    $message->from('waran.2050@gmail.com', 'Venkat');
                });
            }
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}
