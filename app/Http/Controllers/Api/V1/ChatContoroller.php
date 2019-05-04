<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\ProfileRequest;
use App\Mail\CotactMail;

use App\Models\Profile;
use App\Models\Match;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Repositories\ProfileRepositoryInterface;
use App\Repositories\MatchRepositoryInterface;
use App\Repositories\ChatRepositoryInterface;

class ChatController extends Controller
{

    /** @var ProfileRepositoryInterface */
    protected $profileRepository;

    /** @var MatchRepositoryInterface */
    protected $matchRepository;

    /** @var MatchRepositoryInterface */
    protected $chatRepository;

    public function __construct(
        profileRepositoryInterface $profileRepository,
        matchRepositoryInterface $matchRepository,
        chatRepositoryInterface $chatRepository
    ) {
        $this->profileRepository = $profileRepository;
        $this->matchRepository = $matchRepository;
        $this->chatRepository = $chatRepository;
    }

    public function getChatMessages(Request $request)
    {
        $data = $request->all();
        $match_id = $data['matchId'];

        $chat_id = Chat::where('match_id', $match_id)->pluck('id')->first();
        $chatMessages = ChatMessage::where('chat_id', $chat_id)->get();
        $chatMessages->load('sendFrom.profile');

        return response()->json(['chatMessages' => $chatMessages]);
    }

    public function sendChatMessage(Request $request)
    {
        $data = $request->all();
        $match_id = $data['matchId'];
        $message = $data['message'];
        $currentUser = $data['currentUser'];

        $chat_id = Chat::where('match_id', $match_id)->pluck('id')->first();
        $chatMessage = ChatMessage::create(['chat_id' => $chat_id, 'send_from' => $currentUser['id'], 'message' => $message]);

        $chatMessages = ChatMessage::where('chat_id', $chat_id)->get();
        $chatMessages->load('sendFrom.profile');

        return response()->json(['chatMessages' => $chatMessages]);
    }
}
