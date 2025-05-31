<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class ShipmentController extends Controller
{
    protected $apiKey;
    protected $baseUrl;
    protected $supportedCouriers;

    public function __construct()
    {
        // Load Raja Ongkir configuration from config file
        $this->apiKey = Config::get('rajaongkir.api_key');
        $this->baseUrl = Config::get('rajaongkir.base_url');
        $this->supportedCouriers = array_keys(Config::get('rajaongkir.couriers', []));
    }

    /**
     * Get list of provinces from Raja Ongkir
     */
    public function getProvinces()
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get($this->baseUrl . '/province');

            $data = $response->json();
            
            if (isset($data['rajaongkir']['status']['code']) && $data['rajaongkir']['status']['code'] == 200) {
                return response()->json([
                    'success' => true,
                    'data' => $data['rajaongkir']['results']
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch provinces',
                'data' => $data
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error fetching provinces: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching provinces: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get list of cities from Raja Ongkir
     */
    public function getCities(Request $request)
    {
        try {
            $provinceId = $request->query('province');
            $endpoint = $this->baseUrl . '/city';
            
            if ($provinceId) {
                $endpoint .= '?province=' . $provinceId;
            }
            
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get($endpoint);

            $data = $response->json();
            
            if (isset($data['rajaongkir']['status']['code']) && $data['rajaongkir']['status']['code'] == 200) {
                return response()->json([
                    'success' => true,
                    'data' => $data['rajaongkir']['results']
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch cities',
                'data' => $data
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error fetching cities: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching cities: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate shipping cost from Raja Ongkir
     */
    public function calculateShipping(Request $request)
    {
        try {
            $validCouriers = implode(',', $this->supportedCouriers);
            
            $request->validate([
                'origin' => 'required',
                'destination' => 'nullable',
                'weight' => 'required|numeric|min:250',
                'courier' => 'required|in:' . $validCouriers
            ]);

            $response = Http::withHeaders([
                'key' => $this->apiKey,
                'content-type' => 'application/x-www-form-urlencoded'
            ])->asForm()->post($this->baseUrl . '/cost', [
                'origin' => $request->origin,
                'destination' => $request->destination,
                'weight' => $request->weight,
                'courier' => $request->courier
            ]);

            $data = $response->json();
            
            if (isset($data['rajaongkir']['status']['code']) && $data['rajaongkir']['status']['code'] == 200) {
                return response()->json([
                    'success' => true,
                    'data' => $data['rajaongkir']['results']
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate shipping cost',
                'data' => $data
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error calculating shipping cost: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error calculating shipping cost: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Track shipment using Raja Ongkir API
     */
    public function trackShipment(Request $request)
    {
        try {
            $validCouriers = implode(',', $this->supportedCouriers);
            
            $request->validate([
                'waybill' => 'required',
                'courier' => 'required|in:' . $validCouriers
            ]);

            $response = Http::withHeaders([
                'key' => $this->apiKey,
                'content-type' => 'application/x-www-form-urlencoded'
            ])->asForm()->post($this->baseUrl . '/waybill', [
                'waybill' => $request->waybill,
                'courier' => $request->courier
            ]);

            $data = $response->json();
            
            if (isset($data['rajaongkir']['status']['code']) && $data['rajaongkir']['status']['code'] == 200) {
                return response()->json([
                    'success' => true,
                    'data' => $data['rajaongkir']['result']
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to track shipment',
                'data' => $data
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error tracking shipment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error tracking shipment: ' . $e->getMessage()
            ], 500);
        }
    }
} 