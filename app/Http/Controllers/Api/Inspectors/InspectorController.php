<?php

namespace App\Http\Controllers\Api\Inspectors;


use App\Http\Resources\InspectorResources;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Print_;
use App\Models\client_general_info;
use App\Models\answers;
use App\Models\comments;
use App\Models\images;
use App\Models\narratives;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Foreach_;

class InspectorController extends Controller
{

    public function getProfile(): JsonResponse
    {
        $inspector = auth('inspector')->user();
        
        return response()->json(new InspectorResources($inspector));
    }


    public function editProfile(Request $request): JsonResponse
    {
        $editData = $request->only(
            'first_name',
            'last_name',
            'email',
            'phone',
            'status',
            'region',
            'avatar',
            'company',
            'membership',
            'address');

        $profile = Auth::user();

        $avatarPath = $request->file('avatar') ? $request->file('avatar')->store('uploads') : null;

        if ($profile->avatar) {
            Storage::delete($profile->avatar);
        }

        $inspector = ProfileService::editInspectorProfile($editData, $profile, $avatarPath);

        return response()->json(new InspectorResources($inspector));
    }


    public function formData(Request $request)
    {

        $insId = Auth::user();
        $input = $request->all();
        $input['inspector_id'] = $insId->id;
        $input['banner_image'] = $request->file('banner_image') ?
                                 $request->file('banner_image')->store('uploads/form') : null;
        $arr = array();
        
        $formexists = client_general_info::select('*')
                    ->where('id', '=', $request->client_id)
                    ->first();

        if ($insId) {
            if (empty($formexists)) {

              if (empty($request->inspection_address) || empty($request->client_name)) {
                    return response()->json(['success' => false,
                                            'error' => 'Address and Client Name is required']);
                }

                 $formcreate = client_general_info::create($input);
                  if (!empty($formcreate)) {
                    $lastdata = DB::table('client_general_info')
                                ->where('id', '=', $formcreate->id)
                                ->first();
                    $arr = $lastdata;
                  } else { $arr['Error']; }

            } else {

                    if (Storage::exists($formexists->banner_image)) {
                        Storage::delete($formexists->banner_image);
                    }
                    $editData = $request->only(
                        'inspection_address',
                        'inspection_date',
                        'client_name',
                        'client_onsite',
                        'property_type',
                        'add_suites',
                        'add_structure',
                        'year_build',
                        'approx_yrs',
                        'utilities'
                    );
                    if(!empty($input['banner_image'])){
                    $editData['banner_image'] = $input['banner_image'];
                    } else {
                        $editData['banner_image'] = $formexists->banner_image;
                    }
                    $formexists->update($editData);
                    $updateData = client_general_info::find($formexists->id);
                    $arr = $updateData;
                 }
                 return $this->successRespond($arr, 'success');

        } else {
            return $this->errorRespond('Token Not Valid!!', config('constants.CODE.unauthorized'));
        }

    }

    public function catData(Request $request)
    {
        $catData = new answers;
        $insId = Auth::user();

        $answers = DB::table('answers')
                ->where('client_id', '=', $request->client_id)
                ->where('cat_id', '=', $request->cat_id)
                ->where('sub_cat_id', '=', $request->sub_cat_id)
                ->where('question_id', '=', $request->question_id)
                ->get();
        

        if ($insId) {
              if (empty($answers[0])) {
                    $catData->inspector_id = $insId->id;
                    $catData->client_id = $request->client_id;
                    $catData->question_id = $request->question_id;
                    $catData->sub_cat_id = $request->sub_cat_id;
                    $catData->cat_id = $request->cat_id;
                    $catData->answer = $request->answer;
                    $catData->save();
                    return $this->successRespond($catData, 'success');
                } else {
                           DB::table('answers')
                            ->where('client_id', '=', $request->client_id)
                            ->where('cat_id', '=', $request->cat_id)
                            ->where('sub_cat_id', '=', $request->sub_cat_id)
                            ->where('question_id', '=', $request->question_id)
                            ->update(array('answer' => $request->answer));
                            $answers = DB::table('answers')
                                    ->where('id', '=', $answers[0]->id)
                                    ->get();
                            return $this->successRespond($answers, 'success');
                }
            } else {
                return $this->errorRespond('Token Not Valid!!', config('constants.CODE.unauthorized'));
                }

    }

    public function catAllData(Request $request)
    {
        
        $insId = Auth::user();
        $questionans = $request->data;
        
         $arr =  array();
         $arr["client_id"] = $request->client_id;
         $arr["cat_id"] = $request->cat_id;
         $arr["sub_cat_id"] = $request->sub_cat_id;
         
        if ($insId) {

            foreach ($questionans as $qsa) {

                $answers = DB::table('answers')
                ->where('inspector_id', '=', $insId->id)
                ->where('client_id', '=', $request->client_id)
                ->where('cat_id', '=', $request->cat_id)
                ->where('sub_cat_id', '=', $request->sub_cat_id)
                ->where('question_id', '=', $qsa['question_id'])
                ->get();
                
                if (empty($answers[0])) {
                    $catData = new answers;
                    $catData->inspector_id = $insId->id;
                    $catData->client_id = $request->client_id;
                    $catData->sub_cat_id = $request->sub_cat_id;
                    $catData->cat_id = $request->cat_id;
                    $catData->question_id = $qsa['question_id'];
                    $catData->answer = $qsa['answer'];
                    $catData->save();
                    
                   } else {
                     foreach ($answers as $ans) {
                        
                          DB::table('answers')
                        ->where('inspector_id', '=', $insId->id)
                        ->where('client_id', '=', $request->client_id)
                        ->where('cat_id', '=', $request->cat_id)
                        ->where('sub_cat_id', '=', $request->sub_cat_id)
                        ->where('question_id', '=', $qsa['question_id'])
                        ->update(array('answer' => $qsa['answer']));
                       
                         
                    }
                    
                }

            }

            $answersd = answers::select('question_id','answer')
                    ->where('inspector_id', '=', $insId->id)
                    ->where('client_id', '=', $request->client_id)
                    ->where('cat_id', '=', $request->cat_id)
                    ->where('sub_cat_id', '=', $request->sub_cat_id)
                    ->orderBy('question_id', 'ASC')
                    ->get();
             
             $arr["data"] = $answersd;
            
            return $this->successRespond($arr, 'success');

        } else {
            return $this->errorRespond('Token Not Valid!!', config('constants.CODE.unauthorized'));
                }

    }

    public function dataList()
    {
        $insId = Auth::user();

        $dataList = DB::table('client_general_info')
                ->where('inspector_id', '=', $insId->id)
                ->get();
                return $this->successRespond($dataList, 'success');
    }

    public function getAllFormData(Request $request)
    {
        $insId = Auth::user();
        if (empty($request->client_id)) {
            return response()->json(['success' => false,
                                     'error' => 'Client Id is required']);
        }

        $steptwo = answers::select('inspector_id','client_id','cat_id','sub_cat_id','question_id','answer')
                ->where('client_id', '=', $request->client_id)
                ->get();

           return $this->successRespond($steptwo, 'success');

    }

    public function saveNarratives(Request $request)
    {
        $NarrateData = new narratives;
        $insId = Auth::user();
        $narrativeId = $request->narrative_id;
        $Data = array();
        

        if ($insId) {
            if (empty($narrativeId)) {

                if (empty($request->narratives_title) || empty($request->narratives_text)) {
                    return response()->json(['success' => false,'message' => 'Title and Text is required']);
                }

                $NarrateData->inspector_id = $insId->id;
                $NarrateData->cat_id = $request->cat_id;
                $NarrateData->sub_cat_id = $request->sub_cat_id;
                $NarrateData->narratives_title = $request->narratives_title;
                $NarrateData->narratives_text = $request->narratives_text;
                $NarrateData->save();

                $narrateIn = narratives::select('cat_id', 'sub_cat_id', 'narratives_title', 'narratives_text')
                        ->where('id', '=', $NarrateData->id)
                        ->first();
                $Data = $narrateIn;
            } else {

                DB::table('narratives')
                    ->where('id', $narrativeId)
                    ->update([
                        'narratives_title' => $request->narratives_title,
                        'narratives_text' => $request->narratives_text,
                    ]);
                   
                    $updateData = narratives::select('cat_id', 'sub_cat_id', 'narratives_title', 'narratives_text')
                    ->where('id', '=', $narrativeId)
                    ->first();
                $Data = $updateData;
            }

            return $this->successRespond($Data, 'success');

        } else {
            return $this->errorRespond('Token Not Valid!!', config('constants.CODE.unauthorized'));
        }

    }

    public function deleteNarratives(Request $request)
    {
        $narrativeId = $request->narrative_id;

        if (!empty($narrativeId)) {

            $updateData = narratives::select('*')
                    ->where('id', '=', $narrativeId)
                    ->first();
              if(!empty($updateData)){
                $status = narratives::find($narrativeId)->delete();
                return $this->successRespond($status, 'success');
              } else {
                return $this->errorRespond('Narrative is already deleted!!', config('constants.CODE.unauthorized'));
              }

        } else {
            return $this->errorRespond('Narrative Id is required!!', config('constants.CODE.unauthorized'));
        }

    }

    public function deleteClientData(Request $request)
    {
        $Cid = $request->client_id;
        $insId = Auth::user();

        if (!empty($Cid)) {

            $cData = client_general_info::select('*')
                    ->where('id', '=', $Cid)
                    ->where('inspector_id', '=', $insId->id)
                    ->first();
              if(!empty($cData)){
                     DB::table('answers')
                    ->where('client_id', '=', $Cid)
                    ->where('inspector_id', '=', $insId->id)
                    ->delete();

                     DB::table('client_general_info')
                    ->where('id', '=', $Cid)
                    ->where('inspector_id', '=', $insId->id)
                    ->delete();
                return $this->successRespond(true, 'success');
              } else {
                return $this->errorRespond('Client Id is not valid!!', config('constants.CODE.unauthorized'));
              }

        } else {
            return $this->errorRespond('Client details is required!!', config('constants.CODE.unauthorized'));
        }

    }

    public function comments(Request $request)
    {
        $insId = Auth::user();
        $input = $request->only(
            'sub_cat_id',
            'client_id',
            'comments'
        );
        $input['inspector_id'] = $insId->id;

        $imgData = $request->only(
            'sub_cat_id',
            'client_id'
        );
        $imgData['image_path'] = $request->file('commentImage') ?
                                 $request->file('commentImage')->store('uploads/form') : null;

        $arr = array();
        
        
        $commentExists = comments::find($request->comment_id);

            if (empty($commentExists)) {

                 $commentCreate = comments::create($input);
                 
                  if (!empty($commentCreate)) {
                    $imgData['comment_id'] = $commentCreate->id;
                    $imgCreate = images::create($imgData);

                    $lastdata['image'] = $imgCreate->image_path;
                    $lastdata['comments'] = $commentCreate->comments;
                    $lastdata['comment_id'] = $commentCreate->id;

                    $arr = $lastdata;
                  } else { $arr['Error']; }

            } else {

                $imgcomments = images::where('comment_id', $commentExists->id)->first();
                    if (Storage::exists($imgcomments->image_path)) {
                        Storage::delete($imgcomments->image_path);
                    }

                    if(!empty($imgData['image_path'])){
                    $editImg['image_path'] = $imgData['image_path'];
                    } else {
                        $editImg['image_path'] = $imgcomments->image_path;
                    }

                    $commentExists->update($input);
                    $updateComment = comments::find($commentExists->id);

                    $imgcomments->update($editImg);
                    $updateimg = images::find($imgcomments->id);

                    $updateData['comment_id'] = $commentExists->id;
                    $updateData['comments'] = $updateComment->comments;
                    $updateData['image_path'] = $updateimg->image_path;

                    $arr = $updateData;
                 }
                 return $this->successRespond($arr, 'success');

    }

    public function commentDelete(Request $request)
    {
                 $commentId = $request->comment_id;
                 $arr = array();

             if(!empty($commentId))
             {
                   $checkcomment = comments::find($commentId);
                   if(!empty($checkcomment)){
                           images::where('comment_id', $commentId)->delete();
                           comments::destroy($commentId);

                        return $this->successRespond($arr, 'success');
                   } else {
                    return $this->errorRespond('Invalid comment ID', config('constants.CODE.unauthorized'));
                   }
             } else {
                return $this->errorRespond('Comment id is required!!', config('constants.CODE.badRequest'));
             }
                 
    }

    public function getComment(Request $request){

             $commentlist = $request->sub_cat_id;
             
             $data = DB::table('comments')
             ->join('images', 'images.comment_id', '=', 'comments.id')
             ->where('comments.sub_cat_id', '=', $commentlist)
             ->select('images.comment_id', 'images.image_path', 'comments.comments',
                      'comments.client_id', 'comments.sub_cat_id')
             ->get();

                return $this->successRespond($data, 'success');
    }

}