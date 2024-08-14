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

class MigoyController extends Controller
{
    /**
     * Display the user's profile form.
     */
    protected $dynamoDbClient;

    public function __construct(DynamoDbClient $dynamoDbClient)
    {
        $this->dynamoDbClient = $dynamoDbClient;
    }

    public function migoytest(Request $request): Response
    {
        $result             = $this->dynamoDbClient->listTables();
        $dynamoDbEnpoint    = $this->dynamoDbClient->getEndpoint();

        $test_name  = "Migoy";
        $test_name2 = "Archer";
        $test_name3 = "Eugenio";

        return Inertia::render('Practice/Test', [
            'test_name'     => $test_name,
            'test_name2'    => $test_name2,
            'test_name3'    => $test_name3,
            'tables'        => $result['TableNames'],
            'endpoint'      => $dynamoDbEnpoint,
        ]);
    }

    public function createSampleTable()
    {
        $dynamoDbClient = new DynamoDbClient([
            'region'        => env('AWS_DEFAULT_REGION', 'ap-southeast-1'),
            'version'       => 'latest',
            'credentials'   => [
                'key'       => env('AWS_ACCESS_KEY_ID', 'migoyLocalAccess'),
                'secret'    => env('AWS_SECRET_ACCESS_KEY', 'migoyLocalSecret'),
            ],
            'endpoint' => env('AWS_DYNAMODB_ENDPOINT', 'http://localhost:8002'),
        ]);
    
        $result = $dynamoDbClient->createTable(array(
            'TableName' => 'employeeTable',
            'AttributeDefinitions' => array(
                  array(
                      'AttributeName' => 'eid',
                      'AttributeType' => 'N'
                  ),
                  array(
                      'AttributeName' => 'name',
                      'AttributeType' => 'S' 
                  )
            ), 
            'KeySchema' => array( 
                array( 
                      'AttributeName'   => 'eid', 
                      'KeyType'         => 'HASH'
                     ), 
                array(
                      'AttributeName'   => 'name', 
                      'KeyType'         => 'RANGE' 
                    )
            ), 
            'BillingMode' => 'PAY_PER_REQUEST',
            // You need to define the throughput if you select Provisioned as the billing mode
            'ProvisionedThroughput' => array(
                 'ReadCapacityUnits' => 1, 
                 'WriteCapacityUnits' => 1 
                  )
            )
          );
        
        echo "table $result found!\n";
    }
}
