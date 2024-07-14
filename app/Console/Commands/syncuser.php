<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Linked\BaseUser;
use DB;

class syncuser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi user e-central';

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
        $this->info("Memulai migrasi data e-central, jangan tutup terminal ini.");
        DB::beginTransaction();
        $dateNow = date("Y-m-d H:i:s");
        try {
            $data = BaseUser::join('karyawan as k', function($join){
                $join->on('users.nrp','k.nrp')->on('users.p_site','k.paysite');
            })->whereNull('tglkeluar')->get();
            $error['emails_duplicate'] = $error['users_duplicate'] = [];
            $success = 0;
            $this->withProgressBar($data, function($value)use(&$error,&$success,$dateNow){
                $user = DB::table("users")->where('nrp', $value->nrp)->where('p_site', $value->p_site)->first();
                if($user){
                    array_push($error['users_duplicate'], "$user->name [$value->nrp - $value->p_site]");
                    return;
                }
                $email = DB::table("users")->where('email', $value->email)->first();
                if($email){
                    array_push($error['emails_duplicate'], "$value->email");
                    return;
                }
                DB::table("users")->insert([
                    'name' => $value->name,
                    'email' => $value->email,
                    'username' => $value->email,
                    'password' => $value->password,
                    'nrp' => $value->nrp,
                    'p_site' => $value->p_site,
                    'plant' => "1C$value->w_site",
                    'group_user' => 4,
                    'created_at' => $dateNow,
                    'updated_at' => $dateNow,
                ]);
                $success++;
            });
            // Log Error
            $eMessage = ".";
            if(count($error['emails_duplicate']) > 0 || count($error['users_duplicate']) > 0){
                $cError =  count($error['emails_duplicate']) + count($error['users_duplicate']);
                $eMessage = ", dan $cError data gagal diproses.";
                DB::table('log_user')->insert([
                    'created_by' => 0,
                    'module' => 'Sinkronisasi User Central',
                    'text' => 'Duplikat user',
                    'new_value' => json_encode($error),
                    'created_at' => $dateNow,
                    'updated_at' => $dateNow,
                ]);
            }
            DB::commit();
            $this->newLine();
            $this->info("Berhasil memproses $success data$eMessage");
            return Command::SUCCESS;
        } catch (\Throwable $err) {
            DB::rollback();
            DB::table('log_error')->insert([
                'user_id' => 0,
                'module' => 'Sinkronisasi User Central',
                'message' => $err->getMessage(),
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ]);
            $this->newLine();
            $this->error('Terdapat kesalahan saat memproses data!'.$err->getMessage());
            return Command::FAILURE;
        }
    }
}
