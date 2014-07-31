<?php  namespace Teman\Cck\Models\Traits;


use Illuminate\Support\Facades\DB;

trait CckTrait{


    public function columns(){

        $table = $this->getTable();

        return DB::select(" SHOW COLUMNS FROM ".$table);
    }

}