<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizCreateRequest;
use App\Http\Requests\QuizUpdateRequest;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function index()
    {
        $quizzes = Quiz::withCount('questions')->paginate(5); //withCount --> quizle ilişkili olan questionları sayar
        return view('admin.quiz.list', compact('quizzes'));
    }


    public function create()
    {
        return view('admin.quiz.create');
    }

    public function store(QuizCreateRequest $request)
    {

        Quiz::create($request->post());
        return redirect()->route('quizzes.index')->with('success', 'Quiz Başarıyla Oluşturuldu.');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $quiz = Quiz::withCount('questions')->find($id) ?? abort(404, 'Quiz Bulunamadı');
        return view('admin.quiz.edit', compact('quiz'));
    }


    public function update(QuizUpdateRequest $request, $id)
    {
        $quiz = Quiz::find($id) ?? abort(404, 'Quiz Bulunamadı');
        Quiz::where('id', $id)->update($request->except(['_token', '_method']));

        return redirect()->route('quizzes.index')->with('success', 'Quiz Güncelleme İşlemi Başarıyla Gerçekleşti.');
    }


    public function destroy($id)
    {
        $quiz = Quiz::find($id) ?? abort(404, 'Quiz Bulunamadı.');
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz silme işlemi başarıyla gerçekleşti.');
    }
}
