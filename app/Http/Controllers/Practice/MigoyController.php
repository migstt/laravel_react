<?php

namespace App\Http\Controllers\Practice;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

use Aws\DynamoDb\DynamoDbClient;
use Aws\Laravel\AwsFacade;

class MigoyController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function migoytest(Request $request): Response
    {

        $dynamoDbClient = new DynamoDbClient([
            'region'   => env('AWS_DEFAULT_REGION', 'ap-southeast-1'),
            'version'  => 'latest',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID', 'migoyLocalAccess'),
                'secret' => env('AWS_SECRET_ACCESS_KEY', 'migoyLocalSecret'),
            ],
            'endpoint' => env('AWS_DYNAMODB_ENDPOINT', 'http://localhost:8002'),
        ]);

        $result = $dynamoDbClient->listTables();
        $dynamoDbEnpoint = $dynamoDbClient->getEndpoint();

        $test_name = "Migoy";
        $test_name2 = "Archer";
        $test_name3 = "Eugenio";

        return Inertia::render('Practice/Test', [
            'test_name' => $test_name,
            'test_name2' => $test_name2,
            'test_name3' => $test_name3,
            'tables' => $result['TableNames'],
            'endpoint' => $dynamoDbEnpoint,
        ]);
    }
}
