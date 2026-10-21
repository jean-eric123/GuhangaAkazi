<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EngagementController extends Controller
{
    public function toggleLike(Request $request, $type, $id)
    {
        $modelClass = $this->getModelClass($type);
        if (!$modelClass) return response()->json(['success' => false]);

        try {
            $visitorToken = $request->session()->getId();
            
            $exists = DB::table('likes')
                ->where('likeable_id', $id)
                ->where('likeable_type', $modelClass)
                ->where('visitor_token', $visitorToken)
                ->first();

            if ($exists) {
                DB::table('likes')->where('id', $exists->id)->delete();
            } else {
                $data = [
                    'likeable_id' => $id,
                    'likeable_type' => $modelClass,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                if (Schema::hasColumn('likes', 'visitor_token')) $data['visitor_token'] = $visitorToken;
                if (Schema::hasColumn('likes', 'ip_hash')) $data['ip_hash'] = hash('sha256', $request->ip());

                DB::table('likes')->insert($data);
            }
            
            $newCount = DB::table('likes')->where('likeable_id', $id)->where('likeable_type', $modelClass)->count();
            return response()->json(['success' => true, 'count' => $newCount]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function addComment(Request $request, $type, $id)
    {
        $modelClass = $this->getModelClass($type);
        if (!$modelClass) return response()->json(['success' => false]);

        try {
            $data = [
                'commentable_id' => $id,
                'commentable_type' => $modelClass,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Automatically detect the correct column name for the comment text
            $col = 'comment';
            if (Schema::hasColumn('comments', 'body')) $col = 'body';
            if (Schema::hasColumn('comments', 'content')) $col = 'content';
            if (Schema::hasColumn('comments', 'message')) $col = 'message';
            
            $data[$col] = $request->comment;

            if (Schema::hasColumn('comments', 'name')) $data['name'] = $request->name ?? 'Guest User';
            if (Schema::hasColumn('comments', 'email')) $data['email'] = $request->email ?? 'guest@example.com';
            if (Schema::hasColumn('comments', 'is_approved')) $data['is_approved'] = 1;

            DB::table('comments')->insert($data);
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    private function getModelClass($type)
    {
        return [
            'idea' => 'App\Models\Idea',
            'skill' => 'App\Models\Skill',
            'opportunity' => 'App\Models\Opportunity',
            'article' => 'App\Models\Post',
            'post' => 'App\Models\Post',
            'video' => 'App\Models\Video',
            'photo' => 'App\Models\Photo',
        ][$type] ?? null;
    }
}