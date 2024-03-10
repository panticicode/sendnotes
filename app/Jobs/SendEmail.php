<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\Note;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Note $note)
    {
       
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = config('app.url') . '/notes/' . $this->note->id;

        $content = "Hello, you recived new note View at: {$url}";

        Mail::raw($content, function($message){
            $message->from('noreply@mail.com', 'Sendnotes')
            ->to($this->note->recipient)
            ->subject('You have a new note from ' . $this->note->user->name);
        });
    }
}
