<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // 引数で受け取ったデータ用の変数
    protected $contact;
    protected $to_email;

    public function __construct($contact, $to_email)
    {
      // 引数で受け取ったデータを変数にセット
      $this->contact = $contact;
      $this->to_email = $to_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->contact['from_email']) // 送信元
          ->subject(env('APP_NAME').' - メッセージが届きました') // メールタイトル
          ->view('mail') // どのテンプレートを呼び出すか
          ->with(['contact' => $this->contact, 'to_mail' => $this->to_email]); // withオプションでセットしたデータをテンプレートへ受け渡す
    }
}