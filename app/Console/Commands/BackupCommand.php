<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use App\Mail\BackupMail;

class BackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup Data';

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
     * @return mixed
     */
    public function handle()
    {
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $database = config('database.connections.mysql.database');
        $directory = storage_path() . "/backup/";
        $to = Config::get('mail.from.address');
        // Delete old file
        array_map('unlink', array_filter((array) glob($directory . "*.sql")));
        // Expert
        $filename = $database . "-" . date('YmdHis') . ".sql";
        $command = "mysqldump --user=" . $username . " --password=" . $password . " --host=" . $host . " " . $database . " > " . $directory . $filename;
        exec($command);
        // Download
        $isOk = is_file($directory . $filename);
        if ($isOk) {
            $attachment['file'] = $directory . $filename;
            $attachment['filename'] = $filename;
            Mail::to($to)->send(new BackupMail($attachment));
        }
    }
}
