<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\GenericProvider;
use XeroAPI\XeroPHP\Configuration;
use XeroAPI\XeroPHP\Api\IdentityApi;

class XeroController extends Controller
{
    private $provider;

    public function __construct()
    {
        $this->provider = new GenericProvider([
            'clientId'                => config('xero.clientId'),
            'clientSecret'            => config('xero.clientSecret'),
            'redirectUri'             => config('xero.redirectUri'),
            'urlAuthorize'            => 'https://login.xero.com/identity/connect/authorize',
            'urlAccessToken'          => 'https://identity.xero.com/connect/token',
            'urlResourceOwnerDetails' => 'https://api.xero.com/api.xro/2.0/Organisation'
        ]);


    }

    public function xero(Request $request){
        if (empty($request->input('state')) || ($request->input('state') !== session('oauth2state'))) {
            unset($_SESSION['oauth2state']);
            return redirect('/')->with('error', 'Invalid state');
        }

        try {
            // Try to get an access token using the authorization code grant.
            $accessToken = $this->provider->getAccessToken('authorization_code', [
                'code' => $request->input('code')
            ]);

            // Save the access token and other details in the session or database
            session(['access_token' => $accessToken->getToken()]);
            session(['refresh_token' => $accessToken->getRefreshToken()]);
            session(['expires' => $accessToken->getExpires()]);

            // Optionally, you can use the Identity API to get user details
            $config = Configuration::getDefaultConfiguration()->setAccessToken($accessToken->getToken());
            $identityApi = new IdentityApi(new \GuzzleHttp\Client(), $config);
            $connections = $identityApi->getConnections();

            return redirect('/')->with('success', 'Access token obtained successfully!');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Failed to obtain access token: ' . $e->getMessage());
        }
    }


    public function connect(){
        $authorizationUrl = $this->provider->getAuthorizationUrl([
            'scope' => ["accounting.transactions", "accounting.transactions.read", "accounting.reports.read", "accounting.reports.tenninetynine.read", "accounting.budgets.read", "accounting.journals.read", "accounting.settings", "accounting.settings.read", "accounting.contacts", "accounting.contacts.read", "accounting.attachments", "accounting.attachments.read", "assets", "assets.read", "files", "files.read", "payroll.employees", "payroll.employees.read", "payroll.payruns", "payroll.payruns.read", "payroll.payslip", "payroll.payslip.read", "payroll.settings", "payroll.settings.read", "payroll.timesheets", "payroll.timesheets.read", "projects", "projects.read"]
        ]);
        dd( $authorizationUrl);
        // Save the state generated for you and store it to the session.
        session(['oauth2state' => $this->provider->getState()]);

        // Redirect the user to the authorization URL.
        return redirect($authorizationUrl);
    }
}
