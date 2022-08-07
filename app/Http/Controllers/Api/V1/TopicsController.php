<?php

namespace App\Http\Controllers\Api\V1;

use App\Topic;
use App\Test;
use App\Http\Controllers\Controller;
use App\Http\Resources\Topic as TopicResource;
use App\Http\Requests\Admin\StoreTopicsRequest;
use App\Http\Requests\Admin\UpdateTopicsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class TopicsController extends Controller
{
    public function index()
    {
        $topics = Topic::all();
        $topicArr = array();
        foreach($topics as $topic)
        {
            array_push($topicArr, [
                'id'            =>  $topic->id,
                'name'          =>  $topic->name,
                'description'   =>  $topic->description,
                'question_cnt'  =>  $topic->topicQuestions()->count()
            ]);
        }
        return new TopicResource($topicArr);

    }
   
    public function store(StoreTopicsRequest $request)
    {
        if (Gate::denies('topic_create')) {
            return abort(401);
        }

        $topic = Topic::create($request->all());
        
        
        return (new TopicResource($topic))
            ->response()
            ->setStatusCode(201);
    }
    public function show($id)
    {
        if (Gate::denies('topic_view')) {
            return abort(401);
        }

        $topic = Topic::with([])->findOrFail($id);
        
        return new TopicResource($topic);
        
        
    }
    public function update(UpdateTopicsRequest $request, $id)
    {
        if (Gate::denies('topic_edit')) {
            return abort(401);
        }

        $topic = Topic::findOrFail($id);
        $topic->update($request->all());
        
        return (new TopicResource($topic))
            ->response()
            ->setStatusCode(202);
    }
     public function destroy($id)
    {
        if (Gate::denies('topic_delete')) {
            return abort(401);
        }

        $topic = Topic::findOrFail($id);
        $topic->delete();

        return response(null, 204);
    }
}
