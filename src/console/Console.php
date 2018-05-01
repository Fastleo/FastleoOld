<?php

namespace Camanru\Fastleo;

use \Illuminate\Support\Facades\Hash;
use \Illuminate\Console\Command as BaseCommand;

class Console extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fastleo:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user';

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'admin'];

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return bool
     */
    public function handle()
    {
        $class = config(
            'auth.providers.' . config(
                'auth.guards.' . config(
                    'auth.defaults.guard'
                ) . '.provider'
            ) . '.model'
        );

        $user = new $class;
        $fillables = $this->fillable;

        foreach ($fillables as $k => $fillable) {
            if ($fillable == 'password') {
                $user->password = Hash::make($this->secret(($k + 1) . "/" . count($fillables) . " User $fillable"));
            } else {
                $user->$fillable = $this->ask(($k + 1) . "/" . count($fillables) . " User $fillable");
            }
        }

        if ($this->confirm("Do you want to create the user?", true)) {
            $user->save();
            $this->info("User created (id: {$user->id})");
        }

        return true;
    }
}