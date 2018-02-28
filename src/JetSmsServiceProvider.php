<?php

namespace NotificationChannels\JetSms;

use GuzzleHttp\Client;
use UnexpectedValueException;
use Erdemkeren\JetSms\Http\Clients;
use Erdemkeren\JetSms\ShortMessage;
use Erdemkeren\JetSms\JetSmsService;
use Illuminate\Support\ServiceProvider;
use Erdemkeren\JetSms\ShortMessageFactory;
use Erdemkeren\JetSms\ShortMessageCollection;
use Erdemkeren\JetSms\ShortMessageCollectionFactory;
use Erdemkeren\JetSms\Http\Responses\JetSmsResponseInterface;

/**
 * Class JetSmsServiceProvider.
 */
class JetSmsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerJetSmsClient();
        $this->registerJetSmsService();
    }

    /**
     * Register the JetSms Client binding with the container.
     *
     * @return void
     */
    private function registerJetSmsClient()
    {
        $this->app->bind(Clients\JetSmsClientInterface::class, function () {
            $username = config('services.JetSms.username');
            $password = config('services.JetSms.password');
            $originator = config('services.JetSms.originator');

            switch (config('services.JetSms.client', 'http')) {
                case 'http':
                    $timeout = config('services.JetSms.timeout');
                    $endpoint = config('services.JetSms.http.endpoint');
                    $client = new Clients\JetSmsHttpClient(
                        new Client(['timeout' => $timeout]), $endpoint, $username, $password, $originator);
                    break;
                case 'xml':
                    $endpoint = config('services.JetSms.xml.endpoint');
                    $client = new Clients\JetSmsXmlClient($endpoint, $username, $password, $originator);
                    break;
                default:
                    throw new UnexpectedValueException('Unknown JetSms API client has been provided.');
            }

            return $client;
        });
    }

    /**
     * Register the jet-sms service.
     */
    private function registerJetSmsService()
    {
        $beforeSingle = function (ShortMessage $shortMessage) {
            event(new Events\SendingMessage($shortMessage));
        };

        $afterSingle = function (JetSmsResponseInterface $response, ShortMessage $shortMessage) {
            event(new Events\MessageWasSent($shortMessage, $response));
        };

        $beforeMany = function (ShortMessageCollection $shortMessages) {
            event(new Events\SendingMessages($shortMessages));
        };

        $afterMany = function (JetSmsResponseInterface $response, ShortMessageCollection $shortMessages) {
            event(new Events\MessagesWereSent($shortMessages, $response));
        };

        $this->app->singleton('jet-sms', function ($app) use ($beforeSingle, $afterSingle, $beforeMany, $afterMany) {
            return new JetSmsService(
                $app->make(Clients\JetSmsClientInterface::class),
                new ShortMessageFactory(),
                new ShortMessageCollectionFactory(),
                $beforeSingle,
                $afterSingle,
                $beforeMany,
                $afterMany
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'jet-sms',
            Clients\JetSmsClientInterface::class,
        ];
    }
}
