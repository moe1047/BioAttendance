<?php

namespace App\Http\Controllers\Admin;

use App\Models\Timetable;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TimetableRequest as StoreRequest;
use App\Http\Requests\TimetableRequest as UpdateRequest;
use Carbon\Carbon;

class TimetableCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Timetable");
        $this->crud->setRoute("admin/timetable");
        $this->crud->setEntityNameStrings('timetable', 'timetables');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        $this->crud->setFromDb();

        // ------ CRUD FIELDS
         //$this->crud->addField(, 'update/create/both');
        $this->crud->addFields([[   // Time
            'name' => 'start_time',
            'label' => 'Start time',

        ],[   // Time
            'name' => 'end_time',
            'label' => 'End time',
            'type' => 'time',
        ],[   // Time
            'name' => 'late_min',
            'label' => 'Late(min)',
        ],[   // Time
            'name' => 'early_min',
            'label' => 'Early(min)',
        ],[   // Time
            'name' => 'start_clockin_time',
            'label' => 'Start clock-in time',
        ],
        [   // Time
            'name' => 'end_clockin_time',
            'label' => 'End clock-in time',
        ],[   // Time
            'name' => 'start_clockout_time',
            'label' => 'Start clock-out time',
        ],[   // Time
            'name' => 'end_clockout_time',
            'label' => 'End clock-out time',
        ],[   // Time
            'name' => 'must_clock_out',
            'label' => 'Must Clock-Out',
            'type'  => 'checkbox'
        ]], 'create');
        $this->crud->addFields([[   // Time
            'name' => 'start_time',
            'label' => 'Start time',

        ],[   // Time
            'name' => 'end_time',
            'label' => 'End time',
            'type' => 'time',
        ],[   // Time
            'name' => 'late_min',
            'label' => 'Late(min)',
        ],[   // Time
            'name' => 'early_min',
            'label' => 'Early(min)',
        ],[   // Time
            'name' => 'start_clockin_time',
            'label' => 'Start clock-in time',
        ],
            [   // Time
                'name' => 'end_clockin_time',
                'label' => 'End clock-in time',
            ],[   // Time
                'name' => 'start_clockout_time',
                'label' => 'Start clock-out time',
            ],[   // Time
                'name' => 'end_clockout_time',
                'label' => 'End clock-out time',
            ]], 'update');
         $this->crud->removeField('must_clock_in', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
          // add a single column, at the end of the stack
         //$this->crud->addColumn(); // add multiple columns, at the end of the stack
         $this->crud->removeColumn('must_clock_in'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
         $this->crud->setColumnDetails('start_time', ['label' => 'Start Time',
             ]);
        $this->crud->setColumnDetails('end_time', ['label' => 'End time','type' => 'time']);
        $this->crud->setColumnDetails('late_min', ['label' => 'Late(min)','type' => 'time']);
        $this->crud->setColumnDetails('early_min', ['label' => 'Early(min)','type' => 'time']);
        $this->crud->setColumnDetails('start_clockin_time', ['label' => 'Start clock-in time','type' => 'time']);
        $this->crud->setColumnDetails('end_clockin_time', ['label' => 'End clock-in time','type' => 'time']);
        $this->crud->setColumnDetails('start_clockout_time', ['label' => 'Start clock-out time','type' => 'time']);
        $this->crud->setColumnDetails('end_clockout_time', ['label' => 'End clock-out time','type' => 'time']);

        $this->crud->setColumnDetails('must_clock_out', ['label' => 'Must ClockOut','type' => 'check']);

        //$this->crud->setColumnDetails('must_clock_in', ['label' => 'Must Clock-In','type' => 'checkbox']);
        //$this->crud->setColumnDetails('must_clock_out', ['label' => 'Must Clock-Out','type' => 'checkbox']);
        // adjusts the properties of the passed in column (by name)
         //$this->crud->setColumnsDetails(['start_time', 'end_time'], ['label' => 'Start time'],['label' => 'End time']);

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
    public function edit($id)
    {
        $timetable=Timetable::find($id);
		//return $timetable->start_time;
        $id=$timetable->id;
        $name=$timetable->name;
        $start_time=Carbon::parse($timetable->start_time)->format('H:i');
        $end_time=Carbon::parse($timetable->end_time)->format('H:i');
        $late_min=$timetable->late_min;
        $early_min=$timetable->early_min;
		$start_clockin_time=Carbon::parse($timetable->start_clockin_time)->format('H:i');
        $end_clockin_time=Carbon::parse($timetable->end_clockin_time)->format('H:i');
        $start_clockout_time=Carbon::parse($timetable->start_clockout_time)->format('H:i');
        $end_clockout_time=Carbon::parse($timetable->end_clockout_time)->format('H:i');
        $must_clock_in = $timetable->must_clock_in;
        $must_clock_out = $timetable->must_clock_out;
        return view('timeTable.edit',compact('name','start_time','end_time','late_min','early_min',
            'start_clockin_time','end_clockin_time','start_clockout_time','end_clockout_time','id','timetable','must_clock_in','must_clock_out'));

    }

	public function store(StoreRequest $request)
	{
		// your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}

	public function update(UpdateRequest $request)
	{
        //return $request->all();
		// your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}
}
