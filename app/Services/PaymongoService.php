<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymongoService
{
    protected $baseUrl;
    protected $secretKey;
    protected $publicKey;

    public function __construct()
    {
        $this->baseUrl = config('services.paymongo.base_url', 'https://api.paymongo.com/v1');
        $this->secretKey = config('services.paymongo.secret_key');
        $this->publicKey = config('services.paymongo.public_key');
    }

    /**
     * Create a payment source (e.g., GCash, PayMaya)
     *
     * @param string $type 'gcash' or 'paymaya'
     * @param float $amount Amount in PHP (will be converted to cents)
     * @param array $billing Optional billing details
     * @return array|null Source data or null on failure
     */
    public function createSource(string $type, float $amount, array $billing = [])
    {
        try {
            // Convert amount to cents (Paymongo requires amounts in cents)
            $amountInCents = $amount * 100;
            
            $response = Http::withBasicAuth($this->secretKey, '')
                ->post("{$this->baseUrl}/sources", [
                    'data' => [
                        'attributes' => [
                            'type' => $type,
                            'amount' => (int) $amountInCents,
                            'currency' => 'PHP',
                            'redirect' => [
                                'success' => route('payments.success'),
                                'failed' => route('payments.failed')
                            ],
                            'billing' => $billing
                        ]
                    ]
                ]);

            if ($response->successful()) {
                return $response->json()['data'];
            } else {
                Log::error('Paymongo Source Creation Failed', [
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Paymongo Source Creation Error', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Create a payment intent
     *
     * @param float $amount Amount in PHP
     * @param string $description Payment description
     * @param array $metadata Additional metadata
     * @return array|null Payment intent data or null on failure
     */
    public function createPaymentIntent(float $amount, string $description, array $metadata = [])
    {
        try {
            // Convert amount to cents
            $amountInCents = $amount * 100;
            
            $response = Http::withBasicAuth($this->secretKey, '')
                ->post("{$this->baseUrl}/payment_intents", [
                    'data' => [
                        'attributes' => [
                            'amount' => (int) $amountInCents,
                            'payment_method_allowed' => ['card', 'paymaya', 'gcash'],
                            'payment_method_options' => [
                                'card' => ['request_three_d_secure' => 'any']
                            ],
                            'currency' => 'PHP',
                            'description' => $description,
                            'metadata' => $metadata
                        ]
                    ]
                ]);

            if ($response->successful()) {
                return $response->json()['data'];
            } else {
                Log::error('Paymongo Payment Intent Creation Failed', [
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Paymongo Payment Intent Error', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Attach payment method to intent
     *
     * @param string $paymentIntentId Payment intent ID
     * @param string $paymentMethodId Payment method ID
     * @return array|null Payment intent data or null on failure
     */
    public function attachPaymentMethod(string $paymentIntentId, string $paymentMethodId)
    {
        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->post("{$this->baseUrl}/payment_intents/{$paymentIntentId}/attach", [
                    'data' => [
                        'attributes' => [
                            'payment_method' => $paymentMethodId
                        ]
                    ]
                ]);

            if ($response->successful()) {
                return $response->json()['data'];
            } else {
                Log::error('Paymongo Attach Payment Method Failed', [
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Paymongo Attach Payment Method Error', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Create a payment method (for cards)
     *
     * @param array $cardDetails Card details
     * @param array $billingDetails Billing details
     * @return array|null
     */
    public function createPaymentMethod(array $cardDetails, array $billingDetails = [])
    {
        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->post("{$this->baseUrl}/payment_methods", [
                    'data' => [
                        'attributes' => [
                            'type' => 'card',
                            'details' => $cardDetails,
                            'billing' => $billingDetails
                        ]
                    ]
                ]);

            if ($response->successful()) {
                return $response->json()['data'];
            } else {
                Log::error('Paymongo Payment Method Creation Failed', [
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Paymongo Payment Method Error', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Retrieve payment intent status
     *
     * @param string $paymentIntentId The payment intent ID
     * @return array|null
     */
    public function retrievePaymentIntent(string $paymentIntentId)
    {
        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->get("{$this->baseUrl}/payment_intents/{$paymentIntentId}");

            if ($response->successful()) {
                return $response->json()['data'];
            } else {
                Log::error('Paymongo Retrieve Payment Intent Failed', [
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Paymongo Retrieve Payment Intent Error', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Check source payment status
     *
     * @param string $sourceId The source ID
     * @return array|null
     */
/**
 * Check source payment status
 *
 * @param string $sourceId The source ID
 * @return array|null
 */
public function retrieveSource(string $sourceId)
{
    try {
        $response = Http::withBasicAuth($this->secretKey, '')
            ->get("{$this->baseUrl}/sources/{$sourceId}");

        if ($response->successful()) {
            return $response->json()['data'];
        } else {
            // If we get a 404, the source ID might be invalid or might need a prefix
            if ($response->status() === 404 && !str_starts_with($sourceId, 'src_')) {
                // Try adding the source prefix if it's missing
                $prefixedId = 'src_' . $sourceId;
                $retryResponse = Http::withBasicAuth($this->secretKey, '')
                    ->get("{$this->baseUrl}/sources/{$prefixedId}");
                    
                if ($retryResponse->successful()) {
                    return $retryResponse->json()['data'];
                }
            }
            
            Log::error('Paymongo Retrieve Source Failed', [
                'status' => $response->status(),
                'response' => $response->json(),
                'source_id' => $sourceId
            ]);
            return null;
        }
    } catch (\Exception $e) {
        Log::error('Paymongo Retrieve Source Error', [
            'error' => $e->getMessage(),
            'source_id' => $sourceId
        ]);
        return null;
    }
}
}