<?php namespace Teman\Cck\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Laracasts\Validation\FormValidator;

/**
 * Class CckController
 * @package Teman\Cck\Controllers
 */
abstract class CckController extends \Controller
{


    /**
     * @var string
     */
    protected $use_model;


    /**
     * @var FormValidator
     */
    protected $validator;

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


    /**
     *
     */
    public function __construct()
    {


        $this->_init_model();
        $this->_init_columns();
        $this->_init_filtered_columns();
        $this->_init_form_fields();

        $this->_set_shared_vars();

    }


    /**
     *
     */
    private function _init_model()
    {

        $this->model = new $this->use_model;

    }


    /**
     *
     */
    private function _init_columns()
    {

        $this->columns = new Collection($this->model->columns());

    }


    /**
     *
     */
    private function _init_filtered_columns()
    {

        $this->filtered_columns = $this->columns->filter(
            function ($col) {

                /*
                 * varchar
                 */
                if (strpos($col->Type, 'varchar') === 0) {
                    return true;
                }

                /*
                 * text
                 */
                if (strpos($col->Type, 'text') === 0) {
                    return true;
                }
            }
        );

    }


    /**
     *
     */
    private function _init_form_fields()
    {

        $this->form_fields = new Collection;

        $this->filtered_columns->each(
            function ($col) {

                $name = $col->Field;
                $type = 'text';

                if (strpos($col->Type, 'text') === 0) {
                    $type = 'textarea';
                }

                $this->form_fields->push(
                    [
                        'name' => $name,
                        'type' => $type
                    ]
                );

            }
        );
    }


    /**
     *
     */
    private function _set_shared_vars()
    {

        /**
         * Config vars
         */
        View::share('cckMasterView', Config::get('cck::masterView'));
        View::share('cckMasterViewSection', Config::get('cck::masterViewSection'));

        /**
         * Form vars
         */
        View::share('cckFormFields', $this->form_fields);
        View::share('cckFormTitle', $this->use_model);

        /**
         * Route vars
         */
        View::share('cckResourceBaseRoute', $this->_get_resource_base_route_name());

    }


    /**
     * @return string
     */
    private function _get_resource_base_route_name(){

        $current_route_name = Route::currentRouteName();

        $route_array = explode('.', $current_route_name);
        array_pop($route_array);

        return implode('.', $route_array);

    }


    private function _validate_input(){

        if ( $this->validator ){

            $this->validator->validate(Input::all());
        }

    }


    /**
     * @return mixed
     */
    public function index()
    {

        $items = $this->model->all();

        return View::make('cck::index')->withItems($items);

    }


    /**
     * @return mixed
     */
    public function create()
    {

        return View::make('cck::create');

    }


    public function store()
    {

        $this->_validate_input();

        $this->form_fields->each( function($field){
                $this->model->{$field['name']} = Input::get($field['name']);
            } );

        $this->model->save();

        return Redirect::route( $this->_get_resource_base_route_name() . '.index' )->withFlashMessage('New ' . $this->use_model . ' created');
    }


    public function edit($id)
    {

        $item = $this->model->findOrFail($id);

        return View::make('cck::edit')->withItem($item);

    }


    public function update($id){

        $this->_validate_input();

        $item = $this->model->findOrFail($id);

        $this->form_fields->each( function($field) use ($item){
                $item->{$field['name']} = Input::get($field['name']);
            } );

        $item->save();

        return Redirect::route( $this->_get_resource_base_route_name() . '.index' )->withFlashMessage($this->use_model . ' updated');
    }


    public function destroy($id)
    {

        $item = $this->model->findOrFail($id);

        $item->delete();


        return Redirect::route( $this->_get_resource_base_route_name() . '.index' )->withFlashMessage( $this->use_model . ' deleted' );

    }

}