<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GooglePlacesController extends Controller
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('custom.google_maps_api_key');
    }

    private function googleRequest($url, $method = 'GET', $body = null, $fieldMask = null)
    {
        if (!$this->apiKey) {
            return response()->json(['error' => 'Google Maps API key is not configured.'], 500);
        }

        $request = Http::withHeaders(array_filter([
            'Content-Type' => 'application/json',
            'X-Goog-Api-Key' => $this->apiKey,
            'X-Goog-FieldMask' => $fieldMask,
        ]));

        $response = $method === 'POST'
            ? $request->post($url, $body ?? [])
            : $request->get($url);

        return response()->json($response->json(), $response->status());
    }

    public function autoComplete(Request $request)
    {
        $input = trim($request->input('postcode', ''));
        $sessionToken = $request->input('sessionToken', bin2hex(random_bytes(16)));

        if (strlen($input) < 2) {
            return response()->json(['error' => 'Minimum 2 characters required'], 400);
        }

        return $this->googleRequest(
            'https://places.googleapis.com/v1/places:autocomplete',
            'POST',
            [
                'input' => $input,
                'includedRegionCodes' => ['gb'],
                'includedPrimaryTypes' => ['(regions)'],
                'locationBias' => [
                    'circle' => [
                        'center' => [
                            'latitude' => 51.5074,
                            'longitude' => -0.1278
                        ],
                        'radius' => 50000
                    ]
                ],
                'sessionToken' => $sessionToken,
            ],
            'suggestions.placePrediction.placeId,suggestions.placePrediction.text'
        );
    }

    public function placeDetails(Request $request)
    {
        $placeId = $request->query('placeId', '');
        $sessionToken = $request->query('sessionToken', '');

        if (!$placeId) {
            return response()->json(['error' => 'placeId is required'], 400);
        }

        $url = 'https://places.googleapis.com/v1/places/' . urlencode($placeId);

        if ($sessionToken) {
            $url .= '?sessionToken=' . urlencode($sessionToken);
        }

        return $this->googleRequest(
            $url,
            'GET',
            null,
            'id,formattedAddress,addressComponents'
        );
    }
}
