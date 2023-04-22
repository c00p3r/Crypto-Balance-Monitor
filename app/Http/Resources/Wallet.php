<?php

namespace App\Http\Resources;

use App\Models\Wallet as WalletModel;
use App\Models\WalletBalanceLogEntry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Wallet extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var WalletModel $resource */
        $resource = $this->resource;

        if ($resource == null) {
            return [];
        }

        /** @var WalletBalanceLogEntry $latestBalance */
        $latestBalance = $resource->getRelationValue('balanceLog')->first();

        return [
            'address' => $resource->getAttribute('address'),
            'currency' => $resource->getAttribute('currency'),
            'add_date' => $resource->getAttribute('add_date'),
            'balance' => $latestBalance ? $latestBalance->getAttribute('balance') : 0,
            'balance_date' => $latestBalance?->getAttribute('timestamp'),
        ];
    }
}
