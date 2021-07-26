<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Device;
use App\User;
use App\Client;

class DevicesController extends Controller
{
    const PAGE_NAME = "devices";

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
		if(auth()->user()->type == "super_admin") {
	        $devices = Device::orderByDesc('id')->get();
		} else {
			$devices = Device::orderByDesc('id')->where('client_id', auth()->user()->client_id)->orWhereNull('client_id')->get();
		}
        return view('admin/devices/index', ["devices" => $devices, 'page_name' => self::PAGE_NAME]);
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

		if (auth()->user()->type == "super_admin") {
			$clients = Client::orderBy('name')->get();
		} else {
			$clients = Client::where('id', auth()->user()->client_id)->get();
		}
        return view('admin/devices/edit', ['device' => $device, 'clients' => $clients, 'page_name' => self::PAGE_NAME]);
    }

    public function update(Request $request, $id) {
		$rules = [
            'device_code' => [
                            'required',
                            'string',
                            'max:255',
                            Rule::unique('device')->ignore($id)
                        ],
            'enabled' => 'required|boolean',
            
        ];
		
		if (auth()->user()->type == "super_admin") {
			$rules['client_id'] = 'required|integer|exists:clients,id';
		}
        $validator = $request->validate($rules);
        
        $device = Device::find($id);
        $device->device_code = $request->device_code;
        
        $device->enabled = $request->enabled;
		
		if (auth()->user()->type == 'super_admin') {
			$device->client_id = $request->client_id;
		} else {
			if (auth()->user()->client_id) {
				$device->client_id = auth()->user()->client_id;
			}
			
			if ($request->filled('device_up_time')) {
				$device->device_up_time = $request->device_up_time;
			}

			if ($request->filled('device_down_time')) {
				$device->device_down_time = $request->device_down_time;
			}

			if ($request->filled('configuration')) {
				$device->configuration = $request->configuration;
			}

			if ($request->filled('device_heartbeat_minutes')) {
				$device->device_heartbeat_minutes = $request->device_heartbeat_minutes;
			}
		}
		$device->save();

        return redirect(url('admin/devices/' . $id . '/edit'))->with('success', 'A device was updated.');
    }

    public function destroy($id)
    {
        Device::destroy($id);
        return redirect(url('admin/devices'))->with('success', 'A device was deleted.');
    }
}
