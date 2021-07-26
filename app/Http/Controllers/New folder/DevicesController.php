<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Device;

class DevicesController extends Controller
{
    const PAGE_NAME = "devices";

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $devices = Device::orderByDesc('id')->get();
        return view('devices/index', ["devices" => $devices, 'page_name' => self::PAGE_NAME]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $device = Device::find($id);

        if (empty($device)) {
            return redirect(route('devices'))->with('warning', 'warning.');
        }

        return view('devices/edit', ['device' => $device, 'page_name' => self::PAGE_NAME]);
    }

    public function update(Request $request, $id) {
        $validator = $request->validate([
            'device_code' => [
                            'required',
                            'string',
                            'max:255',
                            Rule::unique('device')->ignore($id)
                        ],
            // 'client_id' => 'required|integer|exists:clients,id',
            'enabled' => 'required|boolean',
            'timestamp_last_accessed' => 'nullable|string',
            
        ]);
        
        $device = Device::find($id);

        $device->device_code = $request->device_code;
        $device->client_id = $request->client_id;
        $device->enabled = $request->enabled;
        $device->timestamp_last_accessed = $request->timestamp_last_accessed;
        $device->save();

        return redirect(url('devices/' . $id . '/edit'))->with('success', 'A device was updated.');
    }

    public function destroy($id)
    {
        Device::destroy($id);
        return redirect(url('devices'))->with('success', 'A device was deleted.');
    }
}
