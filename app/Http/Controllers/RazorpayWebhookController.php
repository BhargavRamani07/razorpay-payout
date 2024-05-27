<?php

namespace App\Http\Controllers;

use App\Models\Payout;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Laravel\SerializableClosure\Signers\Hmac;
use Razorpay\Api\Api;

class RazorpayWebhookController extends Controller
{

    public function getPayload()
    {
        $jsonPayload = '{
            "entity": "event",
            "account_id": "acc_NxBpDu3RCJmpQv",
            "event": "payout.processed",
            "contains": [
              "payout"
            ],
            "payload": {
              "payout": {
                "entity": {
                  "id": "pout_OCdqcMiQG04Iz5",
                  "entity": "payout",
                  "fund_account_id": "fa_OBWZvVzfYfdCGb",
                  "fund_account": {
                    "id": "fa_OBWZvVzfYfdCGb",
                    "entity": "fund_account",
                    "contact_id": "cont_OB35wlmKlMfCS3",
                    "account_type": "vpa",
                    "merchant_disabled": false,
                    "batch_id": null,
                    "vpa": {
                      "username": "bhargav.r",
                      "handle": "okhdfc",
                      "address": "bhargav.r@okhdfc"
                    },
                    "active": true,
                    "created_at": 1715940950
                  },
                  "amount": 100000,
                  "currency": "INR",
                  "notes": [],
                  "fees": 236,
                  "tax": 36,
                  "status": "processed",
                  "purpose": "payout",
                  "utr": "OCdqcMiQG04Iz5",
                  "mode": "UPI",
                  "reference_id": "Test Payout For Webhook",
                  "narration": "Test Payout For Webhook",
                  "batch_id": null,
                  "failure_reason": null,
                  "created_at": 1716184890,
                  "status_details": {
                    "reason": "payout_processed",
                    "description": "Payout is processed and the money has been credited into the beneficiary account.",
                    "source": "beneficiary_bank"
                  },
                  "error": {
                    "source": null,
                    "reason": null,
                    "description": null,
                    "code": "NA",
                    "step": "NA",
                    "metadata": {}
                  }
                }
              }
            },
            "created_at": 1716184907
          }';

        $payload = json_decode($jsonPayload, true);

        dd($payload, $payload['payload']['payout']['entity']['utr'], $payload['payload']['payout']['entity']['status_details']);
    }

    public function payoutProcessed(Request $request)
    {
        try {

            $webhookSecret = env("PAYOUT_PROCESSED_SECRET");

            $received_signature = $request->header('X-Razorpay-Signature');
            $webhookBody = $request->getContent();

            $expected_signature = hash_hmac('sha256', $webhookBody, $webhookSecret);

            $isAuthentic = $expected_signature === $received_signature;

            if (!$isAuthentic) {
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            $payload = json_decode($webhookBody, true);

            $payoutEntity = $payload['payload']['payout']['entity'];

            $payoutDBRes = Payout::where("payout_id", $payoutEntity['id'])->update([
                'utr' => $payoutEntity['utr'],
                'status' => $payoutEntity['status'],
                'status_details' => collect($payoutEntity['status_details'])->toJson(),
            ]);
            
            if($payoutDBRes){
                return response()->json(['message' => 'Webhook processed'], 200);
            }else{
                return response()->json(['message' => 'Webhook processed but database update failed'], 502);
            }
        } catch (Exception $e) {

            Log::emergency($e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => "Something went wrong. please try again."
                ],
                500
            );
        }
    }
}
