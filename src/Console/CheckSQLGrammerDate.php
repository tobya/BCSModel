<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * There is a international date format Y-m-d that is supposed to be universal, however the MSSQL implementation is flawed
 * and is not universal and incorrect interprets it as Y-d-m which is beyond idiotic.
 * Laravel uses Y-m-d as their international format.  This command checks the vendor directory for the file and updates
 * it if required.  A patch could be submitted to the illuminate project to allow the end user of Illuminate to change this.
 * Class CheckSQLGrammerDate
 * @package App\Console\Commands
 */
class CheckSQLGrammerDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bcs:checksqldate {--update : Overwrite files in Vendor directory.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if the Correct format for SQL Date has been written. ';

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
     *
     * @return int
     */
    public function handle()
    {
        $filetocheck = base_path('vendor\laravel\framework\src\Illuminate\Database\Query\Grammars\SqlServerGrammar.php');
        if (file_exists($filetocheck)){
            $file_txt = Str::of(file_get_contents($filetocheck));
            $datestr = 'return \'Y-m-d H:i:s.v\';';
            if ($file_txt->contains($datestr)){
                if ($this->option('update')){
                    $UpdatedFile_txt = $file_txt->replace($datestr, 'return \'Ymd H:i:s.v\';');
                    file_put_contents($filetocheck,$UpdatedFile_txt);
                    $this->comment("
Incorrect Date Format value found in file SqlServerGrammar.php
on disk: $filetocheck");
                    $this->info('Updated');
                    return 0;
                } else {
                    $this->warn( $this->NoUpdateMessage($filetocheck));
                    $this->warn('Not Updated');
                    return 0;
                }

            }
        }
        $this->info( "Date Format Appears to be ok.");
        return 0;
    }

    public function NoUpdateMessage($filetocheck){
        return  "
 SqlServerGrammar.php has been overwritten with the wrong date format.  You need to manually edit or call BCS:CheckSQLDate --update
 Change function getDateFormat in file
     $filetocheck
 to return the following format
     return 'Ymd H:i:s.v';
                ";
    }
}
