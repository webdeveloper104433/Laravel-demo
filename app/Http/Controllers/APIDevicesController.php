<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Device;
use App\User;
use App\Client;
use App\Gallery;

class APIDevicesController extends Controller
{
    public function index(Request $request) {
        if (empty($request->all()) || $request->filled("google") || $request->filled("flow")) {
            $data = [];
			if ($request->filled('title') && $request->title == "off") {
                $data['title'] = 'off';
            }
            if ($request->filled('clientname')) {
                $client = Client::where('name', $request->clientname)->first();

                if (!empty($client)) {
                    if ($client->users->isNotEmpty()) {
                        foreach ($client->users as $user) {

                            if (!empty($user)) {
                                $gallery = Gallery::where('user_id', $user->id)->where('name', $request->google)->first();
                                if ($gallery) {
                                    $data['google_images'] = $gallery->sync_google_images;
									$data['label'] = $gallery->sync_google_images()->first()->title;
                                }
                                // dd($data);
                            }
                        }
                    }
                }
            }
            return view('welcome', ['data' => $data]);
        }
		
		date_default_timezone_set('Europe/Berlin');
        $current_timestamp = date('Y-m-d H:i:s');
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $current_ip = $_SERVER['HTTP_CLIENT_current_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $current_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $current_ip = $_SERVER['REMOTE_ADDR'];
        }

        switch ($request->api){
            case "register":

                if (!$request->filled('device_code')) {
                    return "Error: Device register";
                }

                $device = Device::where("device_code", $request->device_code)->first();
                
                if (empty($device)) {

                    $device = new Device();
                    $device->device_code = $request->device_code;
                    // $device->user_id
                    $device->enabled = 0;
                    $device->timestamp_registered = $current_timestamp;
                    // $device->eMail_of_admin
                    // $device->configuration
                    // $device->device_up_time
                    // $device->device_down_time
                    // $device->device_heartbeat_minutes
                    $device->timestamp_last_accessed = $current_timestamp;
                    $device->ip_address_of_last_access = $current_ip;
                    $device->save();

                    return response()->json(["info" => "New device registered, please wait for enabling"]);
                } else if($device->enabled) {
					if ($device->client_id) {
	                    return response()->json(["id"=>$device->client_id]);
					} else {
						return response()->json(["error" => "Not assign client"]);
					}
                }
                return response()->json(["error" => "Not yet enabled"]);

                break;
            case "setup":

               
                if (!$request->filled('device_code') || !$request->filled('client_id')) {
                    return response()->json(["error" => "Device Code and Client ID are required."]);
                }

				
                $device = Device::select("device_code", "client_id", "enabled", "timestamp_registered", "eMail_of_admin", "configuration", "device_up_time", "device_down_time", "device_heartbeat_minutes", "timestamp_last_accessed", "ip_address_of_last_access")->where('device_code', $request->device_code)->where('client_id', $request->client_id)->first();
				
				if (empty($device)) {
					return response()->json(["error" => "Not register"]);
				}
				
                return response()->json(["configuration" => $device->configuration]);

                break;
            case "heartbeat":

                if (!$request->filled('device_code') || !$request->filled('client_id')) {
                    return response()->json(["error" => "Device Code and Client ID are required."]);
                }

                $device = Device::where("device_code", $request->device_code)->where("client_id", $request->client_id)->first();

                if (empty($device)) {
                    return response()->json(["error" => "Not register"]);
                }
				
                $device->timestamp_last_accessed = $current_timestamp;

                // if ($request->filled("ip_address_of_last_access")) {
                //     $device->ip_address_of_last_access = $request->ip_address_of_last_access;
                // }

                $device->save();

				return response()->json([
					'status' => 'ok',
				]);
        }
    }
}
