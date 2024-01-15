<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-auth-token {len=64}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создает новый токен аутнефикации';

    protected array $specSymbols = ['-', '_'];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $randomToken = '';
        for ($i = 0; $i < $this->argument('len'); $i += 1) {
            $randSymbolType = mt_rand(1, 10);
            if ($randSymbolType % 2 == 0) {
                if ($randSymbolType >= 5) {
                    $randomToken .= chr(mt_rand(65, 90));
                } else {
                    $randomToken .= chr(mt_rand(97, 122));
                }
            } elseif ($randSymbolType % 3 == 0) {
                $randomToken .= mt_rand(0, 9);
            } else {
                $randomToken .= $this->specSymbols[array_rand($this->specSymbols)];
            }
        }
        //куда класть то его???
    }
}
