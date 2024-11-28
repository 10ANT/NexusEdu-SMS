<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestPaperController extends Controller
{
    private $predictionUrl = 'https://eastus.api.cognitive.microsoft.com/customvision/v3.0/Prediction/6567f69a-abf5-4fdf-bb59-6a2121d09c51/detect/iterations/aitestpapermakerv2-fin/image';
    private $predictionKey = '689dfc9109c54d0d85427193a7933401';

    public function show()
    {
        return view('papers.upload');
    }

    public function analyzePapers(Request $request)
{
    $request->validate([
        'papers.*' => 'required|image|max:10240',
        'total_marks' => 'required|integer|min:1'
    ]);

    $totalScore = 0;
    $results = [];

    foreach ($request->file('papers') as $paper) {
        $imageData = file_get_contents($paper->path());
        $predictions = $this->getPredictions($imageData);
        
        $paperScore = $this->calculateScore($predictions);
        $totalScore += $paperScore;
        $results[] = [
            'filename' => $paper->getClientOriginalName(),
            'score' => $paperScore
        ];
    }

    $percentage = ($totalScore / $request->total_marks) * 100;

    return view('papers.results', compact('results', 'percentage', 'totalScore'));
}

    private function getPredictions($imageData)
    {
        $client = new Client();
        
        $response = $client->post($this->predictionUrl, [
            'headers' => [
                'Prediction-Key' => $this->predictionKey,
                'Content-Type' => 'application/octet-stream'
            ],
            'body' => $imageData
        ]);

        return json_decode($response->getBody(), true);
    }

    private function calculateScore($predictions)
    {
        $scoreMap = [
            '1right' => 1,
            '2right' => 2,
            '3right' => 3,
            '4right' => 4,
            'questionmark' => 0,
            'right' => 1,
            'wrong' => 0
        ];

        $score = 0;
        foreach ($predictions['predictions'] as $prediction) {
            if ($prediction['probability'] > 0.5) {
                $score += $scoreMap[$prediction['tagName']] ?? 0;
            }
        }

        return $score;
    }
}