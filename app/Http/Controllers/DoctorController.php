<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DOCTOR LIST PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view('doctor.doctors.index', [

            'pageTitle' => 'Doctors',

            'breadcrumbs' => [
                [
                    'title' => 'Doctors',
                    'url' => route('doctor.doctors.index'),
                ],
            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DOCTOR JSON DATA
    |--------------------------------------------------------------------------
    */

    public function data(Request $request)
    {
        $query = Doctor::query()
            ->with('user');


        /*
        |--------------------------------------------------------------------------
        | Total records
        |--------------------------------------------------------------------------
        */

        $recordsTotal = Doctor::count();


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search.value')) {

            $search = $request->input('search.value');

            $query->where(function ($query) use ($search) {

                $query->where(
                    'doctor_id',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'specialization',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'phone',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas('user', function ($query) use ($search) {

                    $query->where(
                        'name',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'email',
                        'like',
                        "%{$search}%"
                    );

                });

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Filtered records
        |--------------------------------------------------------------------------
        */

        $recordsFiltered = $query->count();


        /*
        |--------------------------------------------------------------------------
        | Ordering
        |--------------------------------------------------------------------------
        */

        $columns = [

            0 => 'id',

            1 => 'id',

            2 => 'doctor_id',

            3 => 'specialization',

            4 => 'phone',

            5 => 'created_at',

            6 => 'created_at',

        ];


        $orderColumn = (int) $request->input(
            'order.0.column',
            6
        );


        $orderDirection = $request->input(
            'order.0.dir',
            'desc'
        );


        $orderBy =
            $columns[$orderColumn]
            ?? 'created_at';


        $orderDirection =
            in_array(
                $orderDirection,
                ['asc', 'desc']
            )
                ? $orderDirection
                : 'desc';


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $start = (int) $request->input(
            'start',
            0
        );


        $length = (int) $request->input(
            'length',
            10
        );


        $length = min(
            max($length, 1),
            100
        );


        /*
        |--------------------------------------------------------------------------
        | Get Doctors
        |--------------------------------------------------------------------------
        */

        $doctors = $query

            ->orderBy(
                $orderBy,
                $orderDirection
            )

            ->skip($start)

            ->take($length)

            ->get();


        /*
        |--------------------------------------------------------------------------
        | Transform Data
        |--------------------------------------------------------------------------
        */

        $data = $doctors->map(function ($doctor) {

            return [

                'id' =>
                    $doctor->id,

                'doctor_id' =>
                    $doctor->doctor_id,

                'name' =>
                    $doctor->user?->name,

                'email' =>
                    $doctor->user?->email,

                'specialization' =>
                    $doctor->specialization,

                'phone' =>
                    $doctor->phone,

                'created_at' =>
                    $doctor->created_at
                        ? $doctor->created_at->format('d M Y')
                        : null,

                'show_url' =>
                    route(
                        'doctor.doctors.show',
                        $doctor
                    ),

                'edit_url' =>
                    route(
                        'doctor.doctors.edit',
                        $doctor
                    ),

            ];

        });


        /*
        |--------------------------------------------------------------------------
        | DataTables Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'draw' =>
                (int) $request->input('draw'),

            'recordsTotal' =>
                $recordsTotal,

            'recordsFiltered' =>
                $recordsFiltered,

            'data' =>
                $data,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('doctor.doctors.create', [

            'pageTitle' => 'Add Doctor',

            'breadcrumbs' => [

                [
                    'title' => 'Doctors',
                    'url' =>
                        route('doctor.doctors.index'),
                ],

                [
                    'title' => 'Add Doctor',
                    'url' =>
                        route('doctor.doctors.create'),
                ],

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'first_name' => [
                'required',
                'string',
                'max:255',
            ],

            'last_name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
            ],

            'doctor_id' => [
                'required',
                'string',
                'unique:doctors,doctor_id',
            ],

            'specialization' => [
                'nullable',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:255',
            ],

        ]);


        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            $user = User::create([

                'name' =>
                    $validated['first_name']
                    . ' '
                    . $validated['last_name'],

                'email' =>
                    $validated['email'],

                'password' =>
                    Hash::make(
                        $validated['password']
                    ),

            ]);


            /*
            |--------------------------------------------------------------------------
            | Create Doctor
            |--------------------------------------------------------------------------
            */

            Doctor::create([

                'user_id' =>
                    $user->id,

                'doctor_id' =>
                    $validated['doctor_id'],

                'specialization' =>
                    $validated['specialization']
                    ?? null,

                'phone' =>
                    $validated['phone']
                    ?? null,

            ]);

        });


        return redirect()

            ->route(
                'doctor.doctors.index'
            )

            ->with(
                'success',
                'Doctor created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Doctor $doctor)
    {
        $doctor->load('user');


        return view('doctor.doctors.show', [

            'doctor' =>
                $doctor,

            'pageTitle' =>
                'Doctor Details',

            'breadcrumbs' => [

                [
                    'title' =>
                        'Doctors',

                    'url' =>
                        route(
                            'doctor.doctors.index'
                        ),
                ],

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Doctor $doctor)
    {
        $doctor->load('user');


        return view('doctor.doctors.edit', [

            'doctor' =>
                $doctor,

            'pageTitle' =>
                'Edit Doctor',

            'breadcrumbs' => [

                [
                    'title' =>
                        'Doctors',

                    'url' =>
                        route(
                            'doctor.doctors.index'
                        ),
                ],

                [
                    'title' =>
                        'Edit Doctor',

                    'url' =>
                        route(
                            'doctor.doctors.edit',
                            $doctor
                        ),
                ],

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Doctor $doctor
    ) {

        $doctor->load('user');


        $validated = $request->validate([

            'first_name' => [
                'required',
                'string',
                'max:255',
            ],

            'last_name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email,'
                . $doctor->user_id,
            ],

            'doctor_id' => [
                'required',
                'string',
                'unique:doctors,doctor_id,'
                . $doctor->id,
            ],

            'specialization' => [
                'nullable',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:255',
            ],

        ]);


        DB::transaction(function () use (
            $validated,
            $doctor
        ) {

            /*
            |--------------------------------------------------------------------------
            | Update User
            |--------------------------------------------------------------------------
            */

            $doctor->user->update([

                'name' =>
                    $validated['first_name']
                    . ' '
                    . $validated['last_name'],

                'email' =>
                    $validated['email'],

            ]);


            /*
            |--------------------------------------------------------------------------
            | Update Doctor
            |--------------------------------------------------------------------------
            */

            $doctor->update([

                'doctor_id' =>
                    $validated['doctor_id'],

                'specialization' =>
                    $validated['specialization']
                    ?? null,

                'phone' =>
                    $validated['phone']
                    ?? null,

            ]);

        });


        return redirect()

            ->route(
                'doctor.doctors.edit',
                $doctor
            )

            ->with(
                'success',
                'Doctor updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Doctor $doctor)
    {
        $user = $doctor->user;


        DB::transaction(function () use (
            $doctor,
            $user
        ) {

            /*
            |--------------------------------------------------------------------------
            | Delete Doctor
            |--------------------------------------------------------------------------
            */

            $doctor->delete();


            /*
            |--------------------------------------------------------------------------
            | Delete User
            |--------------------------------------------------------------------------
            */

            if ($user) {

                $user->delete();

            }

        });


        return redirect()

            ->route(
                'doctor.doctors.index'
            )

            ->with(
                'success',
                'Doctor deleted successfully.'
            );
    }
}
 