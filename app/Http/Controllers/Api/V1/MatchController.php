<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\ProfileRequest;
use App\Mail\CotactMail;

use App\Models\Profile;
use App\Models\Match;
use App\Repositories\ProfileRepositoryInterface;
use App\Repositories\MatchRepositoryInterface;

class MatchController extends Controller
{

    /** @var ProfileRepositoryInterface */
    protected $profileRepository;

    /** @var MatchRepositoryInterface */
    protected $matchRepository;

    public function __construct(
        profileRepositoryInterface $profileRepository,
        matchRepositoryInterface $matchRepository
    ) {
        $this->profileRepository = $profileRepository;
        $this->matchRepository = $matchRepository;
    }

    public function like(ProfileRequest $request, Profile $profile)
    {
        $profile->load('user');
        $data = $request->all();
        $responseMessage = $this->matchRepository->like($data);

        return response()->json(['responseMessage' => $responseMessage]);
    }

    public function matchedUsers(Request $request)
    {
        $currentUser = $request->all();

        $matchedUsers = $this->matchRepository->matchedUsers($currentUser['currentUser']['id']);

        return response()->json(['matchedUsers' => $matchedUsers]);
    }
}
