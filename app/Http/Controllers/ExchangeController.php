<?php

namespace App\Http\Controllers;

use Exchange\Exchanger\Exchanger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Requester\TickerRequest;

class ExchangeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $method = $request->input('method');
        switch ($method) {
            case 'rates':
                return $this->rates($request);
            case 'convert':
                return $this->convert($request);
            default:
                return response()->json(['status' => 'error', 'code' => 404, 'message' => 'Method not found'], 404);
        }
    }

    private function rates(Request $request): JsonResponse
    {
        try {
            $requester = new TickerRequest();
            $requester->makeGetRequest();
            $exchanger = new Exchanger(json_decode((string) $requester->getResponse()->getBody(), true));
            $rates = $exchanger->getRates(explode(';', $request->input('currency')));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'code' => 400, 'message' => $e->getMessage()], 400);
        }

        return response()->json(['status' => 'success', 'code' => 200, 'data' => $rates], 200);
    }

    private function convert(Request $request): JsonResponse
    {
        try {
            $requester = new TickerRequest();
            $requester->makeGetRequest();
            $exchanger = new Exchanger(json_decode((string) $requester->getResponse()->getBody(), true));
            $rates = $exchanger->exchange($request->input('currency_from'),
                $request->input('currency_to'),
                $request->input('value'));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'code' => 400, 'message' => $e->getMessage()], 400);
        }

        return response()->json(['status' => 'success', 'code' => 200, 'data' => $rates], 200);
    }
}
