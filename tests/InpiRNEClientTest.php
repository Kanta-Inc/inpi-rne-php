<?php

namespace InpiRNEClient;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class InpiRNEClientTest extends TestCase
{
    private InpiRNEClientInterface $inpiRNEClient;

    protected function setUp(): void
    {
        $this->inpiRNEClient = new InpiRNEClient(null);
    }

    public function testInpiRNEClientInstanciation(): void
    {
        // test instanciation
        $this->inpiRNEClient = new InpiRNEClient();
        $this->assertInstanceOf(InpiRNEClient::class, $this->inpiRNEClient);
        // check token if set at instanciation
        $this->inpiRNEClient = new InpiRNEClient('my_token');
        $this->assertInstanceOf(InpiRNEClient::class, $this->inpiRNEClient);
        // check token
        $this->assertEquals('my_token', $this->inpiRNEClient->getToken());
    }

    public function testAuthenticate(): void
    {
        $fakeResponse = '{"token":"eyJ0edAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJleHAiOjE3MDM2OTkwMzksInVzZXJUeXBlIjoiRk8iLCJjb25uZWN0aW9uVHlwZSI6IkFQSSIsInVzZXJJZCI6MzU2OTkwLCJ1c2VybmFtZSI6ImxhdXJlLmJlYXVncmFuZEBob3RtYWlsLmZyIiwiZmlyc3RuYW1lIjoiTGF1cmUiLCJsYXN0bmFtZSI6IkJlYXVncmFuZCIsImFjY2Vzc1Rva2VuIjoiOWM0NTYxOTg5YTQ1NGM4MDFkYmZlYTg5NzIxYmJlYzc0YjY1ZGY2ZCIsInJlZnJlc2hUb2tlbiI6ImUwZDM4OGQzMTdhM2JkY2IwYWVhYjA3MTgxMDcyMjQ2OWQ0ODMwMTMiLCJleHBpcmVzSW4iOjg2NDAwfQ.IuqbrGn7AJ8AP5rEjSME1PmT9sCvyywpN7JUTd-6AQsYf15RtnkIj-uS2LqKn4a1lRh3bobhH52fdZlgqWZH7aMGcKMjEuxnwXVkPR1OECxzxIVJKQnwckTMnlauRmt0UkiK7PltmsdgrkylH3xBK5mNWz86XtxUkseDIWWch9mmJ19WDvVW0B_TQBlTsHyC6iVaOxbe6I44S4oC9I3upTDWgfoKfzEi2xzySqffi2Sxau3Su6AgRSJNnBCWneppg_ckN3LHyNEkkc7DtxlzrLOO_laBYdfyAXppe-B8JDpUkI2ALwdg0Kq4pHeApDhRP5YXru23UK3DtDmJ5XKfIPoDN3zUePcrhvP9X70yYtNURQ16b3XBXv9qVxzGY9bzXMqUr-F4_BA9oJaWLffj74dMdJR3AjmAMTj6VUCk6GG12GMHcoJ9J-0n6hfuAnZ91TktcFZvVolpMjohtg6b3EvD_sWpGZB2MKccEFTN9Chej8G4RMoSWbKlogPGKFWX4J0Df3rnEPfTsyJ9oiUQmfXNYCCQMowlOWy7YgEGyir5ITWOid41lHTFcV_ibVvBNp3_AYYRGSyFD2DHz5gu5Nnuo2yxgO0KycG-qHwZldj6OQCHZZb56YxD4U4GV1LVNpWYb2g_ir9KxvoTrCOGrBmBLM771cWkeC0bjisgMOU","user":{"roles":["ROLE_NIVEAU_1_COMPANIES_METADATA","ROLE_API","ROLE_IHM"],"id":352990,"email":"john.doe@example.fr","firstname":"John","lastname":"Doe","civilityCode":"MR","address1":"36 Rue de roc","zipCode":"75000","city":"Paris","countryCode":"FR","company":{"id":424,"ssoId":830646,"address1Company":"10 rue de la vie","zipCodeCompany":"75000","cityCompany":"Paris","countryCodeCompany":"FR","companyName":"Cabinet","siret": "19331282200032","useCompanyRole":false},"isManager":true,"mobilePhone":"0626411690","lastLogin":"2023-12-27T17:43:59+01:00","active":true}}';
        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->inpiRNEClient = new InpiRNEClient(null, $mockedClient);

        $this->inpiRNEClient->authenticate('fake_username', 'fake_password');

        // test token
        $this->assertEquals(
            'eyJ0edAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJleHAiOjE3MDM2OTkwMzksInVzZXJUeXBlIjoiRk8iLCJjb25uZWN0aW9uVHlwZSI6IkFQSSIsInVzZXJJZCI6MzU2OTkwLCJ1c2VybmFtZSI6ImxhdXJlLmJlYXVncmFuZEBob3RtYWlsLmZyIiwiZmlyc3RuYW1lIjoiTGF1cmUiLCJsYXN0bmFtZSI6IkJlYXVncmFuZCIsImFjY2Vzc1Rva2VuIjoiOWM0NTYxOTg5YTQ1NGM4MDFkYmZlYTg5NzIxYmJlYzc0YjY1ZGY2ZCIsInJlZnJlc2hUb2tlbiI6ImUwZDM4OGQzMTdhM2JkY2IwYWVhYjA3MTgxMDcyMjQ2OWQ0ODMwMTMiLCJleHBpcmVzSW4iOjg2NDAwfQ.IuqbrGn7AJ8AP5rEjSME1PmT9sCvyywpN7JUTd-6AQsYf15RtnkIj-uS2LqKn4a1lRh3bobhH52fdZlgqWZH7aMGcKMjEuxnwXVkPR1OECxzxIVJKQnwckTMnlauRmt0UkiK7PltmsdgrkylH3xBK5mNWz86XtxUkseDIWWch9mmJ19WDvVW0B_TQBlTsHyC6iVaOxbe6I44S4oC9I3upTDWgfoKfzEi2xzySqffi2Sxau3Su6AgRSJNnBCWneppg_ckN3LHyNEkkc7DtxlzrLOO_laBYdfyAXppe-B8JDpUkI2ALwdg0Kq4pHeApDhRP5YXru23UK3DtDmJ5XKfIPoDN3zUePcrhvP9X70yYtNURQ16b3XBXv9qVxzGY9bzXMqUr-F4_BA9oJaWLffj74dMdJR3AjmAMTj6VUCk6GG12GMHcoJ9J-0n6hfuAnZ91TktcFZvVolpMjohtg6b3EvD_sWpGZB2MKccEFTN9Chej8G4RMoSWbKlogPGKFWX4J0Df3rnEPfTsyJ9oiUQmfXNYCCQMowlOWy7YgEGyir5ITWOid41lHTFcV_ibVvBNp3_AYYRGSyFD2DHz5gu5Nnuo2yxgO0KycG-qHwZldj6OQCHZZb56YxD4U4GV1LVNpWYb2g_ir9KxvoTrCOGrBmBLM771cWkeC0bjisgMOU',
            $this->inpiRNEClient->getToken()
        );
    }

    public function testAuthenticateNeeded(): void
    {
        $fakeResponse = '{"token":"eyJ0edAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJleHAiOjE3MDM2OTkwMzksInVzZXJUeXBlIjoiRk8iLCJjb25uZWN0aW9uVHlwZSI6IkFQSSIsInVzZXJJZCI6MzU2OTkwLCJ1c2VybmFtZSI6ImxhdXJlLmJlYXVncmFuZEBob3RtYWlsLmZyIiwiZmlyc3RuYW1lIjoiTGF1cmUiLCJsYXN0bmFtZSI6IkJlYXVncmFuZCIsImFjY2Vzc1Rva2VuIjoiOWM0NTYxOTg5YTQ1NGM4MDFkYmZlYTg5NzIxYmJlYzc0YjY1ZGY2ZCIsInJlZnJlc2hUb2tlbiI6ImUwZDM4OGQzMTdhM2JkY2IwYWVhYjA3MTgxMDcyMjQ2OWQ0ODMwMTMiLCJleHBpcmVzSW4iOjg2NDAwfQ.IuqbrGn7AJ8AP5rEjSME1PmT9sCvyywpN7JUTd-6AQsYf15RtnkIj-uS2LqKn4a1lRh3bobhH52fdZlgqWZH7aMGcKMjEuxnwXVkPR1OECxzxIVJKQnwckTMnlauRmt0UkiK7PltmsdgrkylH3xBK5mNWz86XtxUkseDIWWch9mmJ19WDvVW0B_TQBlTsHyC6iVaOxbe6I44S4oC9I3upTDWgfoKfzEi2xzySqffi2Sxau3Su6AgRSJNnBCWneppg_ckN3LHyNEkkc7DtxlzrLOO_laBYdfyAXppe-B8JDpUkI2ALwdg0Kq4pHeApDhRP5YXru23UK3DtDmJ5XKfIPoDN3zUePcrhvP9X70yYtNURQ16b3XBXv9qVxzGY9bzXMqUr-F4_BA9oJaWLffj74dMdJR3AjmAMTj6VUCk6GG12GMHcoJ9J-0n6hfuAnZ91TktcFZvVolpMjohtg6b3EvD_sWpGZB2MKccEFTN9Chej8G4RMoSWbKlogPGKFWX4J0Df3rnEPfTsyJ9oiUQmfXNYCCQMowlOWy7YgEGyir5ITWOid41lHTFcV_ibVvBNp3_AYYRGSyFD2DHz5gu5Nnuo2yxgO0KycG-qHwZldj6OQCHZZb56YxD4U4GV1LVNpWYb2g_ir9KxvoTrCOGrBmBLM771cWkeC0bjisgMOU","user":{"roles":["ROLE_NIVEAU_1_COMPANIES_METADATA","ROLE_API","ROLE_IHM"],"id":352990,"email":"john.doe@example.fr","firstname":"John","lastname":"Doe","civilityCode":"MR","address1":"36 Rue de roc","zipCode":"75000","city":"Paris","countryCode":"FR","company":{"id":424,"ssoId":830646,"address1Company":"10 rue de la vie","zipCodeCompany":"75000","cityCompany":"Paris","countryCodeCompany":"FR","companyName":"Cabinet","siret": "19331282200032","useCompanyRole":false},"isManager":true,"mobilePhone":"0626411690","lastLogin":"2023-12-27T17:43:59+01:00","active":true}}';
        $mockHandler = new MockHandler([new Response(200, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->inpiRNEClient = new InpiRNEClient(null, $mockedClient);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("You need to authenticate first.");

        $this->inpiRNEClient->searchCompaniesBySiren(['889924320', '894419969']);
    }

    public function testAuthenticationWithBadCredentials(): void
    {
        $fakeResponse = '{"code":"401","webserviceCode":"JWT_AUTHENTICATOR","errorCode":"access_denied","message":"Erreur rencontr\u00e9 lors du d\u00e9codage du JWT : xxxx","type":"unauthorized"}';
        $mockHandler = new MockHandler([new Response(401, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->inpiRNEClient = new InpiRNEClient(null, $mockedClient);

        // Testez que l'exception est bien levée lors de l'authentification avec de mauvais identifiants
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Bad credentials");

        $this->inpiRNEClient->authenticate('fake_username', 'fake_password');
    }

    public function testAuthenticationWithForbidden(): void
    {
        $fakeResponse = '{
            "code": "403",
            "message": "Access Denied.",
            "type": "access_denied"
        }';
        $mockHandler = new MockHandler([new Response(403, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->inpiRNEClient = new InpiRNEClient(null, $mockedClient);

        // Testez que l'exception est bien levée lors de l'authentification avec de mauvais identifiants
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Forbidden");

        $this->inpiRNEClient->authenticate('forbidden_username', 'forbidden_password');
    }

    public function testAuthenticationWithTooManyRequests(): void
    {
        $fakeResponse = '{
            "code": "429",
            "message": "Too Many Requests.",
            "type": "too_many_requests"
        }';
        $mockHandler = new MockHandler([new Response(429, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->inpiRNEClient = new InpiRNEClient(null, $mockedClient);

        // Testez que l'exception est bien levée lors de l'authentification avec de mauvais identifiants
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Too many requests");

        $this->inpiRNEClient->authenticate('too_many_requests_username', 'too_many_requests_password');
    }

    public function testAuthenticateWithUnknowException(): void
    {
        $fakeResponse = '{
            "code": "500",
            "message": "Internal Server Error.",
            "type": "internal_server_error"
        }';
        $mockHandler = new MockHandler([new Response(500, [], $fakeResponse)]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        $this->inpiRNEClient = new InpiRNEClient(null, $mockedClient);

        // Testez que l'exception est bien levée lors de l'authentification avec de mauvais identifiants
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Unknown error");

        $this->inpiRNEClient->authenticate('unknow_exception_username', 'unknow_exception_password');
    }
}
