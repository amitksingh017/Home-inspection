<?php

namespace App\Http\Controllers\Api\Inspectors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SaveOrUpdateReportRequest;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function save(SaveOrUpdateReportRequest $request)
    {
        try {
            $data = $request->validated();
            $data['inspector_id'] = Auth::id();

            if ($request->hasFile($data['code'])){
                if (Storage::exists('reports/' . Auth::id() . '/' . $data['code'] . '.pdf')){
                    Storage::delete('reports/' . Auth::id() . '/' . $data['code'] . '.pdf');
                }
                $data['path'] = Storage::putFileAs('reports/' . Auth::id(), $request->file($data['code']), $data['code'] . '.pdf');
            }

            Report::query()->updateOrCreate([
                'code'          => $data['code'],
                'inspector_id'  => $data['inspector_id']
            ], [
                'path'      => $data['path'],
                'date'      => $data['date'],
                'address'   => $data['address'],
                'created_at' => $data['date'],
                'updated_at' => now()->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s')
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e){
            Log::error($e->getMessage(), [
                'class'     => __CLASS__,
                'method'    => __METHOD__,
                'line'      => $e->getLine()
            ]);

            return response()->json(['success' => false]);
        }
    }
}
