<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project, Task $task)
    {
            $request->validate([
                'comment' => 'required|string|max:1000',
            ]);
            if (Comment::create([
                'task_id' => $task->id,
                'comment_user_id' => $request->user()->id,
                'comment' => $request->comment,
            ])) {
                $flash = ['success' => __('Added a comment.')];
            } else {
                $flash = ['error' => __('Failed to add comment.')];
            }
            return redirect()->route('tasks.edit', ['project' => $project->id, 'task' => $task->id])
            ->with($flash);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Task $task, Comment $comment)
    {
        $user = auth()->user();
        
        if($user->can('delete', $comment)) {
            if($comment->delete()) {
            $flash = ['success' => __('Comment deleted successfully.')];
            } else {
            $flash = ['error' => __('Failed to delete the Comment.')];
            }
        } else {
            $flash = ['error' => __('Not authorized.')];
        }
    
        return redirect()
            ->route('tasks.edit', ['project' => $project->id, 'task' => $task])
            ->with($flash);
    }
}
