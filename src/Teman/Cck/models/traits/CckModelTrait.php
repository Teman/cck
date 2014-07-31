<?php  namespace Teman\Cck\Models\Traits;


use Illuminate\Support\Facades\DB;

trait CckModelTrait{


    public function columns(){

        $table = $this->getTable();

        return DB::select(" SHOW COLUMNS FROM ".$table);
    }

}