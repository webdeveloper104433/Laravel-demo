<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Flow;
use App\FlowEntry;
class FlowsController extends Controller
{
    const PAGE_NAME = "flows";

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

        $flows = Flow::orderBy('user_id')->orderByDesc('id')->get();

        return view('admin/flows/index', ['flows' => $flows, 'page_name' => self::PAGE_NAME]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/flows/create', ['page_name' => self::PAGE_NAME]);
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
            'name' => ['required', 'string', 'unique:flows', 'max:255'],
            'description' => 'required|string',
            'layout' => 'nullable|string|max:255',
        ]);
        
        $flow = new Flow($request->all());

        $flow->user_id = auth()->user()->id;

        $flow->save();

        return redirect(route('admin.flows'))->with('success', 'A new flow was created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flow = Flow::find($id);

        if (empty($flow)) {
            return redirect(route('admin.flows'))->with('warning', 'warning.');
        }

        return view('admin/flows/edit', ['flow' => $flow, 'page_name' => self::PAGE_NAME]);
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
            'name' => [
                            'required',
                            'string',
                            'max:255',
                            Rule::unique('flows')->ignore($id)
                        ],
            'description' => 'required|string',
            'layout' => 'nullable|string|max:255',
        ]);
        
        $flow = Flow::find($id);

        $flow->fill($request->all());
        $flow->save();

        return redirect(url('admin/flows/' . $id . '/edit'))->with('success', 'A flow was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Flow::destroy($id);
        return redirect(url('admin/flows'))->with('success', 'A flow was deleted.');
    }

    public function get_flow_entriable_names(Request $request) {
        $flow_entriable_names = collect();

        switch ($request->flow_entriable_type) {
            case 'App\Device':
            case 'App\Image':
            case 'App\Gallery':
            case 'App\Site':
            case 'App\Schedule':
                $flow_entriable_names = $request->flow_entriable_type::orderBy('name')->get();
                break;
        }

        return response()->json([
            'flow_entriable_names' => $flow_entriable_names,
        ]);
    }

    public function flow_entry_store(Request $request, $flow_id) {

        $flow_entry = new FlowEntry($request->all());
        $flow_entry->flow_id = $flow_id;
        $flow_entry->user_id = auth()->user()->id;
        $flow_entry->save();


        $request->session()->now('success', 'A new flow entry was created');
        return response()->json($flow_entry);
    }

    public function get_flow_entry($id, $flow_entry_id) {

        $flow_entry = FlowEntry::find($flow_entry_id);

        $flow_entriable_names = collect();

        switch ($flow_entry->flow_entriable_type) {
            case 'App\Device':
            case 'App\Image':
            case 'App\Gallery':
            case 'App\Site':
            case 'App\Schedule':
                $flow_entriable_names = $flow_entry->flow_entriable_type::orderBy('name')->get();
                break;
        }

        return response()->json([
            'flow_entry' => $flow_entry,
            'flow_entriable_names' => $flow_entriable_names,
        ]);
    }

    public function flow_entry_update(Request $request, $flow_id, $flow_entry_id) {

        $flow_entry = FlowEntry::find($flow_entry_id);
        $flow_entry->fill($request->all());
        $flow_entry->flow_id = $flow_id;
        $flow_entry->user_id = auth()->user()->id;
        $flow_entry->save();

        $request->session()->now('success', 'A flow entry was updated');
        return response()->json($flow_entry);
    }

    public function flow_entry_delete($flow_id, $flow_entry_id) {
        FlowEntry::destroy($flow_entry_id);

        return redirect(url('admin/flows/' . $flow_id . '/edit'))->with('success', 'A flow entry was deleted.');

    }
}
