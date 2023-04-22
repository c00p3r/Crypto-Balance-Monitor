<?php

namespace App\Http\Controllers;

use App\Http\Resources\Wallet as WalletResource;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;

class WalletController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function list(Request $request): ResourceCollection
    {
        $wallets = Wallet::query()
            ->with('latestBalance')
            ->get();

        return WalletResource::collection($wallets);
    }

    public function show(Request $request, int $id): WalletResource
    {
        /** @var Wallet $wallet */
        $wallet = Wallet::query()
            ->with('latestBalance')
            ->findOrFail($id);

        return WalletResource::make($wallet);
    }

    public function store(Request $request): WalletResource
    {
        $data = $this->validate($request, [
            'address' => ['required', 'string'],
            'currency' => ['required', Rule::in([Wallet::BTC, Wallet::LTC, Wallet::ETH])],
        ]);

        /*
         * To not overcomplicate the task
         * I assume address provided is valid and exists
         * because otherwise it'd require additional packages
         * but ideally we'd want to validate the address exists
         */

        $wallet = new Wallet([
            'address' => $data['address'],
            'currency' => $data['currency'],
            'add_date' => Carbon::now(),
        ]);

        $wallet->save();

        return WalletResource::make($wallet);
    }
}
