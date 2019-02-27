<?php

namespace App\Mail;

use App\Repositories\SalesRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SalesOfTheDay extends Mailable
{
    use Queueable, SerializesModels;

    /** @var SalesRepository */
    private $repository;

    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SalesRepository $repository, \Carbon\Carbon $date)
    {
        $this->repository = $repository;
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@example.com')
            ->view('emails.sales-of-the-day')
            ->with([
                'total' => $this->repository->getTotalByDay($this->date),
            ]);

    }
}
