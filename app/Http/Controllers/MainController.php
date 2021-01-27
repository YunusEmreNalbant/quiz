<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Quiz;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function dashboard()
    {

        $quizzes = Quiz::where('status', 'publish')->withCount('questions')->paginate(5);

        return view('dashboard', compact('quizzes'));
    }

    public function quiz_detail($slug)
    {
        $quiz = Quiz::where('slug', $slug)->with('my_result', 'topFive.user')->withCount('questions')->first() ?? abort(404, 'Quiz Bulunamadı');
        return view('quiz_detail', compact('quiz'));
    }

    public function quiz($slug)
    {
        $quiz = Quiz::where('slug', $slug)->with('questions')->first();

        return view('quiz', compact('quiz'));
    }

    public function result(Request $request, $slug)
    {
        $quiz = Quiz::with('questions')->where('slug', $slug)->first() ?? abort(404, 'Quiz Bulunamadı.');
        $correct = 0;

        if ($quiz->my_result) {
            abort(404, "Bu Quiz'e daha önce katıldınız!");
        }
        foreach ($quiz->questions as $question) {
            Answer::create([
                'user_id' => Auth::user()->id,
                'question_id' => $question->id,
                'answer' => $request->post($question->id)
            ]);

            if ($question->correct_answer === $request->post($question->id)) {
                $correct += 1;

            }
        }

        $point = round((100 / count($quiz->questions)) * $correct);

        Result::create([
            'user_id' => Auth::user()->id,
            'quiz_id' => $quiz->id,
            'point' => $point,
            'correct' => $correct,
            'wrong' => abs(count($quiz->questions) - $correct),
        ]);

        return redirect()->route('quiz.detail', $quiz->slug)->with('success', "Başarıyla Quiz'i bitirdin! Puanın: " . $point);

    }
}
