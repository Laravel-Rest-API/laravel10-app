<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\traits\BCA;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    use BCA;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partnerServiceId = str_pad(config('bca.code_va'),8," ",STR_PAD_LEFT);
        $customerNo = '123456789012345678';
        $virtualAccountNo = $partnerServiceId.$customerNo;

        $requestBody = [
            'partnerServiceId' => str_pad(config('bca.code_va'), 8, " ", STR_PAD_LEFT),
            'customerNo'=>$customerNo,
            'virtualAccountNo'=>$virtualAccountNo,
//            'trxDateInit' => Carbon::now()->toIso8601String(),
//            'channelCode' => '95051',
//            'inquiryRequestId' => '123456789',
        ];

        dd($this->generateSignatureSymmetric('POST','/openapi/v1.0/transfer-va/status',json_encode($requestBody,JSON_UNESCAPED_UNICODE)));

        return new UserCollection(User::orderByDesc('id')->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
