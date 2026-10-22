<?php

namespace App\Console\Commands\Scockpit;

use App\Models\Institute;
use Illuminate\Console\Command;
use SCockpit\Connector\PortalAPIClient;

class SyncInstitutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scockpit:sync-institutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $client = new PortalAPIClient(config('s_cockpit.portal-api.token'), config('s_cockpit.oauth.api_url'));

        $institutes = $client->allSparkassen();

        foreach ($institutes as $institute) {

            $model = Institute::find($institute['id']);
            $payload = [
                'id' => $institute['id'],
                'bic' => $institute['bic'],
                'blz' => $institute['blz'],
                'name' => $institute['name'],
            ];

            if ($model === null) {
                Institute::create($payload);

                $this->info('Institute: „'.$institute['name'].'“ created');
            } else {
                $model->update($payload);

                $this->info('Institute: „'.$institute['name'].'“ updated');
            }

        }
    }
}
