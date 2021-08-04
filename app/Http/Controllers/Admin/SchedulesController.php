<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


use App\Schedule;
use App\Image;

class SchedulesController extends Controller
{
    const PAGE_NAME = "schedules";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $schedules = Schedule::where('user_id', auth()->user()->id)->orderBy('user_id')->orderByDesc('id')->get();

        return view('admin/schedules/index', ['schedules' => $schedules, 'page_name' => self::PAGE_NAME]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $images = Image::where('user_id', auth()->user()->id)->orderBy('name')->get();
        return view('admin/schedules/create', ['images' => $images, 'page_name' => self::PAGE_NAME]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'date' => 'required|date',
            'time' => 'required|string',
            'name' => 'required|string',
            'type' => [
                        'required',
                        Rule::in(['kids', 'adults', 'general']),
                    ],
            'image_id' => 'nullable|exists:images,id',

        ]);
        
        $schedule = new Schedule($request->all());

        $schedule->user_id = auth()->user()->id;

        $schedule->save();

        return redirect(route('admin.schedules'))->with('success', 'A new schedule was created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = Schedule::find($id);
        $images = Image::where('user_id', auth()->user()->id)->orderBy('name')->get();
        
        if (empty($schedule)) {
            return redirect(route('admin.schedules'))->with('warning', 'warning.');
        }

        return view('admin/schedules/edit', ['schedule' => $schedule, 'images' => $images, 'page_name' => self::PAGE_NAME]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'date' => 'required|date',
            'time' => 'required|string',
            'name' => [
                        'required',
                        'string',
                    ],
            'type' => [
                        'required',
                        Rule::in(['kids', 'adults', 'general']),
                    ],
            'line1' => 'required|string|max:250',
            'image_id' => 'nullable|exists:images,id',

        ]);
        
        $schedule = Schedule::find($id);
        $schedule->fill($request->all());
        $schedule->save();

        return redirect(url('admin/schedules/' . $id . '/edit'))->with('success', 'A schedule was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Schedule::destroy($id);
        return redirect(url('admin/schedules'))->with('success', 'A schedule was deleted.');
    }
}
