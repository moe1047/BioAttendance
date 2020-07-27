<?php

namespace App\Http\Controllers\Admin;

use App\AcademicYear;
use App\Http\Requests\ShiftUpdateRequest;
use App\Models\Shift;
use App\Models\Timetable;
use App\ShiftTimetable;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ShiftRequest as StoreRequest;
use App\Http\Requests\ShiftRequest as UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShiftCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Shift");
        $this->crud->setRoute("admin/shift");
        $this->crud->setEntityNameStrings('shift', 'shifts');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        $this->crud->setFromDb();

        // ------ CRUD FIELDS
         $this->crud->addField([   // date_picker
             'name' => 'start_date',
             'type' => 'date_picker',
             'label' => 'Start Date',
             // optional:
             'date_picker_options' => [
                 'todayBtn' => true,
                 'format' => 'dd-mm-yyyy',
                 'language' => 'en'
             ],
         ], 'update/create/both');
        $this->crud->addField([   // date_picker
            'name' => 'end_date',
            'type' => 'date_picker',
            'label' => 'End Date',
            // optional:
            'date_picker_options' => [
                'todayBtn' => true,
                'format' => 'dd-mm-yyyy',
                'language' => 'en'
            ],
        ], 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();

    }
    public function index()
    {

        // your additional operations before save here
        //$redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        $academic_years=AcademicYear::all()->pluck('from_to','id');
        $default_year=AcademicYear::where('default',true)->get()->first()->id;
        $shifts=Shift::where('clicklizeAcYear_id',$default_year)->get();
        $timetables=Timetable::all()->pluck('timetable_detail','id');
        return view('shift.index',compact('timetables','shifts'));
    }
    public function create()
    {

        // your additional operations before save here
        //$redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        $academic_years=AcademicYear::all()->pluck('from_to','id');
        $default_year=AcademicYear::where('default',true)->get()->first()->id;

        $shifts=Shift::where('clicklizeAcYear_id',$default_year)->get();
        $timetables=Timetable::all()->pluck('timetable_detail','id');

        return view('shift.create',compact('timetables','shifts','academic_years','default_year'));
    }
    public function edit($id)
    {

        // your additional operations before save here
        //$redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        $shift=Shift::findOrFail($id);
        $timetables=Timetable::all()->pluck('timetable_detail','id');
        $selected_days=array();
        $selected_days['sat']=$shift->shiftTimetables()->where('day', "sat")->pluck('clicklizetimetable_id')->toArray();
        $selected_days['sun']=$shift->shiftTimetables()->where('day', "sun")->pluck('clicklizetimetable_id')->toArray();
        $selected_days['mon']=$shift->shiftTimetables()->where('day', "mon")->pluck('clicklizetimetable_id')->toArray();
        $selected_days['tue']=$shift->shiftTimetables()->where('day', "tue")->pluck('clicklizetimetable_id')->toArray();
        $selected_days['wed']=$shift->shiftTimetables()->where('day', "wed")->pluck('clicklizetimetable_id')->toArray();
        $selected_days['thu']=$shift->shiftTimetables()->where('day', "thu")->pluck('clicklizetimetable_id')->toArray();
        $selected_days['fri']=$shift->shiftTimetables()->where('day', "fri")->pluck('clicklizetimetable_id')->toArray();
        $academic_years=AcademicYear::all()->pluck('from_to','id');
        $default_year=AcademicYear::where('default',true)->get()->first()->id;

        return view('shift.edit',compact('timetables','shift','selected_days','academic_years','default_year'));
    }


	public function store(StoreRequest $request)
	{
        DB::transaction(function ($request)use ($request) {
            $shit=Shift::create(['name'=>$request->input('name'),'clicklizeAcYear_id'=>$request->input('ac_year_id')]);
            if($request->input('day')!=''){
                foreach($request->input('day') as $day=>$timetables){
                    if(!empty($timetables)){
                        foreach($timetables as $timetable){
                            ShiftTimetable::create(['clicklizetimetable_id'=>$timetable,'clicklizeshift_id'=>$shit->id,'day'=>$day]);
                        }



                    }

                }
            }


        }, 5);


		// your additional operations before save here
        //$redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return redirect()->back();
	}

    /**
     * @param ShiftUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ShiftUpdateRequest $request)
	{
        //return "hey";
        DB::transaction(function ($request)use ($request) {
            Shift::findOrFail($request->input('id'))
                ->update(['name'=>$request->input('name'),'clicklizeAcYear_id'=>$request->input('ac_year_id')]);
        //$shit=Shift::create(['name'=>$request->input('name'),'start_date'=>$request->input('from'),'end_date'=>$request->input('to')]);
            ShiftTimetable::where('clicklizeshift_id', $request->input('id'))->delete();
            foreach($request->input('day') as $day=>$timetables){
                if(!empty($timetables)){
                    foreach($timetables as $timetable){
                        ShiftTimetable::create(['clicklizetimetable_id'=>$timetable,'clicklizeshift_id'=>$request->input('id'),'day'=>$day]);
                    }
                }

            }

    }, 5);
		// your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return redirect("admin/shift");
	}
    public function destroy($id)
    {
        DB::transaction(function ($id)use ($id) {
            Shift::find($id)->shiftTimetables()->delete();
            Shift::find($id)->delete();
        }, 5);

        //return redirect("admin/shift");
    }
}
