<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class createUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user {name} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create an user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $credentials = array_intersect_key($this->input->getArguments(), array_flip(['name', 'password']));
        $credentials['email'] = $credentials['name'] . '@' . $credentials['name'];

        $user = new User($credentials);
        $user->save();
        $this->output->success('a new user id is ' . $user->id);
    }
}
