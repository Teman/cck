<?php namespace Teman\Cck\Controllers;

/**
 *
 * - get column properties for items in fillable array
 * - build view with smart-guessing field types
 *
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;


abstract class CckController extends \Controller{


    protected $use_model;

    /**
     * @var Model
     */
    private $model;


    /**
     * @var Collection
     */
    private $columns;


    /**
     * @var Collection
     */
    private $filtered_columns;


    /**
     * @var Collection
     */
    private $form_fields;


    public function __construct(){


        $this->_init_model();
        $this->_init_columns();
        $this->_init_filtered_columns();
        $this->_init_form_fields();

        View::share('cckFormFields', $this->form_fields);
    }


    private function _init_model(){

        $this->model = new $this->use_model;

    }


    private function _init_columns(){

        $this->columns = new Collection( $this->model->columns() );

    }


    private function _init_filtered_columns(){

        $this->filtered_columns = $this->columns->filter(function($col){

                /*
                 * varchar
                 */
                if ( strpos($col->Type, 'varchar') === 0 ){
                    return true;
                }

                /*
                 * text
                 */
                if ( strpos($col->Type, 'text') === 0 ){
                    return true;
                }
            });

    }


    private function _init_form_fields()
    {

        $this->form_fields = new Collection;

        $this->filtered_columns->each(function($col){

                $name = $col->Field;
                $type = 'text';

                if ( strpos($col->Type, 'text') === 0 ) $type = 'textarea';

                $this->form_fields->push([
                        'name' => $name,
                        'type' => $type
                    ]);

            });
    }


    public function index(){

        return View::make('cck::index');

    }




}