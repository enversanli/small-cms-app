<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceQuestionResource;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Models\ServiceQuestion;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request){
        $status =   $request->status ? [$request->status] : ['Active', 'Upcoming'];
        $services = Service::whereIn('status', $status)->with('guide','systemRequirement')->orderBy('created_at', 'DESC')->paginate(50);

        return ServiceResource::collection($services);
    }

    public function show($id){
        $service = Service::with(['guide', 'questions', 'systemRequirement'])->findOrFail($id);

        $videoId = 12;
        if (isset($service->guide) && isset($service->guide->youtube_url)){
            $videoId = explode('?v=', $service->guide->youtube_url);
            $videoId = isset($videoId[1]) ? $videoId[1] : $videoId;
            $service->youtubevideoId = $videoId;
        }

        //ServiceResource::make($service)
        return view('web.services.detail')->with(['service' => $service, 'youtubeImgId' => $videoId]);
    }

    public function search($word){
        $services = Service::where('title', 'like', '%'.$word.'%')->take(5)->get();

        return ServiceResource::collection($services);
    }

    public function guide($serviceId){
        $service = Service::with('guide')->findOrFail($serviceId);
        $videoId = explode('?v=', $service->guide->youtube_url);
        $videoId = isset($videoId[1]) ? $videoId[1] : $videoId;
        $service->youtubevideoId = $videoId;
        return view('web.services.guide')->with(['service' => $service, 'youtubeImgId' => $videoId]);
    }

    public function questions($serviceId, $perPage = 10){
        $questions = ServiceQuestion::where('service_id', $serviceId)->paginate($perPage);

        return ServiceQuestionResource::make($questions);
    }

    public function question($serviceId, $questionId){
        $question = ServiceQuestion::where('service_id', $serviceId)->where('id', $questionId)->firstOrFail();

        return ServiceQuestionResource::make($question);
    }
}
