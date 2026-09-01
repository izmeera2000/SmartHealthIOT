<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Events\PatientRegistered;


class PatientController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PATIENT LIST PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {


        return view('doctor.patients.index', [
            'pageTitle' => 'Patients',


            'breadcrumbs' => [
                [
                    'title' => 'Patients',
                    'url' => route('doctor.patients.index'),
                ],
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PATIENT JSON DATA
    |--------------------------------------------------------------------------
    */


    public function data(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query = Patient::query()
            ->with([
                'user',
                'devices',
            ]);


        /*
        |--------------------------------------------------------------------------
        | Total records before search
        |--------------------------------------------------------------------------
        */

        $recordsTotal = Patient::count();


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search.value')) {

            $search = $request->input('search.value');

            $query->where(function ($query) use ($search) {

                $query->where('patient_id', 'like', "%{$search}%")

                    ->orWhere('ic_number', 'like', "%{$search}%")

                    ->orWhere('gender', 'like', "%{$search}%")

                    ->orWhere('phone', 'like', "%{$search}%")

                    /*
                    |--------------------------------------------------------------------------
                    | Search User
                    |--------------------------------------------------------------------------
                    */

                    ->orWhereHas('user', function ($query) use ($search) {

                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");

                    })

                    /*
                    |--------------------------------------------------------------------------
                    | Search Assigned Devices
                    |--------------------------------------------------------------------------
                    */

                    ->orWhereHas('devices', function ($query) use ($search) {

                        $query->where('device_name', 'like', "%{$search}%")
                            ->orWhere('device_uid', 'like', "%{$search}%");

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
            2 => 'patient_id',
            3 => 'date_of_birth',
            4 => 'gender',
            5 => 'phone',
            6 => 'blood_type',
            7 => 'created_at',

        ];


        $orderColumn = $request->input(
            'order.0.column',
            0
        );

        $orderDirection = $request->input(
            'order.0.dir',
            'desc'
        );


        $orderBy = $columns[$orderColumn] ?? 'id';

        $orderDirection = in_array(
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


        $patients = $query
            ->orderBy(
                $orderBy,
                $orderDirection
            )
            ->skip($start)
            ->take($length)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Transform
        |--------------------------------------------------------------------------
        */

        $data = $patients->map(function ($patient) {

            return [

                'id' =>
                    $patient->id,

                'patient_id' =>
                    $patient->patient_id,

                'name' =>
                    $patient->user?->name,

                'email' =>
                    $patient->user?->email,

                'age' =>
                    $patient->date_of_birth
                    ? $patient->date_of_birth->age
                    : null,

                'gender' =>
                    $patient->gender,

                'phone' =>
                    $patient->phone,

                'blood_type' =>
                    $patient->blood_type,


                /*
                |--------------------------------------------------------------------------
                | Assigned Devices
                |--------------------------------------------------------------------------
                */

                'devices' =>
                    $patient->devices->map(function ($device) {

                        return [

                            'id' =>
                                $device->id,

                            'name' =>
                                $device->device_name
                                ?: 'Unnamed Device',

                            'uid' =>
                                $device->device_uid,

                            'status' =>
                                $device->status,

                        ];

                    })->values(),


                /*
                |--------------------------------------------------------------------------
                | Created At
                |--------------------------------------------------------------------------
                */

                'created_at' =>
                    $patient->created_at
                    ? $patient->created_at->format('d M Y')
                    : null,


                /*
                |--------------------------------------------------------------------------
                | URLs
                |--------------------------------------------------------------------------
                */

                'show_url' =>
                    route(
                        'doctor.patients.show',
                        $patient
                    ),

                'edit_url' =>
                    route(
                        'doctor.patients.edit',
                        $patient
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
        return view('doctor.patients.create', [
            'pageTitle' => 'Add Patient',

            'breadcrumbs' => [
                [
                    'title' => 'Patients',
                    'url' => route('doctor.patients.index'),
                ],
                [
                    'title' => 'Add Patient',
                    'url' => route(
                        'doctor.patients.create'
                    ),
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],

            'patient_id' => ['required', 'string', 'unique:patients,patient_id'],
            'ic_number' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],

            'emergency_contact_name' => ['nullable', 'string'],
            'emergency_contact_phone' => ['nullable', 'string'],
            'emergency_contact_relationship' => ['nullable', 'string'],

            'blood_type' => ['nullable', 'string'],
            'height' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric'],
        ]);

        DB::transaction(function () use ($validated) {

            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $patient = Patient::create([
                'user_id' => $user->id,
                'patient_id' => $validated['patient_id'],
                'ic_number' => $validated['ic_number'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'doctor_id' => auth()->id(),

                'emergency_contact_name' =>
                    $validated['emergency_contact_name'] ?? null,

                'emergency_contact_phone' =>
                    $validated['emergency_contact_phone'] ?? null,

                'emergency_contact_relationship' =>
                    $validated['emergency_contact_relationship'] ?? null,

                'blood_type' => $validated['blood_type'] ?? null,
                'height' => $validated['height'] ?? null,
                'weight' => $validated['weight'] ?? null,
            ]);
         
        });

        return redirect()
            ->route('doctor.patients.index')
            ->with('success', 'Patient created successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Patient $patient)
    {
        $patient->load([
            'user',
            'devices',

        ]);

        return view('doctor.patients.show', [
            'patient' => $patient,

            'pageTitle' => 'Patient Details',

            'breadcrumbs' => [
                [
                    'title' => 'Patients',
                    'url' => route('doctor.patients.index'),
                ],
                [
                    'title' => $patient->user->name,
                    'url' => route('doctor.patients.index'),
                ],
            ],
        ]);
    }



    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Patient $patient)
    {
        $patient->load([
            'user',
            'devices',
        ]);

        $devices = Device::where('doctor_id', auth()->id())
            ->orderBy('device_name')
            ->get();

        return view('doctor.patients.edit', compact(
            'patient',
            'devices'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Patient $patient)
    {
        $patient->load('user');

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'unique:users,email,' . $patient->user_id,
            ],

            'patient_id' => [
                'required',
                'string',
                'unique:patients,patient_id,' . $patient->id,
            ],

            'ic_number' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],

            'emergency_contact_name' => ['nullable', 'string'],
            'emergency_contact_phone' => ['nullable', 'string'],
            'emergency_contact_relationship' => ['nullable', 'string'],

            'blood_type' => ['nullable', 'string'],
            'height' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric'],

            'device_id' => [
                'nullable',
                'exists:devices,id',
            ],
        ]);

        DB::transaction(function () use ($validated, $patient) {

            /*
            |--------------------------------------------------------------------------
            | Update User
            |--------------------------------------------------------------------------
            */

            $patient->user->update([
                'name' =>
                    $validated['first_name'] . ' ' . $validated['last_name'],

                'email' =>
                    $validated['email'],
            ]);


            /*
            |--------------------------------------------------------------------------
            | Update Patient
            |--------------------------------------------------------------------------
            */

            $patient->update([
                'patient_id' =>
                    $validated['patient_id'],

                'ic_number' =>
                    $validated['ic_number'] ?? null,

                'date_of_birth' =>
                    $validated['date_of_birth'] ?? null,

                'gender' =>
                    $validated['gender'] ?? null,

                'phone' =>
                    $validated['phone'] ?? null,

                'address' =>
                    $validated['address'] ?? null,

                'emergency_contact_name' =>
                    $validated['emergency_contact_name'] ?? null,

                'emergency_contact_phone' =>
                    $validated['emergency_contact_phone'] ?? null,

                'emergency_contact_relationship' =>
                    $validated['emergency_contact_relationship'] ?? null,

                'blood_type' =>
                    $validated['blood_type'] ?? null,

                'height' =>
                    $validated['height'] ?? null,

                'weight' =>
                    $validated['weight'] ?? null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Device Assignment
            |--------------------------------------------------------------------------
            */

            // First remove any device currently assigned to this patient
            Device::where('patient_id', $patient->id)
                ->update([
                    'patient_id' => null,
                ]);


            // Assign selected device
            if (!empty($validated['device_id'])) {

                $device = Device::where('id', $validated['device_id'])
                    ->where('doctor_id', auth()->id())
                    ->firstOrFail();

                $device->update([
                    'patient_id' => $patient->id,
                ]);
            }
        });

        return redirect()
            ->route('doctor.patients.edit', $patient)
            ->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $user = $patient->user;

        DB::transaction(function () use ($patient, $user) {

            $patient->delete();

            if ($user) {
                $user->delete();
            }
        });


        return redirect()
            ->route('doctor.patients.index')
            ->with('success', 'Patient deleted successfully.');
    }
}

