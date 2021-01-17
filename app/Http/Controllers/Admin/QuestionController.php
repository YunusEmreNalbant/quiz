<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QuestionCreateRequest;
use App\Http\Requests\QuestionUpdateRequest;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class QuestionController extends Controller
{

    public function index($id)
    {

        $quiz = Quiz::where('id', $id)->with('questions')->first() ?? abort(404, 'Quiz Bulunamadı');
        return view('admin.question.list', compact('quiz'));
    }

    public function create($id)
    {
        $quiz = Quiz::find($id);

        return view('admin.question.create', compact('quiz'));
    }


    public function store(QuestionCreateRequest $request, $id)
    {

        if ($request->hasFile('image')) {
            $fileName = Str::slug($request->question) . '.' . $request->image->extension();
            $fileNameWithUpload = 'uploads/' . $fileName;
            $request->image->move(public_path('uploads'), $fileName);
            $request->merge([
                'image' => $fileNameWithUpload
            ]);

        }
        Quiz::find($id)->questions()->create($request->post());
        return redirect()->route('questions.index', $id)->with('success', 'Soru Başarıyla Oluşturuldu.');
    }

    public function show(Question $question)
    {
        //
    }


    public function edit($quiz_id, $question_id)
    {

        $question = Quiz::find($quiz_id)->questions()->where('id', $question_id)->first() ?? abort(404, 'Quiz veya Soru Bulunamadı!');
        return view('admin.question.edit', compact('question'));
    }


    public function update(QuestionUpdateRequest $request, $quiz_id, $question_id)
    {
        if ($request->hasFile('image')) {
            $fileName = Str::slug($request->question) . '.' . $request->image->extension();
            $fileNameWithUpload = 'uploads/' . $fileName;
            $request->image->move(public_path('uploads'), $fileName);
            $request->merge([
                'image' => $fileNameWithUpload
            ]);

        }
        Quiz::find($quiz_id)->questions()->where('id', $question_id)->first()->update($request->post());
        return redirect()->route('questions.index', $quiz_id)->with('success', 'Soru Başarıyla Güncellendi..');

    }

    public function destroy(Question $question)
    {
        //
    }
}
